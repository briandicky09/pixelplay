@extends('layouts.base')

@section('title', 'Masuk')

@section('body')
    <main class="auth">
        <div class="auth__panel">
            <div class="brand brand--centered">
                <img src="{{ asset('images/logo-icon.png') }}" alt="Logo PixelPlay">
                <span>PixelPlay</span>
            </div>

            <div class="card">
                <div class="card__body stack">
                    <div>
                        <span class="eyebrow">Panel administrator</span>
                        <h1 class="auth__title">Masuk ke dasbor</h1>
                        <p class="muted small">Kelola katalog game PixelPlay.</p>
                    </div>

                    @if ($errors->any())
                        <div class="alert alert--error" role="alert">{{ $errors->first() }}</div>
                    @endif

                    <form method="POST" action="{{ route('login') }}" class="stack">
                        @csrf

                        <label class="field">
                            <span class="field__label">Email</span>
                            <input class="input" type="email" name="email" value="{{ old('email', \Database\Seeders\AdminUserSeeder::EMAIL) }}" required autofocus autocomplete="username">
                        </label>

                        <label class="field">
                            <span class="field__label">Kata sandi</span>
                            <input class="input" type="password" name="password" required autocomplete="current-password">
                        </label>

                        <label class="checkline">
                            <input type="checkbox" name="remember" value="1">
                            <span class="muted">Ingat saya</span>
                        </label>

                        <button type="submit" class="btn btn--primary btn--block">Masuk</button>
                    </form>

                    <div class="demo">
                        <span class="eyebrow">Akun demo administrator</span>
                        <div class="demo__row">
                            <span class="muted small">Email</span>
                            <span class="demo__value">{{ \Database\Seeders\AdminUserSeeder::EMAIL }}</span>
                        </div>
                        <div class="demo__row">
                            <span class="muted small">Kata sandi</span>
                            <span class="demo__value">{{ \Database\Seeders\AdminUserSeeder::PASSWORD }}</span>
                        </div>
                        <p class="small muted demo__note">
                            Akun ini dibuat otomatis oleh <code>php artisan migrate:fresh --seed</code>.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
