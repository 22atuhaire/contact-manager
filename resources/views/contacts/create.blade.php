@extends('layouts.app')

@section('content')
    <div class="grid gap-6 xl:grid-cols-[1.1fr_0.9fr]">
        <section class="rounded-[30px] border border-white/80 bg-white/85 p-6 shadow-[0_24px_60px_rgba(15,23,42,0.08)] backdrop-blur-xl sm:p-8">
            <div class="mb-8">
                <p class="text-sm font-medium text-emerald-700">New contact</p>
                <h1 class="mt-2 text-3xl font-semibold tracking-tight text-slate-950">Add a new person to your directory</h1>
                <p class="mt-3 text-sm leading-7 text-slate-600 sm:text-base">Capture the key details now so you can find them instantly later.</p>
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

            <form method="POST" action="{{ route('contacts.store') }}">
                @csrf
                @include('contacts._form', ['submitLabel' => 'Save Contact'])
            </form>
        </section>

        <aside class="rounded-[30px] border border-slate-200/70 bg-gradient-to-br from-slate-950 via-slate-900 to-emerald-900 p-6 text-white shadow-[0_30px_80px_rgba(15,23,42,0.16)] sm:p-8">
            <span class="inline-flex rounded-full border border-white/15 bg-white/10 px-3 py-1 text-xs font-medium tracking-[0.2em] uppercase text-emerald-100">
                Best practice
            </span>
            <h2 class="mt-5 text-2xl font-semibold tracking-tight">Keep details complete and current.</h2>
            <p class="mt-3 text-sm leading-7 text-slate-200/85 sm:text-base">
                Accurate contact information saves time later and makes your directory far more useful.
            </p>

            <div class="mt-8 space-y-4">
                <div class="rounded-2xl border border-white/10 bg-white/10 p-4">
                    <p class="font-semibold">Use a real primary number</p>
                    <p class="mt-1 text-sm text-slate-200/80">Choose the phone number you are most likely to reach successfully.</p>
                </div>
                <div class="rounded-2xl border border-white/10 bg-white/10 p-4">
                    <p class="font-semibold">Keep email unique</p>
                    <p class="mt-1 text-sm text-slate-200/80">This helps avoid confusion and duplicate records.</p>
                </div>
                <div class="rounded-2xl border border-white/10 bg-white/10 p-4">
                    <p class="font-semibold">Add location context</p>
                    <p class="mt-1 text-sm text-slate-200/80">Even a short address or city can help you identify the right person faster.</p>
                </div>
            </div>
        </aside>
    </div>
@endsection
