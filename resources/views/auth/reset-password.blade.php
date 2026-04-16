@extends('layouts.app')

@section('content')
    <div class="mx-auto grid gap-6 lg:max-w-4xl lg:grid-cols-[0.92fr_1.08fr] lg:items-stretch">
        <section class="rounded-[32px] border border-white/70 bg-white/85 p-6 shadow-[0_24px_60px_rgba(15,23,42,0.1)] backdrop-blur-xl sm:p-8">
            <div class="mb-8">
                <p class="text-sm font-medium text-emerald-700">Set new password</p>
                <h1 class="mt-2 text-2xl font-semibold tracking-tight text-slate-950">Choose a fresh password</h1>
                <p class="mt-2 text-sm leading-6 text-slate-600">Enter a new password for the account tied to {{ old('email', $email) }}.</p>
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

            <form method="POST" action="{{ route('password.update') }}" class="space-y-5">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}" />

                <div>
                    <label class="block text-sm font-medium text-slate-700" for="email">Email address</label>
                    <input
                        id="email"
                        name="email"
                        type="email"
                        value="{{ old('email', $email) }}"
                        placeholder="you@example.com"
                        class="mt-2 w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 shadow-sm outline-none transition placeholder:text-slate-400 focus:border-emerald-400 focus:ring-4 focus:ring-emerald-100"
                        required
                        autofocus
                    />
                </div>

                <div class="grid gap-5 sm:grid-cols-2">
                    <div>
                        <label class="block text-sm font-medium text-slate-700" for="password">New password</label>
                        <input
                            id="password"
                            name="password"
                            type="password"
                            placeholder="Create a new password"
                            class="mt-2 w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 shadow-sm outline-none transition placeholder:text-slate-400 focus:border-emerald-400 focus:ring-4 focus:ring-emerald-100"
                            required
                        />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700" for="password_confirmation">Confirm password</label>
                        <input
                            id="password_confirmation"
                            name="password_confirmation"
                            type="password"
                            placeholder="Repeat new password"
                            class="mt-2 w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 shadow-sm outline-none transition placeholder:text-slate-400 focus:border-emerald-400 focus:ring-4 focus:ring-emerald-100"
                            required
                        />
                    </div>
                </div>

                <div class="pt-2">
                    <button type="submit" class="inline-flex w-full items-center justify-center rounded-2xl bg-slate-950 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-slate-900/15 transition hover:-translate-y-0.5 hover:bg-slate-800">
                        Reset password
                    </button>
                </div>
            </form>
        </section>

        <section class="relative overflow-hidden rounded-[32px] border border-slate-200/70 bg-gradient-to-br from-slate-950 via-slate-900 to-emerald-900 px-6 py-8 text-white shadow-[0_25px_80px_rgba(15,23,42,0.18)] sm:px-8 sm:py-10">
            <div class="absolute right-0 top-0 h-44 w-44 translate-x-1/3 -translate-y-1/3 rounded-full bg-emerald-400/25 blur-3xl"></div>
            <div class="absolute bottom-0 left-0 h-48 w-48 -translate-x-1/3 translate-y-1/3 rounded-full bg-indigo-400/20 blur-3xl"></div>

            <div class="relative">
                <span class="inline-flex rounded-full border border-white/15 bg-white/10 px-3 py-1 text-xs font-medium tracking-[0.2em] uppercase text-emerald-100">
                    Security first
                </span>
                <h2 class="mt-5 max-w-md text-3xl font-semibold tracking-tight sm:text-4xl">
                    Keep your account protected with a fresh secret.
                </h2>
                <p class="mt-4 max-w-xl text-sm leading-7 text-slate-200/90 sm:text-base">
                    Once you reset your password, you can continue organizing contacts, groups, tags, and notes without interruption.
                </p>
            </div>
        </section>
    </div>
@endsection