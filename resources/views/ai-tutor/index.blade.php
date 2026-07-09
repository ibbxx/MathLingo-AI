<x-app-layout>

@section('page-title', 'AI Tutor')

<style>
    /* ─── RESET & TOKENS ───────────────────────────────── */
    :root {
        --primary:   #2563EB;
        --p10:       #EFF6FF;
        --p20:       #DBEAFE;
        --surface:   #FFFFFF;
        --bg:        #F8FAFC;
        --border:    #E5E7EB;
        --text:      #1E293B;
        --muted:     #64748B;
        --danger:    #EF4444;
        --secondary: #22C55E;
        --r-card:    20px;
        --shadow:    0 1px 3px rgba(0,0,0,0.06), 0 4px 16px rgba(0,0,0,0.05);
        --ai-sidebar-w: 280px;
    }

    /* Override main-content padding for full-height chat layout */
    .main-content {
        padding: 0 !important;
        display: flex;
        flex-direction: column;
        height: calc(100vh - var(--topbar-h, 64px));
        overflow: hidden;
    }

    /* ─── AI TUTOR SHELL ───────────────────────────────── */
    .at-shell {
        display: flex;
        height: 100%;
        overflow: hidden;
    }

    /* ─── AI SIDEBAR ───────────────────────────────────── */
    .at-sidebar {
        width: var(--ai-sidebar-w);
        flex-shrink: 0;
        background: var(--surface);
        border-right: 1px solid var(--border);
        display: flex;
        flex-direction: column;
        overflow: hidden;
        transition: transform 0.25s cubic-bezier(0.4,0,0.2,1);
    }

    .at-sidebar-head {
        padding: 16px 14px 10px;
        border-bottom: 1px solid var(--border);
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .btn-new-chat {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        width: 100%;
        padding: 10px 14px;
        background: var(--primary);
        color: #fff;
        font-size: 14px;
        font-weight: 600;
        border: none;
        border-radius: 12px;
        cursor: pointer;
        transition: background 0.15s, box-shadow 0.15s;
        text-decoration: none;
    }
    .btn-new-chat:hover { background: #1D4ED8; box-shadow: 0 4px 12px rgba(37,99,235,0.25); }

    .at-search {
        position: relative;
    }
    .at-search svg {
        position: absolute;
        left: 10px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--muted);
        pointer-events: none;
    }
    .at-search input {
        width: 100%;
        padding: 8px 10px 8px 32px;
        border: 1px solid var(--border);
        border-radius: 10px;
        font-size: 13px;
        font-family: inherit;
        color: var(--text);
        background: var(--bg);
        outline: none;
        transition: border-color 0.15s;
    }
    .at-search input:focus { border-color: var(--primary); background: #fff; }

    .at-conv-list {
        flex: 1;
        overflow-y: auto;
        padding: 8px 8px;
        display: flex;
        flex-direction: column;
        gap: 2px;
    }
    .at-conv-list::-webkit-scrollbar { width: 4px; }
    .at-conv-list::-webkit-scrollbar-track { background: transparent; }
    .at-conv-list::-webkit-scrollbar-thumb { background: var(--border); border-radius: 4px; }

    .at-conv-group-label {
        font-size: 10px;
        font-weight: 700;
        color: var(--muted);
        letter-spacing: 0.06em;
        text-transform: uppercase;
        padding: 10px 8px 4px;
    }

    .at-conv-item {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 9px 10px;
        border-radius: 10px;
        cursor: pointer;
        transition: background 0.12s;
        position: relative;
        group: true;
    }
    .at-conv-item:hover { background: var(--bg); }
    .at-conv-item.active { background: var(--p10); }

    .at-conv-icon {
        width: 28px;
        height: 28px;
        border-radius: 8px;
        background: var(--p10);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        color: var(--primary);
    }
    .at-conv-item.active .at-conv-icon { background: var(--p20); }

    .at-conv-title {
        flex: 1;
        font-size: 13px;
        font-weight: 500;
        color: var(--text);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        min-width: 0;
    }
    .at-conv-item.active .at-conv-title { color: var(--primary); font-weight: 600; }

    .at-conv-actions {
        display: none;
        gap: 2px;
        flex-shrink: 0;
    }
    .at-conv-item:hover .at-conv-actions { display: flex; }
    .at-conv-actions button {
        width: 24px; height: 24px;
        border-radius: 6px;
        border: none;
        background: transparent;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--muted);
        transition: background 0.12s, color 0.12s;
    }
    .at-conv-actions button:hover { background: var(--border); color: var(--text); }
    .at-conv-actions button.danger:hover { background: #FEF2F2; color: var(--danger); }

    .at-sidebar-footer {
        padding: 10px 14px;
        border-top: 1px solid var(--border);
        font-size: 11px;
        color: var(--muted);
        text-align: center;
        font-weight: 500;
    }
    .at-sidebar-footer span { color: var(--primary); font-weight: 600; }

    /* ─── CHAT AREA ────────────────────────────────────── */
    .at-chat {
        flex: 1;
        display: flex;
        flex-direction: column;
        overflow: hidden;
        background: var(--bg);
        min-width: 0;
    }

    /* Chat toolbar */
    .at-chat-toolbar {
        padding: 12px 20px;
        background: var(--surface);
        border-bottom: 1px solid var(--border);
        display: flex;
        align-items: center;
        gap: 10px;
        flex-shrink: 0;
    }
    .at-chat-toolbar-title {
        flex: 1;
        font-size: 15px;
        font-weight: 700;
        color: var(--text);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .at-toolbar-btn {
        display: flex;
        align-items: center;
        gap: 6px;
        padding: 7px 12px;
        border: 1px solid var(--border);
        border-radius: 9px;
        background: var(--surface);
        font-size: 12px;
        font-weight: 600;
        color: var(--muted);
        cursor: pointer;
        transition: background 0.12s, color 0.12s, border-color 0.12s;
        white-space: nowrap;
    }
    .at-toolbar-btn:hover { background: var(--bg); color: var(--text); border-color: #CBD5E1; }
    .at-toolbar-btn.danger:hover { background: #FEF2F2; color: var(--danger); border-color: #FCA5A5; }

    /* Mobile sidebar toggle */
    .at-sidebar-toggle {
        display: none;
        align-items: center;
        justify-content: center;
        width: 34px; height: 34px;
        border-radius: 9px;
        border: 1px solid var(--border);
        background: var(--surface);
        cursor: pointer;
        color: var(--muted);
        flex-shrink: 0;
    }

    /* Messages area */
    .at-messages {
        flex: 1;
        overflow-y: auto;
        overscroll-behavior: contain;
        padding: 24px 0;
        display: flex;
        flex-direction: column;
        gap: 0;
        scroll-behavior: smooth;
    }
    .at-messages::-webkit-scrollbar { width: 5px; }
    .at-messages::-webkit-scrollbar-track { background: transparent; }
    .at-messages::-webkit-scrollbar-thumb { background: var(--border); border-radius: 4px; }

    /* Welcome screen */
    .at-welcome {
        flex: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 40px 24px;
        text-align: center;
        gap: 0;
    }
    .at-welcome-icon {
        width: 72px; height: 72px;
        border-radius: 20px;
        background: var(--p10);
        border: 1px solid var(--p20);
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 20px;
        color: var(--primary);
    }
    .at-welcome h2 {
        font-size: 22px;
        font-weight: 800;
        color: var(--text);
        margin: 0 0 8px;
        letter-spacing: -0.4px;
    }
    .at-welcome p {
        font-size: 14px;
        color: var(--muted);
        max-width: 420px;
        line-height: 1.65;
        margin: 0 0 28px;
    }
    .at-welcome-chips {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        justify-content: center;
        max-width: 540px;
    }
    .at-chip {
        padding: 8px 14px;
        border: 1px solid var(--border);
        border-radius: 20px;
        font-size: 13px;
        font-weight: 500;
        color: var(--text);
        background: var(--surface);
        cursor: pointer;
        transition: border-color 0.12s, background 0.12s, color 0.12s;
        box-shadow: var(--shadow);
    }
    .at-chip:hover { border-color: var(--primary); color: var(--primary); background: var(--p10); }

    /* Message row */
    .at-msg-row {
        padding: 6px 20px;
        display: flex;
        flex-direction: column;
        gap: 4px;
    }
    .at-msg-row.user { align-items: flex-end; }
    .at-msg-row.assistant { align-items: flex-start; }

    .at-msg-meta {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 11px;
        color: var(--muted);
        font-weight: 500;
        padding: 0 4px;
    }
    .at-msg-avatar {
        width: 24px; height: 24px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 11px;
        font-weight: 700;
        flex-shrink: 0;
    }
    .at-msg-avatar.ai {
        background: var(--primary);
        color: #fff;
    }
    .at-msg-avatar.user-av {
        background: var(--p20);
        color: var(--primary);
    }

    .at-msg-bubble {
        max-width: min(680px, 78%);
        padding: 12px 16px;
        border-radius: 16px;
        font-size: 14px;
        line-height: 1.65;
        word-break: break-word;
    }
    .at-msg-row.user .at-msg-bubble {
        background: var(--primary);
        color: #fff;
        border-bottom-right-radius: 4px;
    }
    .at-msg-row.assistant .at-msg-bubble {
        background: var(--surface);
        color: var(--text);
        border: 1px solid var(--border);
        border-bottom-left-radius: 4px;
        box-shadow: var(--shadow);
    }

    /* Markdown inside assistant bubble */
    .at-msg-bubble p { margin: 0 0 10px; }
    .at-msg-bubble p:last-child { margin-bottom: 0; }
    .at-msg-bubble strong { font-weight: 700; color: var(--text); }
    .at-msg-bubble em { font-style: italic; }
    .at-msg-bubble code {
        font-family: 'JetBrains Mono', 'Fira Code', monospace;
        font-size: 12.5px;
        background: #F1F5F9;
        padding: 1px 5px;
        border-radius: 4px;
        color: #BE185D;
    }
    .at-msg-bubble pre {
        background: #0F172A;
        border-radius: 10px;
        padding: 14px 16px;
        overflow-x: auto;
        margin: 10px 0;
        position: relative;
    }
    .at-msg-bubble pre code {
        background: none;
        padding: 0;
        color: #E2E8F0;
        font-size: 13px;
        border-radius: 0;
    }
    .at-msg-bubble ol, .at-msg-bubble ul {
        padding-left: 20px;
        margin: 8px 0;
        display: flex;
        flex-direction: column;
        gap: 4px;
    }
    .at-msg-bubble li { line-height: 1.6; }
    .at-msg-bubble blockquote {
        border-left: 3px solid var(--primary);
        padding: 8px 14px;
        margin: 10px 0;
        background: var(--p10);
        border-radius: 0 8px 8px 0;
        color: var(--text);
        font-style: normal;
    }
    .at-msg-bubble h1, .at-msg-bubble h2, .at-msg-bubble h3 {
        font-weight: 700;
        color: var(--text);
        margin: 14px 0 6px;
        letter-spacing: -0.3px;
    }
    .at-msg-bubble h1 { font-size: 18px; }
    .at-msg-bubble h2 { font-size: 16px; }
    .at-msg-bubble h3 { font-size: 14px; }
    .at-msg-bubble hr { border: none; border-top: 1px solid var(--border); margin: 12px 0; }
    .at-msg-bubble table { border-collapse: collapse; width: 100%; margin: 10px 0; font-size: 13px; }
    .at-msg-bubble th, .at-msg-bubble td { border: 1px solid var(--border); padding: 7px 10px; text-align: left; }
    .at-msg-bubble th { background: var(--bg); font-weight: 700; }

    /* Copy button on code blocks */
    .code-copy-btn {
        position: absolute;
        top: 8px; right: 8px;
        padding: 4px 9px;
        background: rgba(255,255,255,0.1);
        border: 1px solid rgba(255,255,255,0.15);
        border-radius: 6px;
        color: #94A3B8;
        font-size: 11px;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.12s, color 0.12s;
        font-family: inherit;
    }
    .code-copy-btn:hover { background: rgba(255,255,255,0.18); color: #fff; }

    /* Message actions */
    .at-msg-actions {
        display: none;
        gap: 4px;
        padding: 0 4px;
    }
    .at-msg-row:hover .at-msg-actions { display: flex; }
    .at-msg-action-btn {
        display: flex;
        align-items: center;
        gap: 4px;
        padding: 4px 8px;
        border-radius: 6px;
        border: 1px solid var(--border);
        background: var(--surface);
        font-size: 11px;
        font-weight: 600;
        color: var(--muted);
        cursor: pointer;
        transition: background 0.12s, color 0.12s;
    }
    .at-msg-action-btn:hover { background: var(--bg); color: var(--text); }

    /* Typing indicator */
    .at-typing {
        display: none;
        align-items: center;
        gap: 10px;
        padding: 10px 20px;
    }
    .at-typing.visible { display: flex; }
    .at-typing-dots {
        display: flex;
        gap: 4px;
        align-items: center;
    }
    .at-typing-dots span {
        width: 7px; height: 7px;
        border-radius: 50%;
        background: var(--primary);
        opacity: 0.4;
        animation: at-bounce 1.2s infinite;
    }
    .at-typing-dots span:nth-child(2) { animation-delay: 0.2s; }
    .at-typing-dots span:nth-child(3) { animation-delay: 0.4s; }
    @keyframes at-bounce {
        0%, 80%, 100% { opacity: 0.4; transform: scale(1); }
        40% { opacity: 1; transform: scale(1.2); }
    }
    .at-typing-label { font-size: 12px; color: var(--muted); font-weight: 500; }

    /* Input area */
    .at-input-area {
        padding: 14px 20px;
        background: var(--surface);
        border-top: 1px solid var(--border);
        flex-shrink: 0;
    }
    .at-input-wrap {
        display: flex;
        align-items: flex-end;
        gap: 10px;
        background: var(--bg);
        border: 1.5px solid var(--border);
        border-radius: 16px;
        padding: 10px 14px;
        transition: border-color 0.15s, box-shadow 0.15s;
    }
    .at-input-wrap:focus-within {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(37,99,235,0.08);
        background: #fff;
    }
    #at-input {
        flex: 1;
        border: none;
        background: none;
        resize: none;
        font-family: inherit;
        font-size: 14px;
        color: var(--text);
        outline: none;
        min-height: 22px;
        max-height: 180px;
        line-height: 1.55;
        overflow-y: auto;
    }
    #at-input::placeholder { color: var(--muted); }
    #at-input::-webkit-scrollbar { width: 3px; }

    .at-input-actions {
        display: flex;
        align-items: center;
        gap: 6px;
        flex-shrink: 0;
    }
    .btn-send {
        width: 36px; height: 36px;
        border-radius: 10px;
        background: var(--primary);
        color: #fff;
        border: none;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background 0.15s, box-shadow 0.15s;
        flex-shrink: 0;
    }
    .btn-send:hover:not(:disabled) { background: #1D4ED8; box-shadow: 0 4px 12px rgba(37,99,235,0.3); }
    .btn-send:disabled { background: #CBD5E1; cursor: not-allowed; }
    .btn-stop {
        width: 36px; height: 36px;
        border-radius: 10px;
        background: #FEF2F2;
        color: var(--danger);
        border: 1px solid #FCA5A5;
        cursor: pointer;
        display: none;
        align-items: center;
        justify-content: center;
        transition: background 0.15s;
    }
    .btn-stop:hover { background: #FEE2E2; }
    .btn-stop.visible { display: flex; }

    .at-input-hint {
        font-size: 11px;
        color: var(--muted);
        text-align: center;
        margin-top: 8px;
        font-weight: 500;
    }

    /* Rename modal */
    .at-modal-overlay {
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.35);
        z-index: 200;
        display: none;
        align-items: center;
        justify-content: center;
        backdrop-filter: blur(2px);
    }
    .at-modal-overlay.open { display: flex; }
    .at-modal {
        background: var(--surface);
        border-radius: 18px;
        padding: 28px;
        width: 380px;
        max-width: calc(100vw - 32px);
        box-shadow: 0 20px 60px rgba(0,0,0,0.2);
    }
    .at-modal h3 {
        font-size: 16px;
        font-weight: 700;
        color: var(--text);
        margin: 0 0 16px;
    }
    .at-modal input {
        width: 100%;
        padding: 10px 14px;
        border: 1.5px solid var(--border);
        border-radius: 10px;
        font-size: 14px;
        font-family: inherit;
        color: var(--text);
        outline: none;
        transition: border-color 0.15s;
        margin-bottom: 14px;
    }
    .at-modal input:focus { border-color: var(--primary); }
    .at-modal-actions {
        display: flex;
        gap: 8px;
        justify-content: flex-end;
    }
    .btn-modal-cancel {
        padding: 9px 18px;
        border: 1px solid var(--border);
        border-radius: 10px;
        background: var(--surface);
        font-size: 13px;
        font-weight: 600;
        color: var(--muted);
        cursor: pointer;
        font-family: inherit;
        transition: background 0.12s;
    }
    .btn-modal-cancel:hover { background: var(--bg); }
    .btn-modal-save {
        padding: 9px 18px;
        border: none;
        border-radius: 10px;
        background: var(--primary);
        font-size: 13px;
        font-weight: 600;
        color: #fff;
        cursor: pointer;
        font-family: inherit;
        transition: background 0.15s;
    }
    .btn-modal-save:hover { background: #1D4ED8; }

    /* Mobile sidebar overlay */
    .at-sidebar-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.4);
        z-index: 50;
    }

    /* ─── RESPONSIVE ────────────────────────────────────── */
    @media (max-width: 768px) {
        .at-sidebar {
            position: fixed;
            top: var(--topbar-h, 64px);
            left: 0;
            bottom: 0;
            z-index: 60;
            transform: translateX(-100%);
        }
        .at-sidebar.mobile-open { transform: translateX(0); }
        .at-sidebar-overlay { display: block; }
        .at-sidebar-overlay.visible { display: block; }
        .at-sidebar-toggle { display: flex; }
        .at-toolbar-btn span { display: none; }
        .at-msg-bubble { max-width: 90%; }
    }
</style>

{{-- ═══ RENAME MODAL ═══════════════════════════════════ --}}
<div class="at-modal-overlay" id="renameModal">
    <div class="at-modal">
        <h3>Ganti Nama Percakapan</h3>
        <input type="text" id="renameInput" placeholder="Masukkan judul baru..." maxlength="100">
        <div class="at-modal-actions">
            <button class="btn-modal-cancel" id="renameCancelBtn">Batal</button>
            <button class="btn-modal-save" id="renameSaveBtn">Simpan</button>
        </div>
    </div>
</div>

<div class="at-sidebar-overlay" id="atSidebarOverlay"></div>

<div class="at-shell">

    {{-- ═══ AI SIDEBAR ══════════════════════════════════ --}}
    <aside class="at-sidebar" id="atSidebar">

        <div class="at-sidebar-head">
            {{-- Obrolan Baru button --}}
            <form method="POST" action="{{ route('ai-tutor.new') }}">
                @csrf
                <button type="submit" class="btn-new-chat">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                    </svg>
                    Obrolan Baru
                </button>
            </form>

            {{-- Search --}}
            <div class="at-search">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
                </svg>
                <input type="text" id="convSearch" placeholder="Cari percakapan...">
            </div>
        </div>

        {{-- Conversation List --}}
        <div class="at-conv-list" id="convList">
            @forelse($conversations as $conv)
            <div class="at-conv-item {{ isset($activeConversation) && $activeConversation->id === $conv->id ? 'active' : '' }}"
                 data-id="{{ $conv->id }}"
                 data-title="{{ e($conv->title) }}"
                 onclick="loadConversation({{ $conv->id }})">
                <div class="at-conv-icon">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                    </svg>
                </div>
                <span class="at-conv-title">{{ $conv->title }}</span>
                <div class="at-conv-actions">
                    <button onclick="openRename(event, {{ $conv->id }}, '{{ addslashes($conv->title) }}')" title="Ganti Nama">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                        </svg>
                    </button>
                    <button class="danger" onclick="deleteConversation(event, {{ $conv->id }})" title="Hapus">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/>
                            <path d="M10 11v6M14 11v6"/><path d="M9 6V4h6v2"/>
                        </svg>
                    </button>
                </div>
            </div>
            @empty
            <div style="padding:24px 12px;text-align:center;">
                <div style="color:var(--muted);font-size:13px;font-weight:500;line-height:1.6;">
                    No conversations yet.<br>Start by clicking <strong>Obrolan Baru</strong>.
                </div>
            </div>
            @endforelse
        </div>

        <div class="at-sidebar-footer">
            Powered by <span>MathLingo AI</span>
        </div>
    </aside>

    {{-- ═══ CHAT AREA ═══════════════════════════════════ --}}
    <div class="at-chat" id="atChat">

        {{-- Toolbar --}}
        <div class="at-chat-toolbar">
            <button class="at-sidebar-toggle" id="atSidebarToggle" title="Tampilkan/sembunyikan percakapan">
                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/>
                </svg>
            </button>
            <div class="at-chat-toolbar-title" id="chatTitle">
                {{ isset($activeConversation) ? $activeConversation->title : 'MathLingo AI Tutor' }}
            </div>
            <button class="at-toolbar-btn" id="clearChatBtn" onclick="clearChat()" title="Hapus tampilan obrolan">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/>
                </svg>
                <span>Hapus</span>
            </button>
        </div>

        {{-- Messages --}}
        <div class="at-messages" id="atMessages">

            @if(!isset($activeConversation) || $messages->isEmpty())
            {{-- Welcome screen --}}
            <div class="at-welcome" id="atWelcome">
                <div class="at-welcome-icon">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 2a10 10 0 1 0 10 10"/>
                        <path d="M12 8v4l3 3"/>
                        <circle cx="18" cy="5" r="3" fill="#2563EB" stroke="#2563EB"/>
                        <path d="M18 3v4M16 5h4" stroke="#fff" stroke-width="1.5"/>
                    </svg>
                </div>
                <h2>MathLingo AI Tutor</h2>
                <p>Asisten Belajar Bahasa Inggris Matematika pribadimu. Tanyakan apa saja tentang matematika, kosakata matematika, pemecahan masalah, atau penulisan akademik.</p>
                <div class="at-welcome-chips">
                    <button class="at-chip" onclick="sendChip(this)">Apa arti "conjecture" dalam matematika?</button>
                    <button class="at-chip" onclick="sendChip(this)">Jelaskan istilah "asymptote" dalam Bahasa Inggris</button>
                    <button class="at-chip" onclick="sendChip(this)">Apa bedanya "theorem" dan "lemma"?</button>
                    <button class="at-chip" onclick="sendChip(this)">Bagaimana cara membaca notasi "∀x ∈ ℝ" dalam Bahasa Inggris?</button>
                    <button class="at-chip" onclick="sendChip(this)">Apa arti "monotonic function" dalam matematika?</button>
                    <button class="at-chip" onclick="sendChip(this)">Jelaskan kosakata dalam ekspresi "matrix decomposition"</button>
                </div>
            </div>
            @else
            {{-- Load existing messages --}}
            @foreach($messages as $msg)
            <div class="at-msg-row {{ $msg->role }}" id="msg-{{ $msg->id }}">
                <div class="at-msg-meta">
                    @if($msg->role === 'assistant')
                    <div class="at-msg-avatar ai">AI</div>
                    <span>MathLingo Tutor</span>
                    <span>{{ $msg->created_at->diffForHumans() }}</span>
                    @else
                    <span>{{ $msg->created_at->diffForHumans() }}</span>
                    <div class="at-msg-avatar user-av">{{ strtoupper(substr(auth()->user()->name, 0, 2)) }}</div>
                    @endif
                </div>
                <div class="at-msg-bubble" @if($msg->role === 'assistant') data-markdown="{{ e($msg->content) }}" @endif>
                    @if($msg->role === 'assistant')
                        {{-- Rendered by JS --}}
                    @else
                        {{ $msg->content }}
                    @endif
                </div>
                @if($msg->role === 'assistant')
                <div class="at-msg-actions">
                    <button class="at-msg-action-btn" onclick="copyMessage(this)">
                        <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="9" y="9" width="13" height="13" rx="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg>
                        Salin
                    </button>
                    <button class="at-msg-action-btn" onclick="regenerateResponse()">
                        <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 .49-4.71"/></svg>
                        Buat Ulang
                    </button>
                </div>
                @endif
            </div>
            @endforeach
            @endif

        </div>

        {{-- Typing indicator --}}
        <div class="at-typing" id="atTyping">
            <div class="at-msg-avatar ai">AI</div>
            <div class="at-typing-dots">
                <span></span><span></span><span></span>
            </div>
            <span class="at-typing-label">MathLingo Tutor sedang berpikir...</span>
        </div>

        {{-- Input --}}
        <div class="at-input-area">
            <div class="at-input-wrap">
                <textarea
                    id="at-input"
                    placeholder="Tanyakan tentang matematika, kosakata matematika, atau pemecahan masalah..."
                    rows="1"
                ></textarea>
                <div class="at-input-actions">
                    <button class="btn-stop" id="btnStop" title="Hentikan generasi">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><rect x="4" y="4" width="16" height="16" rx="2"/></svg>
                    </button>
                    <button class="btn-send" id="btnSend" title="Kirim pesan (Enter)">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/>
                        </svg>
                    </button>
                </div>
            </div>
            <div class="at-input-hint">
                Tekan <strong>Enter</strong> untuk kirim Press <strong>Enter</strong> to send &middot; <strong>Shift+Enter</strong> for new linemiddot; <strong>Shift+Enter</strong> untuk baris baru
            </div>
        </div>

    </div>{{-- /at-chat --}}
</div>{{-- /at-shell --}}

{{-- marked.js for Markdown rendering --}}
<script src="https://cdn.jsdelivr.net/npm/marked@12.0.0/marked.min.js"></script>

<script>
(function () {
    // ── STATE ──────────────────────────────────────────────
    let currentConversationId = {{ isset($activeConversation) ? $activeConversation->id : 'null' }};
    if (currentConversationId !== null) currentConversationId = Number(currentConversationId);
    let isGenerating = false;
    let abortController = null;
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

    // ── ELEMENTS ───────────────────────────────────────────
    const inputEl     = document.getElementById('at-input');
    const btnSend     = document.getElementById('btnSend');
    const btnStop     = document.getElementById('btnStop');
    const msgArea     = document.getElementById('atMessages');
    const typingEl    = document.getElementById('atTyping');
    const chatTitle   = document.getElementById('chatTitle');
    const convSearch  = document.getElementById('convSearch');
    const convList    = document.getElementById('convList');

    // ── MARKED CONFIG ──────────────────────────────────────
    marked.setOptions({
        breaks: true,
        gfm: true,
    });

    // ── AUTO-RESIZE TEXTAREA ───────────────────────────────
    inputEl.addEventListener('input', () => {
        inputEl.style.height = 'auto';
        inputEl.style.height = Math.min(inputEl.scrollHeight, 180) + 'px';
    });

    // ── KEYBOARD SHORTCUTS ─────────────────────────────────
    inputEl.addEventListener('keydown', (e) => {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            handleSend();
        }
    });

    btnSend.addEventListener('click', handleSend);

    btnStop.addEventListener('click', () => {
        if (abortController) {
            abortController.abort();
        }
    });

    // ── RENDER EXISTING MARKDOWN MESSAGES ─────────────────
    document.querySelectorAll('[data-markdown]').forEach(el => {
        el.innerHTML = marked.parse(el.dataset.markdown);
        attachCodeCopyButtons(el);
    });
    scrollBottom();

    // ── MAIN SEND HANDLER ──────────────────────────────────
    async function handleSend() {
        const text = inputEl.value.trim();
        if (!text || isGenerating) return;

        // If no conversation yet, create one first
        if (!currentConversationId) {
            await createConversation(text);
            return;
        }

        sendMessage(text);
    }

    async function createConversation(firstMessage) {
        try {
            const resp = await fetch('{{ route('ai-tutor.new') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({}),
            });

            const data = await resp.json();
            if (data.id) {
                currentConversationId = data.id;
                addConversationToSidebar(data.id, 'Percakapan Baru');
                setActiveConversation(data.id);
                sendMessage(firstMessage);
            }
        } catch (err) {
            console.error('Create conversation error:', err);
        }
    }

    async function sendMessage(text) {
        if (isGenerating) return;

        inputEl.value = '';
        inputEl.style.height = 'auto';

        hideWelcome();
        appendUserMessage(text);
        setGenerating(true);

        abortController = new AbortController();

        let assistantBubble = null;
        let fullContent = '';

        try {
            const response = await fetch('{{ route('ai-tutor.send') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'text/event-stream',
                },
                body: JSON.stringify({
                    conversation_id: currentConversationId,
                    message: text,
                }),
                signal: abortController.signal,
            });

            const reader = response.body.getReader();
            const decoder = new TextDecoder();

            while (true) {
                const { done, value } = await reader.read();
                if (done) break;

                const chunk = decoder.decode(value, { stream: true });
                const lines = chunk.split('\n');

                for (const line of lines) {
                    if (!line.startsWith('data: ')) continue;
                    const jsonStr = line.slice(6).trim();
                    if (!jsonStr) continue;

                    let parsed;
                    try { parsed = JSON.parse(jsonStr); } catch { continue; }

                    if (parsed.type === 'start') {
                        typingEl.classList.remove('visible');
                        assistantBubble = appendAssistantMessageStart();
                    } else if (parsed.type === 'chunk') {
                        fullContent += parsed.content;
                        updateAssistantBubble(assistantBubble, fullContent);
                        scrollBottom();
                    } else if (parsed.type === 'done') {
                        finalizeAssistantBubble(assistantBubble, fullContent);
                        updateConversationTitle(currentConversationId);
                        break;
                    } else if (parsed.type === 'error') {
                        showError(parsed.message || 'Unknown error');
                        break;
                    }
                }
            }

        } catch (err) {
            if (err.name !== 'AbortError') {
                showError('Gagal terhubung ke AI. Silakan coba lagi.');
            }
            if (assistantBubble) {
                finalizeAssistantBubble(assistantBubble, fullContent || '_Generasi dihentikan._');
            }
        }

        setGenerating(false);
        scrollBottom();
    }

    // ── DOM HELPERS ────────────────────────────────────────
    function hideWelcome() {
        const w = document.getElementById('atWelcome');
        if (w) w.remove();
    }

    function appendUserMessage(text) {
        const userInitials = '{{ strtoupper(substr(auth()->user()->name, 0, 2)) }}';
        const row = document.createElement('div');
        row.className = 'at-msg-row user';
        row.innerHTML = `
            <div class="at-msg-meta">
                <span>Baru saja</span>
                <div class="at-msg-avatar user-av">${userInitials}</div>
            </div>
            <div class="at-msg-bubble">${escHtml(text)}</div>
        `;
        msgArea.appendChild(row);
        scrollBottom();
    }

    function appendAssistantMessageStart() {
        typingEl.classList.remove('visible');
        const row = document.createElement('div');
        row.className = 'at-msg-row assistant';
        row.innerHTML = `
            <div class="at-msg-meta">
                <div class="at-msg-avatar ai">AI</div>
                <span>MathLingo Tutor</span>
                <span>Baru saja</span>
            </div>
            <div class="at-msg-bubble at-streaming"></div>
            <div class="at-msg-actions"></div>
        `;
        msgArea.appendChild(row);
        scrollBottom();
        return row.querySelector('.at-streaming');
    }

    function updateAssistantBubble(bubble, content) {
        if (!bubble) return;
        // Render partial markdown
        bubble.innerHTML = marked.parse(content);
    }

    function finalizeAssistantBubble(bubble, content) {
        if (!bubble) return;
        bubble.classList.remove('at-streaming');
        bubble.innerHTML = marked.parse(content);
        attachCodeCopyButtons(bubble);

        // Add action buttons
        const actionsDiv = bubble.closest('.at-msg-row').querySelector('.at-msg-actions');
        if (actionsDiv) {
            actionsDiv.innerHTML = `
                <button class="at-msg-action-btn" onclick="copyMessage(this)">
                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="9" y="9" width="13" height="13" rx="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg>
                        Salin
                </button>
                <button class="at-msg-action-btn" onclick="regenerateResponse()">
                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 .49-4.71"/></svg>
                        Buat Ulang
                </button>
            `;
        }
    }

    function attachCodeCopyButtons(container) {
        container.querySelectorAll('pre').forEach(pre => {
            if (pre.querySelector('.code-copy-btn')) return;
            const btn = document.createElement('button');
            btn.className = 'code-copy-btn';
            btn.textContent = 'Salin';
            btn.addEventListener('click', () => {
                const code = pre.querySelector('code');
                navigator.clipboard.writeText(code ? code.textContent : pre.textContent).then(() => {
                    btn.textContent = 'Tersalin!';
                    setTimeout(() => { btn.textContent = 'Salin'; }, 2000);
                });
            });
            pre.style.position = 'relative';
            pre.appendChild(btn);
        });
    }

    function setGenerating(state) {
        isGenerating = state;
        btnSend.disabled = state;
        typingEl.classList.toggle('visible', state && !document.querySelector('.at-streaming'));
        btnStop.classList.toggle('visible', state);
        if (!state) {
            typingEl.classList.remove('visible');
        }
    }

    function showError(msg) {
        const row = document.createElement('div');
        row.className = 'at-msg-row assistant';
        row.innerHTML = `
            <div class="at-msg-meta"><div class="at-msg-avatar ai">AI</div><span>Error</span></div>
            <div class="at-msg-bubble" style="background:#FEF2F2;border-color:#FCA5A5;color:#991B1B;">
                ⚠️ ${escHtml(msg)}
            </div>
        `;
        msgArea.appendChild(row);
        scrollBottom();
    }

    function scrollBottom() {
        msgArea.scrollTop = msgArea.scrollHeight;
    }

    function escHtml(str) {
        return str
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

    // ── LOAD CONVERSATION VIA AJAX ─────────────────────────
    window.loadConversation = async function (id) {
        id = Number(id);
        if (isGenerating) return;

        closeMobileSidebar();

        try {
            const resp = await fetch(`/ai-tutor/messages/${id}`, {
                headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
            });

            if (!resp.ok) {
                console.error('Load conversation failed:', resp.status);
                return;
            }

            const data = await resp.json();

            currentConversationId = id;
            chatTitle.textContent = data.conversation.title;

            // Update URL
            window.history.pushState({}, '', `/ai-tutor?conversation=${id}`);

            // Clear messages area
            msgArea.innerHTML = '';

            if (data.messages.length === 0) {
                showWelcome();
            } else {
                const userInitials = '{{ strtoupper(substr(auth()->user()->name, 0, 2)) }}';
                data.messages.forEach(msg => {
                    const row = document.createElement('div');
                    row.className = `at-msg-row ${msg.role}`;

                    if (msg.role === 'assistant') {
                        row.innerHTML = `
                            <div class="at-msg-meta">
                                <div class="at-msg-avatar ai">AI</div>
                                <span>MathLingo Tutor</span>
                                <span>${msg.created_at}</span>
                            </div>
                            <div class="at-msg-bubble"></div>
                            <div class="at-msg-actions">
                                <button class="at-msg-action-btn" onclick="copyMessage(this)">
                                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="9" y="9" width="13" height="13" rx="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg>
                        Salin
                                </button>
                                <button class="at-msg-action-btn" onclick="regenerateResponse()">
                                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 .49-4.71"/></svg>
                        Buat Ulang
                                </button>
                            </div>
                        `;
                        const bubble = row.querySelector('.at-msg-bubble');
                        bubble.innerHTML = marked.parse(msg.content);
                        attachCodeCopyButtons(bubble);
                    } else {
                        row.innerHTML = `
                            <div class="at-msg-meta">
                                <span>${msg.created_at}</span>
                                <div class="at-msg-avatar user-av">${userInitials}</div>
                            </div>
                            <div class="at-msg-bubble">${escHtml(msg.content)}</div>
                        `;
                    }

                    msgArea.appendChild(row);
                });

                scrollBottom();
            }

            // Mark active in sidebar
            setActiveConversation(id);

        } catch (err) {
            console.error('Load conversation error:', err);
        }
    };

    function showWelcome() {
        const div = document.createElement('div');
        div.className = 'at-welcome';
        div.id = 'atWelcome';
        div.innerHTML = `
            <div class="at-welcome-icon">
                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                </svg>
            </div>
            <h2>Siap belajar!</h2>
            <p>Ini adalah percakapan baru. Tanyakan apa saja tentang matematika atau Bahasa Inggris matematika.</p>
            <div class="at-welcome-chips">
                <button class="at-chip" onclick="sendChip(this)">Apa arti "conjecture" dalam matematika?</button>
                <button class="at-chip" onclick="sendChip(this)">Jelaskan istilah "asymptote" dalam Bahasa Inggris</button>
                <button class="at-chip" onclick="sendChip(this)">Apa bedanya "theorem" dan "lemma"?</button>
                <button class="at-chip" onclick="sendChip(this)">Bagaimana cara membaca notasi "∀x ∈ ℝ" dalam Bahasa Inggris?</button>
            </div>
        `;
        msgArea.appendChild(div);
    }

    function setActiveConversation(id) {
        id = Number(id);
        document.querySelectorAll('.at-conv-item').forEach(el => {
            el.classList.toggle('active', Number(el.dataset.id) === id);
        });
    }

    function addConversationToSidebar(id, title) {
        id = Number(id);
        // Remove empty state if present
        const emptyEl = convList.querySelector('div[style]');
        if (emptyEl) emptyEl.remove();

        const item = document.createElement('div');
        item.className = 'at-conv-item';
        item.dataset.id = id;
        item.dataset.title = title;
        item.onclick = () => loadConversation(id);
        item.innerHTML = `
            <div class="at-conv-icon">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                </svg>
            </div>
            <span class="at-conv-title">${escHtml(title)}</span>
            <div class="at-conv-actions">
                <button onclick="openRename(event, ${id}, '${escHtml(title)}')" title="Ganti Nama">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                    </svg>
                </button>
                <button class="danger" onclick="deleteConversation(event, ${id})" title="Hapus">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/>
                        <path d="M10 11v6M14 11v6"/><path d="M9 6V4h6v2"/>
                    </svg>
                </button>
            </div>
        `;
        convList.prepend(item);
    }

    async function updateConversationTitle(id) {
        try {
            const resp = await fetch(`/ai-tutor/messages/${id}`, {
                headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': csrfToken },
            });
            const data = await resp.json();
            const newTitle = data.conversation.title;
            chatTitle.textContent = newTitle;

            const item = convList.querySelector(`.at-conv-item[data-id="${id}"]`);
            if (item) {
                item.dataset.title = newTitle;
                const titleEl = item.querySelector('.at-conv-title');
                if (titleEl) titleEl.textContent = newTitle;
            }
        } catch {}
    }

    // ── NEW CONVERSATION (AJAX) ────────────────────────────
    // Override form submit to be AJAX for smooth UX
    document.querySelector('.btn-new-chat').closest('form').addEventListener('submit', async function(e) {
        e.preventDefault();
        if (isGenerating) return;

        try {
            const resp = await fetch('{{ route('ai-tutor.new') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({}),
            });

            const data = await resp.json();
            if (data.id) {
                currentConversationId = data.id;
                addConversationToSidebar(data.id, 'Percakapan Baru');
                setActiveConversation(data.id);
                chatTitle.textContent = 'Percakapan Baru';
                window.history.pushState({}, '', `/ai-tutor?conversation=${data.id}`);
                msgArea.innerHTML = '';
                showWelcome();
                inputEl.focus();
                closeMobileSidebar();
            }
        } catch (err) {
            console.error('New conversation error:', err);
        }
    });

    // ── CHIP CLICK ─────────────────────────────────────────
    window.sendChip = function(btn) {
        inputEl.value = btn.textContent;
        handleSend();
    };

    // ── COPY MESSAGE ───────────────────────────────────────
    window.copyMessage = function(btn) {
        const bubble = btn.closest('.at-msg-row').querySelector('.at-msg-bubble');
        navigator.clipboard.writeText(bubble.innerText).then(() => {
            btn.textContent = 'Tersalin!';
            setTimeout(() => { btn.innerHTML = `<svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="9" y="9" width="13" height="13" rx="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg> Copy`; }, 2000);
        });
    };

    // ── REGENERATE ─────────────────────────────────────────
    window.regenerateResponse = async function () {
        if (isGenerating || !currentConversationId) return;

        // Remove last assistant message from DOM
        const rows = msgArea.querySelectorAll('.at-msg-row.assistant');
        if (rows.length > 0) rows[rows.length - 1].remove();

        setGenerating(true);
        abortController = new AbortController();
        let assistantBubble = null;
        let fullContent = '';

        try {
            const response = await fetch('{{ route('ai-tutor.regenerate') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'text/event-stream',
                },
                body: JSON.stringify({ conversation_id: currentConversationId }),
                signal: abortController.signal,
            });

            const reader = response.body.getReader();
            const decoder = new TextDecoder();

            while (true) {
                const { done, value } = await reader.read();
                if (done) break;

                const chunk = decoder.decode(value, { stream: true });
                const lines = chunk.split('\n');

                for (const line of lines) {
                    if (!line.startsWith('data: ')) continue;
                    const jsonStr = line.slice(6).trim();
                    if (!jsonStr) continue;
                    let parsed;
                    try { parsed = JSON.parse(jsonStr); } catch { continue; }

                    if (parsed.type === 'start') {
                        typingEl.classList.remove('visible');
                        assistantBubble = appendAssistantMessageStart();
                    } else if (parsed.type === 'chunk') {
                        fullContent += parsed.content;
                        updateAssistantBubble(assistantBubble, fullContent);
                        scrollBottom();
                    } else if (parsed.type === 'done') {
                        finalizeAssistantBubble(assistantBubble, fullContent);
                        break;
                    }
                }
            }
        } catch (err) {
            if (err.name !== 'AbortError') {
                showError('Gagal membuat ulang. Silakan coba lagi.');
            }
        }

        setGenerating(false);
    };

    // ── CLEAR CHAT (DOM ONLY) ──────────────────────────────
    window.clearChat = function () {
        msgArea.innerHTML = '';
        showWelcome();
    };

    // ── RENAME ─────────────────────────────────────────────
    let renameTargetId = null;
    const renameModal  = document.getElementById('renameModal');
    const renameInput  = document.getElementById('renameInput');

    window.openRename = function(e, id, title) {
        e.stopPropagation();
        renameTargetId = id;
        renameInput.value = title;
        renameModal.classList.add('open');
        renameInput.focus();
        renameInput.select();
    };

    document.getElementById('renameCancelBtn').addEventListener('click', () => {
        renameModal.classList.remove('open');
    });

    document.getElementById('renameSaveBtn').addEventListener('click', doRename);
    renameInput.addEventListener('keydown', (e) => { if (e.key === 'Enter') doRename(); });

    async function doRename() {
        const title = renameInput.value.trim();
        if (!title || !renameTargetId) return;

        try {
            const resp = await fetch(`/ai-tutor/conversation/${renameTargetId}/rename`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ title }),
            });

            const data = await resp.json();
            if (data.success) {
                const item = convList.querySelector(`.at-conv-item[data-id="${renameTargetId}"]`);
                if (item) {
                    item.dataset.title = data.title;
                    item.querySelector('.at-conv-title').textContent = data.title;
                }
                if (currentConversationId === renameTargetId) {
                    chatTitle.textContent = data.title;
                }
            }
        } catch (err) {
            console.error('Rename error:', err);
        }

        renameModal.classList.remove('open');
    }

    renameModal.addEventListener('click', (e) => {
        if (e.target === renameModal) renameModal.classList.remove('open');
    });

    // ── DELETE ─────────────────────────────────────────────
    window.deleteConversation = async function(e, id) {
        e.stopPropagation();
        id = Number(id);
        if (!confirm('Hapus percakapan ini? Tindakan ini tidak dapat dibatalkan.')) return;

        try {
            const resp = await fetch(`/ai-tutor/conversation/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                },
            });

            if (!resp.ok) {
                console.error('Delete failed:', resp.status);
                return;
            }

            const item = convList.querySelector(`.at-conv-item[data-id="${id}"]`);
            if (item) item.remove();

            if (currentConversationId === id) {
                currentConversationId = null;
                chatTitle.textContent = 'MathLingo AI Tutor';
                msgArea.innerHTML = '';
                showWelcome();
                window.history.pushState({}, '', '/ai-tutor');
            }

            // Show empty state if no conversations left
            if (convList.querySelectorAll('.at-conv-item').length === 0) {
                convList.innerHTML = `
                    <div style="padding:24px 12px;text-align:center;">
                        <div style="color:var(--muted);font-size:13px;font-weight:500;line-height:1.6;">
                            Belum ada percakapan.<br>Mulai dengan klik <strong>Obrolan Baru</strong>.
                        </div>
                    </div>
                `;
            }
        } catch (err) {
            console.error('Delete error:', err);
        }
    };

    // ── SEARCH ────────────────────────────────────────────
    convSearch.addEventListener('input', () => {
        const q = convSearch.value.toLowerCase().trim();
        convList.querySelectorAll('.at-conv-item').forEach(item => {
            const title = (item.dataset.title || '').toLowerCase();
            item.style.display = q === '' || title.includes(q) ? '' : 'none';
        });
    });

    // ── MOBILE SIDEBAR ─────────────────────────────────────
    const atSidebar       = document.getElementById('atSidebar');
    const atSidebarOverlay = document.getElementById('atSidebarOverlay');
    const atSidebarToggle = document.getElementById('atSidebarToggle');

    atSidebarToggle.addEventListener('click', () => {
        atSidebar.classList.toggle('mobile-open');
        atSidebarOverlay.classList.toggle('visible');
    });

    atSidebarOverlay.addEventListener('click', closeMobileSidebar);

    function closeMobileSidebar() {
        atSidebar.classList.remove('mobile-open');
        atSidebarOverlay.classList.remove('visible');
    }

    // ── FOCUS INPUT ON LOAD ────────────────────────────────
    inputEl.focus();

})();
</script>

</x-app-layout>