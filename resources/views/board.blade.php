@extends('layouts.wishnotes')
@section('title', $board->judul)
@section('content')
@php($isTree = $board->tipe_wadah === 'tree')
<section class="intro">
    <h1>{{ $board->judul }}</h1><p>{{ $board->deskripsi_singkat }}</p>
    @if($board->privasi === 'public')
        <label>Tautan untuk dibagikan <input readonly value="{{ route('boards.show', $board) }}" onclick="this.select()"></label>
    @else
        <p>Privat · hanya pemilik yang dapat membuka papan ini.</p>
    @endif
</section>
<div class="board-layout">
    <section class="panel theme-{{ $board->tipe_wadah }}" aria-labelledby="messages-heading">
        <h2 id="messages-heading">{{ match($board->tipe_wadah) {'tree' => 'Pohon Natal', 'mading' => 'Mading', default => 'Kotak surat'} }}</h2>
        @if($isTree)
            <div class="tree" id="tree">
                <img src="{{ asset('images/pohonNatal/pohonNatalTerang.png') }}" alt="Pohon Natal">
                @foreach($messages as $message)
                    @if($message->ornament && $message->x !== null && $message->y !== null)
                        <a href="#message-{{ $message->id }}" class="ornament" style="left:{{ (float) $message->x }}%;top:{{ (float) $message->y }}%" aria-label="Baca pesan {{ $loop->iteration }}"><img src="{{ asset('images/pohonNatal/ornamen'.$message->ornament.'.png') }}" alt=""></a>
                    @endif
                @endforeach
            </div>
        @endif
        <div class="messages">
            @forelse($messages as $message)
                <article id="message-{{ $message->id }}" class="message"><h3>{{ $message->display_name ?? 'Tanpa nama' }}</h3><p>{{ $message->body }}</p></article>
            @empty
                <p class="muted">Belum ada pesan.</p>
            @endforelse
        </div>
    </section>
    <section class="panel" aria-labelledby="write-heading">
        <h2 id="write-heading">Tulis pesan</h2>
        <form method="post" action="{{ route('messages.store', $board) }}" class="fields">
            @csrf
            <label>Nama (opsional) <input name="display_name" maxlength="60" value="{{ old('display_name') }}"></label>
            <label>Pesan <textarea name="body" maxlength="1000" required>{{ old('body') }}</textarea></label>
            @if($isTree)
                <label>Ornamen <select name="ornament">@foreach(['Bola'=>'Bola','CandyCane'=>'Permen tongkat','Kado'=>'Kado','KaosKaki'=>'Kaus kaki','Lolipop'=>'Lolipop'] as $id => $label)<option value="{{ $id }}" @selected(old('ornament') === $id)>{{ $label }}</option>@endforeach</select></label>
                <p class="muted">Klik pohon untuk memilih posisi atau masukkan koordinat (0–100%).</p>
                <div class="coordinates">
                    <label>Horizontal <input name="x" id="position-x" type="number" min="0" max="100" step="0.01" value="{{ old('x', 50) }}" required></label>
                    <label>Vertikal <input name="y" id="position-y" type="number" min="0" max="100" step="0.01" value="{{ old('y', 50) }}" required></label>
                </div>
            @endif
            <button>Kirim pesan</button>
        </form>
    </section>
</div>
@if(auth()->id() !== null && auth()->id() === $board->users_id)
    <details class="panel delete-board"><summary>Hapus papan</summary>
        <p>Papan dan semua pesannya akan dihapus.</p>
        <form method="post" action="{{ route('boards.destroy', $board) }}">@csrf @method('DELETE')<button>Hapus papan dan pesan</button></form>
    </details>
@endif
@if($isTree)
    <script>
        const tree = document.querySelector('#tree');
        tree.addEventListener('click', event => {
            if (event.target.closest('a')) return;
            const rect = tree.getBoundingClientRect();
            document.querySelector('#position-x').value = ((event.clientX - rect.left) / rect.width * 100).toFixed(2);
            document.querySelector('#position-y').value = ((event.clientY - rect.top) / rect.height * 100).toFixed(2);
        });
    </script>
@endif
@endsection
