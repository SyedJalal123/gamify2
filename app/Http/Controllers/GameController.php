<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Game;
use App\Models\Category;

class GameController extends Controller
{
    public function index($category_id, $game_id)
    {
        $game = Game::where('id', $game_id)->with('items')->first();
        $items = Item::where('category_id', $category_id)->where('game_id', $game_id)->with('attributes')->get();
        // dd($items->all());
        return view('frontend.catalog', compact('game','items'));
    }
}
