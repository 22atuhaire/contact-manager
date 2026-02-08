<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Contact Manager') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif
    </head>
    <body class="min-h-screen bg-gradient-to-br from-amber-50 via-stone-50 to-emerald-50 text-stone-900">
        <div class="max-w-5xl mx-auto px-4 py-8">
            <header class="mb-8">
                <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                    <div>
                        <a href="{{ route('contacts.index') }}" class="text-2xl font-semibold tracking-tight">
                            Contact Manager
                        </a>
                        <p class="text-sm text-stone-600">
                            Store and manage your contact list in one place.
                        </p>
                    </div>
                    <nav class="flex items-center gap-3">
                        <a href="{{ route('contacts.index') }}" class="text-sm font-medium text-stone-700 hover:text-stone-900">
                            Contacts
                        </a>
                        <a href="{{ route('contacts.create') }}" class="inline-flex items-center rounded-full bg-stone-900 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-stone-800">
                            Add Contact
                        </a>
                    </nav>
                </div>
            </header>

            <main class="rounded-3xl border border-stone-200 bg-white/80 p-6 shadow-sm backdrop-blur">
                @if (session('status'))
                    <div class="mb-4 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-900">
                        {{ session('status') }}
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </body>
</html>
