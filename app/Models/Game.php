<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Game
 * @package App\Models
 * @property int $id
 * @property string $name
 * @property int $round
 * @property int $day
 */
class Game extends Model
{
    public function tributes()
    {
        return $this->belongsToMany(Tribute::class);
    }
}
