<x-app-layout title="Beranda">

<style>
    /* ─── DESIGN TOKENS (re-declared for cascade safety) ─── */
    :root {
        --primary:   #2563EB;
        --p10:       #EFF6FF;
        --p20:       #DBEAFE;
        --secondary: #22C55E;
        --s10:       #F0FDF4;
        --accent:    #F59E0B;
        --a10:       #FFFBEB;
        --danger:    #EF4444;
        --bg:        #F8FAFC;
        --surface:   #FFFFFF;
        --border:    #E5E7EB;
        --text:      #1E293B;
        --muted:     #64748B;
        --r-card:    20px;
        --shadow:    0 1px 3px rgba(0,0,0,0.06),0 4px 16px rgba(0,0,0,0.05);
        --shadow-md: 0 4px 8px rgba(0,0,0,0.08),0 12px 32px rgba(0,0,0,0.08);
    }

    /* ─── HERO ──────────────────────────────────────────── */
    .hero {
        background: var(--primary);
        border-radius: var(--r-card);
        padding: 36px 40px;
        display: flex;
        flex-wrap: wrap;
        gap: 28px;
        align-items: center;
        justify-content: space-between;
        position: relative;
        overflow: hidden;
    }
    .hero-main {
        flex: 1 1 300px;
        min-width: 0;
    }
    .hero-date {
        font-size: 13px;
        font-weight: 500;
        color: rgba(255,255,255,0.6);
        margin-bottom: 8px;
    }
    .hero-title {
        font-size: 28px;
        font-weight: 800;
        color: #fff;
        letter-spacing: -0.5px;
        line-height: 1.2;
        margin: 0 0 10px;
    }
    .hero-sub {
        font-size: 14px;
        color: rgba(255,255,255,0.75);
        line-height: 1.6;
        max-width: 440px;
        margin: 0 0 24px;
    }
    .hero-sub strong { color: #fff; font-weight: 700; }
    .btn-hero {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 11px 22px;
        background: #fff;
        color: var(--primary);
        font-size: 14px;
        font-weight: 700;
        border-radius: 10px;
        text-decoration: none;
        transition: background 0.15s, box-shadow 0.15s;
        box-shadow: 0 2px 12px rgba(0,0,0,0.15);
    }
    .btn-hero:hover { background: #F0F9FF; }

    .hero-stats {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
        justify-content: flex-end;
        max-width: 470px;
        flex: 0 1 auto;
        position: relative;
        z-index: 1;
    }
    .stat-card {
        background: rgba(255,255,255,0.12);
        border: 1px solid rgba(255,255,255,0.18);
        border-radius: 14px;
        padding: 14px 18px;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 4px;
        width: 84px;
        flex-shrink: 0;
        text-align: center;
        backdrop-filter: blur(8px);
        transition: background 0.15s, transform 0.15s;
    }
    .stat-card:hover {
        background: rgba(255,255,255,0.18);
        transform: translateY(-2px);
    }
    .stat-card-icon { color: rgba(255,255,255,0.8); }
    .stat-card-value {
        font-size: 22px;
        font-weight: 800;
        color: #fff;
        letter-spacing: -0.5px;
        line-height: 1;
    }
    .stat-card-label {
        font-size: 11px;
        font-weight: 600;
        color: rgba(255,255,255,0.6);
        text-transform: uppercase;
        letter-spacing: 0.04em;
    }

    .hero-level-bar-wrap {
        padding: 0 40px 24px;
        position: relative;
        z-index: 1;
    }
    .hero-level-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 8px;
        font-size: 12px;
        font-weight: 600;
        color: rgba(255,255,255,0.65);
    }
    .hero-level-row span:last-child { color: rgba(255,255,255,0.9); }
    .hero-level-bar {
        height: 6px;
        background: rgba(255,255,255,0.15);
        border-radius: 99px;
        overflow: hidden;
    }
    .hero-level-fill {
        height: 100%;
        background: #34D399;
        border-radius: 99px;
        transition: width 1s cubic-bezier(0.4,0,0.2,1);
    }

    /* ─── SECTION LABEL ─────────────────────────────────── */
    .section-label {
        font-size: 12px;
        font-weight: 700;
        color: var(--muted);
        letter-spacing: 0.06em;
        text-transform: uppercase;
        margin-bottom: 14px;
        margin-top: 4px;
    }

    /* ─── CARD ──────────────────────────────────────────── */
    .card {
        background: var(--surface);
        border-radius: var(--r-card);
        box-shadow: var(--shadow);
        overflow: hidden;
    }
    .card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 22px 24px 16px;
    }
    .card-header-left {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .card-icon {
        width: 34px;
        height: 34px;
        border-radius: 9px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .card-title {
        font-size: 15px;
        font-weight: 700;
        color: var(--text);
        letter-spacing: -0.2px;
    }
    .card-link {
        font-size: 13px;
        font-weight: 600;
        color: var(--primary);
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 4px;
        transition: opacity 0.15s;
    }
    .card-link:hover { opacity: 0.75; }
    .card-body { padding: 0 24px 24px; }

    /* ─── STAT MINI GRID ─────────────────────────────────── */
    .stat-mini-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(130px, 1fr));
        gap: 10px;
    }
    .stat-mini-item {
        background: var(--bg);
        border-radius: 12px;
        padding: 14px 16px;
        display: flex;
        flex-direction: column;
        gap: 4px;
    }
    .stat-mini-label {
        font-size: 11px;
        font-weight: 600;
        color: var(--muted);
        text-transform: uppercase;
        letter-spacing: 0.04em;
    }
    .stat-mini-value {
        font-size: 22px;
        font-weight: 800;
        color: var(--text);
        letter-spacing: -0.5px;
        line-height: 1;
    }
    .stat-mini-sub {
        font-size: 11px;
        color: var(--muted);
    }

    /* ─── MAIN GRID ─────────────────────────────────────── */
    .dashboard-grid {
        display: grid;
        grid-template-columns: 1fr 340px;
        gap: 20px;
        align-items: start;
    }
    .col-left  { display: flex; flex-direction: column; gap: 20px; }
    .col-right { display: flex; flex-direction: column; gap: 20px; }

    /* ─── DAILY GOAL ─────────────────────────────────────── */
    .daily-goal-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
        gap: 10px;
    }
    .goal-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 14px 16px;
        border-radius: 12px;
        border: 1.5px solid var(--border);
        background: var(--bg);
        transition: border-color 0.15s;
    }
    .goal-item.done {
        background: var(--s10);
        border-color: #BBF7D0;
    }
    .goal-item-icon {
        width: 34px;
        height: 34px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .goal-item-text { flex: 1; min-width: 0; }
    .goal-item-label {
        font-size: 13px;
        font-weight: 600;
        color: var(--text);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .goal-item.done .goal-item-label {
        color: #166534;
        text-decoration: line-through;
    }
    .goal-item-xp {
        font-size: 12px;
        font-weight: 700;
        color: var(--secondary);
    }
    .goal-check {
        flex-shrink: 0;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        border: 2px solid var(--border);
        background: transparent;
    }
    .goal-check.done {
        border: none;
        background: transparent;
        color: var(--secondary);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* ─── CONTINUE LEARNING ─────────────────────────────── */
    .course-list { display: flex; flex-direction: column; gap: 6px; }
    .course-item {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 14px 24px;
        text-decoration: none;
        border-radius: 0;
        transition: background 0.12s;
        color: inherit;
    }
    .course-item:hover { background: var(--bg); }
    .course-thumb {
        width: 44px;
        height: 44px;
        border-radius: 11px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .course-meta { flex: 1; min-width: 0; }
    .course-title-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 8px;
        margin-bottom: 4px;
    }
    .course-name {
        font-size: 14px;
        font-weight: 600;
        color: var(--text);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .course-pct {
        font-size: 12px;
        font-weight: 700;
        color: var(--muted);
        flex-shrink: 0;
    }
    .course-tags {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 8px;
    }
    .badge {
        font-size: 11px;
        font-weight: 600;
        padding: 2px 8px;
        border-radius: 99px;
    }
    .badge-muted { background: #F1F5F9; color: var(--muted); }
    .prog-track {
        height: 5px;
        background: #F1F5F9;
        border-radius: 99px;
        overflow: hidden;
    }
    .prog-fill {
        height: 100%;
        border-radius: 99px;
        transition: width 0.8s cubic-bezier(0.4,0,0.2,1);
    }

    /* ─── EMPTY STATE ────────────────────────────────────── */
    .empty-state {
        padding: 40px 24px;
        text-align: center;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 10px;
    }
    .empty-icon {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        background: var(--bg);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--muted);
        margin: 0 auto;
    }
    .empty-title {
        font-size: 14px;
        font-weight: 600;
        color: var(--text);
    }
    .empty-sub {
        font-size: 13px;
        color: var(--muted);
        max-width: 260px;
    }
    .btn-primary {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 9px 18px;
        background: var(--primary);
        color: #fff;
        font-size: 13px;
        font-weight: 600;
        border-radius: 9px;
        text-decoration: none;
        transition: opacity 0.15s;
        margin-top: 4px;
    }
    .btn-primary:hover { opacity: 0.88; }

    /* ─── LEARNING PATH ──────────────────────────────────── */
    .learning-path-wrap { padding: 8px 24px 24px; }
    .learning-path {
        display: flex;
        flex-direction: column;
        gap: 0;
        align-items: center;
        position: relative;
    }
    .lp-row {
        display: flex;
        align-items: center;
        width: 100%;
        position: relative;
    }
    .lp-row.right { justify-content: flex-end; }
    .lp-row.left  { justify-content: flex-start; }
    .lp-row.center { justify-content: center; }

    .lp-node-wrap {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 6px;
        position: relative;
        z-index: 2;
    }
    .lp-node {
        width: 72px;
        height: 72px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: transform 0.2s cubic-bezier(0.34,1.56,0.64,1), box-shadow 0.2s;
        cursor: default;
        position: relative;
    }
    .lp-node:hover { transform: scale(1.08); box-shadow: 0 8px 24px rgba(0,0,0,0.15); }
    .lp-node.done {
        background: var(--secondary);
        box-shadow: 0 4px 14px rgba(34,197,94,0.3);
    }
    .lp-node.active {
        background: var(--primary);
        box-shadow: 0 4px 20px rgba(37,99,235,0.4);
    }
    .lp-node.locked {
        background: #E2E8F0;
        box-shadow: none;
        cursor: not-allowed;
    }
    .lp-node.active::after {
        content: '';
        position: absolute;
        inset: -6px;
        border-radius: 50%;
        border: 2.5px solid var(--primary);
        opacity: 0.35;
        animation: pulse-ring 2s cubic-bezier(0.4,0,0.6,1) infinite;
    }
    @keyframes pulse-ring {
        0%, 100% { opacity: 0.35; transform: scale(1); }
        50% { opacity: 0.1; transform: scale(1.12); }
    }
    .lp-label {
        font-size: 12px;
        font-weight: 600;
        color: var(--muted);
        text-align: center;
        white-space: nowrap;
    }
    .lp-label.done   { color: #15803D; }
    .lp-label.active { color: var(--primary); font-weight: 700; }

    .lp-connector {
        position: relative;
        height: 36px;
        width: 100%;
        display: flex;
        align-items: center;
    }
    .lp-connector svg {
        position: absolute;
        top: 0;
        width: 100%;
        height: 36px;
    }

    /* ─── VOCAB PROGRESS ─────────────────────────────────── */
    .vocab-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 14px;
    }
    .vocab-item {
        padding: 16px;
        background: var(--bg);
        border-radius: 12px;
    }
    .vocab-item-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 10px;
    }
    .vocab-item-name {
        font-size: 13px;
        font-weight: 600;
        color: var(--text);
    }
    .vocab-item-count {
        font-size: 12px;
        font-weight: 700;
    }
    .vocab-bar {
        height: 8px;
        background: var(--border);
        border-radius: 99px;
        overflow: hidden;
    }
    .vocab-fill {
        height: 100%;
        border-radius: 99px;
        transition: width 0.8s cubic-bezier(0.4,0,0.2,1);
    }

    /* ─── ACHIEVEMENTS ───────────────────────────────────── */
    .ach-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(90px, 1fr));
        gap: 12px;
    }
    .ach-badge {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 6px;
        padding: 16px 8px 12px;
        border-radius: 14px;
        border: 1.5px solid var(--border);
        transition: box-shadow 0.15s, border-color 0.15s;
    }
    .ach-badge.earned {
        border-color: #FDE68A;
        background: var(--a10);
    }
    .ach-badge.earned:hover { box-shadow: 0 4px 16px rgba(245,158,11,0.15); }
    .ach-badge.locked { opacity: 0.35; filter: grayscale(1); }
    .ach-badge-icon {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .ach-badge-label {
        font-size: 11px;
        font-weight: 600;
        color: var(--muted);
        text-align: center;
        line-height: 1.3;
    }
    .ach-badge.earned .ach-badge-label { color: #92400E; }

    /* ─── DAILY CHALLENGE ────────────────────────────────── */
    .challenge-card {
        background: var(--surface);
        border-radius: var(--r-card);
        box-shadow: var(--shadow);
        overflow: hidden;
        border-left: 4px solid var(--primary);
        padding: 22px 22px 22px 20px;
    }
    .challenge-eyebrow {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 10px;
    }
    .challenge-tag {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 11px;
        font-weight: 700;
        color: var(--primary);
        text-transform: uppercase;
        letter-spacing: 0.06em;
    }
    .xp-badge {
        font-size: 12px;
        font-weight: 800;
        color: var(--accent);
        background: var(--a10);
        padding: 3px 10px;
        border-radius: 99px;
    }
    .challenge-title {
        font-size: 16px;
        font-weight: 800;
        color: var(--text);
        letter-spacing: -0.2px;
        margin: 0 0 6px;
    }
    .challenge-desc {
        font-size: 13px;
        color: var(--muted);
        line-height: 1.55;
        margin: 0 0 16px;
    }
    .challenge-meta {
        display: flex;
        align-items: center;
        gap: 16px;
        margin-bottom: 18px;
    }
    .challenge-meta-item {
        display: flex;
        align-items: center;
        gap: 5px;
        font-size: 12px;
        font-weight: 600;
        color: var(--muted);
    }
    .btn-start {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        width: 100%;
        padding: 11px;
        background: var(--primary);
        color: #fff;
        font-size: 14px;
        font-weight: 700;
        border-radius: 10px;
        border: none;
        cursor: pointer;
        transition: opacity 0.15s;
        font-family: inherit;
    }
    .btn-start:hover { opacity: 0.88; }

    /* ─── REKOMENDASI ─────────────────────────────────────── */
    .rec-list { display: flex; flex-direction: column; gap: 6px; }
    .rec-item {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        padding: 12px 14px;
        border-radius: 12px;
        transition: background 0.12s;
    }
    .rec-item:hover { background: var(--bg); }
    .rec-icon {
        width: 36px;
        height: 36px;
        border-radius: 9px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        color: var(--primary);
        background: var(--p10);
    }
    .rec-body { flex: 1; min-width: 0; }
    .rec-title {
        font-size: 13px;
        font-weight: 700;
        color: var(--text);
        margin-bottom: 2px;
    }
    .rec-desc {
        font-size: 12px;
        color: var(--muted);
        line-height: 1.45;
    }
    .rec-action {
        font-size: 12px;
        font-weight: 700;
        color: var(--primary);
        text-decoration: none;
        white-space: nowrap;
        flex-shrink: 0;
        padding-top: 2px;
    }
    .rec-action:hover { text-decoration: underline; }

    /* ─── LEADERBOARD ────────────────────────────────────── */
    .lb-list { display: flex; flex-direction: column; gap: 4px; }
    .lb-row {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 14px;
        border-radius: 10px;
        transition: background 0.12s;
    }
    .lb-row:hover { background: var(--bg); }
    .lb-row.me { background: var(--p10); }
    .lb-rank {
        font-size: 13px;
        font-weight: 800;
        color: var(--muted);
        width: 22px;
        text-align: center;
        flex-shrink: 0;
    }
    .lb-rank.top { color: var(--accent); }
    .lb-avatar {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        background: var(--primary);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 11px;
        font-weight: 700;
        flex-shrink: 0;
    }
    .lb-name {
        flex: 1;
        font-size: 13px;
        font-weight: 600;
        color: var(--text);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .lb-xp {
        font-size: 12px;
        font-weight: 800;
        color: var(--primary);
        flex-shrink: 0;
    }

    /* ─── RECENT ACTIVITY ────────────────────────────────── */
    .activity-list { display: flex; flex-direction: column; }
    .activity-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 14px;
        border-bottom: 1px solid #F8FAFC;
    }
    .activity-item:last-child { border-bottom: none; }
    .activity-icon {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        color: var(--primary);
        background: var(--p10);
    }
    .activity-body { flex: 1; min-width: 0; }
    .activity-title {
        font-size: 13px;
        font-weight: 600;
        color: var(--text);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .activity-time {
        font-size: 11px;
        color: var(--muted);
    }
    .activity-xp {
        font-size: 12px;
        font-weight: 700;
        color: var(--secondary);
        flex-shrink: 0;
    }

    /* ─── UPCOMING LESSONS ───────────────────────────────── */
    .upcoming-list { display: flex; flex-direction: column; gap: 8px; padding: 0 14px 20px; }
    .upcoming-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 14px;
        border-radius: 11px;
        border: 1.5px solid var(--border);
        transition: border-color 0.15s, box-shadow 0.15s;
    }
    .upcoming-item:hover { border-color: var(--p20); box-shadow: 0 2px 8px rgba(37,99,235,0.07); }
    .upcoming-thumb {
        width: 38px;
        height: 38px;
        border-radius: 9px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        background: var(--p10);
        color: var(--primary);
    }
    .upcoming-info { flex: 1; min-width: 0; }
    .upcoming-title {
        font-size: 13px;
        font-weight: 600;
        color: var(--text);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .upcoming-time { font-size: 11px; color: var(--muted); }
    .upcoming-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: var(--primary);
        flex-shrink: 0;
        opacity: 0.5;
    }

    /* ─── AI TUTOR STATS ─────────────────────────────────── */
    .ai-stats-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 8px;
    }
    .ai-stat-item {
        background: var(--bg);
        border-radius: 10px;
        padding: 12px;
        text-align: center;
    }
    .ai-stat-value {
        font-size: 20px;
        font-weight: 800;
        color: var(--text);
        letter-spacing: -0.3px;
        line-height: 1;
    }
    .ai-stat-label {
        font-size: 10px;
        font-weight: 600;
        color: var(--muted);
        text-transform: uppercase;
        letter-spacing: 0.04em;
        margin-top: 3px;
    }
    .ai-chart {
        display: flex;
        align-items: flex-end;
        gap: 4px;
        height: 48px;
        padding: 8px 0 4px;
    }
    .ai-chart-bar {
        flex: 1;
        border-radius: 3px 3px 0 0;
        background: var(--p20);
        min-height: 4px;
        transition: background 0.15s;
        position: relative;
    }
    .ai-chart-bar:hover { background: var(--primary); }
    .ai-chart-label {
        display: flex;
        gap: 4px;
        padding-top: 4px;
    }
    .ai-chart-day {
        flex: 1;
        text-align: center;
        font-size: 9px;
        font-weight: 600;
        color: var(--muted);
    }

    /* ─── PROGRESS RING MINI ─────────────────────────────── */
    .progress-rings {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 12px;
        padding: 0 24px 24px;
    }
    .ring-item {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .ring-svg { flex-shrink: 0; }
    .ring-info { flex: 1; min-width: 0; }
    .ring-label {
        font-size: 12px;
        font-weight: 600;
        color: var(--text);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .ring-val {
        font-size: 11px;
        color: var(--muted);
    }

    /* ─── ACHIEVEMENT STAT GRID ──────────────────────────── */
    .ach-stat-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 8px;
        margin-bottom: 16px;
    }
    .ach-stat-item {
        background: var(--bg);
        border-radius: 10px;
        padding: 10px 8px;
        text-align: center;
    }
    .ach-stat-val {
        font-size: 18px;
        font-weight: 800;
        line-height: 1;
    }
    .ach-stat-label {
        font-size: 10px;
        font-weight: 600;
        color: var(--muted);
        margin-top: 2px;
    }

    /* ─── RESPONSIVE ─────────────────────────────────────── */
    @media (max-width: 1199px) {
        .dashboard-grid { grid-template-columns: 1fr; }
        .col-right { order: -1; }
        .hero-stats { justify-content: flex-start; max-width: none; }
    }
    @media (max-width: 767px) {
        .hero { padding: 28px 24px; }
        .hero-stats { flex-wrap: wrap; max-width: none; }
        .hero-level-bar-wrap { padding: 0 24px 24px; }
        .stat-card { width: auto; min-width: 72px; padding: 12px 14px; }
        .hero-title { font-size: 22px; }
        .daily-goal-grid { grid-template-columns: 1fr 1fr; }
        .vocab-grid { grid-template-columns: 1fr; }
        .ach-grid { grid-template-columns: repeat(3, 1fr); }
        .ai-stats-grid { grid-template-columns: repeat(3, 1fr); }
        .progress-rings { grid-template-columns: 1fr; }
        .ach-stat-grid { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 479px) {
        .daily-goal-grid { grid-template-columns: 1fr; }
        .stat-mini-grid { grid-template-columns: repeat(2, 1fr); }
    }

    /* ─── PAGE ANIMATION ─────────────────────────────────── */
    .section-fade { opacity: 0; animation: fadeUp 0.45s cubic-bezier(0.22,1,0.36,1) forwards; }
    @keyframes fadeUp {
        from { opacity:0; transform:translateY(18px); }
        to   { opacity:1; transform:translateY(0); }
    }
    .d1 { animation-delay: 0.05s; }
    .d2 { animation-delay: 0.12s; }
    .d3 { animation-delay: 0.19s; }
    .d4 { animation-delay: 0.26s; }
    .d5 { animation-delay: 0.33s; }
    .d6 { animation-delay: 0.40s; }
    .d7 { animation-delay: 0.47s; }
    .d8 { animation-delay: 0.54s; }
</style>

<div style="max-width:1400px;margin:0 auto;display:flex;flex-direction:column;gap:20px;">

    {{-- ─────────────────────────────────────────────────
         HERO
    ───────────────────────────────────────────────── --}}
    <div class="section-fade d1">
        <div class="hero">
            <div class="hero-main" style="position:relative;z-index:1;">
                <p class="hero-date">{{ now()->translatedFormat('l, d F Y') }}</p>
                <h1 class="hero-title">
                    Selamat datang, {{ explode(' ', $user->name)[0] }}
                </h1>
                <p class="hero-sub">
                    @if($profile && $profile->streak_days > 0)
                        Kamu telah menjaga <strong>streak {{ $profile->streak_days }} hari</strong>.
                        Pertahankan momentum — konsistensi adalah kunci menuju mahir.
                    @else
                        Perjalananmu menuju fasih bahasa inggris matematika dimulai di sini.
                        Selesaikan pelajaran pertama dan mulai bangun streak-mu.
                    @endif
                </p>
                <a href="{{ route('courses.index') }}" class="btn-hero">
                    Lanjutkan Belajar
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M5 12h14M12 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>

            @if($profile)
            <div class="hero-stats" style="position:relative;z-index:1;">
                <div class="stat-card">
                    <div class="stat-card-icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/>
                        </svg>
                    </div>
                    <span class="stat-card-value">{{ $profile->streak_days }}</span>
                    <span class="stat-card-label">Streak</span>
                </div>
                <div class="stat-card">
                    <div class="stat-card-icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                        </svg>
                    </div>
                    <span class="stat-card-value">{{ number_format($profile->xp_total) }}</span>
                    <span class="stat-card-label">Total XP</span>
                </div>
                <div class="stat-card">
                    <div class="stat-card-icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22 10v6M2 10l10-5 10 5-10 5z"/>
                            <path d="M6 12v5c3 3 9 3 12 0v-5"/>
                        </svg>
                    </div>
                    <span class="stat-card-value">Lv. {{ $profile->current_level }}</span>
                    <span class="stat-card-label">Level</span>
                </div>
                <div class="stat-card">
                    <div class="stat-card-icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                        </svg>
                    </div>
                    <span class="stat-card-value">{{ $profile->hearts }}</span>
                    <span class="stat-card-label">Hati</span>
                </div>
                <div class="stat-card">
                    <div class="stat-card-icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2zm0 0v10l6 3"/>
                        </svg>
                    </div>
                    <span class="stat-card-value">{{ number_format($profile->gems) }}</span>
                    <span class="stat-card-label">Gems</span>
                </div>
            </div>
            @endif
        </div>

        @if($profile)
        <div class="hero-level-bar-wrap" style="background:var(--primary);border-radius:0 0 20px 20px;margin-top:-1px;">
            <div class="hero-level-row">
                <span>Progress Level {{ $profile->current_level }}</span>
                <span>{{ $profile->level_progress_percent ?? 0 }}%</span>
            </div>
            <div class="hero-level-bar">
                <div class="hero-level-fill" style="width:{{ $profile->level_progress_percent ?? 0 }};"></div>
            </div>
        </div>
        @endif
    </div>

    {{-- ─────────────────────────────────────────────────
         TARGET HARIAN
    ───────────────────────────────────────────────── --}}
    <div class="section-fade d2">
        @php
        $goals = [
            [
                'icon_svg' => '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>',
                'label' => 'Selesaikan 1 pelajaran',
                'done'  => $stats['lessons_today'] >= 1,
                'xp'    => 10,
                'icon_bg' => '#EFF6FF',
                'icon_color' => '#2563EB',
            ],
            [
                'icon_svg' => '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>',
                'label' => 'Jawab 5 pertanyaan',
                'done'  => $stats['questions_today'] >= 5,
                'xp'    => 20,
                'icon_bg' => '#F0FDF4',
                'icon_color' => '#22C55E',
            ],
            [
                'icon_svg' => '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/></svg>',
                'label' => 'Jaga streak harian',
                'done'  => $stats['streak_days'] >= 1,
                'xp'    => 10,
                'icon_bg' => '#FFFBEB',
                'icon_color' => '#F59E0B',
            ],
            [
                'icon_svg' => '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>',
                'label' => 'Pelajari vocabulary',
                'done'  => $stats['lessons_today'] >= 1 && $stats['vocab_mastered'] > 0,
                'xp'    => 10,
                'icon_bg' => '#FDF4FF',
                'icon_color' => '#9333EA',
            ],
        ];
        @endphp

        <div class="card">
            <div class="card-header">
                <div class="card-header-left">
                    <div class="card-icon" style="background:#FFFBEB;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#F59E0B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"/><path d="M12 8v4l3 3"/>
                        </svg>
                    </div>
                    <span class="card-title">Target Harian</span>
                </div>
                <span style="font-size:13px;font-weight:700;color:var(--muted);">
                    {{ now()->format('D, d M') }}
                    &nbsp;&middot;&nbsp;
                    <span style="color:var(--secondary);">{{ $stats['xp_today'] }}</span> XP hari ini
                </span>
            </div>
            <div class="card-body">
                <div class="daily-goal-grid">
                    @foreach($goals as $goal)
                    <div class="goal-item {{ $goal['done'] ? 'done' : '' }}">
                        <div class="goal-item-icon" style="background:{{ $goal['icon_bg'] }};color:{{ $goal['icon_color'] }};">
                            {!! $goal['icon_svg'] !!}
                        </div>
                        <div class="goal-item-text">
                            <div class="goal-item-label">{{ $goal['label'] }}</div>
                            <div class="goal-item-xp">+{{ $goal['xp'] }} XP</div>
                        </div>
                        @if($goal['done'])
                        <div class="goal-check done">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#22C55E" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="20 6 9 17 4 12"/>
                            </svg>
                        </div>
                        @else
                        <div class="goal-check"></div>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- ─────────────────────────────────────────────────
         RINGKASAN STATISTIK PEMBELAJARAN
    ───────────────────────────────────────────────── --}}
    <div class="section-fade d2">
        <div class="card">
            <div class="card-header">
                <div class="card-header-left">
                    <div class="card-icon" style="background:#EFF6FF;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#2563EB" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/>
                        </svg>
                    </div>
                    <span class="card-title">Statistik Pembelajaran</span>
                </div>
                <span style="font-size:12px;font-weight:600;color:var(--muted);">
                    {{ optional($profile)->league_label ?? 'Bronze League' }}
                    &nbsp;·&nbsp;
                    {{ optional($profile)->educational_level_label ?? '-' }}
                </span>
            </div>
            <div class="card-body">
                <div class="stat-mini-grid">
                    <div class="stat-mini-item">
                        <div class="stat-mini-label">Total Kursus</div>
                        <div class="stat-mini-value">{{ $stats['total_courses'] }}</div>
                        <div class="stat-mini-sub">{{ $stats['courses_completed'] }} selesai</div>
                    </div>
                    <div class="stat-mini-item">
                        <div class="stat-mini-label">Pelajaran Selesai</div>
                        <div class="stat-mini-value">{{ $stats['lessons_completed'] }}</div>
                        <div class="stat-mini-sub">dari semua kursus</div>
                    </div>
                    <div class="stat-mini-item">
                        <div class="stat-mini-label">Vocabulary</div>
                        <div class="stat-mini-value">{{ $stats['vocab_mastered'] }}</div>
                        <div class="stat-mini-sub">dari {{ $stats['vocab_total'] }} dikuasai</div>
                    </div>
                    <div class="stat-mini-item">
                        <div class="stat-mini-label">Quiz Selesai</div>
                        <div class="stat-mini-value">{{ $stats['quizzes_done'] }}</div>
                        <div class="stat-mini-sub">rata-rata {{ $stats['avg_quiz_score'] }}%</div>
                    </div>
                    <div class="stat-mini-item">
                        <div class="stat-mini-label">Tingkat Penyelesaian</div>
                        <div class="stat-mini-value">{{ $stats['completion_rate'] }}%</div>
                        <div class="stat-mini-sub">dari seluruh kursus</div>
                    </div>
                    <div class="stat-mini-item">
                        <div class="stat-mini-label">Target Belajar</div>
                        <div class="stat-mini-value" style="font-size:13px;padding-top:2px;">{{ optional($profile)->learning_goal_label ?? '-' }}</div>
                        <div class="stat-mini-sub">{{ optional($profile)->country ?? 'Indonesia' }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ─────────────────────────────────────────────────
         MAIN GRID
    ───────────────────────────────────────────────── --}}
    <div class="dashboard-grid">

        {{-- ── KOLOM KIRI ────────────────────────────── --}}
        <div class="col-left">

            {{-- Lanjutkan Belajar --}}
            <div class="section-fade d3">
                <div class="card">
                    <div class="card-header">
                        <div class="card-header-left">
                            <div class="card-icon" style="background:#EFF6FF;">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#2563EB" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/>
                                </svg>
                            </div>
                            <span class="card-title">Lanjutkan Belajar</span>
                        </div>
                        <a href="{{ route('courses.index') }}" class="card-link">
                            Lihat semua
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M9 18l6-6-6-6"/>
                            </svg>
                        </a>
                    </div>

                    @if($courses->isEmpty())
                    <div class="empty-state">
                        <div class="empty-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/>
                            </svg>
                        </div>
                        <p class="empty-title">Belum ada kursus yang dimulai</p>
                        <p class="empty-sub">Jelajahi perpustakaan kursus dan mulai pelajaran pertamamu.</p>
                        <a href="{{ route('courses.index') }}" class="btn-primary">
                            Jelajahi Kursus
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M5 12h14M12 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>
                    @else
                    <div class="course-list">
                        @foreach($courses as $course)
                        <a href="{{ route('courses.show', $course->slug) }}" class="course-item">
                            <div class="course-thumb" style="background:{{ $course->color ?? '#EFF6FF' }}20;">
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="{{ $course->color ?? '#2563EB' }}" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/>
                                </svg>
                            </div>
                            <div class="course-meta">
                                <div class="course-title-row">
                                    <span class="course-name">{{ $course->title }}</span>
                                    <span class="course-pct">{{ $course->progress_percent }}%</span>
                                </div>
                                <div class="course-tags">
                                    <span class="badge badge-muted">{{ $course->difficulty_label }}</span>
                                    <span style="font-size:12px;color:var(--muted);">{{ $course->total_lessons }} pelajaran</span>
                                </div>
                                <div class="prog-track">
                                    <div class="prog-fill" style="width:{{ $course->progress_percent }}%;background:{{ $course->color ?? '#2563EB' }};"></div>
                                </div>
                            </div>
                        </a>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>

            {{-- Jalur Pembelajaran --}}
            <div class="section-fade d4">
                <div class="card">
                    <div class="card-header">
                        <div class="card-header-left">
                            <div class="card-icon" style="background:#F0FDF4;">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#22C55E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>
                                </svg>
                            </div>
                            <span class="card-title">Jalur Pembelajaran</span>
                        </div>
                        <span style="font-size:12px;font-weight:600;color:var(--muted);">
                            @php $doneCount = collect($learningPath)->where('done', true)->count(); @endphp
                            {{ $doneCount }} / {{ count($learningPath) }} selesai
                        </span>
                    </div>

                    @if(empty($learningPath))
                    <div class="empty-state" style="padding:24px 0;">
                        <div class="empty-icon">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>
                            </svg>
                        </div>
                        <p class="empty-title">Belum ada kursus tersedia</p>
                        <p class="empty-sub">Kursus akan muncul di sini setelah ditambahkan admin.</p>
                    </div>
                    @else
                    <div class="learning-path-wrap">
                        <div class="learning-path">
                            @foreach($learningPath as $i => $step)
                            @php
                                $col = $i % 4;
                                $alignClass = match($col) {
                                    0 => 'left',
                                    1 => 'center',
                                    2 => 'right',
                                    3 => 'center',
                                    default => 'left'
                                };
                                $nodeState = ($step['done'] ?? false) ? 'done' : (($step['active'] ?? false) ? 'active' : 'locked');
                                $iconColor = $nodeState === 'locked' ? '#94A3B8' : 'white';
                            @endphp

                            <div class="lp-row {{ $alignClass }}" style="padding: 0 40px;">
                                <div class="lp-node-wrap">
                                    <div class="lp-node {{ $nodeState }}" title="{{ $step['label'] }}">
                                        @if($nodeState === 'done')
                                        <svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                            <polyline points="20 6 9 17 4 12"/>
                                        </svg>
                                        @elseif($nodeState === 'active')
                                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <polygon points="5 3 19 12 5 21 5 3"/>
                                        </svg>
                                        @else
                                        <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="{{ $iconColor }}" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                                        </svg>
                                        @endif
                                    </div>
                                    <span class="lp-label {{ $nodeState }}">{{ $step['label'] }}</span>
                                </div>
                            </div>

                            @if(!$loop->last)
                            <div class="lp-connector">
                                <svg viewBox="0 0 600 36" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
                                    @php $connColor = ($step['done'] ?? false) ? '#22C55E' : '#E2E8F0'; @endphp
                                    <path d="M300 4 Q300 32 300 32"
                                          stroke="{{ $connColor }}"
                                          stroke-width="3"
                                          stroke-dasharray="{{ ($step['done'] ?? false) ? 'none' : '6 4' }}"
                                          fill="none"
                                          stroke-linecap="round"/>
                                </svg>
                            </div>
                            @endif
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Progress Vocabulary --}}
            <div class="section-fade d5">
                <div class="card">
                    <div class="card-header">
                        <div class="card-header-left">
                            <div class="card-icon" style="background:#F0FDF4;">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#22C55E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/>
                                </svg>
                            </div>
                            <span class="card-title">Progress Vocabulary</span>
                        </div>
                        <span style="font-size:12px;font-weight:700;color:var(--secondary);background:var(--s10);padding:4px 10px;border-radius:99px;">
                            {{ $stats['vocab_mastered'] }} dikuasai
                        </span>
                    </div>
                    <div class="card-body">
                        @if(empty($vocabProgress))
                        <div class="empty-state" style="padding:24px 0;">
                            <div class="empty-icon">
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/>
                                </svg>
                            </div>
                            <p class="empty-title">Belum ada data vocabulary</p>
                            <p class="empty-sub">Mulai belajar vocabulary untuk melihat progress-mu.</p>
                        </div>
                        @else
                        <div class="vocab-grid">
                            @foreach($vocabProgress as $vc)
                            <div class="vocab-item">
                                <div class="vocab-item-header">
                                    <span class="vocab-item-name">{{ $vc['name'] }}</span>
                                    <span class="vocab-item-count" style="color:{{ $vc['color'] }};">
                                        {{ $vc['mastered'] }}/{{ $vc['total'] }}
                                    </span>
                                </div>
                                <div class="vocab-bar">
                                    <div class="vocab-fill" style="width:{{ $vc['total'] > 0 ? round($vc['mastered'] / $vc['total'] * 100) : 0 }}%;background:{{ $vc['color'] }};"></div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Pencapaian --}}
            <div class="section-fade d6">
                <div class="card">
                    <div class="card-header">
                        <div class="card-header-left">
                            <div class="card-icon" style="background:#FFFBEB;">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#F59E0B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="8" r="6"/>
                                    <path d="M15.477 12.89L17 22l-5-3-5 3 1.523-9.11"/>
                                </svg>
                            </div>
                            <span class="card-title">Pencapaian</span>
                        </div>
                        @if($allAchievements->isNotEmpty())
                        <span style="font-size:12px;font-weight:600;color:var(--muted);">
                            {{ $achievementStats['earned'] }} / {{ $achievementStats['total'] }} diraih
                        </span>
                        @endif
                    </div>

                    {{-- Statistik rarity --}}
                    @if($allAchievements->isNotEmpty())
                    <div style="padding: 0 24px 16px;">
                        <div class="ach-stat-grid">
                            <div class="ach-stat-item">
                                <div class="ach-stat-val" style="color:#F59E0B;">{{ $achievementStats['legendary'] }}</div>
                                <div class="ach-stat-label">Legendaris</div>
                            </div>
                            <div class="ach-stat-item">
                                <div class="ach-stat-val" style="color:#8B5CF6;">{{ $achievementStats['epic'] }}</div>
                                <div class="ach-stat-label">Epik</div>
                            </div>
                            <div class="ach-stat-item">
                                <div class="ach-stat-val" style="color:#2563EB;">{{ $achievementStats['rare'] }}</div>
                                <div class="ach-stat-label">Langka</div>
                            </div>
                            <div class="ach-stat-item">
                                <div class="ach-stat-val" style="color:#10B981;">{{ $achievementStats['common'] }}</div>
                                <div class="ach-stat-label">Umum</div>
                            </div>
                        </div>
                        {{-- Progress bar penyelesaian --}}
                        <div style="margin-bottom:4px;display:flex;justify-content:space-between;font-size:11px;font-weight:600;color:var(--muted);">
                            <span>Progress Pencapaian</span>
                            <span style="color:var(--accent);">{{ $achievementStats['completion_pct'] }}%</span>
                        </div>
                        <div class="prog-track" style="height:6px;">
                            <div class="prog-fill" style="width:{{ $achievementStats['completion_pct'] }}%;background:var(--accent);"></div>
                        </div>
                    </div>
                    @endif

                    <div class="card-body" style="padding-top:0;">
                        @if($allAchievements->isEmpty())
                        <div class="empty-state" style="padding:24px 0;">
                            <div class="empty-icon">
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="8" r="6"/>
                                    <path d="M15.477 12.89L17 22l-5-3-5 3 1.523-9.11"/>
                                </svg>
                            </div>
                            <p class="empty-title">Belum ada pencapaian</p>
                            <p class="empty-sub">Selesaikan pelajaran dan tantangan untuk meraih lencana pertamamu.</p>
                        </div>
                        @else
                        <div class="ach-grid">
                            @foreach($allAchievements->take(8) as $achievement)
                            @php $earned = in_array($achievement->id, $earnedAchievementIds); @endphp
                            <div class="ach-badge {{ $earned ? 'earned' : 'locked' }}" title="{{ $achievement->title }}: {{ $achievement->description }}">
                                @php
                                $rarityStyle = match($achievement->rarity) {
                                    'legendary' => ['bg' => '#FEF9C3', 'stroke' => '#CA8A04'],
                                    'epic'      => ['bg' => '#F5F3FF', 'stroke' => '#7C3AED'],
                                    'rare'      => ['bg' => '#DBEAFE', 'stroke' => '#2563EB'],
                                    default     => ['bg' => '#ECFDF5', 'stroke' => '#059669'],
                                };
                                @endphp
                                <div class="ach-badge-icon" style="background:{{ $rarityStyle['bg'] }};">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="{{ $rarityStyle['stroke'] }}" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <circle cx="12" cy="8" r="6"/>
                                        <path d="M15.477 12.89L17 22l-5-3-5 3 1.523-9.11"/>
                                    </svg>
                                </div>
                                <span class="ach-badge-label">{{ $achievement->title }}</span>
                            </div>
                            @endforeach
                        </div>
                        @if($allAchievements->count() > 8)
                        <div style="padding-top:14px;text-align:center;">
                            <a href="{{ route('achievements.index') }}" class="card-link" style="justify-content:center;">
                                Lihat semua {{ $allAchievements->count() }} pencapaian
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M9 18l6-6-6-6"/>
                                </svg>
                            </a>
                        </div>
                        @endif
                        @endif
                    </div>
                </div>
            </div>

            {{-- Rekomendasi Kursus --}}
            @if($recommendations->isNotEmpty())
            <div class="section-fade d7">
                <div class="card">
                    <div class="card-header">
                        <div class="card-header-left">
                            <div class="card-icon" style="background:#EFF6FF;">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#2563EB" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="3"/>
                                    <path d="M12 1v4M12 19v4M4.22 4.22l2.83 2.83M16.95 16.95l2.83 2.83M1 12h4M19 12h4M4.22 19.78l2.83-2.83M16.95 7.05l2.83-2.83"/>
                                </svg>
                            </div>
                            <span class="card-title">Rekomendasi Untukmu</span>
                        </div>
                        <a href="{{ route('courses.index') }}" class="card-link">
                            Lihat semua
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M9 18l6-6-6-6"/>
                            </svg>
                        </a>
                    </div>
                    <div style="padding:0 8px 16px;">
                        @foreach($recommendations as $rec)
                        <div class="rec-item">
                            <div class="rec-icon" style="background:{{ $rec->color ?? '#EFF6FF' }}20;color:{{ $rec->color ?? '#2563EB' }};">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/>
                                    <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/>
                                </svg>
                            </div>
                            <div class="rec-body">
                                <div class="rec-title">{{ $rec->title }}</div>
                                <div class="rec-desc">{{ $rec->difficulty_label }} · {{ $rec->total_lessons }} pelajaran · {{ $rec->total_xp }} XP</div>
                            </div>
                            <a href="{{ route('courses.show', $rec->slug) }}" class="rec-action">Mulai →</a>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

        </div>{{-- /col-left --}}

        {{-- ── KOLOM KANAN ───────────────────────────── --}}
        <div class="col-right">

            {{-- Tantangan Harian --}}
            <div class="section-fade d3">
                <div class="challenge-card">
                    <div class="challenge-eyebrow">
                        <div class="challenge-tag">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/>
                            </svg>
                            Tantangan Harian
                        </div>
                        @if($dailyChallenge['xp_reward'] > 0)
                        <span class="xp-badge">+{{ $dailyChallenge['xp_reward'] }} XP</span>
                        @endif
                    </div>
                    <h3 class="challenge-title">{{ $dailyChallenge['title'] }}</h3>
                    <p class="challenge-desc">{{ $dailyChallenge['description'] }}</p>
                    <div class="challenge-meta">
                        <div class="challenge-meta-item">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                            </svg>
                            {{ $dailyChallenge['time_limit'] }}
                        </div>
                        <div class="challenge-meta-item">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>
                            </svg>
                            {{ $dailyChallenge['difficulty'] }}
                        </div>
                    </div>
                    <a href="{{ route('courses.index') }}" class="btn-start" style="text-decoration:none;">
                        Mulai Tantangan
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M5 12h14M12 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>

            {{-- AI Tutor Stats --}}
            <div class="section-fade d4">
                <div class="card">
                    <div class="card-header">
                        <div class="card-header-left">
                            <div class="card-icon" style="background:#EFF6FF;">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#2563EB" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                                </svg>
                            </div>
                            <span class="card-title">AI Tutor</span>
                        </div>
                        <a href="{{ route('ai-tutor.index') }}" class="card-link">
                            Buka
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M9 18l6-6-6-6"/>
                            </svg>
                        </a>
                    </div>
                    <div style="padding:0 24px 16px;">
                        <div class="ai-stats-grid">
                            <div class="ai-stat-item">
                                <div class="ai-stat-value">{{ $aiTutorStats['total_conversations'] }}</div>
                                <div class="ai-stat-label">Sesi</div>
                            </div>
                            <div class="ai-stat-item">
                                <div class="ai-stat-value">{{ $aiTutorStats['total_messages'] }}</div>
                                <div class="ai-stat-label">Pesan</div>
                            </div>
                            <div class="ai-stat-item">
                                <div class="ai-stat-value">{{ $aiTutorStats['today'] }}</div>
                                <div class="ai-stat-label">Hari Ini</div>
                            </div>
                        </div>

                        {{-- Mini chart AI usage 7 hari --}}
                        @if(collect($aiTutorStats['chart'])->sum('count') > 0)
                        @php
                            $maxAi = max(1, collect($aiTutorStats['chart'])->max('count'));
                        @endphp
                        <div style="margin-top:12px;">
                            <div style="font-size:10px;font-weight:600;color:var(--muted);text-transform:uppercase;letter-spacing:0.04em;margin-bottom:6px;">Aktivitas 7 Hari Terakhir</div>
                            <div class="ai-chart">
                                @foreach($aiTutorStats['chart'] as $bar)
                                @php $h = max(4, round($bar['count'] / $maxAi * 44)); @endphp
                                <div class="ai-chart-bar" style="height:{{ $h }}px;" title="{{ $bar['date'] }}: {{ $bar['count'] }} pesan"></div>
                                @endforeach
                            </div>
                            <div class="ai-chart-label">
                                @foreach($aiTutorStats['chart'] as $bar)
                                <div class="ai-chart-day">{{ $bar['date'] }}</div>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        <div style="margin-top:12px;display:flex;gap:8px;flex-wrap:wrap;">
                            <span style="font-size:11px;font-weight:600;background:var(--p10);color:var(--primary);padding:3px 10px;border-radius:99px;">
                                {{ $aiTutorStats['this_week'] }} minggu ini
                            </span>
                            <span style="font-size:11px;font-weight:600;background:#F0FDF4;color:#15803D;padding:3px 10px;border-radius:99px;">
                                {{ $aiTutorStats['this_month'] }} bulan ini
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Leaderboard --}}
            <div class="section-fade d5">
                <div class="card">
                    <div class="card-header">
                        <div class="card-header-left">
                            <div class="card-icon" style="background:#FFFBEB;">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#F59E0B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M8 21H16M12 21V13M20 13C20 13 21 12 21 10V3H3V10C3 12 4 13 4 13H20Z"/>
                                    <path d="M3 3H21M3 7H21"/>
                                </svg>
                            </div>
                            <span class="card-title">Peringkat</span>
                        </div>
                        @if($profile)
                        <span style="font-size:11px;font-weight:700;background:#F1F5F9;color:var(--muted);padding:3px 9px;border-radius:99px;text-transform:capitalize;">
                            {{ optional($profile)->league_label ?? 'Bronze League' }}
                        </span>
                        @endif
                    </div>
                    <div style="padding:0 8px 16px;">
                        @forelse($leaderboard as $i => $player)
                        <div class="lb-row {{ ($player['is_me'] ?? false) ? 'me' : '' }}">
                            <div class="lb-rank {{ $i < 3 ? 'top' : '' }}">
                                @if($i === 0)
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="#F59E0B" stroke="#F59E0B" stroke-width="1"><circle cx="12" cy="12" r="10"/></svg>
                                @elseif($i === 1)
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="#94A3B8" stroke="#94A3B8" stroke-width="1"><circle cx="12" cy="12" r="10"/></svg>
                                @elseif($i === 2)
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="#B45309" stroke="#B45309" stroke-width="1"><circle cx="12" cy="12" r="10"/></svg>
                                @else
                                    {{ $i + 1 }}
                                @endif
                            </div>
                            <div class="lb-avatar" style="background:{{ $player['color'] ?? '#2563EB' }};">
                                {{ strtoupper(substr($player['name'], 0, 2)) }}
                            </div>
                            <div class="lb-name">
                                {{ $player['name'] }}{{ ($player['is_me'] ?? false) ? ' (Kamu)' : '' }}
                            </div>
                            <div class="lb-xp">{{ number_format($player['xp']) }}</div>
                        </div>
                        @empty
                        <div class="empty-state" style="padding:20px 16px;">
                            <div class="empty-icon">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M8 21H16M12 21V13M20 13C20 13 21 12 21 10V3H3V10C3 12 4 13 4 13H20Z"/>
                                </svg>
                            </div>
                            <p class="empty-title">Peringkat masih kosong</p>
                            <p class="empty-sub" style="font-size:12px;">Kumpulkan XP untuk muncul di papan peringkat mingguan.</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- Aktivitas Terbaru --}}
            <div class="section-fade d6">
                <div class="card">
                    <div class="card-header">
                        <div class="card-header-left">
                            <div class="card-icon" style="background:#F8FAFC;">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#64748B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                    <polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/>
                                    <line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/>
                                </svg>
                            </div>
                            <span class="card-title">Aktivitas Terbaru</span>
                        </div>
                    </div>
                    @if($recentActivities->isEmpty())
                    <div class="empty-state" style="padding:20px 24px 28px;">
                        <div class="empty-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                <polyline points="14 2 14 8 20 8"/>
                            </svg>
                        </div>
                        <p class="empty-title">Belum ada aktivitas</p>
                        <p class="empty-sub" style="font-size:12px;">Pelajaran dan latihan yang diselesaikan akan muncul di sini.</p>
                    </div>
                    @else
                    <div class="activity-list">
                        @foreach($recentActivities as $activity)
                        <div class="activity-item">
                            <div class="activity-icon" style="background:{{ $activity['color'] ?? '#EFF6FF' }}20;color:{{ $activity['color'] ?? '#2563EB' }};">
                                @if($activity['type'] === 'achievement')
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="8" r="6"/>
                                    <path d="M15.477 12.89L17 22l-5-3-5 3 1.523-9.11"/>
                                </svg>
                                @else
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="9 11 12 14 22 4"/>
                                    <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/>
                                </svg>
                                @endif
                            </div>
                            <div class="activity-body">
                                <div class="activity-title">{{ $activity['title'] }}</div>
                                <div class="activity-time">
                                    {{ $activity['time'] instanceof \Carbon\Carbon
                                        ? $activity['time']->diffForHumans()
                                        : \Carbon\Carbon::parse($activity['time'])->diffForHumans() }}
                                </div>
                            </div>
                            @if(!empty($activity['xp']))
                            <div class="activity-xp">+{{ $activity['xp'] }} XP</div>
                            @endif
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>

            {{-- Pelajaran Berikutnya --}}
            <div class="section-fade d7">
                <div class="card">
                    <div class="card-header">
                        <div class="card-header-left">
                            <div class="card-icon" style="background:#EFF6FF;">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#2563EB" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                                    <line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/>
                                    <line x1="3" y1="10" x2="21" y2="10"/>
                                </svg>
                            </div>
                            <span class="card-title">Pelajaran Berikutnya</span>
                        </div>
                    </div>
                    @if(empty($upcomingLessons))
                    <div class="empty-state" style="padding:16px 24px 28px;">
                        <div class="empty-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                                <line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/>
                                <line x1="3" y1="10" x2="21" y2="10"/>
                            </svg>
                        </div>
                        <p class="empty-title">Tidak ada pelajaran tersedia</p>
                        <p class="empty-sub" style="font-size:12px;">Mulai kursus baru untuk melihat pelajaran berikutnya.</p>
                    </div>
                    @else
                    <div class="upcoming-list">
                        @foreach($upcomingLessons as $lesson)
                        <div class="upcoming-item">
                            <div class="upcoming-thumb" style="background:{{ $lesson['color'] ?? '#EFF6FF' }}20;color:{{ $lesson['color'] ?? '#2563EB' }};">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/>
                                </svg>
                            </div>
                            <div class="upcoming-info">
                                <div class="upcoming-title">{{ $lesson['title'] }}</div>
                                <div class="upcoming-time">{{ $lesson['course'] }} · {{ $lesson['duration'] }}</div>
                            </div>
                            <div class="upcoming-dot" style="background:{{ $lesson['color'] ?? '#2563EB' }};"></div>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>

        </div>{{-- /col-right --}}
    </div>{{-- /dashboard-grid --}}
</div>

</x-app-layout>