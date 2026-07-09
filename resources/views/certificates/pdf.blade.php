<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Sertifikat - {{ $certificate->course->title }}</title>
<style>
    /* Dompdf hanya mendukung CSS2.1-ish, jadi hindari flexbox/grid di sini. */
    @page { margin: 0; }
    body {
        margin: 0; padding: 0;
        font-family: Helvetica, Arial, sans-serif;
        color: #1E293B;
    }
    .outer {
        border: 14px solid #FFFBEB;
        padding: 20px;
    }
    .inner {
        border: 3px solid #FDE68A;
        border-radius: 6px;
        padding: 50px 60px;
        text-align: center;
    }
    .logo { font-size: 13px; font-weight: bold; letter-spacing: 2px; text-transform: uppercase; color: #2563EB; margin-bottom: 20px; }
    .kicker { font-size: 12px; font-weight: bold; letter-spacing: 3px; text-transform: uppercase; color: #B45309; margin-bottom: 8px; }
    .title { font-size: 30px; font-weight: bold; color: #1E293B; margin-bottom: 22px; font-family: 'Times New Roman', serif; }
    .presented { font-size: 13px; color: #64748B; margin-bottom: 6px; }
    .name { font-size: 32px; font-weight: bold; color: #2563EB; font-family: 'Times New Roman', serif; margin-bottom: 20px; }
    .desc { font-size: 14px; color: #1E293B; line-height: 1.7; width: 520px; margin: 0 auto 28px; }
    .desc b { color: #2563EB; }

    table.meta { margin: 0 auto; }
    table.meta td { padding: 0 30px; text-align: center; }
    .meta-label { font-size: 10px; font-weight: bold; text-transform: uppercase; letter-spacing: 1px; color: #64748B; margin-bottom: 4px; }
    .meta-value { font-size: 13px; font-weight: bold; color: #1E293B; }

    table.footer { width: 100%; margin-top: 40px; }
    table.footer td { width: 33%; text-align: center; vertical-align: bottom; }
    .sig-line { border-top: 1.5px solid #1E293B; width: 160px; margin: 0 auto 6px; }
    .sig-name { font-size: 12px; font-weight: bold; }
    .sig-role { font-size: 10px; color: #64748B; }

    .cert-number { margin-top: 26px; font-size: 10px; color: #64748B; letter-spacing: 1px; }
</style>
</head>
<body>
    <div class="outer">
        <div class="inner">
            <div class="logo">MathLingo AI</div>
            <div class="kicker">Sertifikat Penyelesaian</div>
            <div class="title">Certificate of Completion</div>

            <div class="presented">Dengan bangga diberikan kepada</div>
            <div class="name">{{ $certificate->user->name }}</div>

            <div class="desc">
                Atas keberhasilan menyelesaikan seluruh materi kursus
                <b>{{ $certificate->course->title }}</b> di MathLingo AI,
                mencakup {{ $certificate->total_lessons }} pelajaran dengan penuh dedikasi.
            </div>

            <table class="meta">
                <tr>
                    <td>
                        <div class="meta-label">Diterbitkan</div>
                        <div class="meta-value">{{ $certificate->issued_at->translatedFormat('d F Y') }}</div>
                    </td>
                    <td>
                        <div class="meta-label">Total XP</div>
                        <div class="meta-value">{{ $certificate->total_xp_earned }} XP</div>
                    </td>
                    @if($certificate->quiz_score_percent !== null)
                    <td>
                        <div class="meta-label">Skor Quiz</div>
                        <div class="meta-value">{{ $certificate->quiz_score_percent }}%</div>
                    </td>
                    @endif
                </tr>
            </table>

            <table class="footer">
                <tr>
                    <td>
                        <div class="sig-line"></div>
                        <div class="sig-name">MathLingo AI</div>
                        <div class="sig-role">Learning Platform</div>
                    </td>
                    <td></td>
                    <td>
                        <div class="sig-line"></div>
                        <div class="sig-name">Admin1</div>
                        <div class="sig-role">Administrator</div>
                    </td>
                </tr>
            </table>

            <div class="cert-number">No. Sertifikat: {{ $certificate->certificate_number }} &middot; Verifikasi keaslian di MathLingo AI</div>
        </div>
    </div>
</body>
</html>
