<?php

namespace App\Http\Controllers;

use App\Models\ContactGroup;
use App\Models\ContactInteraction;
use App\Models\ContactTag;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ContactsController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Contact::class, 'contact');
    }

    public function index(Request $request)
    {
        $user = $request->user();

        $query = $user->contacts()->with(['group', 'tags']);
        $search = trim((string) $request->query('q', ''));
        $sort = (string) $request->query('sort', 'name');
        $direction = strtolower((string) $request->query('direction', 'asc')) === 'desc' ? 'desc' : 'asc';
        $status = (string) $request->query('status', 'active');
        $favoritesOnly = $request->boolean('favorites');
        $groupId = (int) $request->query('group_id', 0);
        $tagId = (int) $request->query('tag_id', 0);

        if ($status === 'trashed') {
            $query->onlyTrashed();
        } elseif ($status === 'all') {
            $query->withTrashed();
        }

        if ($search !== '') {
            $query->where(function ($builder) use ($search) {
                $builder->where('name', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('address', 'like', "%{$search}%");
            });
        }

        if ($favoritesOnly) {
            $query->where('is_favorite', true);
        }

        if ($groupId > 0) {
            $query->where('group_id', $groupId);
        }

        if ($tagId > 0) {
            $query->whereHas('tags', fn ($q) => $q->where('contact_tags.id', $tagId));
        }

        $allowedSorts = ['name', 'created_at', 'updated_at', 'email'];
        if (! in_array($sort, $allowedSorts, true)) {
            $sort = 'name';
        }

        $contacts = $query
            ->orderBy($sort, $direction)
            ->paginate(12)
            ->withQueryString();

        return view('contacts.index', [
            'contacts' => $contacts,
            'search' => $search,
            'sort' => $sort,
            'direction' => $direction,
            'status' => $status,
            'favoritesOnly' => $favoritesOnly,
            'groups' => $user->contactGroups()->orderBy('name')->get(),
            'tags' => $user->contactTags()->orderBy('name')->get(),
            'selectedGroupId' => $groupId,
            'selectedTagId' => $tagId,
        ]);
    }

    public function create(Request $request)
    {
        return view('contacts.create', [
            'groups' => $request->user()->contactGroups()->orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:50'],
            'email' => ['required', 'email', 'max:255'],
            'address' => ['nullable', 'string', 'max:255'],
            'group_id' => ['nullable', 'integer'],
            'tags' => ['nullable', 'string', 'max:500'],
        ]);

        $normalizedPhone = $this->normalizePhone($validated['phone']);

        $duplicate = $user->contacts()
            ->where(function ($query) use ($validated, $normalizedPhone) {
                $query->where('email', strtolower($validated['email']))
                    ->orWhere('normalized_phone', $normalizedPhone);
            })
            ->first();

        if ($duplicate) {
            return back()
                ->withErrors(['email' => 'A contact with this email or phone already exists in your account.'])
                ->withInput();
        }

        $nearDuplicate = $user->contacts()
            ->where('name', 'like', '%'.trim($validated['name']).'%')
            ->exists();

        if ($nearDuplicate) {
            session()->flash('warning', 'Potential duplicate detected: a similarly named contact already exists.');
        }

        $groupId = $this->resolveGroup($request, $validated['group_id'] ?? null);

        $contact = $user->contacts()->create([
            'name' => trim($validated['name']),
            'phone' => trim($validated['phone']),
            'normalized_phone' => $normalizedPhone,
            'email' => strtolower(trim($validated['email'])),
            'address' => isset($validated['address']) ? trim((string) $validated['address']) : null,
            'group_id' => $groupId,
        ]);

        $this->syncTags($user->id, $contact, (string) ($validated['tags'] ?? ''));

        return redirect()
            ->route('contacts.index')
            ->with('status', 'Contact added successfully.');
    }

    public function edit(Request $request, Contact $contact)
    {
        return view('contacts.edit', [
            'contact' => $contact,
            'groups' => $request->user()->contactGroups()->orderBy('name')->get(),
            'tagList' => $contact->tags()->orderBy('name')->pluck('name')->implode(', '),
            'interactions' => $contact->interactions()->take(8)->get(),
        ]);
    }

    public function update(Request $request, Contact $contact)
    {
        $user = $request->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:50'],
            'email' => ['required', 'email', 'max:255'],
            'address' => ['nullable', 'string', 'max:255'],
            'group_id' => ['nullable', 'integer'],
            'tags' => ['nullable', 'string', 'max:500'],
        ]);

        $normalizedPhone = $this->normalizePhone($validated['phone']);

        $exists = $user->contacts()
            ->where('id', '!=', $contact->id)
            ->where(function ($query) use ($validated, $normalizedPhone) {
                $query->where('email', strtolower($validated['email']))
                    ->orWhere('normalized_phone', $normalizedPhone);
            })
            ->exists();

        if ($exists) {
            return back()
                ->withErrors(['email' => 'A contact with this email or phone already exists in your account.'])
                ->withInput();
        }

        $groupId = $this->resolveGroup($request, $validated['group_id'] ?? null);

        $contact->update([
            'name' => trim($validated['name']),
            'phone' => trim($validated['phone']),
            'normalized_phone' => $normalizedPhone,
            'email' => strtolower(trim($validated['email'])),
            'address' => isset($validated['address']) ? trim((string) $validated['address']) : null,
            'group_id' => $groupId,
        ]);

        $this->syncTags($user->id, $contact, (string) ($validated['tags'] ?? ''));

        return redirect()
            ->route('contacts.index')
            ->with('status', 'Contact updated successfully.');
    }

    public function destroy(Contact $contact)
    {
        $contact->delete();

        return redirect()
            ->route('contacts.index')
            ->with('status', 'Contact deleted successfully.');
    }

    public function restore(Request $request, int $contactId)
    {
        $contact = Contact::withTrashed()
            ->where('user_id', $request->user()->id)
            ->findOrFail($contactId);

        $this->authorize('restore', $contact);

        if ($contact->trashed()) {
            $contact->restore();
        }

        return redirect()
            ->route('contacts.index', ['status' => 'trashed'])
            ->with('status', 'Contact restored successfully.');
    }

    public function toggleFavorite(Contact $contact)
    {
        $this->authorize('update', $contact);

        $contact->update([
            'is_favorite' => ! $contact->is_favorite,
        ]);

        return back()->with('status', 'Favorite status updated.');
    }

    public function storeInteraction(Request $request, Contact $contact)
    {
        $this->authorize('update', $contact);

        $validated = $request->validate([
            'kind' => ['required', 'string', 'max:50'],
            'note' => ['required', 'string', 'max:2000'],
            'interacted_at' => ['required', 'date'],
        ]);

        $contact->interactions()->create([
            'user_id' => $request->user()->id,
            'kind' => $validated['kind'],
            'note' => $validated['note'],
            'interacted_at' => $validated['interacted_at'],
        ]);

        return back()->with('status', 'Interaction note saved.');
    }

    public function exportCsv(Request $request): StreamedResponse
    {
        $contacts = $request->user()->contacts()->with(['group', 'tags'])->orderBy('name')->get();

        $filename = 'contacts-export-'.now()->format('Ymd_His').'.csv';

        return response()->streamDownload(function () use ($contacts): void {
            $out = fopen('php://output', 'w');
            fputcsv($out, ['name', 'phone', 'email', 'address', 'group', 'tags', 'favorite']);

            foreach ($contacts as $contact) {
                fputcsv($out, [
                    $contact->name,
                    $contact->phone,
                    $contact->email,
                    $contact->address,
                    $contact->group?->name,
                    $contact->tags->pluck('name')->implode('|'),
                    $contact->is_favorite ? 'yes' : 'no',
                ]);
            }

            fclose($out);
        }, $filename, [
            'Content-Type' => 'text/csv',
        ]);
    }

    public function importCsv(Request $request)
    {
        $validated = $request->validate([
            'csv_file' => ['required', 'file', 'mimes:csv,txt', 'max:2048'],
        ]);

        $user = $request->user();
        $file = fopen($validated['csv_file']->getRealPath(), 'r');

        if (! $file) {
            return back()->withErrors(['csv_file' => 'Unable to read the uploaded CSV file.']);
        }

        $headers = fgetcsv($file);
        if (! is_array($headers)) {
            fclose($file);

            return back()->withErrors(['csv_file' => 'CSV file is empty or invalid.']);
        }

        $map = array_flip(array_map(static fn ($h) => strtolower(trim((string) $h)), $headers));
        foreach (['name', 'phone', 'email'] as $required) {
            if (! isset($map[$required])) {
                fclose($file);

                return back()->withErrors(['csv_file' => 'CSV is missing required header: '.$required]);
            }
        }

        $created = 0;
        $updated = 0;

        while (($row = fgetcsv($file)) !== false) {
            $name = trim((string) ($row[$map['name']] ?? ''));
            $phone = trim((string) ($row[$map['phone']] ?? ''));
            $email = strtolower(trim((string) ($row[$map['email']] ?? '')));

            if ($name === '' || $phone === '' || $email === '') {
                continue;
            }

            $normalizedPhone = $this->normalizePhone($phone);
            $address = isset($map['address']) ? trim((string) ($row[$map['address']] ?? '')) : null;
            $groupName = isset($map['group']) ? trim((string) ($row[$map['group']] ?? '')) : '';
            $tagString = isset($map['tags']) ? trim((string) ($row[$map['tags']] ?? '')) : '';
            $favoriteValue = strtolower(trim((string) ($row[$map['favorite']] ?? '')));
            $isFavorite = in_array($favoriteValue, ['1', 'yes', 'true'], true);

            $groupId = null;
            if ($groupName !== '') {
                $groupId = $user->contactGroups()->firstOrCreate(['name' => $groupName])->id;
            }

            $contact = $user->contacts()
                ->where('email', $email)
                ->orWhere('normalized_phone', $normalizedPhone)
                ->first();

            if ($contact) {
                $contact->update([
                    'name' => $name,
                    'phone' => $phone,
                    'normalized_phone' => $normalizedPhone,
                    'email' => $email,
                    'address' => $address,
                    'group_id' => $groupId,
                    'is_favorite' => $isFavorite,
                ]);
                $updated++;
            } else {
                $contact = $user->contacts()->create([
                    'name' => $name,
                    'phone' => $phone,
                    'normalized_phone' => $normalizedPhone,
                    'email' => $email,
                    'address' => $address,
                    'group_id' => $groupId,
                    'is_favorite' => $isFavorite,
                ]);
                $created++;
            }

            if ($tagString !== '') {
                $this->syncTags($user->id, $contact, str_replace('|', ',', $tagString));
            }
        }

        fclose($file);

        return redirect()
            ->route('contacts.index')
            ->with('status', "Import complete: {$created} created, {$updated} updated.");
    }

    private function resolveGroup(Request $request, mixed $groupId): ?int
    {
        if (! $groupId) {
            return null;
        }

        return $request->user()->contactGroups()->whereKey((int) $groupId)->value('id');
    }

    private function syncTags(int $userId, Contact $contact, string $tagInput): void
    {
        $parts = collect(explode(',', $tagInput))
            ->map(fn ($tag) => trim((string) $tag))
            ->filter()
            ->unique()
            ->take(10)
            ->values();

        if ($parts->isEmpty()) {
            $contact->tags()->sync([]);

            return;
        }

        $tagIds = $parts->map(function (string $name) use ($userId) {
            $slug = Str::slug($name);

            return ContactTag::firstOrCreate(
                ['user_id' => $userId, 'slug' => $slug],
                ['name' => $name]
            )->id;
        })->all();

        $contact->tags()->sync($tagIds);
    }

    private function normalizePhone(string $phone): string
    {
        $raw = trim($phone);
        $hasPlus = str_starts_with($raw, '+');
        $digits = preg_replace('/\D+/', '', $raw) ?? '';

        return $hasPlus ? '+'.$digits : $digits;
    }
}
