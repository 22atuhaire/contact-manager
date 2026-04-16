<div class="grid gap-5 md:grid-cols-2">
    <div class="md:col-span-1">
        <label class="block text-sm font-medium text-slate-700" for="name">Name</label>
        <input
            id="name"
            name="name"
            type="text"
            value="{{ old('name', $contact->name ?? '') }}"
            placeholder="Jane Doe"
            class="mt-2 w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 shadow-sm outline-none transition placeholder:text-slate-400 focus:border-emerald-400 focus:ring-4 focus:ring-emerald-100"
            required
        />
        <p class="mt-2 text-xs text-slate-500">Use the full name you want displayed in the directory.</p>
    </div>

    <div class="md:col-span-1">
        <label class="block text-sm font-medium text-slate-700" for="phone">Phone Number</label>
        <input
            id="phone"
            name="phone"
            type="text"
            value="{{ old('phone', $contact->phone ?? '') }}"
            placeholder="+256 700 000 000"
            class="mt-2 w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 shadow-sm outline-none transition placeholder:text-slate-400 focus:border-emerald-400 focus:ring-4 focus:ring-emerald-100"
            required
        />
        <p class="mt-2 text-xs text-slate-500">This must be unique across contacts.</p>
    </div>

    <div class="md:col-span-1">
        <label class="block text-sm font-medium text-slate-700" for="email">Email</label>
        <input
            id="email"
            name="email"
            type="email"
            value="{{ old('email', $contact->email ?? '') }}"
            placeholder="jane@example.com"
            class="mt-2 w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 shadow-sm outline-none transition placeholder:text-slate-400 focus:border-emerald-400 focus:ring-4 focus:ring-emerald-100"
            required
        />
        <p class="mt-2 text-xs text-slate-500">A unique email helps keep records clean and searchable.</p>
    </div>

    <div class="md:col-span-1">
        <label class="block text-sm font-medium text-slate-700" for="address">Address</label>
        <input
            id="address"
            name="address"
            type="text"
            value="{{ old('address', $contact->address ?? '') }}"
            placeholder="Kampala, Uganda"
            class="mt-2 w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 shadow-sm outline-none transition placeholder:text-slate-400 focus:border-emerald-400 focus:ring-4 focus:ring-emerald-100"
        />
        <p class="mt-2 text-xs text-slate-500">Optional, but useful for context and identification.</p>
    </div>

    <div class="md:col-span-1">
        <label class="block text-sm font-medium text-slate-700" for="group_id">Group</label>
        <select
            id="group_id"
            name="group_id"
            class="mt-2 w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 shadow-sm outline-none transition focus:border-emerald-400 focus:ring-4 focus:ring-emerald-100"
        >
            <option value="">No group</option>
            @foreach ($groups as $group)
                <option value="{{ $group->id }}" @selected((string) old('group_id', $contact->group_id ?? '') === (string) $group->id)>
                    {{ $group->name }}
                </option>
            @endforeach
        </select>
        <p class="mt-2 text-xs text-slate-500">Use groups to organize contacts by category.</p>
    </div>

    <div class="md:col-span-1">
        <label class="block text-sm font-medium text-slate-700" for="tags">Tags</label>
        <input
            id="tags"
            name="tags"
            type="text"
            value="{{ old('tags', $tagList ?? '') }}"
            placeholder="client, partner, urgent"
            class="mt-2 w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 shadow-sm outline-none transition placeholder:text-slate-400 focus:border-emerald-400 focus:ring-4 focus:ring-emerald-100"
        />
        <p class="mt-2 text-xs text-slate-500">Separate tags using commas.</p>
    </div>
</div>

<div class="mt-8 flex flex-wrap gap-3">
    <button type="submit" class="inline-flex items-center rounded-2xl bg-slate-950 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-slate-900/15 transition hover:-translate-y-0.5 hover:bg-slate-800">
        {{ $submitLabel }}
    </button>
    <a href="{{ route('contacts.index') }}" class="inline-flex items-center rounded-2xl border border-slate-200 bg-white px-5 py-3 text-sm font-medium text-slate-700 transition hover:border-slate-300 hover:bg-slate-50">
        Cancel
    </a>
</div>
