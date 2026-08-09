@extends('layouts.admin')

@section('title', 'Ubah Kategori')

@section('admin')
    <div>
        <span class="eyebrow">Referensi</span>
        <h1>Ubah {{ $category->name }}</h1>
    </div>

    @include('admin.categories.form')
@endsection
