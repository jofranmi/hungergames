<?php

namespace App\Traits\Tribute;

use App\Models\Tribute;

/**
 * Trait TributeKillTrait
 * @package App\Traits\Tribute
 */
trait TributeKillTrait
{
	/**
	 * @param Tribute $tribute
	 */
	private function killTribute(Tribute $tribute)
	{
		$tribute->dead = true;
		$tribute->save();
	}

	/**
	 * @param Tribute $tribute
	 * @param int $killCount
	 */
	private function addKillCount(Tribute $tribute, int $killCount)
	{
		$tribute->kills += $killCount;
		$tribute->save();
	}
}