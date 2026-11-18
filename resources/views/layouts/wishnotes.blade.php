<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'WishNotes') · WishNotes</title>
    <link rel="stylesheet" href="{{ asset('wishnotes.css') }}">
</head>
<body>
    <header class="site-header"><nav class="wrap" aria-label="Navigasi utama">
        <a class="brand" href="{{ route('dashboard') }}">WishNotes</a>
        @auth
            <form method="post" action="{{ route('logout') }}">@csrf<button class="secondary">Keluar</button></form>
        @else
            <a href="{{ route('login') }}">Masuk</a>
        @endauth
    </nav></header>
    <main class="wrap">
        @if (session('status'))<p class="notice" role="status">{{ session('status') }}</p>@endif
        @if ($errors->any())
            <div class="notice error" role="alert"><ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
        @endif
        @yield('content')
    </main>
</body>
</html>
