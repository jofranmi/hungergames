<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class EventType
 * @package App\Models
 */
class EventType extends Model
{
    public const POSITIVE = 1;
    public const NEUTRAL = 2;
    public const NEGATIVE = 3;
}
