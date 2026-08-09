<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Game;
use App\Models\Platform;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        return view('admin.dashboard', [
            'stats' => [
                'Total Game' => Game::count(),
                'Kategori' => Category::count(),
                'Platform' => Platform::count(),
                'Game Unggulan' => Game::where('is_featured', true)->count(),
            ],
            'latest' => Game::with('category')->latest('id')->take(5)->get(),
        ]);
    }
}
