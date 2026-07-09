<x-app-layout>

@section('page-title', 'Learning Report')

<style>
:root {
    --primary: #2563EB; --p10: #EFF6FF;
    --success: #22C55E; --s10: #F0FDF4;
    --danger:  #EF4444; --d10: #FEF2F2;
    --gold:    #B45309; --gold-bg: #FFFBEB; --gold-border: #FDE68A;
    --purple:  #8B5CF6; --pur10: #F5F3FF;
    --bg:      #F8FAFC; --surface: #FFFFFF; --border: #E5E7EB;
    --text:    #1E293B; --muted: #64748B;
    --r-card:  20px;
    --shadow:  0 1px 3px rgba(0,0,0,0.06), 0 4px 16px rgba(0,0,0,0.05);
}

.page-wrap { padding: 28px; display:flex; flex-direction:column; gap:22px; }

.page-hero {
    background: linear-gradient(135deg, var(--primary), #1D4ED8);
    border-radius: var(--r-card); padding: 30px 34px; color:#fff; position:relative; overflow:hidden;
}
.page-hero::before { content:''; position:absolute; top:-70px; right:-40px; width:220px; height:220px; border-radius:50%; background:rgba(255,255,255,0.08); }
.page-hero-title { font-size:22px; font-weight:800; position:relative; z-index:1; }
.page-hero-sub { font-size:13.5px; opacity:0.85; margin-top:6px; position:relative; z-index:1; }

.summary-grid { display:grid; grid-template-columns:repeat(auto-fit, minmax(150px,1fr)); gap:14px; margin-top:22px; position:relative; z-index:1; }
.summary-card { background:rgba(255,255,255,0.12); border-radius:14px; padding:14px 16px; }
.summary-num { font-size:21px; font-weight:800; }
.summary-label { font-size:11.5px; opacity:0.85; margin-top:2px; }

.section-title { font-size:16px; font-weight:800; color:var(--text); margin-bottom:2px; display:flex; align-items:center; gap:8px; }
.section-sub { font-size:12.5px; color:var(--muted); margin-bottom:14px; }

.panel { background:var(--surface); border:1px solid var(--border); border-radius:var(--r-card); box-shadow:var(--shadow); padding:20px 24px; }

.stat-mini-grid { display:grid; grid-template-columns:repeat(auto-fit, minmax(140px,1fr)); gap:14px; }
.stat-mini { text-align:center; padding:14px 10px; border-radius:14px; background:#FAFBFC; border:1px solid var(--border); }
.stat-mini-num { font-size:20px; font-weight:800; color:var(--text); }
.stat-mini-num.success { color:#16A34A; }
.stat-mini-num.danger { color:#EF4444; }
.stat-mini-num.primary { color:var(--primary); }
.stat-mini-label { font-size:11.5px; color:var(--muted); margin-top:3px; }

.course-row { display:flex; align-items:center; gap:16px; padding:14px 0; border-bottom:1px solid var(--border); }
.course-row:last-child { border-bottom:none; }
.course-row-icon { width:42px; height:42px; border-radius:12px; flex-shrink:0; display:flex; align-items:center; justify-content:center; color:#fff; font-weight:800; font-size:15px; }
.course-row-body { flex:1; min-width:0; }
.course-row-title { font-size:13.5px; font-weight:700; color:var(--text); margin-bottom:6px; display:flex; align-items:center; gap:8px; flex-wrap:wrap; }
.course-row-meta { font-size:12px; color:var(--muted); }
.progress-track { height:7px; border-radius:99px; background:#F1F5F9; margin-top:8px; overflow:hidden; }
.progress-fill { height:100%; border-radius:99px; background:var(--primary); }
.course-row-pct { font-size:14px; font-weight:800; color:var(--text); width:44px; text-align:right; flex-shrink:0; }
.badge-cert { font-size:10.5px; font-weight:700; color:var(--gold); background:var(--gold-bg); border:1px solid var(--gold-border); padding:2px 8px; border-radius:99px; display:inline-flex; align-items:center; gap:4px; text-decoration:none; }

.empty-inline { text-align:center; padding:30px; color:var(--muted); font-size:13px; }

.cert-mini-list { display:flex; flex-direction:column; gap:10px; }
.cert-mini-row { display:flex; align-items:center; justify-content:space-between; gap:12px; padding:12px 14px; border:1px solid var(--gold-border); background:var(--gold-bg); border-radius:12px; text-decoration:none; color:inherit; }
.cert-mini-title { font-size:13px; font-weight:700; color:var(--text); }
.cert-mini-sub { font-size:11.5px; color:var(--muted); }
.cert-mini-arrow { color:var(--gold); flex-shrink:0; }

.two-col { display:grid; grid-template-columns: 2fr 1fr; gap:20px; align-items:start; }
@media (max-width: 900px) { .two-col { grid-template-columns: 1fr; } }
</style>

<div class="page-wrap">

    <div class="page-hero">
        <div class="page-hero-title">📊 Learning Report</div>
        <div class="page-hero-sub">Ringkasan menyeluruh perjalanan belajarmu di MathLingo AI.</div>

        <div class="summary-grid">
            <div class="summary-card">
                <div class="summary-num">{{ $summary['xp_total'] }}</div>
                <div class="summary-label">Total XP</div>
            </div>
            <div class="summary-card">
                <div class="summary-num">Lv. {{ $summary['level'] }}</div>
                <div class="summary-label">Level Saat Ini</div>
            </div>
            <div class="summary-card">
                <div class="summary-num">🔥 {{ $summary['streak_days'] }}</div>
                <div class="summary-label">Hari Beruntun</div>
            </div>
            <div class="summary-card">
                <div class="summary-num">{{ $summary['courses_completed'] }}/{{ $summary['courses_touched'] }}</div>
                <div class="summary-label">Kursus Selesai</div>
            </div>
            <div class="summary-card">
                <div class="summary-num">{{ $summary['lessons_completed'] }}</div>
                <div class="summary-label">Pelajaran Selesai</div>
            </div>
            <div class="summary-card">
                <div class="summary-num">🎓 {{ $summary['certificates_count'] }}</div>
                <div class="summary-label">Sertifikat</div>
            </div>
        </div>
    </div>

    <div class="two-col">
        <div style="display:flex; flex-direction:column; gap:20px;">

            <div class="panel">
                <div class="section-title">Progres per Kursus</div>
                <div class="section-sub">Persentase pelajaran yang sudah kamu selesaikan di tiap kursus.</div>

                @forelse($courseRows as $row)
                    <div class="course-row">
                        <div class="course-row-icon" style="background: {{ $row['course']->color }};">
                            {{ strtoupper(substr($row['course']->title, 0, 1)) }}
                        </div>
                        <div class="course-row-body">
                            <div class="course-row-title">
                                {{ $row['course']->title }}
                                @if($row['certificate'])
                                    <a href="{{ route('certificates.show', $row['certificate']->id) }}" class="badge-cert">🎓 Sertifikat</a>
                                @endif
                            </div>
                            <div class="course-row-meta">{{ $row['completed_lessons'] }}/{{ $row['total_lessons'] }} pelajaran · {{ $row['xp_earned'] }} XP</div>
                            <div class="progress-track"><div class="progress-fill" style="width:{{ $row['percent'] }}%; background:{{ $row['course']->color }};"></div></div>
                        </div>
                        <div class="course-row-pct">{{ $row['percent'] }}%</div>
                    </div>
                @empty
                    <div class="empty-inline">Belum ada progres kursus. Yuk mulai belajar!</div>
                @endforelse
            </div>

            <div class="panel">
                <div class="section-title">Performa Quiz</div>
                <div class="section-sub">Rekap seluruh soal quiz yang pernah kamu kerjakan.</div>
                <div class="stat-mini-grid">
                    <div class="stat-mini">
                        <div class="stat-mini-num success">{{ $correctAttempts }}</div>
                        <div class="stat-mini-label">Jawaban Benar</div>
                    </div>
                    <div class="stat-mini">
                        <div class="stat-mini-num danger">{{ $wrongAttempts }}</div>
                        <div class="stat-mini-label">Jawaban Salah</div>
                    </div>
                    <div class="stat-mini">
                        <div class="stat-mini-num primary">{{ $quizAccuracy }}%</div>
                        <div class="stat-mini-label">Akurasi</div>
                    </div>
                    <div class="stat-mini">
                        <div class="stat-mini-num">{{ $quizXpTotal }}</div>
                        <div class="stat-mini-label">XP dari Quiz</div>
                    </div>
                </div>
            </div>

        </div>

        <div style="display:flex; flex-direction:column; gap:20px;">

            <div class="panel">
                <div class="section-title">Vocabulary</div>
                <div class="section-sub">Istilah matematika yang sudah kamu pelajari.</div>
                <div class="stat-mini-grid">
                    <div class="stat-mini">
                        <div class="stat-mini-num primary">{{ $vocabMastered }}</div>
                        <div class="stat-mini-label">Dipelajari</div>
                    </div>
                    <div class="stat-mini">
                        <div class="stat-mini-num">{{ $vocabTotal }}</div>
                        <div class="stat-mini-label">Total Tersedia</div>
                    </div>
                </div>
            </div>

            <div class="panel">
                <div class="section-title">Pencapaian</div>
                <div class="section-sub">Badge yang berhasil kamu buka.</div>
                <div class="stat-mini-grid" style="grid-template-columns:1fr;">
                    <div class="stat-mini">
                        <div class="stat-mini-num primary">{{ $achievementsEarned }}/{{ $achievementsTotal }}</div>
                        <div class="stat-mini-label">Pencapaian Terbuka</div>
                    </div>
                </div>
                <a href="{{ route('achievements.index') }}" style="display:block; text-align:center; margin-top:12px; font-size:12.5px; font-weight:700; color:var(--primary); text-decoration:none;">Lihat semua pencapaian →</a>
            </div>

            <div class="panel">
                <div class="section-title">Sertifikat Terbaru</div>
                <div class="section-sub">Sertifikat kursus yang sudah kamu dapatkan.</div>

                @if($certificates->isEmpty())
                    <div class="empty-inline">Belum ada sertifikat.</div>
                @else
                    <div class="cert-mini-list">
                        @foreach($certificates->take(4) as $certificate)
                            <a href="{{ route('certificates.show', $certificate->id) }}" class="cert-mini-row">
                                <div>
                                    <div class="cert-mini-title">{{ $certificate->course->title }}</div>
                                    <div class="cert-mini-sub">{{ $certificate->issued_at->translatedFormat('d M Y') }}</div>
                                </div>
                                <svg class="cert-mini-arrow" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
                            </a>
                        @endforeach
                    </div>
                    <a href="{{ route('certificates.index') }}" style="display:block; text-align:center; margin-top:12px; font-size:12.5px; font-weight:700; color:var(--primary); text-decoration:none;">Lihat semua sertifikat →</a>
                @endif
            </div>

        </div>
    </div>

</div>

</x-app-layout>
