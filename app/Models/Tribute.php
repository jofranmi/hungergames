<?php

namespace App\Models;

use App\Game;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Tribute
 * @package App\Models
 */
class Tribute extends Model
{
	/**
	 * @var string[]
	 */
	protected $fillable = [
		'power_roll',
	];

    public function games()
    {
        return $this->belongsToMany(Game::class);
    }

    public function scopeAlive($query)
    {
        return $query->where('dead', 0);
    }
}
