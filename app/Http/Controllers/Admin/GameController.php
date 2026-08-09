<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\GameRequest;
use App\Models\Category;
use App\Models\Game;
use App\Models\Platform;
use App\Services\CoverImageStore;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GameController extends Controller
{
    public function __construct(private readonly CoverImageStore $covers) {}

    public function index(Request $request): View
    {
        return view('admin.games.index', [
            'games' => Game::with(['category', 'platforms'])
                ->search($request->query('q'))
                ->orderBy('title')
                ->paginate(10)
                ->withQueryString(),
            'q' => $request->query('q'),
        ]);
    }

    public function create(): View
    {
        return view('admin.games.create', [
            'game' => new Game,
            ...$this->formOptions(),
        ]);
    }

    public function store(GameRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['cover_image'] = $this->covers->store($request->file('cover'), $data['slug']);

        $game = Game::create($data);
        $game->platforms()->sync($data['platforms']);

        return redirect()
            ->route('admin.games.index')
            ->with('status', $game->title.' berhasil ditambahkan.');
    }

    public function edit(Game $game): View
    {
        return view('admin.games.edit', [
            'game' => $game->load('platforms'),
            ...$this->formOptions(),
        ]);
    }

    public function update(GameRequest $request, Game $game): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('cover')) {
            $previous = $game->cover_image;
            $data['cover_image'] = $this->covers->store($request->file('cover'), $data['slug']);
            $this->covers->delete($previous);
        }

        $game->update($data);
        $game->platforms()->sync($data['platforms']);

        return redirect()
            ->route('admin.games.index')
            ->with('status', $game->title.' berhasil diperbarui.');
    }

    public function destroy(Game $game): RedirectResponse
    {
        $this->covers->delete($game->cover_image);
        $game->delete();

        return redirect()
            ->route('admin.games.index')
            ->with('status', $game->title.' berhasil dihapus.');
    }

    private function formOptions(): array
    {
        return [
            'categories' => Category::orderBy('name')->get(),
            'platforms' => Platform::orderBy('name')->get(),
        ];
    }
}
