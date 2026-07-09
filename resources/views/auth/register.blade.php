<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account — MathLingo AI</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'system-ui', 'sans-serif'],
                        display: ['"Plus Jakarta Sans"', 'sans-serif'],
                    },
                    colors: {
                        primary: {
                            50:  '#EFF6FF',
                            100: '#DBEAFE',
                            500: '#3B82F6',
                            600: '#2563EB',
                            700: '#1D4ED8',
                        },
                        accent: {
                            50:  '#F0FDF4',
                            500: '#22C55E',
                            600: '#16A34A',
                        },
                        ink: '#1E293B',
                        muted: '#64748B',
                        border: '#E5E7EB',
                        surface: '#F8FAFC',
                        danger: '#EF4444',
                        warn: '#F59E0B',
                    },
                    borderRadius: {
                        '2xl': '1rem',
                        '3xl': '1.5rem',
                    },
                    boxShadow: {
                        card: '0 1px 3px 0 rgba(0,0,0,0.06), 0 4px 24px 0 rgba(37,99,235,0.06)',
                        btn:  '0 1px 2px 0 rgba(37,99,235,0.18)',
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Inter', system-ui, sans-serif; }
        .font-display { font-family: 'Plus Jakarta Sans', sans-serif; }

        .left-accent-strip {
            position: absolute;
            inset: 0;
            background:
                radial-gradient(ellipse 65% 50% at 70% 15%, rgba(34,197,94,0.08) 0%, transparent 70%),
                radial-gradient(ellipse 50% 45% at 20% 75%, rgba(37,99,235,0.07) 0%, transparent 70%);
            pointer-events: none;
        }

        .grid-texture {
            background-image:
                linear-gradient(rgba(37,99,235,0.035) 1px, transparent 1px),
                linear-gradient(90deg, rgba(37,99,235,0.035) 1px, transparent 1px);
            background-size: 40px 40px;
        }

        @keyframes drift {
            0%   { transform: translateY(0px) rotate(0deg); opacity: 0.07; }
            50%  { transform: translateY(-14px) rotate(5deg); opacity: 0.12; }
            100% { transform: translateY(0px) rotate(0deg); opacity: 0.07; }
        }
        .math-sym { animation: drift linear infinite; }

        .ml-input {
            display: block;
            width: 100%;
            padding: 0.5625rem 0.875rem 0.5625rem 2.5rem;
            font-size: 0.9375rem;
            font-family: 'Inter', sans-serif;
            color: #1E293B;
            background: #fff;
            border: 1.5px solid #E5E7EB;
            border-radius: 0.625rem;
            outline: none;
            transition: border-color 0.15s, box-shadow 0.15s;
        }
        .ml-input:focus {
            border-color: #2563EB;
            box-shadow: 0 0 0 3px rgba(37,99,235,0.12);
        }
        .ml-input.error {
            border-color: #EF4444;
            box-shadow: 0 0 0 3px rgba(239,68,68,0.10);
        }
        .ml-input::placeholder { color: #94A3B8; }

        .ml-input-no-icon {
            display: block;
            width: 100%;
            padding: 0.5625rem 0.875rem;
            font-size: 0.9375rem;
            font-family: 'Inter', sans-serif;
            color: #1E293B;
            background: #fff;
            border: 1.5px solid #E5E7EB;
            border-radius: 0.625rem;
            outline: none;
            transition: border-color 0.15s, box-shadow 0.15s;
        }
        .ml-input-no-icon:focus {
            border-color: #2563EB;
            box-shadow: 0 0 0 3px rgba(37,99,235,0.12);
        }
        .ml-input-no-icon.error {
            border-color: #EF4444;
        }
        .ml-input-no-icon::placeholder { color: #94A3B8; }

        .ml-select {
            display: block;
            width: 100%;
            padding: 0.5625rem 2.5rem 0.5625rem 2.5rem;
            font-size: 0.9375rem;
            font-family: 'Inter', sans-serif;
            color: #1E293B;
            background: #fff;
            border: 1.5px solid #E5E7EB;
            border-radius: 0.625rem;
            outline: none;
            appearance: none;
            transition: border-color 0.15s, box-shadow 0.15s;
        }
        .ml-select:focus {
            border-color: #2563EB;
            box-shadow: 0 0 0 3px rgba(37,99,235,0.12);
        }
        .ml-select.error { border-color: #EF4444; }
        .ml-select option[value=""] { color: #94A3B8; }

        .pw-eye {
            position: absolute;
            right: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            background: none;
            border: none;
            padding: 0.2rem;
            color: #94A3B8;
            transition: color 0.15s;
            display: flex;
            align-items: center;
        }
        .pw-eye:hover { color: #2563EB; }

        /* Password strength meter */
        .strength-bar {
            height: 3px;
            border-radius: 99px;
            transition: width 0.3s, background-color 0.3s;
        }
    </style>
</head>
<body class="bg-surface min-h-screen">

<div class="min-h-screen flex flex-col lg:flex-row">

    {{-- ============================================================ --}}
    {{-- LEFT PANEL (60%) --}}
    {{-- ============================================================ --}}
    <div class="hidden lg:flex lg:w-3/5 relative flex-col items-center justify-center px-12 xl:px-20 py-16 bg-white grid-texture overflow-hidden">

        <div class="left-accent-strip"></div>

        {{-- Floating math symbols --}}
        <span class="math-sym select-none pointer-events-none absolute text-accent-500 text-2xl font-bold opacity-[0.07]" style="top:8%;left:10%;animation-duration:8s;">∇</span>
        <span class="math-sym select-none pointer-events-none absolute text-primary-600 text-xl font-bold opacity-[0.07]" style="top:18%;right:10%;animation-duration:10s;animation-delay:-3s;">θ</span>
        <span class="math-sym select-none pointer-events-none absolute text-primary-600 text-3xl font-bold opacity-[0.05]" style="bottom:28%;left:5%;animation-duration:12s;animation-delay:-5s;">λ</span>
        <span class="math-sym select-none pointer-events-none absolute text-accent-500 text-xl font-bold opacity-[0.07]" style="bottom:12%;right:9%;animation-duration:9s;animation-delay:-2s;">σ</span>
        <span class="math-sym select-none pointer-events-none absolute text-primary-600 text-2xl font-bold opacity-[0.06]" style="top:50%;left:15%;animation-duration:14s;animation-delay:-7s;">φ</span>
        <span class="math-sym select-none pointer-events-none absolute text-warn text-lg font-bold opacity-[0.06]" style="top:38%;right:5%;animation-duration:11s;animation-delay:-4s;">≈</span>

        <div class="relative z-10 w-full max-w-md">

            {{-- Logo --}}
            <a href="/" class="flex items-center gap-3 mb-10 w-fit">
                <div class="w-10 h-10 rounded-xl bg-primary-600 flex items-center justify-center shadow-btn flex-shrink-0">
                    <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.745 3A23.933 23.933 0 003 12c0 3.183.62 6.22 1.745 9M19.255 3A23.933 23.933 0 0121 12c0 3.183-.62 6.22-1.745 9M8.25 8.885l1.444-.89a.75.75 0 011.105.402l2.402 7.206a.75.75 0 001.104.401l1.445-.89M8.25 15.11l1.444.89a.75.75 0 001.105-.402l.948-2.844"/>
                    </svg>
                </div>
                <span class="font-display font-extrabold text-xl text-ink tracking-tight">
                    Math<span class="text-primary-600">Lingo</span> <span class="text-accent-500">AI</span>
                </span>
            </a>

            {{-- Headline --}}
            <h1 class="font-display font-extrabold text-4xl xl:text-5xl text-ink leading-tight tracking-tight mb-4">
                Start your<br>
                <span class="text-accent-500">Math Journey</span><br>
                today
            </h1>

            <p class="text-muted text-base leading-relaxed mb-10 max-w-sm">
                Join thousands of students mastering mathematical English for olympiads and international exams.
            </p>

            {{-- Learning path cards --}}
            <div class="flex flex-col gap-3">

                <div class="flex items-center gap-4 bg-surface border border-border rounded-2xl p-4 hover:border-primary-500 hover:shadow-card transition-all duration-200 cursor-default">
                    <div class="w-10 h-10 rounded-xl bg-primary-50 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/>
                        </svg>
                    </div>
                    <div class="min-w-0">
                        <p class="font-semibold text-sm text-ink">Math Vocabulary</p>
                        <p class="text-xs text-muted">12 lessons · Beginner</p>
                    </div>
                    <span class="ml-auto text-xs font-semibold text-primary-600 bg-primary-50 px-2 py-0.5 rounded-full flex-shrink-0">Popular</span>
                </div>

                <div class="flex items-center gap-4 bg-surface border border-border rounded-2xl p-4 hover:border-accent-500 hover:shadow-card transition-all duration-200 cursor-default">
                    <div class="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-warn" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 00-2.456 2.456zM16.894 20.567L16.5 21.75l-.394-1.183a2.25 2.25 0 00-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 001.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 001.423 1.423l1.183.394-1.183.394a2.25 2.25 0 00-1.423 1.423z"/>
                        </svg>
                    </div>
                    <div class="min-w-0">
                        <p class="font-semibold text-sm text-ink">Algebra Apprentice</p>
                        <p class="text-xs text-muted">15 lessons · Intermediate</p>
                    </div>
                </div>

                <div class="flex items-center gap-4 bg-surface border border-border rounded-2xl p-4 hover:border-accent-500 hover:shadow-card transition-all duration-200 cursor-default">
                    <div class="w-10 h-10 rounded-xl bg-accent-50 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-accent-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6a7.5 7.5 0 107.5 7.5h-7.5V6z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 10.5H21A7.5 7.5 0 0013.5 3v7.5z"/>
                        </svg>
                    </div>
                    <div class="min-w-0">
                        <p class="font-semibold text-sm text-ink">Statistics Analyst</p>
                        <p class="text-xs text-muted">8 lessons · Advanced</p>
                    </div>
                    <span class="ml-auto text-xs font-semibold text-accent-600 bg-accent-50 px-2 py-0.5 rounded-full flex-shrink-0">New</span>
                </div>

                <div class="flex items-center gap-4 bg-surface border border-border rounded-2xl p-4 hover:border-primary-500 hover:shadow-card transition-all duration-200 cursor-default">
                    <div class="w-10 h-10 rounded-xl bg-primary-50 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0112 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 013 12c0-1.605.42-3.113 1.157-4.418"/>
                        </svg>
                    </div>
                    <div class="min-w-0">
                        <p class="font-semibold text-sm text-ink">Olympiad Prep</p>
                        <p class="text-xs text-muted">20 lessons · Advanced</p>
                    </div>
                </div>

            </div>

        </div>
    </div>

    {{-- ============================================================ --}}
    {{-- RIGHT PANEL (40%) — register form --}}
    {{-- ============================================================ --}}
    <div class="flex-1 lg:w-2/5 flex items-start justify-center px-5 py-10 sm:px-8 bg-surface overflow-y-auto">

        <div class="w-full max-w-sm">

            {{-- Mobile logo --}}
            <div class="flex lg:hidden items-center gap-3 mb-8">
                <div class="w-9 h-9 rounded-xl bg-primary-600 flex items-center justify-center shadow-btn flex-shrink-0">
                    <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.745 3A23.933 23.933 0 003 12c0 3.183.62 6.22 1.745 9M19.255 3A23.933 23.933 0 0121 12c0 3.183-.62 6.22-1.745 9M8.25 8.885l1.444-.89a.75.75 0 011.105.402l2.402 7.206a.75.75 0 001.104.401l1.445-.89M8.25 15.11l1.444.89a.75.75 0 001.105-.402l.948-2.844"/>
                    </svg>
                </div>
                <span class="font-display font-extrabold text-lg text-ink tracking-tight">
                    Math<span class="text-primary-600">Lingo</span> <span class="text-accent-500">AI</span>
                </span>
            </div>

            <div class="bg-white rounded-3xl shadow-card border border-border p-8">

                <div class="mb-6">
                    <p class="text-xs font-semibold tracking-widest text-accent-500 uppercase mb-1.5">Free forever · No credit card</p>
                    <h2 class="font-display font-extrabold text-2xl text-ink tracking-tight">Create your account</h2>
                    <p class="text-sm text-muted mt-1">Get started in under a minute</p>
                </div>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    {{-- Full Name --}}
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-semibold text-ink mb-1.5">Full Name</label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-muted pointer-events-none">
                                <svg class="w-[18px] h-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
                                </svg>
                            </span>
                            <input
                                id="name"
                                type="text"
                                name="name"
                                value="{{ old('name') }}"
                                placeholder="Your full name"
                                required
                                autofocus
                                autocomplete="name"
                                class="ml-input {{ $errors->has('name') ? 'error' : '' }}"
                            >
                        </div>
                        @error('name')
                            <p class="mt-1.5 text-xs text-danger font-medium flex items-center gap-1">
                                <svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"/></svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div class="mb-4">
                        <label for="email" class="block text-sm font-semibold text-ink mb-1.5">Email address</label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-muted pointer-events-none">
                                <svg class="w-[18px] h-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/>
                                </svg>
                            </span>
                            <input
                                id="email"
                                type="email"
                                name="email"
                                value="{{ old('email') }}"
                                placeholder="your@email.com"
                                required
                                autocomplete="email"
                                class="ml-input {{ $errors->has('email') ? 'error' : '' }}"
                            >
                        </div>
                        @error('email')
                            <p class="mt-1.5 text-xs text-danger font-medium flex items-center gap-1">
                                <svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"/></svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div class="mb-2">
                        <label for="password" class="block text-sm font-semibold text-ink mb-1.5">Password</label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-muted pointer-events-none">
                                <svg class="w-[18px] h-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/>
                                </svg>
                            </span>
                            <input
                                id="password"
                                type="password"
                                name="password"
                                placeholder="Min. 8 characters"
                                required
                                autocomplete="new-password"
                                oninput="checkStrength(this.value)"
                                class="ml-input {{ $errors->has('password') ? 'error' : '' }}"
                            >
                            <button type="button" class="pw-eye" onclick="togglePw('password', this)" aria-label="Toggle password visibility">
                                <svg id="eye-password" class="w-[18px] h-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </button>
                        </div>
                        {{-- Strength meter --}}
                        <div class="mt-2 flex gap-1" id="strength-bars">
                            <div class="strength-bar flex-1 bg-border" id="bar-1"></div>
                            <div class="strength-bar flex-1 bg-border" id="bar-2"></div>
                            <div class="strength-bar flex-1 bg-border" id="bar-3"></div>
                            <div class="strength-bar flex-1 bg-border" id="bar-4"></div>
                        </div>
                        <p class="mt-1 text-xs text-muted" id="strength-label"></p>
                        @error('password')
                            <p class="mt-1.5 text-xs text-danger font-medium flex items-center gap-1">
                                <svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"/></svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Confirm Password --}}
                    <div class="mb-4">
                        <label for="password_confirmation" class="block text-sm font-semibold text-ink mb-1.5">Confirm Password</label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-muted pointer-events-none">
                                <svg class="w-[18px] h-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/>
                                </svg>
                            </span>
                            <input
                                id="password_confirmation"
                                type="password"
                                name="password_confirmation"
                                placeholder="Repeat your password"
                                required
                                autocomplete="new-password"
                                class="ml-input"
                            >
                            <button type="button" class="pw-eye" onclick="togglePw('password_confirmation', this)" aria-label="Toggle password visibility">
                                <svg id="eye-password_confirmation" class="w-[18px] h-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    {{-- Section label --}}
                    <div class="flex items-center gap-3 my-5">
                        <div class="flex-1 h-px bg-border"></div>
                        <span class="text-xs font-semibold text-muted uppercase tracking-widest">About you</span>
                        <div class="flex-1 h-px bg-border"></div>
                    </div>

                    {{-- Educational Level --}}
                    <div class="mb-4">
                        <label for="educational_level" class="block text-sm font-semibold text-ink mb-1.5">Educational Level</label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-muted pointer-events-none">
                                <svg class="w-[18px] h-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5zm0 0v-3.675A55.378 55.378 0 0112 8.443m-7.007 11.55A5.981 5.981 0 006.75 15.75v-1.5"/>
                                </svg>
                            </span>
                            <select
                                id="educational_level"
                                name="educational_level"
                                required
                                class="ml-select {{ $errors->has('educational_level') ? 'error' : '' }}"
                            >
                                <option value="" disabled {{ old('educational_level') ? '' : 'selected' }}>Select your level</option>
                                <option value="junior_high"    {{ old('educational_level') === 'junior_high'    ? 'selected' : '' }}>Junior High School</option>
                                <option value="senior_high"    {{ old('educational_level') === 'senior_high'    ? 'selected' : '' }}>Senior High School</option>
                                <option value="undergraduate"  {{ old('educational_level') === 'undergraduate'  ? 'selected' : '' }}>Undergraduate</option>
                                <option value="teacher"        {{ old('educational_level') === 'teacher'        ? 'selected' : '' }}>Teacher / Educator</option>
                            </select>
                            {{-- Chevron --}}
                            <span class="absolute right-3 top-1/2 -translate-y-1/2 text-muted pointer-events-none">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg>
                            </span>
                        </div>
                        @error('educational_level')
                            <p class="mt-1.5 text-xs text-danger font-medium flex items-center gap-1">
                                <svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"/></svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Learning Goal --}}
                    <div class="mb-5">
                        <label for="learning_goal" class="block text-sm font-semibold text-ink mb-1.5">Learning Goal</label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-muted pointer-events-none">
                                <svg class="w-[18px] h-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z"/>
                                </svg>
                            </span>
                            <select
                                id="learning_goal"
                                name="learning_goal"
                                required
                                class="ml-select {{ $errors->has('learning_goal') ? 'error' : '' }}"
                            >
                                <option value="" disabled {{ old('learning_goal') ? '' : 'selected' }}>What is your main goal?</option>
                                <option value="vocabulary"          {{ old('learning_goal') === 'vocabulary'          ? 'selected' : '' }}>Improve Mathematical Vocabulary</option>
                                <option value="problem_solving"     {{ old('learning_goal') === 'problem_solving'     ? 'selected' : '' }}>Improve Problem Solving</option>
                                <option value="olympiad"            {{ old('learning_goal') === 'olympiad'            ? 'selected' : '' }}>Prepare for Olympiad</option>
                                <option value="international_exams" {{ old('learning_goal') === 'international_exams' ? 'selected' : '' }}>Prepare for International Exams</option>
                            </select>
                            <span class="absolute right-3 top-1/2 -translate-y-1/2 text-muted pointer-events-none">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg>
                            </span>
                        </div>
                        @error('learning_goal')
                            <p class="mt-1.5 text-xs text-danger font-medium flex items-center gap-1">
                                <svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"/></svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Terms checkbox --}}
                    <div class="flex items-start gap-3 mb-6">
                        <input
                            id="terms"
                            type="checkbox"
                            name="terms"
                            required
                            class="mt-0.5 w-4 h-4 rounded border-border text-primary-600 focus:ring-primary-500 focus:ring-offset-0 transition flex-shrink-0"
                        >
                        <label for="terms" class="text-sm text-muted leading-snug cursor-pointer select-none">
                            I agree to the
                            <a href="#" class="text-primary-600 hover:underline font-medium">Terms of Service</a>
                            and
                            <a href="#" class="text-primary-600 hover:underline font-medium">Privacy Policy</a>
                        </label>
                    </div>

                    {{-- Submit --}}
                    <button
                        type="submit"
                        class="w-full h-11 bg-primary-600 hover:bg-primary-700 active:bg-primary-700 text-white font-semibold text-sm rounded-xl shadow-btn transition-all duration-150 flex items-center justify-center gap-2 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2"
                    >
                        Create account — it's free
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                        </svg>
                    </button>

                    {{-- Divider --}}
                    <div class="flex items-center gap-3 my-4">
                        <div class="flex-1 h-px bg-border"></div>
                        <span class="text-xs font-medium text-muted">or</span>
                        <div class="flex-1 h-px bg-border"></div>
                    </div>

                    {{-- Sign in CTA --}}
                    <a
                        href="{{ route('login') }}"
                        class="w-full h-11 border-2 border-border hover:border-primary-500 hover:text-primary-600 text-ink font-semibold text-sm rounded-xl transition-all duration-150 flex items-center justify-center gap-2 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2"
                    >
                        Already have an account? Sign in
                    </a>

                </form>
            </div>

            <p class="mt-6 text-center text-xs text-muted pb-6">
                MathLingo AI is free for students.
                <a href="#" class="text-primary-600 hover:underline font-medium">Learn more</a>
            </p>

        </div>
    </div>

</div>

<script>
function togglePw(fieldId, btn) {
    const input = document.getElementById(fieldId);
    const icon  = document.getElementById('eye-' + fieldId);
    if (input.type === 'password') {
        input.type = 'text';
        icon.innerHTML = `
            <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88"/>
        `;
    } else {
        input.type = 'password';
        icon.innerHTML = `
            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/>
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
        `;
    }
}

function checkStrength(pw) {
    let score = 0;
    if (pw.length >= 8)  score++;
    if (/[A-Z]/.test(pw)) score++;
    if (/[0-9]/.test(pw)) score++;
    if (/[^A-Za-z0-9]/.test(pw)) score++;

    const colors = ['', '#EF4444', '#F59E0B', '#22C55E', '#16A34A'];
    const labels = ['', 'Weak', 'Fair', 'Good', 'Strong'];

    for (let i = 1; i <= 4; i++) {
        const bar = document.getElementById('bar-' + i);
        bar.style.backgroundColor = i <= score ? colors[score] : '#E5E7EB';
    }

    const lbl = document.getElementById('strength-label');
    lbl.textContent = pw.length ? labels[score] : '';
    lbl.style.color = pw.length ? colors[score] : '';
}
</script>

</body>
</html>