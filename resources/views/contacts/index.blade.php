@extends('layouts.app')

@section('content')
    <section class="space-y-6">
        <div class="grid gap-6 xl:grid-cols-[1.2fr_0.8fr]">
            <div class="rounded-[30px] border border-slate-200/70 bg-gradient-to-br from-slate-950 via-slate-900 to-emerald-900 px-6 py-8 text-white shadow-[0_30px_80px_rgba(15,23,42,0.16)] sm:px-8">
                <span class="inline-flex rounded-full border border-white/15 bg-white/10 px-3 py-1 text-xs font-medium tracking-[0.2em] uppercase text-emerald-100">
                    Contacts overview
                </span>
                <h1 class="mt-5 text-3xl font-semibold tracking-tight sm:text-4xl">Your contact directory, beautifully organized.</h1>
                <p class="mt-4 max-w-2xl text-sm leading-7 text-slate-200/85 sm:text-base">
                    Keep personal and professional connections easy to find, easy to update, and easy to trust.
                </p>

                <div class="mt-8 grid gap-4 sm:grid-cols-3">
                    <div class="rounded-2xl border border-white/10 bg-white/10 p-4 backdrop-blur-sm">
                        <p class="text-sm text-slate-200/80">Total contacts</p>
                        <p class="mt-2 text-3xl font-semibold">{{ $contacts->count() }}</p>
                    </div>
                    <div class="rounded-2xl border border-white/10 bg-white/10 p-4 backdrop-blur-sm">
                        <p class="text-sm text-slate-200/80">Search status</p>
                        <p class="mt-2 text-lg font-semibold">{{ $search !== '' ? 'Filtered' : 'All contacts' }}</p>
                    </div>
                    <div class="rounded-2xl border border-white/10 bg-white/10 p-4 backdrop-blur-sm">
                        <p class="text-sm text-slate-200/80">Next step</p>
                        <p class="mt-2 text-lg font-semibold">Add or update records</p>
                    </div>
                </div>
            </div>

            <div class="rounded-[30px] border border-white/70 bg-white/85 p-6 shadow-[0_24px_60px_rgba(15,23,42,0.08)] backdrop-blur-xl sm:p-7">
                <div class="mb-5 flex items-start justify-between gap-4">
                    <div>
                        <p class="text-sm font-medium text-emerald-700">Quick actions</p>
                        <h2 class="mt-2 text-xl font-semibold tracking-tight text-slate-950">Find someone fast</h2>
                    </div>
                    <a href="{{ route('contacts.create') }}" class="inline-flex items-center rounded-full bg-slate-950 px-4 py-2 text-sm font-semibold text-white transition hover:-translate-y-0.5 hover:bg-slate-800">
                        New Contact
                    </a>
                </div>

                <form method="GET" action="{{ route('contacts.index') }}" class="space-y-4">
                    <div>
                        <label for="q" class="block text-sm font-medium text-slate-700">Search directory</label>
                        <input
                            id="q"
                            type="text"
                            name="q"
                            value="{{ $search }}"
                            placeholder="Search by name, phone, email, or address"
                            class="mt-2 w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 shadow-sm outline-none transition placeholder:text-slate-400 focus:border-emerald-400 focus:ring-4 focus:ring-emerald-100"
                        />
                    </div>

                    <div class="flex flex-wrap gap-3">
                        <button type="submit" class="inline-flex items-center rounded-2xl bg-slate-950 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-slate-900/15 transition hover:-translate-y-0.5 hover:bg-slate-800">
                            Search Contacts
                        </button>
                        @if ($search !== '')
                            <a href="{{ route('contacts.index') }}" class="inline-flex items-center rounded-2xl border border-slate-200 bg-white px-5 py-3 text-sm font-medium text-slate-700 transition hover:border-slate-300 hover:bg-slate-50">
                                Clear Search
                            </a>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        @if ($contacts->isEmpty())
            <div class="rounded-[30px] border border-dashed border-slate-300 bg-white/80 px-6 py-12 text-center shadow-sm backdrop-blur sm:px-10">
                <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-3xl bg-slate-950 text-2xl text-white shadow-lg shadow-slate-900/15">
                    ✦
                </div>
                <h2 class="mt-5 text-2xl font-semibold tracking-tight text-slate-950">
                    {{ $search !== '' ? 'No contacts match your search' : 'Your directory is still empty' }}
                </h2>
                <p class="mx-auto mt-3 max-w-xl text-sm leading-7 text-slate-600 sm:text-base">
                    {{ $search !== '' ? 'Try a different keyword or clear your search to explore all saved records.' : 'Add your first contact to start building a clean, searchable list of important people.' }}
                </p>
                <div class="mt-6 flex flex-wrap justify-center gap-3">
                    @if ($search !== '')
                        <a href="{{ route('contacts.index') }}" class="inline-flex items-center rounded-2xl border border-slate-200 bg-white px-5 py-3 text-sm font-medium text-slate-700 transition hover:border-slate-300 hover:bg-slate-50">
                            Clear Search
                        </a>
                    @endif
                    <a href="{{ route('contacts.create') }}" class="inline-flex items-center rounded-2xl bg-slate-950 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-slate-900/15 transition hover:-translate-y-0.5 hover:bg-slate-800">
                        Create Contact
                    </a>
                </div>
            </div>
        @else
            <div class="overflow-hidden rounded-[30px] border border-white/80 bg-white/85 shadow-[0_24px_60px_rgba(15,23,42,0.08)] backdrop-blur-xl">
                <div class="border-b border-slate-200/80 px-6 py-5">
                    <h2 class="text-lg font-semibold text-slate-950">Saved contacts</h2>
                    <p class="mt-1 text-sm text-slate-500">Browse, edit, or remove records from your directory.</p>
                </div>

                <div class="hidden lg:block">
                    <table class="min-w-full divide-y divide-slate-200 text-sm">
                        <thead class="bg-slate-50/90 text-left">
                            <tr>
                                <th class="px-6 py-4 font-semibold text-slate-600">Contact</th>
                                <th class="px-6 py-4 font-semibold text-slate-600">Phone</th>
                                <th class="px-6 py-4 font-semibold text-slate-600">Email</th>
                                <th class="px-6 py-4 font-semibold text-slate-600">Address</th>
                                <th class="px-6 py-4 text-right font-semibold text-slate-600">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 bg-white/80">
                            @foreach ($contacts as $contact)
                                <tr class="transition hover:bg-slate-50/80">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-gradient-to-br from-slate-900 to-emerald-600 text-sm font-semibold text-white shadow-sm">
                                                {{ strtoupper(substr($contact->name, 0, 1)) }}
                                            </div>
                                            <div>
                                                <p class="font-semibold text-slate-900">{{ $contact->name }}</p>
                                                <p class="text-xs text-slate-500">Contact record</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-slate-700">{{ $contact->phone }}</td>
                                    <td class="px-6 py-4 text-slate-700">{{ $contact->email }}</td>
                                    <td class="px-6 py-4 text-slate-700">{{ $contact->address ?: '—' }}</td>
                                    <td class="px-6 py-4">
                                        <div class="flex justify-end gap-2">
                                            <a href="https://mail.google.com/mail/?view=cm&fs=1&to={{ rawurlencode($contact->email) }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center rounded-xl border border-sky-200 bg-sky-50 px-3 py-2 text-xs font-semibold text-sky-700 transition hover:border-sky-300 hover:bg-sky-100">
                                                Gmail
                                            </a>
                                            <a href="tel:{{ preg_replace('/\D+/', '', $contact->phone) }}" class="inline-flex items-center rounded-xl border border-emerald-200 bg-emerald-50 px-3 py-2 text-xs font-semibold text-emerald-700 transition hover:border-emerald-300 hover:bg-emerald-100">
                                                Call
                                            </a>
                                            <a href="{{ route('contacts.edit', $contact) }}" class="inline-flex items-center rounded-xl border border-slate-200 bg-white px-3 py-2 text-xs font-semibold text-slate-700 transition hover:border-slate-300 hover:bg-slate-50">
                                                Edit
                                            </a>
                                            <form method="POST" action="{{ route('contacts.destroy', $contact) }}" onsubmit="return confirm('Delete this contact?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="inline-flex items-center rounded-xl border border-rose-200 bg-rose-50 px-3 py-2 text-xs font-semibold text-rose-700 transition hover:border-rose-300 hover:bg-rose-100">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="grid gap-4 p-4 lg:hidden">
                    @foreach ($contacts as $contact)
                        <article class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm">
                            <div class="flex items-start justify-between gap-4">
                                <div class="flex items-center gap-3">
                                    <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-gradient-to-br from-slate-900 to-emerald-600 text-sm font-semibold text-white">
                                        {{ strtoupper(substr($contact->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <h3 class="font-semibold text-slate-950">{{ $contact->name }}</h3>
                                        <p class="text-xs text-slate-500">{{ $contact->email }}</p>
                                    </div>
                                </div>
                            </div>

                            <dl class="mt-4 grid gap-3 text-sm">
                                <div>
                                    <dt class="text-xs font-medium uppercase tracking-wide text-slate-400">Phone</dt>
                                    <dd class="mt-1 text-slate-700">{{ $contact->phone }}</dd>
                                </div>
                                <div>
                                    <dt class="text-xs font-medium uppercase tracking-wide text-slate-400">Address</dt>
                                    <dd class="mt-1 text-slate-700">{{ $contact->address ?: '—' }}</dd>
                                </div>
                            </dl>

                            <div class="mt-5 flex gap-2">
                                <a href="https://mail.google.com/mail/?view=cm&fs=1&to={{ rawurlencode($contact->email) }}" target="_blank" rel="noopener noreferrer" class="inline-flex flex-1 items-center justify-center rounded-2xl border border-sky-200 bg-sky-50 px-4 py-3 text-sm font-semibold text-sky-700 transition hover:border-sky-300 hover:bg-sky-100">
                                    Gmail
                                </a>
                                <a href="tel:{{ preg_replace('/\D+/', '', $contact->phone) }}" class="inline-flex flex-1 items-center justify-center rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-700 transition hover:border-emerald-300 hover:bg-emerald-100">
                                    Call
                                </a>
                            </div>

                            <div class="mt-2 flex gap-2">
                                <a href="{{ route('contacts.edit', $contact) }}" class="inline-flex flex-1 items-center justify-center rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm font-semibold text-slate-700 transition hover:border-slate-300 hover:bg-slate-50">
                                    Edit
                                </a>
                                <form method="POST" action="{{ route('contacts.destroy', $contact) }}" class="flex-1" onsubmit="return confirm('Delete this contact?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex w-full items-center justify-center rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm font-semibold text-rose-700 transition hover:border-rose-300 hover:bg-rose-100">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        @endif
    </section>
@endsection
