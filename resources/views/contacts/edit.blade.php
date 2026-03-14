@extends('layouts.app')

@section('content')
    <div class="grid gap-6 xl:grid-cols-[1.1fr_0.9fr]">
        <section class="rounded-[30px] border border-white/80 bg-white/85 p-6 shadow-[0_24px_60px_rgba(15,23,42,0.08)] backdrop-blur-xl sm:p-8">
            <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                <div>
                    <p class="text-sm font-medium text-emerald-700">Edit contact</p>
                    <h1 class="mt-2 text-3xl font-semibold tracking-tight text-slate-950">Update {{ $contact->name }}</h1>
                    <p class="mt-3 text-sm leading-7 text-slate-600 sm:text-base">Refresh this record so the latest details are always available.</p>
                </div>
                <div class="flex h-14 w-14 items-center justify-center rounded-3xl bg-gradient-to-br from-slate-900 to-emerald-600 text-lg font-semibold text-white shadow-lg shadow-slate-900/15">
                    {{ strtoupper(substr($contact->name, 0, 1)) }}
                </div>
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

            <form method="POST" action="{{ route('contacts.update', $contact) }}">
                @csrf
                @method('PUT')
                @include('contacts._form', ['submitLabel' => 'Update Contact', 'contact' => $contact])
            </form>
        </section>

        <aside class="rounded-[30px] border border-slate-200/70 bg-gradient-to-br from-white/90 to-slate-100/90 p-6 shadow-[0_24px_60px_rgba(15,23,42,0.08)] backdrop-blur-xl sm:p-8">
            <p class="text-sm font-medium text-slate-500">Record snapshot</p>
            <div class="mt-5 rounded-[28px] bg-slate-950 px-6 py-6 text-white shadow-xl shadow-slate-900/20">
                <p class="text-xs uppercase tracking-[0.25em] text-slate-400">Current contact</p>
                <h2 class="mt-3 text-2xl font-semibold">{{ $contact->name }}</h2>
                <div class="mt-6 space-y-4 text-sm text-slate-200/90">
                    <div>
                        <p class="text-xs uppercase tracking-[0.2em] text-slate-400">Phone</p>
                        <p class="mt-1">{{ $contact->phone }}</p>
                    </div>
                    <div>
                        <p class="text-xs uppercase tracking-[0.2em] text-slate-400">Email</p>
                        <p class="mt-1 break-all">{{ $contact->email }}</p>
                    </div>
                    <div>
                        <p class="text-xs uppercase tracking-[0.2em] text-slate-400">Address</p>
                        <p class="mt-1">{{ $contact->address ?: 'No address saved yet' }}</p>
                    </div>
                </div>
            </div>

            <div class="mt-6 rounded-3xl border border-slate-200 bg-white px-5 py-5 text-sm text-slate-600 shadow-sm">
                Review changes carefully before saving so your directory stays clean and reliable.
            </div>
        </aside>
    </div>
@endsection
