<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PlatformRequest;
use App\Models\Platform;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PlatformController extends Controller
{
    public function index(): View
    {
        return view('admin.platforms.index', [
            'platforms' => Platform::withCount('games')->orderBy('name')->paginate(10),
        ]);
    }

    public function create(): View
    {
        return view('admin.platforms.create', ['platform' => new Platform]);
    }

    public function store(PlatformRequest $request): RedirectResponse
    {
        $platform = Platform::create($request->validated());

        return redirect()
            ->route('admin.platforms.index')
            ->with('status', $platform->name.' berhasil ditambahkan.');
    }

    public function edit(Platform $platform): View
    {
        return view('admin.platforms.edit', ['platform' => $platform]);
    }

    public function update(PlatformRequest $request, Platform $platform): RedirectResponse
    {
        $platform->update($request->validated());

        return redirect()
            ->route('admin.platforms.index')
            ->with('status', $platform->name.' berhasil diperbarui.');
    }

    public function destroy(Platform $platform): RedirectResponse
    {
        if ($platform->games()->exists()) {
            return redirect()
                ->route('admin.platforms.index')
                ->with('error', $platform->name.' masih dipakai oleh game dan tidak bisa dihapus.');
        }

        $platform->delete();

        return redirect()
            ->route('admin.platforms.index')
            ->with('status', $platform->name.' berhasil dihapus.');
    }
}
