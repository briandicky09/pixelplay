@php($isEdit = $category->exists)

<form method="POST" action="{{ $isEdit ? route('admin.categories.update', $category) : route('admin.categories.store') }}" class="stack form-panel">
    @csrf
    @if ($isEdit)
        @method('PUT')
    @endif

    <div class="card">
        <div class="card__body stack">
            <label class="field">
                <span class="field__label">Nama</span>
                <input class="input" type="text" name="name" value="{{ old('name', $category->name) }}" required autofocus>
                @error('name') <span class="field__error">{{ $message }}</span> @enderror
            </label>

            <label class="field">
                <span class="field__label">Slug <span class="muted">(kosongkan untuk dibuat dari nama)</span></span>
                <input class="input" type="text" name="slug" value="{{ old('slug', $category->slug) }}">
                @error('slug') <span class="field__error">{{ $message }}</span> @enderror
            </label>
        </div>
    </div>

    <div class="filters">
        <button type="submit" class="btn btn--primary">{{ $isEdit ? 'Simpan perubahan' : 'Tambah Kategori' }}</button>
        <a href="{{ route('admin.categories.index') }}" class="btn btn--ghost">Batal</a>
    </div>
</form>
