<?php

namespace App\Models;

use App\Game;
use Illuminate\Database\Eloquent\Model;

class Tribute extends Model
{
    public function games()
    {
        return $this->belongsToMany(Game::class);
    }

    public function scopeAlive($query)
    {
        return $query->where('dead', 0);
    }
}
