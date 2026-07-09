<x-admin-layout title="Dashboard">

<style>
/* ── Page wrapper ── */
.admin-page { padding: 28px 28px 0; }
.admin-page-header { margin-bottom: 24px; }
.admin-page-title { font-size: 22px; font-weight: 800; color: var(--color-text); margin: 0 0 4px; letter-spacing: -0.4px; }
.admin-page-sub   { font-size: 13.5px; color: var(--color-muted); margin: 0; }

/* ── KPI Grid ── */
.kpi-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 16px;
    margin-bottom: 24px;
}
@media (max-width: 1100px) { .kpi-grid { grid-template-columns: repeat(2, 1fr); } }
@media (max-width: 600px)  { .kpi-grid { grid-template-columns: 1fr; } }

.kpi-card {
    background: var(--color-surface);
    border: 1px solid var(--color-border);
    border-radius: var(--radius-card);
    padding: 20px 22px;
    display: flex; align-items: flex-start; gap: 16px;
    box-shadow: var(--shadow-card);
    transition: box-shadow 0.18s, transform 0.18s;
}
.kpi-card:hover { box-shadow: var(--shadow-card-hover); transform: translateY(-1px); }
.kpi-icon {
    width: 46px; height: 46px; border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}
.kpi-icon.blue   { background: var(--color-primary-10); color: var(--color-primary); }
.kpi-icon.green  { background: #DCFCE7; color: #16A34A; }
.kpi-icon.amber  { background: #FEF3C7; color: #D97706; }
.kpi-icon.purple { background: #F3E8FF; color: var(--color-purple); }
.kpi-icon.red    { background: #FEE2E2; color: var(--color-danger); }
.kpi-icon.teal   { background: #CCFBF1; color: #0D9488; }

.kpi-body { flex: 1; min-width: 0; }
.kpi-label { font-size: 12px; font-weight: 600; color: var(--color-muted); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 6px; }
.kpi-value { font-size: 28px; font-weight: 800; color: var(--color-text); letter-spacing: -0.5px; line-height: 1; margin-bottom: 8px; }
.kpi-badge {
    display: inline-flex; align-items: center; gap: 4px;
    font-size: 11px; font-weight: 600;
    padding: 3px 8px; border-radius: 6px;
}
.kpi-badge.coming { background: var(--color-primary-10); color: var(--color-primary); }
.kpi-badge.live    { background: #DCFCE7; color: #16A34A; }
.kpi-badge.neutral { background: var(--color-bg); color: var(--color-muted); }

/* ── Bottom grid ── */
.admin-bottom-grid {
    display: grid;
    grid-template-columns: 1fr 340px;
    gap: 16px;
    margin-bottom: 28px;
}
@media (max-width: 1000px) { .admin-bottom-grid { grid-template-columns: 1fr; } }

/* ── Panel card ── */
.panel-card {
    background: var(--color-surface);
    border: 1px solid var(--color-border);
    border-radius: var(--radius-card);
    box-shadow: var(--shadow-card);
    overflow: hidden;
}
.panel-card-header {
    display: flex; align-items: center; justify-content: space-between;
    padding: 18px 22px 16px;
    border-bottom: 1px solid var(--color-border);
}
.panel-card-title { font-size: 14px; font-weight: 700; color: var(--color-text); margin: 0; }
.panel-card-badge {
    font-size: 11px; font-weight: 600;
    background: var(--color-primary-10); color: var(--color-primary);
    padding: 3px 9px; border-radius: 6px;
}
.panel-card-body { padding: 22px; }

/* Chart placeholder */
.chart-placeholder {
    height: 200px;
    background: linear-gradient(135deg, var(--color-primary-10) 0%, #EFF6FF 100%);
    border-radius: 12px;
    display: flex; flex-direction: column;
    align-items: center; justify-content: center; gap: 8px;
    color: var(--color-primary);
}
.chart-placeholder svg { opacity: 0.4; }
.chart-placeholder-label { font-size: 13px; font-weight: 600; color: var(--color-muted); }

/* Quick actions */
.quick-actions { display: flex; flex-direction: column; gap: 10px; }
.quick-action-item {
    display: flex; align-items: center; gap: 12px;
    padding: 12px 14px; border-radius: 10px;
    background: var(--color-bg); border: 1px solid var(--color-border);
    text-decoration: none;
    transition: background 0.12s, border-color 0.12s, box-shadow 0.12s;
}
.quick-action-item:hover {
    background: var(--color-primary-10);
    border-color: var(--color-primary-20);
    box-shadow: 0 2px 8px rgba(37,99,235,0.07);
}
.quick-action-icon {
    width: 34px; height: 34px; border-radius: 9px;
    background: var(--color-surface);
    border: 1px solid var(--color-border);
    display: flex; align-items: center; justify-content: center;
    color: var(--color-primary); flex-shrink: 0;
}
.quick-action-label { font-size: 13px; font-weight: 600; color: var(--color-text); }
.quick-action-sub   { font-size: 11px; color: var(--color-muted); margin-top: 1px; }
.quick-action-arrow { margin-left: auto; color: var(--color-muted); }

/* Activity list */
.activity-list { display: flex; flex-direction: column; gap: 14px; }
.activity-item { display: flex; align-items: flex-start; gap: 12px; }
.activity-dot {
    width: 8px; height: 8px; border-radius: 50%;
    background: var(--color-primary); flex-shrink: 0; margin-top: 5px;
}
.activity-text { font-size: 13px; color: var(--color-text); font-weight: 500; line-height: 1.4; }
.activity-time { font-size: 11px; color: var(--color-muted); margin-top: 2px; }
.activity-empty { text-align: center; padding: 24px 10px; color: var(--color-muted); font-size: 13px; }

/* Placeholder notice */
.placeholder-notice {
    text-align: center; padding: 32px 20px;
    color: var(--color-muted);
}
.placeholder-notice svg { margin-bottom: 10px; opacity: 0.3; }
.placeholder-notice p { font-size: 13px; font-weight: 500; margin: 0; }
</style>

<div class="admin-page">

    {{-- Page Header --}}
    <div class="admin-page-header">
        <h1 class="admin-page-title">Dashboard</h1>
        <p class="admin-page-sub">Selamat datang kembali, {{ auth()->user()->name }}. Berikut ringkasan platform MathLingo AI.</p>
    </div>

    {{-- KPI Cards --}}
    <div class="kpi-grid">

        <div class="kpi-card">
            <div class="kpi-icon blue">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                    <circle cx="9" cy="7" r="4"/>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                </svg>
            </div>
            <div class="kpi-body">
                <div class="kpi-label">Total Pengguna</div>
                <div class="kpi-value">{{ number_format($stats['total_users']) }}</div>
                @if($stats['new_users_this_month'] > 0)
                    <span class="kpi-badge live">+{{ number_format($stats['new_users_this_month']) }} bulan ini</span>
                @else
                    <span class="kpi-badge neutral">Belum ada pengguna baru bulan ini</span>
                @endif
            </div>
        </div>

        <div class="kpi-card">
            <div class="kpi-icon green">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/>
                    <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/>
                </svg>
            </div>
            <div class="kpi-body">
                <div class="kpi-label">Total Kursus</div>
                <div class="kpi-value">{{ number_format($stats['total_courses']) }}</div>
                @if($stats['new_courses_this_month'] > 0)
                    <span class="kpi-badge live">+{{ number_format($stats['new_courses_this_month']) }} bulan ini</span>
                @else
                    <span class="kpi-badge neutral">Tidak ada kursus baru bulan ini</span>
                @endif
            </div>
        </div>

        <div class="kpi-card">
            <div class="kpi-icon amber">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                    <polyline points="14 2 14 8 20 8"/>
                    <line x1="16" y1="13" x2="8" y2="13"/>
                    <line x1="16" y1="17" x2="8" y2="17"/>
                </svg>
            </div>
            <div class="kpi-body">
                <div class="kpi-label">Total Pelajaran</div>
                <div class="kpi-value">{{ number_format($stats['total_lessons']) }}</div>
                <span class="kpi-badge neutral">Tersebar di {{ number_format($stats['total_courses']) }} kursus</span>
            </div>
        </div>

        <div class="kpi-card">
            <div class="kpi-icon purple">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="4 7 4 4 20 4 20 7"/>
                    <line x1="9" y1="20" x2="15" y2="20"/>
                    <line x1="12" y1="4" x2="12" y2="20"/>
                </svg>
            </div>
            <div class="kpi-body">
                <div class="kpi-label">Total Kosakata</div>
                <div class="kpi-value">{{ number_format($stats['total_vocabulary']) }}</div>
                <span class="kpi-badge neutral">Tersebar di {{ number_format($stats['total_lessons']) }} pelajaran</span>
            </div>
        </div>

        <div class="kpi-card">
            <div class="kpi-icon teal">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                </svg>
            </div>
            <div class="kpi-body">
                <div class="kpi-label">Total Percakapan AI</div>
                <div class="kpi-value">{{ number_format($stats['total_conversations']) }}</div>
                @if($stats['new_conversations_this_month'] > 0)
                    <span class="kpi-badge live">+{{ number_format($stats['new_conversations_this_month']) }} bulan ini</span>
                @else
                    <span class="kpi-badge neutral">Belum ada percakapan baru bulan ini</span>
                @endif
            </div>
        </div>

        <div class="kpi-card">
            <div class="kpi-icon red">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="8" r="6"/>
                    <path d="M15.477 12.89L17 22l-5-3-5 3 1.523-9.11"/>
                </svg>
            </div>
            <div class="kpi-body">
                <div class="kpi-label">Total Pencapaian</div>
                <div class="kpi-value">{{ number_format($stats['total_achievements']) }}</div>
                @if($stats['new_achievements_this_month'] > 0)
                    <span class="kpi-badge live">+{{ number_format($stats['new_achievements_this_month']) }} diraih bulan ini</span>
                @else
                    <span class="kpi-badge neutral">Belum ada pencapaian baru bulan ini</span>
                @endif
            </div>
        </div>

    </div>

    {{-- Bottom Grid: Chart + Quick Actions --}}
    <div class="admin-bottom-grid">

        {{-- Grafik Placeholder --}}
        <div class="panel-card">
            <div class="panel-card-header">
                <h2 class="panel-card-title">Grafik Pertumbuhan Pengguna</h2>
                <span class="panel-card-badge">30 hari terakhir</span>
            </div>
            <div class="panel-card-body">
                <div style="height:220px; position:relative;">
                    <canvas id="userGrowthChart"></canvas>
                </div>

                <div style="margin-top:20px;">
                    <div class="panel-card-header" style="border:none;padding:0 0 14px;">
                        <h2 class="panel-card-title">Aktivitas Terbaru</h2>
                    </div>

                    @if($recentActivities->isEmpty())
                        <div class="placeholder-notice">
                            <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"/>
                                <polyline points="12 6 12 12 16 14"/>
                            </svg>
                            <p>Belum ada aktivitas untuk ditampilkan.</p>
                        </div>
                    @else
                        <div class="activity-list">
                            @foreach($recentActivities as $activity)
                                <div class="activity-item">
                                    <div class="activity-dot"></div>
                                    <div>
                                        <div class="activity-text">{{ $activity['text'] }}</div>
                                        <div class="activity-time">{{ \Illuminate\Support\Carbon::parse($activity['time'])->diffForHumans() }}</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Quick Actions --}}
        <div class="panel-card">
            <div class="panel-card-header">
                <h2 class="panel-card-title">Aksi Cepat</h2>
            </div>
            <div class="panel-card-body">
                <div class="quick-actions">

                    <a href="{{ route('admin.users.index') }}" class="quick-action-item">
                        <div class="quick-action-icon">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                                <circle cx="9" cy="7" r="4"/>
                            </svg>
                        </div>
                        <div>
                            <div class="quick-action-label">Kelola Pengguna</div>
                            <div class="quick-action-sub">Manajemen Pengguna</div>
                        </div>
                        <div class="quick-action-arrow">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="9 18 15 12 9 6"/>
                            </svg>
                        </div>
                    </a>

                    <a href="{{ route('admin.courses.index') }}" class="quick-action-item">
                        <div class="quick-action-icon">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/>
                                <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/>
                            </svg>
                        </div>
                        <div>
                            <div class="quick-action-label">Kelola Kursus</div>
                            <div class="quick-action-sub">Manajemen Kursus</div>
                        </div>
                        <div class="quick-action-arrow">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="9 18 15 12 9 6"/>
                            </svg>
                        </div>
                    </a>

                    <a href="{{ route('admin.vocabulary.index') }}" class="quick-action-item">
                        <div class="quick-action-icon">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="4 7 4 4 20 4 20 7"/>
                                <line x1="9" y1="20" x2="15" y2="20"/>
                                <line x1="12" y1="4" x2="12" y2="20"/>
                            </svg>
                        </div>
                        <div>
                            <div class="quick-action-label">Kelola Kosakata</div>
                            <div class="quick-action-sub">Manajemen Kosakata</div>
                        </div>
                        <div class="quick-action-arrow">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="9 18 15 12 9 6"/>
                            </svg>
                        </div>
                    </a>

                    <a href="{{ route('admin.statistics.index') }}" class="quick-action-item">
                        <div class="quick-action-icon">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="18" y1="20" x2="18" y2="10"/>
                                <line x1="12" y1="20" x2="12" y2="4"/>
                                <line x1="6" y1="20" x2="6" y2="14"/>
                            </svg>
                        </div>
                        <div>
                            <div class="quick-action-label">Lihat Statistik</div>
                            <div class="quick-action-sub">Analitik Platform</div>
                        </div>
                        <div class="quick-action-arrow">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="9 18 15 12 9 6"/>
                            </svg>
                        </div>
                    </a>

                    <a href="{{ route('admin.settings.index') }}" class="quick-action-item">
                        <div class="quick-action-icon">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="3"/>
                                <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06A1.65 1.65 0 0 0 15 19.4a1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9 1.65 1.65 0 0 0 4.27 7.18l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/>
                            </svg>
                        </div>
                        <div>
                            <div class="quick-action-label">Pengaturan Sistem</div>
                            <div class="quick-action-sub">Konfigurasi Platform</div>
                        </div>
                        <div class="quick-action-arrow">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="9 18 15 12 9 6"/>
                            </svg>
                        </div>
                    </a>

                </div>
            </div>
        </div>

    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('userGrowthChart');
        console.log('[chart-debug] canvas element:', ctx);
        console.log('[chart-debug] Chart global loaded?', typeof Chart);

        if (!ctx) {
            console.error('[chart-debug] STOP: elemen canvas #userGrowthChart tidak ditemukan di DOM.');
            return;
        }
        if (typeof Chart === 'undefined') {
            console.error('[chart-debug] STOP: library Chart.js gagal dimuat (cek tab Network untuk chart.umd.min.js).');
            return;
        }

        const chartData = @json($chartData);
        console.log('[chart-debug] chartData dari server:', chartData);

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: chartData.labels,
                datasets: [{
                    label: 'Pengguna Baru',
                    data: chartData.data,
                    borderColor: '#2563EB',
                    backgroundColor: 'rgba(37, 99, 235, 0.1)',
                    borderWidth: 2,
                    pointBackgroundColor: '#2563EB',
                    pointRadius: 4,
                    tension: 0.35,
                    fill: true,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: (item) => `${item.parsed.y} pengguna baru`
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { precision: 0 },
                        grid: { color: 'rgba(0,0,0,0.05)' }
                    },
                    x: {
                        grid: { display: false },
                        ticks: {
                            autoSkip: true,
                            maxTicksLimit: 10,
                            maxRotation: 45,
                            minRotation: 0
                        }
                    }
                }
            }
        });
    });
</script>

</x-admin-layout>