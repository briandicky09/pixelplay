<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\GameIndexRequest;
use App\Http\Resources\GameResource;
use App\Models\Game;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class GameController extends Controller
{
    public function index(GameIndexRequest $request): AnonymousResourceCollection
    {
        $games = Game::with(['category', 'platforms'])
            ->search($request->validated('q'))
            ->inCategory($request->validated('category'))
            ->onPlatform($request->validated('platform'))
            ->when($request->boolean('featured'), fn (Builder $query) => $query->where('is_featured', true))
            ->orderByDesc('is_featured')
            ->orderBy('title')
            ->paginate($request->perPage())
            ->withQueryString();

        return GameResource::collection($games);
    }

    public function show(Game $game): GameResource
    {
        return new GameResource($game->load(['category', 'platforms']));
    }
}
