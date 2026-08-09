@extends('layouts.admin')

@section('title', 'Tambah Game')

@section('admin')
    <div>
        <span class="eyebrow">Katalog</span>
        <h1>Tambah Game</h1>
    </div>

    @include('admin.games.form')
@endsection
