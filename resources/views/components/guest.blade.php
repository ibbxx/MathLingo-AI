<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'MathLingo AI') }}</title>

        <!-- Fonts: Inter untuk clean academic feel -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="ml-font-sans text-gray-900 antialiased ml-bg-surface">

        {{-- Layout 2-kolom di desktop, stack di mobile --}}
        <div class="min-h-screen flex">

            {{-- Kolom Kiri: Form --}}
            <div class="flex-1 flex flex-col justify-center px-6 py-12 lg:px-12 xl:px-16 bg-white">

                {{-- Logo di atas form --}}
                <div class="mb-10">
                    <a href="/" class="inline-flex items-center gap-2.5 group">
                        {{-- Logo mark: huruf M bergaya sederhana --}}
                        <div class="ml-logo-mark">
                            <span>M</span>
                        </div>
                        <div>
                            <div class="ml-wordmark">MathLingo</div>
                            <div class="ml-wordmark-sub">AI Learning Platform</div>
                        </div>
                    </a>
                </div>

                {{-- Slot konten (login / register) --}}
                <div class="w-full max-w-sm">
                    {{ $slot }}
                </div>

                {{-- Footer kecil --}}
                <p class="mt-12 text-xs text-gray-400">
                    © {{ date('Y') }} MathLingo AI · Learn Mathematics Through English
                </p>
            </div>

            {{-- Kolom Kanan: Brand panel — hanya tampil di lg ke atas --}}
            <div class="hidden lg:flex lg:w-[420px] xl:w-[480px] flex-col justify-between ml-brand-panel px-12 py-14">

                {{-- Konten tengah panel --}}
                <div class="flex-1 flex flex-col justify-center">

                    <div class="ml-panel-badge mb-8">
                        For Students · Teachers · University
                    </div>

                    <h2 class="ml-panel-heading">
                        Master the language<br>of mathematics.
                    </h2>

                    <p class="ml-panel-body mt-4">
                        Pelajari kosakata matematika internasional, baca soal berbahasa Inggris, dan tingkatkan kemampuan akademik globalmu.
                    </p>

                    {{-- Feature list sederhana —  bukan promo, hanya orienting info --}}
                    <ul class="mt-10 space-y-4">
                        <li class="ml-panel-feature">
                            <span class="ml-panel-feature-dot"></span>
                            Kosakata matematika dalam Bahasa Inggris
                        </li>
                        <li class="ml-panel-feature">
                            <span class="ml-panel-feature-dot"></span>
                            Latihan soal kontekstual berbasis AI
                        </li>
                        <li class="ml-panel-feature">
                            <span class="ml-panel-feature-dot"></span>
                            Progress tracker untuk guru dan siswa
                        </li>
                    </ul>
                </div>

                {{-- Stats bawah panel --}}
                <div class="grid grid-cols-2 gap-6 pt-10 border-t border-white/20">
                    <div>
                        <div class="ml-stat-number">12K+</div>
                        <div class="ml-stat-label">Pelajar aktif</div>
                    </div>
                    <div>
                        <div class="ml-stat-number">480+</div>
                        <div class="ml-stat-label">Kosakata & soal</div>
                    </div>
                </div>
            </div>

        </div>
    </body>
</html>