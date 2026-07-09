<x-app-layout>

@section('page-title', $achievement->title)

<style>
:root {
    --primary:   #2563EB; --p10: #EFF6FF;
    --success:   #10B981; --s10: #ECFDF5;
    --warning:   #F59E0B; --w10: #FFFBEB;
    --danger:    #EF4444; --d10: #FEF2F2;
    --bg:        #F8FAFC; --surface: #FFFFFF; --border: #E5E7EB;
    --text:      #111827; --muted: #6B7280;
    --r-card:    20px;
    --shadow:    0 1px 3px rgba(0,0,0,0.06), 0 4px 16px rgba(0,0,0,0.05);
    --shadow-md: 0 4px 8px rgba(0,0,0,0.08), 0 12px 32px rgba(0,0,0,0.08);
}

/* Breadcrumb */
.breadcrumb {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 13px;
    color: var(--muted);
    margin-bottom: 24px;
}
.breadcrumb a { color: var(--muted); text-decoration: none; }
.breadcrumb a:hover { color: var(--primary); }
.breadcrumb-sep { color: #D1D5DB; }
.breadcrumb-current { color: var(--text); font-weight: 600; }

/* Main layout */
.show-layout {
    display: grid;
    grid-template-columns: 1fr 340px;
    gap: 28px;
    align-items: start;
}

/* Card base */
.card {
    background: var(--surface);
    border-radius: var(--r-card);
    box-shadow: var(--shadow);
    overflow: hidden;
}

/* Hero card */
.ach-show-hero {
    border-radius: var(--r-card);
    box-shadow: var(--shadow);
    overflow: hidden;
    margin-bottom: 24px;
}
.ach-show-hero-top {
    height: 160px;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
}
.ach-show-icon { font-size: 64px; line-height: 1; filter: drop-shadow(0 4px 16px rgba(0,0,0,0.2)); position: relative; z-index: 1; }
.ach-show-rarity {
    position: absolute;
    top: 16px; right: 16px;
    font-size: 11px; font-weight: 700;
    padding: 4px 12px; border-radius: 99px;
    text-transform: uppercase; letter-spacing: 0.05em;
    z-index: 2;
}
.ach-show-status {
    position: absolute;
    top: 16px; left: 16px;
    font-size: 11px; font-weight: 700;
    padding: 5px 12px; border-radius: 99px;
    z-index: 2;
    display: flex; align-items: center; gap: 5px;
}

.ach-show-body { padding: 28px 32px; background: var(--surface); }
.ach-show-title {
    font-size: 26px;
    font-weight: 800;
    color: var(--text);
    letter-spacing: -0.5px;
    margin-bottom: 8px;
}
.ach-show-desc {
    font-size: 14.5px;
    color: var(--muted);
    line-height: 1.7;
    margin-bottom: 24px;
}

/* Meta row */
.ach-meta-row {
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
    margin-bottom: 24px;
}
.ach-meta-chip {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 14px;
    border-radius: 99px;
    font-size: 12px;
    font-weight: 600;
}

/* Progress section */
.prog-section { margin-bottom: 24px; }
.prog-label-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 10px;
}
.prog-label { font-size: 13px; font-weight: 700; color: var(--text); }
.prog-values { font-size: 13px; color: var(--muted); }
.prog-values strong { color: var(--text); font-weight: 800; }
.prog-bar {
    height: 10px;
    background: #F1F5F9;
    border-radius: 99px;
    overflow: hidden;
    margin-bottom: 6px;
}
.prog-fill {
    height: 100%;
    border-radius: 99px;
    transition: width 1s cubic-bezier(0.4,0,0.2,1);
}
.prog-pct { font-size: 12px; color: var(--muted); font-weight: 600; text-align: right; }

/* Requirement box */
.req-box {
    background: #F8FAFC;
    border: 1px solid var(--border);
    border-radius: 14px;
    padding: 18px 20px;
    margin-bottom: 20px;
    display: flex;
    align-items: flex-start;
    gap: 14px;
}
.req-box-icon {
    width: 40px; height: 40px;
    border-radius: 11px;
    background: var(--p10);
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}
.req-box-title { font-size: 13px; font-weight: 700; color: var(--text); margin-bottom: 4px; }
.req-box-sub   { font-size: 12px; color: var(--muted); line-height: 1.5; }

