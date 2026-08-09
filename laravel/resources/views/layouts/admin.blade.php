@extends('layouts.base')

@section('body')
    <div class="admin">
        <aside class="sidebar">
            <a href="{{ route('admin.dashboard') }}" class="brand">
                <img src="{{ asset('images/logo-icon.png') }}" alt="Logo PixelPlay">
                <span>PixelPlay</span>
            </a>

            <nav class="sidebar__nav" aria-label="Navigasi admin">
                <a href="{{ route('admin.dashboard') }}" class="sidebar__link @if(request()->routeIs('admin.dashboard')) is-active @endif" @if(request()->routeIs('admin.dashboard')) aria-current="page" @endif>Dasbor</a>
                <a href="{{ route('admin.games.index') }}" class="sidebar__link @if(request()->routeIs('admin.games.*')) is-active @endif" @if(request()->routeIs('admin.games.*')) aria-current="page" @endif>Game</a>
                <a href="{{ route('admin.categories.index') }}" class="sidebar__link @if(request()->routeIs('admin.categories.*')) is-active @endif" @if(request()->routeIs('admin.categories.*')) aria-current="page" @endif>Kategori</a>
                <a href="{{ route('admin.platforms.index') }}" class="sidebar__link @if(request()->routeIs('admin.platforms.*')) is-active @endif" @if(request()->routeIs('admin.platforms.*')) aria-current="page" @endif>Platform</a>
            </nav>

            <form method="POST" action="{{ route('logout') }}" class="sidebar__footer">
                @csrf
                <p class="small muted">Masuk sebagai {{ auth()->user()->name }}</p>
                <button type="submit" class="btn btn--secondary btn--sm btn--block">Keluar</button>
            </form>
        </aside>

        <main class="admin__main">
            @if (session('status'))
                <div class="alert alert--success alert--flash" role="status">{{ session('status') }}</div>
            @endif

            @if (session('error'))
                <div class="alert alert--error alert--flash" role="alert">{{ session('error') }}</div>
            @endif

            @yield('admin')
        </main>
    </div>
@endsection
