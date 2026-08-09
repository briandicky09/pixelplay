@extends('layouts.admin')

@section('title', 'Kategori')

@section('admin')
    <div class="page-head">
        <div>
            <span class="eyebrow">Referensi</span>
            <h1>Kategori</h1>
        </div>
        <a href="{{ route('admin.categories.create') }}" class="btn btn--primary">Tambah Kategori</a>
    </div>

    <div class="card mt-28">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Nama</th>
                    <th scope="col">Slug</th>
                    <th scope="col">Jumlah Game</th>
                    <th scope="col"><span class="sr-only">Aksi</span></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($categories as $category)
                    <tr>
                        <td class="table__name">{{ $category->name }}</td>
                        <td class="muted"><code>{{ $category->slug }}</code></td>
                        <td class="muted">{{ $category->games_count }}</td>
                        <td>
                            <div class="table__actions">
                                <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn--secondary btn--sm">Ubah</a>
                                <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" onsubmit="return confirm('Hapus {{ $category->name }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn--danger btn--sm">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="muted">Belum ada data.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $categories->links('partials.pagination') }}
@endsection
