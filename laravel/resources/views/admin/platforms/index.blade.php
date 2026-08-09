@extends('layouts.admin')

@section('title', 'Platform')

@section('admin')
    <div class="page-head">
        <div>
            <span class="eyebrow">Referensi</span>
            <h1>Platform</h1>
        </div>
        <a href="{{ route('admin.platforms.create') }}" class="btn btn--primary">Tambah Platform</a>
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
                @forelse ($platforms as $platform)
                    <tr>
                        <td class="table__name">{{ $platform->name }}</td>
                        <td class="muted"><code>{{ $platform->slug }}</code></td>
                        <td class="muted">{{ $platform->games_count }}</td>
                        <td>
                            <div class="table__actions">
                                <a href="{{ route('admin.platforms.edit', $platform) }}" class="btn btn--secondary btn--sm">Ubah</a>
                                <form method="POST" action="{{ route('admin.platforms.destroy', $platform) }}" onsubmit="return confirm('Hapus {{ $platform->name }}?')">
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

    {{ $platforms->links('partials.pagination') }}
@endsection
