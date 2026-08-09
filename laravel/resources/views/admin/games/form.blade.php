@php($isEdit = $game->exists)

<form method="POST" action="{{ $isEdit ? route('admin.games.update', $game) : route('admin.games.store') }}" enctype="multipart/form-data" class="stack form-panel">
    @csrf
    @if ($isEdit)
        @method('PUT')
    @endif

    <div class="grid grid--2">
        <div class="card">
            <div class="card__body stack">
                <label class="field">
                    <span class="field__label">Judul</span>
                    <input class="input" type="text" name="title" value="{{ old('title', $game->title) }}" required>
                    @error('title') <span class="field__error">{{ $message }}</span> @enderror
                </label>

                <label class="field">
                    <span class="field__label">Slug <span class="muted">(kosongkan untuk dibuat dari judul)</span></span>
                    <input class="input" type="text" name="slug" value="{{ old('slug', $game->slug) }}">
                    @error('slug') <span class="field__error">{{ $message }}</span> @enderror
                </label>

                <label class="field">
                    <span class="field__label">Kategori</span>
                    <select class="select" name="category_id" required>
                        <option value="">Pilih kategori</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @selected((int) old('category_id', $game->category_id) === $category->id)>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id') <span class="field__error">{{ $message }}</span> @enderror
                </label>

                <fieldset class="field">
                    <legend class="field__label">Platform</legend>
                    <div class="checkgrid">
                        @php($selected = collect(old('platforms', $game->platforms->pluck('id')->all()))->map('intval'))
                        @foreach ($platforms as $platform)
                            <label class="checkline">
                                <input type="checkbox" name="platforms[]" value="{{ $platform->id }}" @checked($selected->contains($platform->id))>
                                <span>{{ $platform->name }}</span>
                            </label>
                        @endforeach
                    </div>
                    @error('platforms') <span class="field__error">{{ $message }}</span> @enderror
                </fieldset>

                <div class="grid grid--2 grid--tight">
                    <label class="field">
                        <span class="field__label">Harga (Rp)</span>
                        <input class="input" type="number" name="price" min="0" step="1000" value="{{ old('price', $game->price ?? 0) }}" required>
                        @error('price') <span class="field__error">{{ $message }}</span> @enderror
                    </label>
                    <label class="field">
                        <span class="field__label">Rating</span>
                        <input class="input" type="number" name="rating" min="0" max="5" step="0.1" value="{{ old('rating', $game->rating ?? 0) }}" required>
                        @error('rating') <span class="field__error">{{ $message }}</span> @enderror
                    </label>
                </div>

                <label class="field">
                    <span class="field__label">Tanggal rilis</span>
                    <input class="input" type="date" name="released_at" value="{{ old('released_at', $game->released_at?->toDateString()) }}" required>
                    @error('released_at') <span class="field__error">{{ $message }}</span> @enderror
                </label>

                <label class="checkline">
                    <input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $game->is_featured))>
                    <span>Tampilkan sebagai game unggulan</span>
                </label>
            </div>
        </div>

        <div class="stack">
            <div class="card">
                <div class="card__body stack">
                    <label class="field">
                        <span class="field__label">Deskripsi</span>
                        <textarea class="textarea" name="description" required>{{ old('description', $game->description) }}</textarea>
                        @error('description') <span class="field__error">{{ $message }}</span> @enderror
                    </label>
                </div>
            </div>

            <div class="card">
                <div class="card__body stack">
                    <span class="field__label">Gambar sampul</span>
                    @if ($isEdit)
                        <img class="cover cover--rounded" src="{{ $game->coverUrl() }}" alt="Sampul {{ $game->title }}">
                    @endif
                    <input class="input" type="file" name="cover" accept="image/jpeg,image/png,image/webp" aria-label="Gambar sampul" @required(! $isEdit)>
                    <p class="small muted">JPG, PNG, atau WEBP. Maksimal 4 MB. Disimpan di <code>public/images/games</code>.</p>
                    @error('cover') <span class="field__error">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>
    </div>

    <div class="filters">
        <button type="submit" class="btn btn--primary">{{ $isEdit ? 'Simpan perubahan' : 'Tambah game' }}</button>
        <a href="{{ route('admin.games.index') }}" class="btn btn--ghost">Batal</a>
    </div>
</form>
