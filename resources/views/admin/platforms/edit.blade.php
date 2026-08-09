@extends('layouts.admin')

@section('title', 'Ubah Platform')

@section('admin')
    <div>
        <span class="eyebrow">Referensi</span>
        <h1>Ubah {{ $platform->name }}</h1>
    </div>

    @include('admin.platforms.form')
@endsection
