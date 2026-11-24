{{-- Shared <head> for both layouts. Expects $title (string|null). --}}
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>{{ $title ? $title.' — '.config('app.name') : config('app.name') }}</title>

@vite(['resources/scss/main.scss', 'resources/js/app.js'])