/* Unlock date box */
.unlock-box {
    background: var(--s10);
    border: 1px solid #A7F3D0;
    border-radius: 14px;
    padding: 16px 20px;
    display: flex;
    align-items: center;
    gap: 14px;
    margin-bottom: 24px;
}
.unlock-box-icon {
    width: 40px; height: 40px;
    border-radius: 50%;
    background: #D1FAE5;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
    color: var(--success);
}
.unlock-box-title { font-size: 13px; font-weight: 700; color: #065F46; }
.unlock-box-sub   { font-size: 12px; color: #047857; margin-top: 2px; }

/* Admin actions */
.admin-actions {
    display: flex;
    gap: 10px;
    margin-bottom: 24px;
    flex-wrap: wrap;
}
.btn {
    display: inline-flex; align-items: center; gap: 7px;
    padding: 9px 18px; border-radius: 10px;
    font-size: 13px; font-weight: 600; font-family: inherit;
    cursor: pointer; text-decoration: none; border: none;
    transition: all 0.15s;
}
.btn-primary { background: var(--primary); color: #fff; }
.btn-primary:hover { background: #1D4ED8; }
.btn-warning { background: var(--w10); color: #92400E; }
.btn-warning:hover { background: #FDE68A; }
.btn-danger  { background: var(--d10); color: var(--danger); }
.btn-danger:hover { background: #FECACA; }
.btn-ghost   { background: #F8FAFC; color: var(--muted); border: 1px solid var(--border); }
.btn-ghost:hover { background: #F1F5F9; color: var(--text); }

/* ── Sidebar panels ───────────────────────────────────────────────────── */
.panel { background: var(--surface); border-radius: var(--r-card); box-shadow: var(--shadow); margin-bottom: 20px; }
.panel-header {
    padding: 18px 22px 14px;
    border-bottom: 1px solid var(--border);
    display: flex; align-items: center; gap: 10px;
}
.panel-icon {
    width: 32px; height: 32px;
    border-radius: 9px;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}
.panel-title { font-size: 14px; font-weight: 700; color: var(--text); }
.panel-body  { padding: 16px 22px 20px; }

/* Earners list */
.earner-row {
    display: flex; align-items: center; gap: 12px;
    padding: 10px 0;
    border-bottom: 1px solid #F3F4F6;
}
.earner-row:last-child { border-bottom: none; }
.earner-avatar {
    width: 36px; height: 36px; border-radius: 50%;
    background: var(--primary);
    display: flex; align-items: center; justify-content: center;
    color: #fff; font-size: 13px; font-weight: 700; flex-shrink: 0;
}
.earner-name  { font-size: 13px; font-weight: 600; color: var(--text); }
.earner-date  { font-size: 11px; color: var(--muted); }
.earner-badge {
    margin-left: auto;
    font-size: 10px; font-weight: 700;
    background: var(--s10); color: var(--success);
    padding: 2px 8px; border-radius: 99px;
}

/* Related grid */
.related-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 12px;
}
.related-card {
    border: 1px solid var(--border);
    border-radius: 14px;
    padding: 14px 12px;
    text-decoration: none;
    color: inherit;
    transition: box-shadow 0.2s, transform 0.2s;
    display: block;
}
.related-card:hover { box-shadow: var(--shadow-md); transform: translateY(-2px); }
.related-card-icon { font-size: 24px; margin-bottom: 6px; }
.related-card-title { font-size: 12px; font-weight: 700; color: var(--text); line-height: 1.3; margin-bottom: 4px; }
.related-card-xp { font-size: 11px; color: var(--warning); font-weight: 600; }

/* Fade in */
.fade-in { animation: fadeIn 0.4s ease both; }
@keyframes fadeIn { from { opacity:0; transform:translateY(10px); } to { opacity:1; transform:none; } }
.d1 { animation-delay: 0.05s; }
.d2 { animation-delay: 0.12s; }
.d3 { animation-delay: 0.18s; }

@media (max-width: 900px) {
    .show-layout { grid-template-columns: 1fr; }
    .related-grid { grid-template-columns: 1fr; }
}
@media (max-width: 600px) {
    .ach-show-body { padding: 20px 18px; }
    .ach-show-title { font-size: 20px; }
}
</style>

<div style="padding: 28px 32px;">

    {{-- Breadcrumb --}}
    <div class="breadcrumb fade-in d1">
        <a href="{{ route('achievements.index') }}">Pencapaian</a>
        <span class="breadcrumb-sep">›</span>
        <span class="breadcrumb-current">{{ $achievement->title }}</span>
    </div>

    <div class="show-layout">

        {{-- ── KIRI: Detail utama ────────────────────────────────────────── --}}
        <div>

            {{-- Hero card --}}
            <div class="ach-show-hero fade-in d1">
                <div class="ach-show-hero-top" style="background: {{ $achievement->gradient }};">

                    <span class="ach-show-rarity"
                          style="background: {{ $achievement->rarityBg }}; color: {{ $achievement->rarityColor }};">
                        {{ $achievement->rarityLabel }}
                    </span>

                    <span class="ach-show-status"
                          style="{{ $isUnlocked
                              ? 'background: rgba(16,185,129,0.9); color:#fff;'
                              : 'background: rgba(0,0,0,0.4); color:rgba(255,255,255,0.85);' }}">
                        @if($isUnlocked)
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                            Sudah Dibuka
                        @else
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                            Terkunci
                        @endif
                    </span>

                    <div class="ach-show-icon">{{ $achievement->icon ?? $achievement->badge_icon ?? '🏅' }}</div>
                </div>

                <div class="ach-show-body">
                    <h1 class="ach-show-title">{{ $achievement->title }}</h1>
                    <p class="ach-show-desc">{{ $achievement->description }}</p>

                    {{-- Meta chips --}}
                    <div class="ach-meta-row">
                        <span class="ach-meta-chip" style="background: var(--p10); color: var(--primary);">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                            {{ $achievement->categoryLabel }}
                        </span>
                        <span class="ach-meta-chip"
                              style="background: {{ $achievement->rarityBg }}; color: {{ $achievement->rarityColor }};">
                            {{ $achievement->rarityLabel }}
                        </span>
                        <span class="ach-meta-chip" style="background: var(--w10); color: #92400E;">
                            ⭐ {{ number_format($achievement->xp_reward) }} XP
                        </span>
                    </div>

                    {{-- Unlock date box --}}
                    @if($isUnlocked && $userAchievement)
                    <div class="unlock-box">
                        <div class="unlock-box-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                        </div>
                        <div>
                            <div class="unlock-box-title">Achievement Berhasil Diraih! 🎉</div>
                            <div class="unlock-box-sub">
                                Kamu membuka achievement ini pada
                                {{ \Carbon\Carbon::parse($userAchievement->earned_at)->translatedFormat('l, d F Y — H:i') }} WIB
                            </div>
                        </div>
                    </div>
                    @endif

                    {{-- Requirement --}}
                    @if($achievement->requirement_type && $achievement->requirement_value)
                    <div class="req-box">
                        <div class="req-box-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#2563EB" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/>
                            </svg>
                        </div>
                        <div>
                            <div class="req-box-title">Syarat untuk Membuka</div>
                            <div class="req-box-sub">
                                Capai <strong>{{ number_format($achievement->requirement_value) }}</strong>
                                {{ str_replace('_', ' ', $achievement->requirement_type) }}.
                            </div>
                        </div>
                    </div>
                    @endif

                    {{-- Progress --}}
                    <div class="prog-section">
                        <div class="prog-label-row">
                            <span class="prog-label">Progress Kamu</span>
                            <span class="prog-values">
                                <strong>{{ number_format($currentProgress) }}</strong>
                                / {{ number_format($achievement->requirement_value) }}
                            </span>
                        </div>
                        <div class="prog-bar">
                            <div class="prog-fill"
                                 data-pct="{{ $progressPct }}"
                                 style="width: 0%; background: {{ $isUnlocked ? '#10B981' : '#2563EB' }};">
                            </div>
                        </div>
                        <div class="prog-pct">{{ $progressPct }}% selesai</div>
                    </div>

                    {{-- Admin actions --}}
                    <div class="admin-actions">
                        <a href="{{ route('achievements.edit', $achievement) }}" class="btn btn-warning">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                            Edit Achievement
                        </a>
                        <a href="{{ route('achievements.index') }}" class="btn btn-ghost">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
                            Kembali
                        </a>
                        <form method="POST" action="{{ route('achievements.destroy', $achievement) }}"
                              onsubmit="return confirm('Yakin ingin menghapus achievement ini?');"
                              style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>

        </div>{{-- /left --}}

        {{-- ── KANAN: Sidebar ─────────────────────────────────────────────── --}}
        <div>

            {{-- Earners panel --}}
            <div class="panel fade-in d2">
                <div class="panel-header">
                    <div class="panel-icon" style="background: var(--w10);">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#F59E0B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                        </svg>
                    </div>
                    <div class="panel-title">Siapa yang Meraih</div>
                </div>
                <div class="panel-body" style="padding-top: 8px; padding-bottom: 8px;">
                    @forelse($earners as $i => $ua)
                    <div class="earner-row">
                        <div class="earner-avatar" style="background: {{ ['#2563EB','#10B981','#F59E0B','#8B5CF6','#EF4444'][$i % 5] }};">
                            {{ strtoupper(substr($ua->user->name ?? 'U', 0, 2)) }}
                        </div>
                        <div>
                            <div class="earner-name">{{ $ua->user->name ?? 'Pengguna' }}</div>
                            <div class="earner-date">{{ \Carbon\Carbon::parse($ua->earned_at)->diffForHumans() }}</div>
                        </div>
                        @if($i === 0)
                        <span class="earner-badge">Pertama! 🥇</span>
                        @endif
                    </div>
                    @empty
                    <p style="font-size:13px; color: var(--muted); text-align:center; padding: 16px 0;">
                        Belum ada yang meraih achievement ini.
                    </p>
                    @endforelse
                </div>
            </div>

            {{-- Related achievements --}}
            @if($related->isNotEmpty())
            <div class="panel fade-in d3">
                <div class="panel-header">
                    <div class="panel-icon" style="background: var(--p10);">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#2563EB" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="8" r="6"/><path d="M15.477 12.89L17 22l-5-3-5 3 1.523-9.11"/>
                        </svg>
                    </div>
                    <div class="panel-title">Achievement Terkait</div>
                </div>
                <div class="panel-body">
                    <div class="related-grid">
                        @foreach($related as $rel)
                        <a href="{{ route('achievements.show', $rel) }}" class="related-card">
                            <div class="related-card-icon">{{ $rel->icon ?? $rel->badge_icon ?? '🏅' }}</div>
                            <div class="related-card-title">{{ $rel->title }}</div>
                            <div class="related-card-xp">⭐ {{ number_format($rel->xp_reward) }} XP</div>
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            {{-- Info panel --}}
            <div class="panel fade-in d3">
                <div class="panel-header">
                    <div class="panel-icon" style="background: #F0FDF4;">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#10B981" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/>
                        </svg>
                    </div>
                    <div class="panel-title">Informasi</div>
                </div>
                <div class="panel-body">
                    <table style="width:100%; border-collapse:collapse; font-size:13px;">
                        <tr>
                            <td style="padding:7px 0; color:var(--muted); width:50%;">Kategori</td>
                            <td style="padding:7px 0; font-weight:600; color:var(--text);">{{ $achievement->categoryLabel }}</td>
                        </tr>
                        <tr style="border-top:1px solid #F3F4F6;">
                            <td style="padding:7px 0; color:var(--muted);">Rarity</td>
                            <td style="padding:7px 0; font-weight:600;" style="color: {{ $achievement->rarityColor }};">
                                <span style="color: {{ $achievement->rarityColor }};">{{ $achievement->rarityLabel }}</span>
                            </td>
                        </tr>
                        <tr style="border-top:1px solid #F3F4F6;">
                            <td style="padding:7px 0; color:var(--muted);">XP Reward</td>
                            <td style="padding:7px 0; font-weight:700; color: #F59E0B;">{{ number_format($achievement->xp_reward) }} XP</td>
                        </tr>
                        <tr style="border-top:1px solid #F3F4F6;">
                            <td style="padding:7px 0; color:var(--muted);">Dibuat</td>
                            <td style="padding:7px 0; font-weight:600; color:var(--text);">{{ $achievement->created_at->format('d M Y') }}</td>
                        </tr>
                        <tr style="border-top:1px solid #F3F4F6;">
                            <td style="padding:7px 0; color:var(--muted);">Status</td>
                            <td style="padding:7px 0;">
                                @if($isUnlocked)
                                    <span style="color: #10B981; font-weight:700;">✓ Terbuka</span>
                                @else
                                    <span style="color: var(--muted); font-weight:600;">🔒 Terkunci</span>
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

        </div>{{-- /right --}}
    </div>{{-- /show-layout --}}

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const fill = document.querySelector('.prog-fill');
    if (fill) {
        const pct = fill.getAttribute('data-pct') || '0';
        fill.style.width = '0%';
        setTimeout(function () {
            fill.style.width = pct + '%';
        }, 300);
    }
});
</script>

</x-app-layout>