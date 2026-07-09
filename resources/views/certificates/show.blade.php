<x-app-layout>

@section('page-title', 'Sertifikat')

<style>
:root {
    --primary: #2563EB; --p10: #EFF6FF;
    --gold:    #B45309; --gold-bg: #FFFBEB; --gold-border: #FDE68A;
    --bg:      #F8FAFC; --surface: #FFFFFF; --border: #E5E7EB;
    --text:    #1E293B; --muted: #64748B;
    --r-card:  20px;
    --shadow:  0 1px 3px rgba(0,0,0,0.06), 0 4px 16px rgba(0,0,0,0.05);
}

.cert-page-wrap { padding: 28px; max-width: 980px; margin: 0 auto; }

.breadcrumb { display:flex; align-items:center; gap:6px; font-size:13px; font-weight:500; color:var(--muted); margin-bottom:18px; }
.breadcrumb a { color:var(--muted); text-decoration:none; }
.breadcrumb a:hover { color:var(--primary); }

.cert-actions { display:flex; justify-content:flex-end; gap:10px; margin-bottom:18px; }
.btn-cert { padding:10px 20px; border-radius:11px; font-size:13.5px; font-weight:700; display:inline-flex; align-items:center; gap:8px; text-decoration:none; cursor:pointer; border:none; font-family:inherit; }
.btn-cert.primary { background:var(--primary); color:#fff; }
.btn-cert.ghost { background:#fff; border:1.5px solid var(--border); color:var(--text); }

/* ── Sertifikat itu sendiri ── */
.cert-frame {
    background: linear-gradient(135deg, #FFFDF7, #FFFFFF);
    border-radius: var(--r-card);
    box-shadow: var(--shadow);
    padding: 10px;
    margin-bottom: 22px;
}
.cert-inner {
    border: 3px solid var(--gold-border);
    border-radius: 14px;
    padding: 56px 60px;
    text-align: center;
    position: relative;
    background:
        radial-gradient(circle at top left, rgba(180,83,9,0.06), transparent 40%),
        radial-gradient(circle at bottom right, rgba(37,99,235,0.06), transparent 40%);
}
.cert-corner { position:absolute; width:34px; height:34px; border: 3px solid var(--gold); }
.cert-corner.tl { top:10px; left:10px; border-right:none; border-bottom:none; }
.cert-corner.tr { top:10px; right:10px; border-left:none; border-bottom:none; }
.cert-corner.bl { bottom:10px; left:10px; border-right:none; border-top:none; }
.cert-corner.br { bottom:10px; right:10px; border-left:none; border-top:none; }

.cert-logo { font-size:13px; font-weight:800; letter-spacing:0.12em; text-transform:uppercase; color:var(--primary); margin-bottom:22px; }
.cert-kicker { font-size:12.5px; font-weight:700; letter-spacing:0.15em; text-transform:uppercase; color:var(--gold); margin-bottom:10px; }
.cert-title { font-size:30px; font-weight:800; color:var(--text); margin-bottom:22px; font-family: Georgia, 'Times New Roman', serif; }
.cert-presented { font-size:13.5px; color:var(--muted); margin-bottom:6px; }
.cert-name { font-size:34px; font-weight:800; color:var(--primary); font-family: Georgia, 'Times New Roman', serif; margin-bottom:20px; }
.cert-desc { font-size:14.5px; color:var(--text); line-height:1.7; max-width:560px; margin:0 auto 26px; }
.cert-desc b { color:var(--primary); }

.cert-meta-row { display:flex; justify-content:center; gap:60px; margin-top:10px; }
.cert-meta { text-align:center; }
.cert-meta-label { font-size:10.5px; font-weight:700; text-transform:uppercase; letter-spacing:0.08em; color:var(--muted); margin-bottom:4px; }
.cert-meta-value { font-size:13.5px; font-weight:700; color:var(--text); }

.cert-footer { margin-top:34px; display:flex; justify-content:space-between; align-items:flex-end; }
.cert-signature { text-align:center; }
.cert-signature-line { width:160px; border-top:1.5px solid var(--text); margin-bottom:6px; }
.cert-signature-name { font-size:12.5px; font-weight:700; color:var(--text); }
.cert-signature-role { font-size:11px; color:var(--muted); }
.cert-badge { width:64px; height:64px; border-radius:50%; background: var(--gold-bg); border:2px solid var(--gold-border); display:flex; align-items:center; justify-content:center; color:var(--gold); }

.cert-number { margin-top:26px; font-size:11px; color:var(--muted); letter-spacing:0.05em; }

.stats-row { display:grid; grid-template-columns:repeat(3,1fr); gap:14px; }
.stat-card { background:var(--surface); border:1px solid var(--border); border-radius:16px; box-shadow:var(--shadow); padding:16px 18px; text-align:center; }
.stat-card-num { font-size:20px; font-weight:800; color:var(--text); }
.stat-card-label { font-size:11.5px; color:var(--muted); margin-top:2px; }

@media print {
    .breadcrumb, .cert-actions, .stats-row, x-app-layout header, .sidebar, nav { display:none !important; }
    .cert-page-wrap { padding: 0; max-width:none; }
    .cert-frame { box-shadow:none; }
    body { background:#fff; }
}

@media (max-width: 700px) {
    .cert-inner { padding: 34px 22px; }
    .cert-title { font-size:22px; }
    .cert-name { font-size:24px; }
    .cert-meta-row { flex-wrap:wrap; gap:24px; }
    .cert-footer { flex-direction:column; gap:18px; align-items:center; text-align:center; }
}
</style>

<div class="cert-page-wrap">

    <div class="breadcrumb">
        <a href="{{ route('certificates.index') }}">Sertifikat</a>
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
        <span style="color:var(--text);font-weight:600;">{{ $certificate->course->title }}</span>
    </div>

    <div class="cert-actions">
        <a href="{{ route('certificates.index') }}" class="btn-cert ghost">Kembali</a>
        <button type="button" class="btn-cert ghost" onclick="window.print()">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
            Print
        </button>
        <a href="{{ route('certificates.download', $certificate->id) }}" class="btn-cert primary">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
            Download PDF
        </a>
    </div>

    <div class="cert-frame">
        <div class="cert-inner">
            <span class="cert-corner tl"></span>
            <span class="cert-corner tr"></span>
            <span class="cert-corner bl"></span>
            <span class="cert-corner br"></span>

            <div class="cert-logo">📐 MathLingo AI</div>
            <div class="cert-kicker">Sertifikat Penyelesaian</div>
            <div class="cert-title">Certificate of Completion</div>

            <div class="cert-presented">Dengan bangga diberikan kepada</div>
            <div class="cert-name">{{ $certificate->user->name }}</div>

            <div class="cert-desc">
                Atas keberhasilan menyelesaikan seluruh materi kursus
                <b>{{ $certificate->course->title }}</b> di MathLingo AI,
                mencakup {{ $certificate->total_lessons }} pelajaran dengan penuh dedikasi.
            </div>

            <div class="cert-meta-row">
                <div class="cert-meta">
                    <div class="cert-meta-label">Diterbitkan</div>
                    <div class="cert-meta-value">{{ $certificate->issued_at->translatedFormat('d F Y') }}</div>
                </div>
                <div class="cert-meta">
                    <div class="cert-meta-label">Total XP</div>
                    <div class="cert-meta-value">{{ $certificate->total_xp_earned }} XP</div>
                </div>
                @if($certificate->quiz_score_percent !== null)
                <div class="cert-meta">
                    <div class="cert-meta-label">Skor Quiz</div>
                    <div class="cert-meta-value">{{ $certificate->quiz_score_percent }}%</div>
                </div>
                @endif
            </div>

            <div class="cert-footer">
                <div class="cert-signature">
                    <div class="cert-signature-line"></div>
                    <div class="cert-signature-name">MathLingo AI</div>
                    <div class="cert-signature-role">Learning Platform</div>
                </div>
                <div class="cert-badge">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="6"/><path d="M15.477 12.89L17 22l-5-3-5 3 1.523-9.11"/></svg>
                </div>
                <div class="cert-signature">
                    <div class="cert-signature-line"></div>
                    <div class="cert-signature-name">Admin1</div>
                    <div class="cert-signature-role">Administrator</div>
                </div>
            </div>

            <div class="cert-number">No. Sertifikat: {{ $certificate->certificate_number }} · Verifikasi keaslian di MathLingo AI</div>
        </div>
    </div>

    <div class="stats-row">
        <div class="stat-card">
            <div class="stat-card-num">{{ $certificate->total_lessons }}</div>
            <div class="stat-card-label">Pelajaran Diselesaikan</div>
        </div>
        <div class="stat-card">
            <div class="stat-card-num">{{ $certificate->total_xp_earned }}</div>
            <div class="stat-card-label">Total XP</div>
        </div>
        <div class="stat-card">
            <div class="stat-card-num">{{ $certificate->quiz_score_percent !== null ? $certificate->quiz_score_percent . '%' : '-' }}</div>
            <div class="stat-card-label">Skor Quiz Rata-rata</div>
        </div>
    </div>

</div>

</x-app-layout>
