<?php

namespace App\Traits\Tribute;

use App\Models\Tribute;

/**
 * Trait TributeActionsTrait
 * @package App\Traits\Tribute
 */
trait TributeActionsTrait
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

	/**
	 * @param Tribute $tribute
	 */
	private function updatePowerRoll(Tribute $tribute)
	{
		$tribute->power_roll = rand(0, $tribute->power);
		$tribute->save();
	}
}