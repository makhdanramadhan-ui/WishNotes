@extends('layouts.wishnotes')
@section('title', 'Papan saya')
@section('content')
<section class="intro"><h1>Papan saya</h1><p>Halo, {{ auth()->user()->name }}. Buat papan untuk mengumpulkan pesan dari teman.</p></section>
<details class="panel" @if($errors->any()) open @endif>
    <summary>Buat papan baru</summary>
    <form method="post" action="{{ route('boards.store') }}" class="fields">
        @csrf
        <label>Judul <input name="judul" value="{{ old('judul') }}" maxlength="100" required></label>
        <label>Deskripsi <textarea name="deskripsi_singkat" maxlength="255" required>{{ old('deskripsi_singkat') }}</textarea></label>
        <label>Tampilan <select name="tipe_wadah">@foreach (['tree'=>'Pohon Natal','mading'=>'Mading','mailbox'=>'Kotak surat'] as $value => $label)<option value="{{ $value }}" @selected(old('tipe_wadah') === $value)>{{ $label }}</option>@endforeach</select></label>
        <label>Akses <select name="privasi"><option value="private">Hanya saya</option><option value="public" @selected(old('privasi') === 'public')>Siapa pun yang punya tautan</option></select></label>
        <button>Buat papan</button>
    </form>
</details>
<div class="cards">
@forelse ($boards as $board)
    <article class="panel">
        <h2><a href="{{ route('boards.show', $board) }}">{{ $board->judul }}</a></h2>
        <p>{{ $board->deskripsi_singkat }}</p>
        <p class="muted">{{ $board->messages_count }} pesan · {{ $board->privasi === 'public' ? 'Publik' : 'Privat' }}</p>
    </article>
@empty
    <p class="muted">Belum ada papan. Buka formulir di atas untuk membuat papan pertama.</p>
@endforelse
</div>
@endsection
