@extends('layouts.app')

@section('content')
    <div class="grid gap-6 lg:grid-cols-[1.08fr_0.92fr] lg:items-stretch">
        <section class="relative overflow-hidden rounded-[32px] border border-slate-200/70 bg-gradient-to-br from-slate-950 via-slate-900 to-emerald-900 px-6 py-8 text-white shadow-[0_25px_80px_rgba(15,23,42,0.18)] sm:px-8 sm:py-10">
            <div class="absolute right-0 top-0 h-40 w-40 translate-x-1/3 -translate-y-1/3 rounded-full bg-emerald-400/30 blur-3xl"></div>
            <div class="absolute bottom-0 left-0 h-48 w-48 -translate-x-1/3 translate-y-1/3 rounded-full bg-indigo-400/20 blur-3xl"></div>

            <div class="relative">
                <span class="inline-flex rounded-full border border-white/15 bg-white/10 px-3 py-1 text-xs font-medium tracking-[0.2em] uppercase text-emerald-100">
                    Welcome back
                </span>
                <h1 class="mt-5 max-w-md text-3xl font-semibold tracking-tight sm:text-4xl">
                    Manage every contact from one calm, organized dashboard.
                </h1>
                <p class="mt-4 max-w-xl text-sm leading-7 text-slate-200/90 sm:text-base">
                    Sign in to search contacts instantly, update details quickly, and keep your relationship data neatly structured.
                </p>

                <div class="mt-8 grid gap-4 sm:grid-cols-3">
                    <div class="rounded-2xl border border-white/10 bg-white/8 p-4 backdrop-blur-sm">
                        <p class="text-2xl font-semibold">Fast</p>
                        <p class="mt-1 text-sm text-slate-200/80">Quick search and simple editing flow.</p>
                    </div>
                    <div class="rounded-2xl border border-white/10 bg-white/8 p-4 backdrop-blur-sm">
                        <p class="text-2xl font-semibold">Secure</p>
                        <p class="mt-1 text-sm text-slate-200/80">Account-based access for your contact data.</p>
                    </div>
                    <div class="rounded-2xl border border-white/10 bg-white/8 p-4 backdrop-blur-sm">
                        <p class="text-2xl font-semibold">Clean</p>
                        <p class="mt-1 text-sm text-slate-200/80">A focused interface that stays easy to use.</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="rounded-[32px] border border-white/70 bg-white/85 p-6 shadow-[0_24px_60px_rgba(15,23,42,0.1)] backdrop-blur-xl sm:p-8">
            <div class="mb-8">
                <p class="text-sm font-medium text-emerald-700">Sign in</p>
                <h2 class="mt-2 text-2xl font-semibold tracking-tight text-slate-950">Access your account</h2>
                <p class="mt-2 text-sm leading-6 text-slate-600">Use your email and password to continue to your contacts workspace.</p>
            </div>

            @if ($errors->any())
                <div class="mb-6 rounded-3xl border border-rose-200 bg-rose-50 px-4 py-4 text-sm text-rose-900">
                    <p class="font-semibold">Please fix the following</p>
                    <ul class="mt-2 list-disc space-y-1 pl-5 text-rose-800">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-slate-700" for="email">Email address</label>
                    <input
                        id="email"
                        name="email"
                        type="email"
                        value="{{ old('email') }}"
                        placeholder="you@example.com"
                        class="mt-2 w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 shadow-sm outline-none transition placeholder:text-slate-400 focus:border-emerald-400 focus:ring-4 focus:ring-emerald-100"
                        required
                        autofocus
                    />
                </div>

                <div>
                    <div class="flex items-center justify-between gap-4">
                        <label class="block text-sm font-medium text-slate-700" for="password">Password</label>
                        <span class="text-xs text-slate-400">Minimum 8 characters</span>
                    </div>
                    <input
                        id="password"
                        name="password"
                        type="password"
                        placeholder="Enter your password"
                        class="mt-2 w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 shadow-sm outline-none transition placeholder:text-slate-400 focus:border-emerald-400 focus:ring-4 focus:ring-emerald-100"
                        required
                    />
                </div>

                <label class="inline-flex items-center gap-3 text-sm text-slate-600">
                    <input type="checkbox" name="remember" value="1" class="h-4 w-4 rounded border-slate-300 text-emerald-600 focus:ring-emerald-400" />
                    Keep me signed in on this device
                </label>

                <div class="pt-2">
                    <button type="submit" class="inline-flex w-full items-center justify-center rounded-2xl bg-slate-950 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-slate-900/15 transition hover:-translate-y-0.5 hover:bg-slate-800">
                        Sign In
                    </button>
                </div>

                <div class="text-center text-sm text-slate-600">
                    <a href="{{ route('password.request') }}" class="font-semibold text-slate-950 hover:text-emerald-700">
                        Forgot your password?
                    </a>
                </div>

                <div class="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-4 text-center text-sm text-slate-600">
                    New here?
                    <a href="{{ route('register') }}" class="font-semibold text-slate-950 hover:text-emerald-700">
                        Create an account
                    </a>
                </div>
            </form>
        </section>
    </div>
@endsection
