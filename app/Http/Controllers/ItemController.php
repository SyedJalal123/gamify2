<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Category;
use App\Models\Game;
use App\Models\Attribute;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{
    public function create()
    {
        $categories = Category::with('games')->get();

        return view('frontend.seller.items_create', compact('categories'));
    }

    public function index()
    {
        $categories = Category::all();
        return view('frontend.seller.items_create', compact('categories'));
    }

    public function getGames(Request $request)
    {
        $games = Game::whereHas('categories', function ($query) use ($request) {
            $query->where('categories.id', $request->category_id);
        })->get();

        return response()->json(['games' => $games]);
    }

    public function getAttributes(Request $request)
    {
        // dd($request->all());
        $attributes = Attribute::where(function ($query) use ($request) {
            if ($request->category_id) {
                $query->where('category_id', $request->category_id);
            }
            if ($request->game_id) {
                $query->orWhere('game_id', $request->game_id);
            }
        })->get();
        // dd($attributes);
        return response()->json(['attributes' => $attributes]);
    }

    public function store(Request $request)
    {
        dd('Website Under Maintainence');
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'game_id' => 'required|exists:games,id',
            'delivery_type' => 'required|in:instant,manual',
            'price' => 'required|numeric|min:0',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Handle multiple images
        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('items', 'public');
                $imagePaths[] = $path;
            }
        }

        // Ensure the selected feature image is within uploaded images
        if (!in_array($request->feature_image, $imagePaths)) {
            return redirect()->back()->withErrors(['feature_image' => 'Invalid feature image selection']);
        }

        $item = Item::create([
            'title'         => $request->title,
            'seller_id'     => Auth::id(),
            'description'   => $request->description,
            'category_id'   => $request->category_id,
            'game_id'       => $request->game_id,
            'price'         => $request->price,
            'delivery_type' => $request->delivery_type,
            'images'        => json_encode($imagePaths),
            'feature_image' => $request->feature_image,
        ]);

        return redirect()->route('frontend.seller.items_show', $item->id)->with('success', 'Item listed successfully!');
    }

    public function show(Item $item)
    {
        return view('frontend.seller.items_show', compact('item'));
    }
}