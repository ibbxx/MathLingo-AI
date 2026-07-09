<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CertificateController extends Controller
{
    /**
     * Daftar sertifikat yang sudah didapat siswa yang sedang login.
     */
    public function index(): View
    {
        $certificates = Certificate::where('user_id', Auth::id())
            ->with('course')
            ->orderByDesc('issued_at')
            ->get();

        return view('certificates.index', compact('certificates'));
    }

    /**
     * Tampilkan 1 sertifikat (halaman ini juga dipakai sebagai template PDF).
     */
    public function show(Certificate $certificate): View
    {
        $this->authorizeOwner($certificate);

        $certificate->load('course', 'user');

        return view('certificates.show', compact('certificate'));
    }

    /**
     * Unduh sertifikat sebagai file PDF.
     *
     * Butuh paket "barryvdh/laravel-dompdf" (composer require barryvdh/laravel-dompdf).
     * Kalau paket itu belum ter-install, redirect ke halaman lihat sertifikat
     * (yang tetap bisa di-print / disimpan sebagai PDF lewat browser).
     */
    public function download(Certificate $certificate)
    {
        $this->authorizeOwner($certificate);

        $certificate->load('course', 'user');

        if (! class_exists(\Barryvdh\DomPDF\Facade\Pdf::class)) {
            return redirect()
                ->route('certificates.show', $certificate->id)
                ->with('error', 'Fitur download PDF butuh paket tambahan. Jalankan "composer require barryvdh/laravel-dompdf" di server, atau gunakan tombol Print di halaman ini untuk simpan sebagai PDF lewat browser.');
        }

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('certificates.pdf', compact('certificate'))
            ->setPaper('a4', 'landscape');

        $filename = 'Sertifikat-' . str_replace(' ', '-', $certificate->course->title) . '-' . $certificate->certificate_number . '.pdf';

        return $pdf->download($filename);
    }

    private function authorizeOwner(Certificate $certificate): void
    {
        $user = Auth::user();
        abort_unless($certificate->user_id === $user->id || $user->isAdmin(), 403);
    }
}
