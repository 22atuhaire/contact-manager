<div class="grid gap-4 md:grid-cols-2">
    <div class="md:col-span-1">
        <label class="block text-sm font-medium text-stone-700" for="name">Name</label>
        <input
            id="name"
            name="name"
            type="text"
            value="{{ old('name', $contact->name ?? '') }}"
            class="mt-1 w-full rounded-xl border border-stone-200 bg-white px-4 py-2 text-sm focus:border-stone-400 focus:outline-none"
            required
        />
    </div>

    <div class="md:col-span-1">
        <label class="block text-sm font-medium text-stone-700" for="phone">Phone Number</label>
        <input
            id="phone"
            name="phone"
            type="text"
            value="{{ old('phone', $contact->phone ?? '') }}"
            class="mt-1 w-full rounded-xl border border-stone-200 bg-white px-4 py-2 text-sm focus:border-stone-400 focus:outline-none"
            required
        />
    </div>

    <div class="md:col-span-1">
        <label class="block text-sm font-medium text-stone-700" for="email">Email</label>
        <input
            id="email"
            name="email"
            type="email"
            value="{{ old('email', $contact->email ?? '') }}"
            class="mt-1 w-full rounded-xl border border-stone-200 bg-white px-4 py-2 text-sm focus:border-stone-400 focus:outline-none"
            required
        />
    </div>

    <div class="md:col-span-1">
        <label class="block text-sm font-medium text-stone-700" for="address">Address</label>
        <input
            id="address"
            name="address"
            type="text"
            value="{{ old('address', $contact->address ?? '') }}"
            class="mt-1 w-full rounded-xl border border-stone-200 bg-white px-4 py-2 text-sm focus:border-stone-400 focus:outline-none"
        />
    </div>
</div>

<div class="mt-6 flex flex-wrap gap-3">
    <button type="submit" class="rounded-full bg-stone-900 px-5 py-2 text-sm font-semibold text-white hover:bg-stone-800">
        {{ $submitLabel }}
    </button>
    <a href="{{ route('contacts.index') }}" class="rounded-full border border-stone-200 px-5 py-2 text-sm font-medium text-stone-700 hover:border-stone-300">
        Cancel
    </a>
</div>
