<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PlatformResource;
use App\Models\Platform;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PlatformController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return PlatformResource::collection(
            Platform::withCount('games')->orderBy('name')->get()
        );
    }
}
