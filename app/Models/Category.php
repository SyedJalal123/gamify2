<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = ['name'];

    public function games()
    {
        return $this->belongsToMany(Game::class);
    }

    public function attributes()
    {
        return $this->hasMany(Attribute::class);
    }

    public function items()
    {
        return $this->hasMany(Item::class);
    }
}
