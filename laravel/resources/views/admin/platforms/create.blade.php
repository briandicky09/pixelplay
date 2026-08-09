@extends('layouts.admin')

@section('title', 'Tambah Platform')

@section('admin')
    <div>
        <span class="eyebrow">Referensi</span>
        <h1>Tambah Platform</h1>
    </div>

    @include('admin.platforms.form')
@endsection
