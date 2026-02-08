<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactsController extends Controller
{
    public function index(Request $request)
    {
        $query = Contact::query();
        $search = trim((string) $request->query('q', ''));

        if ($search !== '') {
            $query->where(function ($builder) use ($search) {
                $builder->where('name', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('address', 'like', "%{$search}%");
            });
        }

        $contacts = $query->orderBy('name')->get();

        return view('contacts.index', [
            'contacts' => $contacts,
            'search' => $search,
        ]);
    }

    public function create()
    {
        return view('contacts.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:50', 'unique:contacts,phone'],
            'email' => ['required', 'email', 'max:255', 'unique:contacts,email'],
            'address' => ['nullable', 'string', 'max:255'],
        ]);

        Contact::create($validated);

        return redirect()
            ->route('contacts.index')
            ->with('status', 'Contact added successfully.');
    }

    public function edit(Contact $contact)
    {
        return view('contacts.edit', [
            'contact' => $contact,
        ]);
    }

    public function update(Request $request, Contact $contact)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:50', 'unique:contacts,phone,' . $contact->id],
            'email' => ['required', 'email', 'max:255', 'unique:contacts,email,' . $contact->id],
            'address' => ['nullable', 'string', 'max:255'],
        ]);

        $contact->update($validated);

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
}
