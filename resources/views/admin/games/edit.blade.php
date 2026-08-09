@extends('layouts.admin')

@section('title', 'Ubah Game')

@section('admin')
    <div>
        <span class="eyebrow">Katalog</span>
        <h1>Ubah {{ $game->title }}</h1>
    </div>

    @include('admin.games.form')
@endsection
