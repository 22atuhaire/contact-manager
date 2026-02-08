@extends('layouts.app')

@section('content')
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-xl font-semibold">Contacts</h1>
            <p class="text-sm text-stone-600">{{ $contacts->count() }} total</p>
        </div>
        <form method="GET" action="{{ route('contacts.index') }}" class="flex w-full gap-2 md:w-auto">
            <input
                type="text"
                name="q"
                value="{{ $search }}"
                placeholder="Search by name, phone, email, or address"
                class="w-full rounded-full border border-stone-200 bg-white px-4 py-2 text-sm focus:border-stone-400 focus:outline-none"
            />
            <button type="submit" class="rounded-full border border-stone-200 px-4 py-2 text-sm font-medium text-stone-700 hover:border-stone-300">
                Search
            </button>
        </form>
    </div>

    <div class="mt-6">
        @if ($contacts->isEmpty())
            <div class="rounded-2xl border border-dashed border-stone-300 bg-stone-50 p-6 text-center">
                <p class="text-sm text-stone-600">No contacts yet.</p>
                <a href="{{ route('contacts.create') }}" class="mt-3 inline-flex items-center rounded-full bg-stone-900 px-4 py-2 text-sm font-semibold text-white hover:bg-stone-800">
                    Create your first contact
                </a>
            </div>
        @else
            <div class="overflow-hidden rounded-2xl border border-stone-200">
                <table class="min-w-full divide-y divide-stone-200 text-sm">
                    <thead class="bg-stone-50 text-left">
                        <tr>
                            <th class="px-4 py-3 font-medium text-stone-700">Name</th>
                            <th class="px-4 py-3 font-medium text-stone-700">Phone</th>
                            <th class="px-4 py-3 font-medium text-stone-700">Email</th>
                            <th class="px-4 py-3 font-medium text-stone-700">Address</th>
                            <th class="px-4 py-3 text-right font-medium text-stone-700">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-200 bg-white">
                        @foreach ($contacts as $contact)
                            <tr>
                                <td class="px-4 py-3 font-medium text-stone-900">{{ $contact->name }}</td>
                                <td class="px-4 py-3 text-stone-700">{{ $contact->phone }}</td>
                                <td class="px-4 py-3 text-stone-700">{{ $contact->email }}</td>
                                <td class="px-4 py-3 text-stone-700">{{ $contact->address ?? '-' }}</td>
                                <td class="px-4 py-3">
                                    <div class="flex justify-end gap-2">
                                        <a href="{{ route('contacts.edit', $contact) }}" class="rounded-full border border-stone-200 px-3 py-1 text-xs font-medium text-stone-700 hover:border-stone-300">
                                            Edit
                                        </a>
                                        <form method="POST" action="{{ route('contacts.destroy', $contact) }}" onsubmit="return confirm('Delete this contact?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="rounded-full border border-rose-200 px-3 py-1 text-xs font-medium text-rose-700 hover:border-rose-300">
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
        @endif
    </div>
@endsection
