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

.page-wrap { padding: 28px; }

.page-hero {
    background: linear-gradient(135deg, var(--primary), #1D4ED8);
    border-radius: var(--r-card); padding: 32px 36px; color: #fff; margin-bottom: 24px;
    position: relative; overflow: hidden;
}
.page-hero::before { content:''; position:absolute; top:-70px; right:-40px; width:220px; height:220px; border-radius:50%; background:rgba(255,255,255,0.08); }
.page-hero-title { font-size:22px; font-weight:800; position:relative; z-index:1; }
.page-hero-sub { font-size:13.5px; opacity:0.85; margin-top:6px; position:relative; z-index:1; max-width:520px; }

.cert-grid { display:grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap:18px; }

.cert-card {
    background: var(--surface); border:1px solid var(--border); border-radius: var(--r-card);
    box-shadow: var(--shadow); overflow:hidden; text-decoration:none; color:inherit;
    transition: transform 0.15s;
}
.cert-card:hover { transform: translateY(-2px); }
.cert-card-ribbon {
    height: 90px; background: linear-gradient(135deg, var(--gold-bg), #fff);
    border-bottom: 1px solid var(--gold-border);
    display:flex; align-items:center; justify-content:center; color: var(--gold);
}
.cert-card-body { padding: 16px 18px 18px; }
.cert-card-title { font-size:14.5px; font-weight:800; color:var(--text); margin-bottom:6px; }
.cert-card-meta { font-size:12px; color:var(--muted); display:flex; align-items:center; gap:6px; margin-bottom:4px; }
.cert-card-number { font-size:11px; color:var(--muted); margin-top:8px; padding-top:8px; border-top:1px dashed var(--border); }

.empty-state { text-align:center; padding:60px 20px; background:var(--surface); border-radius:var(--r-card); box-shadow:var(--shadow); color:var(--muted); }
.empty-state svg { color:var(--gold); margin-bottom:14px; }
.empty-state-title { font-size:15px; font-weight:700; color:var(--text); margin-bottom:6px; }
</style>

<div class="page-wrap">

    <div class="page-hero">
        <div class="page-hero-title">🎓 Sertifikat Saya</div>
        <div class="page-hero-sub">Semua sertifikat yang kamu dapatkan setelah menyelesaikan sebuah kursus di MathLingo AI, lengkap dengan nomor unik yang bisa diverifikasi.</div>
    </div>

    @if($certificates->isEmpty())
        <div class="empty-state">
            <svg width="46" height="46" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="6"/><path d="M15.477 12.89L17 22l-5-3-5 3 1.523-9.11"/></svg>
            <div class="empty-state-title">Belum ada sertifikat</div>
            <div>Selesaikan semua pelajaran dalam satu kursus untuk mendapatkan sertifikat pertamamu.</div>
        </div>
    @else
        <div class="cert-grid">
            @foreach($certificates as $certificate)
                <a href="{{ route('certificates.show', $certificate->id) }}" class="cert-card">
                    <div class="cert-card-ribbon">
                        <svg width="34" height="34" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="6"/><path d="M15.477 12.89L17 22l-5-3-5 3 1.523-9.11"/></svg>
                    </div>
                    <div class="cert-card-body">
                        <div class="cert-card-title">{{ $certificate->course->title }}</div>
                        <div class="cert-card-meta">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                            Diterbitkan {{ $certificate->issued_at->translatedFormat('d F Y') }}
                        </div>
                        <div class="cert-card-meta">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/></svg>
                            {{ $certificate->total_xp_earned }} XP · {{ $certificate->total_lessons }} pelajaran
                        </div>
                        <div class="cert-card-number">No. {{ $certificate->certificate_number }}</div>
                    </div>
                </a>
            @endforeach
        </div>
    @endif

</div>

</x-app-layout>
