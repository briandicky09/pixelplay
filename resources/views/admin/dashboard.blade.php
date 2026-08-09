@extends('layouts.admin')

@section('title', 'Dasbor')

@section('admin')
    <div class="page-head">
        <div>
            <span class="eyebrow">Ringkasan</span>
            <h1>Dasbor</h1>
        </div>
        <a href="{{ route('admin.games.create') }}" class="btn btn--primary">Tambah Game</a>
    </div>

    <div class="grid grid--4 mt-28">
        @foreach ($stats as $label => $value)
            <div class="card">
                <div class="card__body">
                    <p class="stat__label">{{ $label }}</p>
                    <p class="stat__value">{{ $value }}</p>
                </div>
            </div>
        @endforeach
    </div>

    <h2 class="mt-44">Game terbaru</h2>
    <div class="card mt-16">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Game</th>
                    <th scope="col">Kategori</th>
                    <th scope="col">Harga</th>
                    <th scope="col">Rating</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($latest as $game)
                    <tr>
                        <td>
                            <span class="table__title">
                                <img class="table__thumb" src="{{ $game->coverUrl() }}" alt="">
                                {{ $game->title }}
                            </span>
                        </td>
                        <td class="muted">{{ $game->category->name }}</td>
                        <td class="price">{{ $game->priceLabel() }}</td>
                        <td class="rating">&#9733; {{ number_format($game->rating, 1) }}</td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="muted">Belum ada game. Jalankan <code>php artisan migrate:fresh --seed</code>.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
