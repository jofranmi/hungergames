<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Tribute
 * @package App\Models
 * @property string $friendly_name
 * @property string $name
 * @property int $district
 * @property int $aggressiveness
 * @property int $power_initial
 * @property int $power
 * @property int $power_roll
 * @property int $kills
 * @property bool $dead
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
