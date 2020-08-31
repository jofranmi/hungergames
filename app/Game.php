<?php

namespace App;

use App\Models\Tribute;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    public function tributes()
    {
        return $this->belongsToMany(Tribute::class);
    }
}
