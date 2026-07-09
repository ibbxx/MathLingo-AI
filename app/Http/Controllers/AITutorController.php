<?php

namespace App\Http\Controllers;

use App\Models\AiConversation;
use App\Models\AiMessage;
use App\Services\GroqAIService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AITutorController extends Controller
{
    public function __construct(protected GroqAIService $groq) {}

    /**
     * Main AI Tutor page.
     */
    public function index(Request $request)
    {
        $conversations = AiConversation::where('user_id', Auth::id())
            ->orderBy('updated_at', 'desc')
            ->get();

        $activeConversation = null;
        $messages = collect();

        if ($request->has('conversation')) {
            $activeConversation = AiConversation::where('id', $request->conversation)
                ->where('user_id', Auth::id())
                ->first();

            if ($activeConversation) {
                $messages = $activeConversation->messages()->orderBy('created_at')->get();
            }
        }

        return view('ai-tutor.index', compact('conversations', 'activeConversation', 'messages'));
    }

    /**
     * Create a new conversation.
     */
    public function newConversation(Request $request)
    {
        $conversation = AiConversation::create([
            'user_id' => Auth::id(),
            'title'   => 'Percakapan Baru',
        ]);

        if ($request->expectsJson() || $request->wantsJson()) {
            return response()->json([
                'id'    => $conversation->id,
                'title' => $conversation->title,
            ]);
        }

        return redirect()->route('ai-tutor.index', ['conversation' => $conversation->id]);
    }

    /**
     * Send a message and get streamed AI response.
     */
    public function sendMessage(Request $request): StreamedResponse
    {
        $request->validate([
            'conversation_id' => 'required|integer',
            'message'         => 'required|string|max:4000',
        ]);

        $conversation = AiConversation::where('id', $request->conversation_id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $userContent = trim($request->message);

        // Save user message
        AiMessage::create([
            'conversation_id' => $conversation->id,
            'role'            => 'user',
            'content'         => $userContent,
            'tokens'          => 0,
        ]);

        // Auto-generate title on first message
        if ($conversation->title === 'Percakapan Baru' || $conversation->title === 'New Conversation') {
            $title = $this->groq->generateTitle($userContent);
            $conversation->update(['title' => $title]);
        }

        $messages = $this->groq->buildMessages($conversation, $userContent);

        $fullContent = '';

        return response()->stream(function () use ($messages, $conversation, &$fullContent) {
            if (ob_get_level()) ob_end_clean();
            ini_set('output_buffering', 'off');
            ini_set('zlib.output_compression', false);

            echo "data: " . json_encode(['type' => 'start']) . "\n\n";
            flush();

            try {
                $this->groq->stream($messages, function (string $chunk) use (&$fullContent) {
                    $fullContent .= $chunk;
                    echo "data: " . json_encode([
                        'type'    => 'chunk',
                        'content' => $chunk,
                    ]) . "\n\n";
                    flush();
                });
            } catch (\Exception $e) {
                echo "data: " . json_encode([
                    'type'    => 'error',
                    'message' => $e->getMessage(),
                ]) . "\n\n";
                flush();
            }

            $tokens = (int) (str_word_count($fullContent) * 1.3);
            AiMessage::create([
                'conversation_id' => $conversation->id,
                'role'            => 'assistant',
                'content'         => $fullContent,
                'tokens'          => $tokens,
            ]);

            $conversation->touch();

            echo "data: " . json_encode(['type' => 'done']) . "\n\n";
            flush();

        }, 200, [
            'Content-Type'      => 'text/event-stream',
            'Cache-Control'     => 'no-cache',
            'X-Accel-Buffering' => 'no',
            'Connection'        => 'keep-alive',
        ]);
    }

    /**
     * Rename a conversation.
     */
    public function rename(Request $request, AiConversation $conversation)
    {
        if ($conversation->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $request->validate(['title' => 'required|string|max:100']);

        $conversation->update(['title' => $request->title]);

        return response()->json(['success' => true, 'title' => $conversation->title]);
    }

    /**
     * Delete a conversation and all its messages.
     */
    public function destroy(AiConversation $conversation)
    {
        if ($conversation->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $conversation->messages()->delete();
        $conversation->delete();

        return response()->json(['success' => true]);
    }

    /**
     * Get messages for a conversation (AJAX).
     */
    public function getMessages(AiConversation $conversation)
    {
        if ($conversation->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $messages = $conversation->messages()->orderBy('created_at')->get()->map(fn($m) => [
            'id'         => $m->id,
            'role'       => $m->role,
            'content'    => $m->content,
            'created_at' => $m->created_at->diffForHumans(),
        ]);

        return response()->json([
            'conversation' => [
                'id'    => $conversation->id,
                'title' => $conversation->title,
            ],
            'messages' => $messages,
        ]);
    }

    /**
     * Regenerate last assistant response.
     */
    public function regenerate(Request $request): StreamedResponse
    {
        $request->validate(['conversation_id' => 'required|integer']);

        $conversation = AiConversation::where('id', $request->conversation_id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // Delete last assistant message
        $lastAssistant = $conversation->messages()
            ->where('role', 'assistant')
            ->latest()
            ->first();

        if ($lastAssistant) {
            $lastAssistant->delete();
        }

        // Get last user message
        $lastUser = $conversation->messages()
            ->where('role', 'user')
            ->latest()
            ->first();

        if (!$lastUser) {
            return response()->stream(function () {
                echo "data: " . json_encode(['type' => 'error', 'message' => 'No user message found.']) . "\n\n";
                flush();
            }, 200, ['Content-Type' => 'text/event-stream', 'Cache-Control' => 'no-cache']);
        }

        $messages = $this->groq->buildMessages($conversation, $lastUser->content, excludeLastUser: true);

        $fullContent = '';

        return response()->stream(function () use ($messages, $conversation, &$fullContent) {
            if (ob_get_level()) ob_end_clean();
            ini_set('output_buffering', 'off');

            echo "data: " . json_encode(['type' => 'start']) . "\n\n";
            flush();

            try {
                $this->groq->stream($messages, function (string $chunk) use (&$fullContent) {
                    $fullContent .= $chunk;
                    echo "data: " . json_encode([
                        'type'    => 'chunk',
                        'content' => $chunk,
                    ]) . "\n\n";
                    flush();
                }, temperature: 0.8);
            } catch (\Exception $e) {
                echo "data: " . json_encode([
                    'type'    => 'error',
                    'message' => $e->getMessage(),
                ]) . "\n\n";
                flush();
            }

            $tokens = (int) (str_word_count($fullContent) * 1.3);
            AiMessage::create([
                'conversation_id' => $conversation->id,
                'role'            => 'assistant',
                'content'         => $fullContent,
                'tokens'          => $tokens,
            ]);

            $conversation->touch();

            echo "data: " . json_encode(['type' => 'done']) . "\n\n";
            flush();

        }, 200, [
            'Content-Type'      => 'text/event-stream',
            'Cache-Control'     => 'no-cache',
            'X-Accel-Buffering' => 'no',
        ]);
    }
}