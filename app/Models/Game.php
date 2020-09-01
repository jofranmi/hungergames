<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Game
 * @package App\Models
 */
class Game extends Model
{
    public function tributes()
    {
        return $this->belongsToMany(Tribute::class);
    }
}
