<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'type', 'options', 'applies_to', 'game_id', 'category_id'];

    protected $casts = [
        'options' => 'array', // Since options are stored as JSON
    ];
    
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function game()
    {
        return $this->belongsTo(Game::class);
    }

    public function items()
    {
        return $this->belongsToMany(Item::class, 'item_attributes')
                    ->withPivot('value')
                    ->withTimestamps();
    }
}