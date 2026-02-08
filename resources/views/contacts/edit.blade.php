@extends('layouts.app')

@section('content')
    <div class="mb-6">
        <h1 class="text-xl font-semibold">Edit Contact</h1>
        <p class="text-sm text-stone-600">Update the details for {{ $contact->name }}.</p>
    </div>

    @if ($errors->any())
        <div class="mb-6 rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-900">
            <p class="font-semibold">Please fix the errors below.</p>
            <ul class="mt-2 list-disc space-y-1 pl-5">
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
@endsection
