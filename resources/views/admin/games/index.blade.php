@extends('layouts.admin')

@section('title', 'Game')

@section('admin')
    <div class="page-head">
        <div>
            <span class="eyebrow">Katalog</span>
            <h1>Game</h1>
        </div>
        <div class="filters">
            <form method="GET" action="{{ route('admin.games.index') }}" class="filters">
                <input class="input" type="search" name="q" value="{{ $q }}" placeholder="Cari judul" aria-label="Cari judul game">
                <button type="submit" class="btn btn--secondary">Cari</button>
            </form>
            <a href="{{ route('admin.games.create') }}" class="btn btn--primary">Tambah Game</a>
        </div>
    </div>

    <div class="card mt-28">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Game</th>
                    <th scope="col">Kategori</th>
                    <th scope="col">Platform</th>
                    <th scope="col">Harga</th>
                    <th scope="col">Rating</th>
                    <th scope="col"><span class="sr-only">Aksi</span></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($games as $game)
                    <tr>
                        <td>
                            <span class="table__title">
                                <img class="table__thumb" src="{{ $game->coverUrl() }}" alt="">
                                {{ $game->title }}
                            </span>
                        </td>
                        <td class="muted">{{ $game->category->name }}</td>
                        <td class="muted">{{ $game->platforms->pluck('name')->join(', ') }}</td>
                        <td class="price">{{ $game->priceLabel() }}</td>
                        <td class="rating">&#9733; {{ number_format($game->rating, 1) }}</td>
                        <td>
                            <div class="table__actions">
                                <a href="{{ route('admin.games.edit', $game) }}" class="btn btn--secondary btn--sm">Ubah</a>
                                <form method="POST" action="{{ route('admin.games.destroy', $game) }}" onsubmit="return confirm('Hapus {{ $game->title }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn--danger btn--sm">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="muted">Belum ada game yang cocok.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $games->links('partials.pagination') }}
@endsection
