<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In — MathLingo AI</title>
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
                            500: '#22C55E',
                            600: '#16A34A',
                        },
                        ink: '#1E293B',
                        muted: '#64748B',
                        border: '#E5E7EB',
                        surface: '#F8FAFC',
                        danger: '#EF4444',
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

        /* Left panel diagonal accent strip */
        .left-accent-strip {
            position: absolute;
            inset: 0;
            background:
                radial-gradient(ellipse 70% 55% at 30% 20%, rgba(37,99,235,0.08) 0%, transparent 70%),
                radial-gradient(ellipse 50% 40% at 80% 80%, rgba(34,197,94,0.07) 0%, transparent 70%);
            pointer-events: none;
        }

        /* Subtle grid texture on left panel */
        .grid-texture {
            background-image:
                linear-gradient(rgba(37,99,235,0.035) 1px, transparent 1px),
                linear-gradient(90deg, rgba(37,99,235,0.035) 1px, transparent 1px);
            background-size: 40px 40px;
        }

        /* Floating math symbols — very subtle */
        @keyframes drift {
            0%   { transform: translateY(0px) rotate(0deg); opacity: 0.06; }
            50%  { transform: translateY(-18px) rotate(6deg); opacity: 0.1; }
            100% { transform: translateY(0px) rotate(0deg); opacity: 0.06; }
        }
        .math-sym { animation: drift linear infinite; }

        /* Input focus ring */
        .ml-input {
            display: block;
            width: 100%;
            padding: 0.625rem 0.875rem 0.625rem 2.625rem;
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

        .ml-select {
            display: block;
            width: 100%;
            padding: 0.625rem 2.5rem 0.625rem 2.625rem;
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

        .pw-eye {
            position: absolute;
            right: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            background: none;
            border: none;
            padding: 0.25rem;
            color: #94A3B8;
            transition: color 0.15s;
            display: flex;
            align-items: center;
        }
        .pw-eye:hover { color: #2563EB; }
    </style>
</head>
<body class="bg-surface min-h-screen">

<div class="min-h-screen flex flex-col lg:flex-row">

    {{-- ============================================================ --}}
    {{-- LEFT PANEL  (60%) — visible lg+ --}}
    {{-- ============================================================ --}}
    <div class="hidden lg:flex lg:w-3/5 relative flex-col items-center justify-center px-12 xl:px-20 py-16 bg-white grid-texture overflow-hidden">

        <div class="left-accent-strip"></div>

        {{-- Floating math decorations --}}
        <span class="math-sym select-none pointer-events-none absolute text-primary-600 text-2xl font-bold opacity-[0.07]" style="top:10%;left:8%;animation-duration:7s;">∑</span>
        <span class="math-sym select-none pointer-events-none absolute text-accent-500 text-xl font-bold opacity-[0.07]" style="top:20%;right:12%;animation-duration:9s;animation-delay:-3s;">π</span>
        <span class="math-sym select-none pointer-events-none absolute text-primary-600 text-3xl font-bold opacity-[0.05]" style="bottom:25%;left:6%;animation-duration:11s;animation-delay:-5s;">∫</span>
        <span class="math-sym select-none pointer-events-none absolute text-accent-500 text-2xl font-bold opacity-[0.07]" style="bottom:15%;right:8%;animation-duration:8s;animation-delay:-2s;">∞</span>
        <span class="math-sym select-none pointer-events-none absolute text-primary-600 text-xl font-bold opacity-[0.06]" style="top:55%;left:14%;animation-duration:13s;animation-delay:-6s;">√</span>
        <span class="math-sym select-none pointer-events-none absolute text-accent-600 text-lg font-bold opacity-[0.06]" style="top:40%;right:6%;animation-duration:10s;animation-delay:-4s;">Δ</span>

        <div class="relative z-10 w-full max-w-md">

            {{-- Logo --}}
            <a href="/" class="flex items-center gap-3 mb-12 group w-fit">
                <div class="w-10 h-10 rounded-xl bg-primary-600 flex items-center justify-center shadow-btn flex-shrink-0">
                    {{-- Icon: formula / function --}}
                    <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.745 3A23.933 23.933 0 003 12c0 3.183.62 6.22 1.745 9M19.255 3A23.933 23.933 0 0121 12c0 3.183-.62 6.22-1.745 9M8.25 8.885l1.444-.89a.75.75 0 011.105.402l2.402 7.206a.75.75 0 001.104.401l1.445-.89M8.25 15.11l1.444.89a.75.75 0 001.105-.402l.948-2.844"/>
                    </svg>
                </div>
                <span class="font-display font-800 text-xl text-ink tracking-tight">
                    Math<span class="text-primary-600">Lingo</span> <span class="text-accent-500">AI</span>
                </span>
            </a>

            {{-- Headline --}}
            <h1 class="font-display font-extrabold text-4xl xl:text-5xl text-ink leading-tight tracking-tight mb-4">
                Master Mathematics<br>
                Through <span class="text-primary-600">English</span>
            </h1>

            <p class="text-muted text-base leading-relaxed mb-10 max-w-sm">
                Improve Mathematical English with interactive lessons, an AI tutor, and international-level practice.
            </p>

            {{-- Feature cards --}}
            <div class="grid grid-cols-2 gap-3">

                <div class="bg-surface border border-border rounded-2xl p-4 flex flex-col gap-2 hover:border-primary-500 hover:shadow-card transition-all duration-200 cursor-default">
                    <div class="w-9 h-9 rounded-xl bg-primary-50 flex items-center justify-center">
                        <svg class="w-5 h-5 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                        </svg>
                    </div>
                    <p class="font-semibold text-sm text-ink leading-snug">Mathematical Vocabulary</p>
                    <p class="text-xs text-muted">Terms & notation in English</p>
                </div>

                <div class="bg-surface border border-border rounded-2xl p-4 flex flex-col gap-2 hover:border-accent-500 hover:shadow-card transition-all duration-200 cursor-default">
                    <div class="w-9 h-9 rounded-xl bg-green-50 flex items-center justify-center">
                        <svg class="w-5 h-5 text-accent-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
                        </svg>
                    </div>
                    <p class="font-semibold text-sm text-ink leading-snug">Problem Solving</p>
                    <p class="text-xs text-muted">English-medium exercises</p>
                </div>

                <div class="bg-surface border border-border rounded-2xl p-4 flex flex-col gap-2 hover:border-primary-500 hover:shadow-card transition-all duration-200 cursor-default">
                    <div class="w-9 h-9 rounded-xl bg-primary-50 flex items-center justify-center">
                        <svg class="w-5 h-5 text-primary-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 9.75a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375m-13.5 3.01c0 1.6 1.123 2.994 2.707 3.227 1.087.16 2.185.283 3.293.369V21l4.184-4.183a1.14 1.14 0 01.778-.332 48.294 48.294 0 005.83-.498c1.585-.233 2.708-1.626 2.708-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z" />
                        </svg>
                    </div>
                    <p class="font-semibold text-sm text-ink leading-snug">AI Tutor</p>
                    <p class="text-xs text-muted">Personalized guidance</p>
                </div>

                <div class="bg-surface border border-border rounded-2xl p-4 flex flex-col gap-2 hover:border-accent-500 hover:shadow-card transition-all duration-200 cursor-default">
                    <div class="w-9 h-9 rounded-xl bg-green-50 flex items-center justify-center">
                        <svg class="w-5 h-5 text-accent-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0112 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 013 12c0-1.605.42-3.113 1.157-4.418" />
                        </svg>
                    </div>
                    <p class="font-semibold text-sm text-ink leading-snug">International Practice</p>
                    <p class="text-xs text-muted">Olympiad & exam prep</p>
                </div>

            </div>

            {{-- Trust bar --}}
            <div class="mt-10 flex items-center gap-4">
                <div class="flex -space-x-2">
                    @foreach(['2563EB','22C55E','F59E0B','EF4444'] as $color)
                    <div class="w-8 h-8 rounded-full border-2 border-white flex items-center justify-center text-white text-xs font-bold" style="background:#{{ $color }}">
                        {{ ['A','B','C','D'][($loop->index)] }}
                    </div>
                    @endforeach
                </div>
                <p class="text-sm text-muted">
                    <span class="font-semibold text-ink">2,400+</span> students already learning
                </p>
            </div>

        </div>
    </div>

    {{-- ============================================================ --}}
    {{-- RIGHT PANEL (40%) — the form --}}
    {{-- ============================================================ --}}
    <div class="flex-1 lg:w-2/5 flex items-center justify-center px-5 py-12 sm:px-8 bg-surface">

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

            {{-- Form card --}}
            <div class="bg-white rounded-3xl shadow-card border border-border p-8">

                {{-- Session status --}}
                @if (session('status'))
                    <div class="mb-5 flex items-center gap-2 px-4 py-3 rounded-xl bg-green-50 border border-green-200 text-accent-600 text-sm font-medium">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        {{ session('status') }}
                    </div>
                @endif

                <div class="mb-7">
                    <p class="text-xs font-semibold tracking-widest text-primary-600 uppercase mb-1.5">Welcome back</p>
                    <h2 class="font-display font-extrabold text-2xl text-ink tracking-tight">Sign in to MathLingo</h2>
                    <p class="text-sm text-muted mt-1">Continue your learning journey</p>
                </div>

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    {{-- Email --}}
                    <div class="mb-4">
                        <label for="email" class="block text-sm font-semibold text-ink mb-1.5">Email address</label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-muted pointer-events-none">
                                <svg class="w-4.5 h-4.5 w-[18px] h-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
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
                                autofocus
                                autocomplete="username"
                                class="ml-input {{ $errors->has('email') ? 'error' : '' }}"
                            >
                        </div>
                        @error('email')
                            <p class="mt-1.5 text-xs text-danger font-medium flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"/></svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div class="mb-3">
                        <div class="flex items-center justify-between mb-1.5">
                            <label for="password" class="block text-sm font-semibold text-ink">Password</label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-xs text-primary-600 font-medium hover:text-primary-700 transition-colors">Forgot password?</a>
                            @endif
                        </div>
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
                                placeholder="Enter your password"
                                required
                                autocomplete="current-password"
                                class="ml-input {{ $errors->has('password') ? 'error' : '' }}"
                            >
                            <button type="button" class="pw-eye" onclick="togglePw('password', this)" aria-label="Toggle password visibility">
                                <svg id="eye-password" class="w-[18px] h-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </button>
                        </div>
                        @error('password')
                            <p class="mt-1.5 text-xs text-danger font-medium flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"/></svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Remember me --}}
                    <div class="flex items-center gap-2 mb-6">
                        <input
                            id="remember_me"
                            name="remember"
                            type="checkbox"
                            class="w-4 h-4 rounded border-border text-primary-600 focus:ring-primary-500 focus:ring-offset-0 transition"
                        >
                        <label for="remember_me" class="text-sm text-muted select-none cursor-pointer">Remember me for 30 days</label>
                    </div>

                    {{-- Submit --}}
                    <button
                        type="submit"
                        class="w-full h-11 bg-primary-600 hover:bg-primary-700 active:bg-primary-700 text-white font-semibold text-sm rounded-xl shadow-btn transition-all duration-150 flex items-center justify-center gap-2 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2"
                    >
                        Sign in
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                        </svg>
                    </button>

                    {{-- Divider --}}
                    <div class="flex items-center gap-3 my-5">
                        <div class="flex-1 h-px bg-border"></div>
                        <span class="text-xs font-medium text-muted">or</span>
                        <div class="flex-1 h-px bg-border"></div>
                    </div>

                    {{-- Register CTA --}}
                    <a
                        href="{{ route('register') }}"
                        class="w-full h-11 border-2 border-border hover:border-primary-500 hover:text-primary-600 text-ink font-semibold text-sm rounded-xl transition-all duration-150 flex items-center justify-center gap-2 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2"
                    >
                        Create a free account
                    </a>

                </form>
            </div>

            <p class="mt-6 text-center text-xs text-muted">
                By signing in you agree to our
                <a href="#" class="text-primary-600 hover:underline font-medium">Terms</a>
                and
                <a href="#" class="text-primary-600 hover:underline font-medium">Privacy Policy</a>.
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
</script>

</body>
</html>