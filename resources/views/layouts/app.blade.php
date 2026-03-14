<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Contact Manager') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif
    </head>
    <body class="min-h-screen overflow-x-hidden bg-[radial-gradient(circle_at_top,_#f0fdf4,_#f8fafc_38%,_#eef2ff_70%,_#e2e8f0_100%)] text-slate-900">
        @php($isAuthPage = request()->routeIs('login', 'register'))

        <div class="pointer-events-none fixed inset-0 -z-10 overflow-hidden">
            <div class="absolute left-[-8rem] top-[-6rem] h-64 w-64 rounded-full bg-emerald-200/40 blur-3xl"></div>
            <div class="absolute right-[-7rem] top-24 h-72 w-72 rounded-full bg-indigo-200/50 blur-3xl"></div>
            <div class="absolute bottom-[-8rem] left-1/3 h-80 w-80 rounded-full bg-amber-200/40 blur-3xl"></div>
            <div class="absolute inset-0 bg-[linear-gradient(to_right,rgba(255,255,255,0.18)_1px,transparent_1px),linear-gradient(to_bottom,rgba(255,255,255,0.18)_1px,transparent_1px)] bg-[size:48px_48px] opacity-30"></div>
        </div>

        <div class="mx-auto flex min-h-screen w-full max-w-7xl flex-col px-4 py-6 sm:px-6 lg:px-8 lg:py-8">
            <header class="mb-6 rounded-[28px] border border-white/60 bg-white/70 px-5 py-4 shadow-[0_20px_60px_rgba(15,23,42,0.08)] backdrop-blur-xl sm:px-7">
                <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                    <div class="flex items-start gap-4">
                        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-gradient-to-br from-slate-950 via-slate-800 to-emerald-600 text-sm font-bold tracking-[0.25em] text-white shadow-lg shadow-emerald-500/20">
                            CM
                        </div>
                        <div>
                            <a href="{{ auth()->check() ? route('contacts.index') : route('login') }}" class="text-xl font-semibold tracking-tight text-slate-950 sm:text-2xl">
                                Contact Manager
                            </a>
                            <p class="mt-1 max-w-2xl text-sm leading-6 text-slate-600">
                                A refined space to organize your network, keep important details accessible, and stay productive.
                            </p>
                        </div>
                    </div>

                    <nav class="flex flex-col gap-3 sm:flex-row sm:items-center">
                        @auth
                            <div class="flex items-center gap-3 rounded-full border border-slate-200/80 bg-white/80 px-3 py-2 shadow-sm">
                                <div class="flex h-9 w-9 items-center justify-center rounded-full bg-gradient-to-br from-emerald-500 to-teal-600 text-sm font-semibold text-white">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </div>
                                <div class="pr-2">
                                    <p class="text-sm font-semibold text-slate-900">{{ auth()->user()->name }}</p>
                                    <p class="text-xs text-slate-500">Signed in</p>
                                </div>
                            </div>

                            <div class="flex flex-wrap items-center gap-2">
                                <a href="{{ route('contacts.index') }}" class="inline-flex items-center rounded-full px-4 py-2 text-sm font-medium text-slate-700 transition hover:bg-white/70 hover:text-slate-950">
                                    Contacts
                                </a>
                                <a href="{{ route('contacts.create') }}" class="inline-flex items-center rounded-full bg-slate-950 px-4 py-2 text-sm font-semibold text-white shadow-lg shadow-slate-900/15 transition hover:-translate-y-0.5 hover:bg-slate-800">
                                    Add Contact
                                </a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="inline-flex items-center rounded-full border border-slate-200 bg-white/80 px-4 py-2 text-sm font-medium text-slate-700 transition hover:border-slate-300 hover:bg-white">
                                        Sign Out
                                    </button>
                                </form>
                            </div>
                        @else
                            <div class="flex flex-wrap items-center gap-2">
                                <a href="{{ route('login') }}" class="inline-flex items-center rounded-full px-4 py-2 text-sm font-medium text-slate-700 transition hover:bg-white/70 hover:text-slate-950">
                                    Sign In
                                </a>
                                <a href="{{ route('register') }}" class="inline-flex items-center rounded-full bg-slate-950 px-4 py-2 text-sm font-semibold text-white shadow-lg shadow-slate-900/15 transition hover:-translate-y-0.5 hover:bg-slate-800">
                                    Sign Up
                                </a>
                            </div>
                        @endauth
                    </nav>
                </div>
            </header>

            <main class="flex-1">
                @if (session('status'))
                    <div class="mb-5 rounded-[24px] border border-emerald-200/80 bg-emerald-50/90 px-5 py-4 text-sm text-emerald-950 shadow-sm backdrop-blur">
                        <div class="flex items-start gap-3">
                            <div class="mt-0.5 flex h-6 w-6 items-center justify-center rounded-full bg-emerald-600 text-xs font-bold text-white">✓</div>
                            <div>
                                <p class="font-semibold">Success</p>
                                <p class="mt-0.5 text-emerald-900/80">{{ session('status') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="{{ $isAuthPage ? 'mx-auto max-w-6xl' : '' }}">
                    @yield('content')
                </div>
            </main>
        </div>
    </body>
</html>
