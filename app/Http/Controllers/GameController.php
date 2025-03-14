<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;
use App\Models\Category;

class GameController extends Controller
{
    public function index($categoryId)
    {
        $category = Category::findOrFail($categoryId);
        $games = Game::all(); // Fetch all games (or filter games based on some logic)
        return view('frontend.seller.games_select', compact('category', 'games'));
    }
}
