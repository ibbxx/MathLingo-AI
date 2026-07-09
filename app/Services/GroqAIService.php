<?php

namespace App\Services;

use App\Models\AiConversation;
use App\Models\AiMessage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GroqAIService
{
    protected string $apiKey;
    protected string $model;
    protected string $baseUrl = 'https://api.groq.com/openai/v1/chat/completions';

    protected string $systemPrompt = <<<'PROMPT'
You are MathLingo AI Tutor — a professional Mathematical English Learning Assistant built for university-level mathematics students and educators.

Your core expertise covers:
- Mathematics: Calculus, Algebra, Geometry, Trigonometry, Statistics, Probability, Linear Algebra, Discrete Mathematics, Real Analysis, Number Theory, Differential Equations, Machine Learning mathematics
- Mathematical English: precise academic vocabulary, formal mathematical writing, theorem/proof language, research writing conventions
- Pedagogy: step-by-step explanations, worked examples, practice problems, error diagnosis, conceptual scaffolding

Behavioral guidelines:
1. Always explain mathematical concepts clearly, using both formal notation and plain English.
2. When introducing a mathematical term, always explain its English meaning and etymology when relevant.
3. Provide step-by-step solutions for problems, annotating each step in English.
4. After answering, offer a follow-up exercise or ask a check-for-understanding question.
5. When a student makes an error, identify it specifically, explain why it is wrong, and guide them to the correct approach without just giving the answer.
6. Use encouraging, growth-oriented language. Celebrate effort and progress.
7. Format responses using Markdown: use **bold** for key terms, `code` for expressions/formulas, numbered lists for steps, and > blockquotes for important notes.
8. For LaTeX-style expressions, wrap inline math in \( ... \) and display math in \[ ... \].
9. If asked about a topic outside mathematics, respond politely and briefly, then redirect to how it might relate to mathematics or mathematical English.
10. Never fabricate mathematical results. If uncertain, say so and suggest how the student can verify.

You are patient, precise, and deeply committed to helping students master both mathematics and the English language of mathematics.
PROMPT;

    public function __construct()
    {
        $this->apiKey = config('services.groq.key');
        $this->model  = config('services.groq.model', 'llama-3.3-70b-versatile');
    }

    /**
     * Build message array from conversation history + optionally appending a new user message.
     */
    public function buildMessages(AiConversation $conversation, ?string $userMessage = null, bool $excludeLastUser = false): array
    {
        $messages = [
            ['role' => 'system', 'content' => $this->systemPrompt],
        ];

        // Load last 20 messages for context window management in chronological order.
        // We get the latest 20 in descending order first, then reverse them.
        $query = $conversation->messages()->orderBy('created_at', 'desc');

        if ($userMessage !== null && !$excludeLastUser) {
            // The newly created user message is already in the database as the latest message.
            // We skip it in the database query and append it manually.
            $history = $query->skip(1)->take(20)->get()->reverse();
        } else {
            // The latest message in the database is already the user message (or we are in regenerate mode).
            // We load the latest 20 messages directly.
            $history = $query->take(20)->get()->reverse();
        }

        foreach ($history as $msg) {
            $messages[] = [
                'role'    => $msg->role,
                'content' => $msg->content,
            ];
        }

        if ($userMessage !== null && !$excludeLastUser) {
            $messages[] = ['role' => 'user', 'content' => $userMessage];
        }

        return $messages;
    }

    /**
     * Send chat to Groq API and return full response.
     */
    public function chat(AiConversation $conversation, string $userMessage): array
    {
        $messages = $this->buildMessages($conversation, $userMessage);

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiKey,
            'Content-Type'  => 'application/json',
        ])->timeout(60)->post($this->baseUrl, [
            'model'       => $this->model,
            'messages'    => $messages,
            'max_tokens'  => 2048,
            'temperature' => 0.7,
        ]);

        if ($response->failed()) {
            Log::error('Groq API error', [
                'status' => $response->status(),
                'body'   => $response->body(),
            ]);
            throw new \RuntimeException('Groq API request failed: ' . $response->status());
        }

        $data = $response->json();

        return [
            'content' => $data['choices'][0]['message']['content'] ?? '',
            'tokens'  => $data['usage']['completion_tokens'] ?? 0,
            'prompt_tokens' => $data['usage']['prompt_tokens'] ?? 0,
        ];
    }

    /**
     * Stream chat response from Groq API and call the callback with each text chunk.
     *
     * @param  array  $messages
     * @param  callable  $onChunk Function signature: function(string $chunk): void
     * @param  float  $temperature
     * @return void
     */
    public function stream(array $messages, callable $onChunk, float $temperature = 0.7): void
    {
        $ch = curl_init();

        curl_setopt_array($ch, [
            CURLOPT_URL            => $this->baseUrl,
            CURLOPT_POST           => true,
            CURLOPT_HTTPHEADER     => [
                'Authorization: Bearer ' . $this->apiKey,
                'Content-Type: application/json',
            ],
            CURLOPT_POSTFIELDS     => json_encode([
                'model'       => $this->model,
                'messages'    => $messages,
                'max_tokens'  => 2048,
                'temperature' => $temperature,
                'stream'      => true,
            ]),
            CURLOPT_RETURNTRANSFER => false,
        ]);

        $buffer = '';

        curl_setopt($ch, CURLOPT_WRITEFUNCTION, function ($ch, $data) use (&$buffer, $onChunk) {
            $buffer .= $data;
            $lines = explode("\n", $buffer);
            $buffer = array_pop($lines);

            foreach ($lines as $line) {
                $line = trim($line);
                if (!str_starts_with($line, 'data: ')) {
                    continue;
                }

                $json = substr($line, 6);
                if ($json === '[DONE]') {
                    continue;
                }

                $decoded = json_decode($json, true);
                $content = $decoded['choices'][0]['delta']['content'] ?? '';

                if ($content !== '') {
                    $onChunk($content);
                }
            }

            return strlen($data);
        });

        curl_exec($ch);

        if (curl_errno($ch)) {
            Log::error('Groq stream cURL error', ['error' => curl_error($ch)]);
            throw new \RuntimeException('Connection error: ' . curl_error($ch));
        }

        curl_close($ch);
    }


    /**
     * Generate a short conversation title from first user message.
     */
    public function generateTitle(string $userMessage): string
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiKey,
            'Content-Type'  => 'application/json',
        ])->timeout(15)->post($this->baseUrl, [
            'model'       => $this->model,
            'messages'    => [
                [
                    'role'    => 'system',
                    'content' => 'Generate a short, descriptive title (max 6 words) for a math tutoring conversation based on the user\'s first message. Return only the title, no quotes, no punctuation at the end.',
                ],
                [
                    'role'    => 'user',
                    'content' => $userMessage,
                ],
            ],
            'max_tokens'  => 20,
            'temperature' => 0.5,
        ]);

        if ($response->failed()) {
            return 'New Conversation';
        }

        $title = trim($response->json('choices.0.message.content', 'New Conversation'));
        return strlen($title) > 80 ? substr($title, 0, 77) . '...' : $title;
    }
}