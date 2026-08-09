@extends('layouts.admin')

@section('title', 'Tambah Kategori')

@section('admin')
    <div>
        <span class="eyebrow">Referensi</span>
        <h1>Tambah Kategori</h1>
    </div>

    @include('admin.categories.form')
@endsection
