@extends('layouts.app')

@section('content')
    <div class="mx-auto grid gap-6 lg:max-w-4xl lg:grid-cols-[0.92fr_1.08fr] lg:items-stretch">
        <section class="rounded-[32px] border border-white/70 bg-white/85 p-6 shadow-[0_24px_60px_rgba(15,23,42,0.1)] backdrop-blur-xl sm:p-8">
            <div class="mb-8">
                <p class="text-sm font-medium text-emerald-700">Verify email</p>
                <h1 class="mt-2 text-2xl font-semibold tracking-tight text-slate-950">Confirm your address</h1>
                <p class="mt-2 text-sm leading-6 text-slate-600">A verification link was sent when your account was created. Please confirm your email to continue.</p>
            </div>

            @if (session('status'))
                <div class="mb-6 rounded-3xl border border-emerald-200 bg-emerald-50 px-4 py-4 text-sm text-emerald-900">
                    {{ session('status') }}
                </div>
            @endif

            <div class="space-y-4 text-sm leading-6 text-slate-600">
                <p>Until verification is complete, access to the contact workspace stays limited.</p>
                <p>If you did not receive the email, request a new one below.</p>
            </div>

            <form method="POST" action="{{ route('verification.send') }}" class="mt-6 space-y-4">
                @csrf

                <button type="submit" class="inline-flex w-full items-center justify-center rounded-2xl bg-slate-950 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-slate-900/15 transition hover:-translate-y-0.5 hover:bg-slate-800">
                    Resend verification email
                </button>
            </form>

            <form method="POST" action="{{ route('logout') }}" class="mt-3">
                @csrf
                <button type="submit" class="inline-flex w-full items-center justify-center rounded-2xl border border-slate-200 bg-white px-5 py-3 text-sm font-medium text-slate-700 transition hover:border-slate-300 hover:bg-slate-50">
                    Sign out
                </button>
            </form>
        </section>

        <section class="relative overflow-hidden rounded-[32px] border border-slate-200/70 bg-gradient-to-br from-slate-950 via-slate-900 to-emerald-900 px-6 py-8 text-white shadow-[0_25px_80px_rgba(15,23,42,0.18)] sm:px-8 sm:py-10">
            <div class="absolute right-0 top-0 h-44 w-44 translate-x-1/3 -translate-y-1/3 rounded-full bg-emerald-400/25 blur-3xl"></div>
            <div class="absolute bottom-0 left-0 h-48 w-48 -translate-x-1/3 translate-y-1/3 rounded-full bg-indigo-400/20 blur-3xl"></div>

            <div class="relative">
                <span class="inline-flex rounded-full border border-white/15 bg-white/10 px-3 py-1 text-xs font-medium tracking-[0.2em] uppercase text-emerald-100">
                    Verification step
                </span>
                <h2 class="mt-5 max-w-md text-3xl font-semibold tracking-tight sm:text-4xl">
                    One confirmation unlocks the full workspace.
                </h2>
                <p class="mt-4 max-w-xl text-sm leading-7 text-slate-200/90 sm:text-base">
                    After verifying your email, you can create contacts, import CSV files, export records, and use the full directory flow.
                </p>
            </div>
        </section>
    </div>
@endsection