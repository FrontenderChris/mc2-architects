<?php

namespace App\Models\Abstracts;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Undeletable
 * @package App\Models\Abstracts
 *
 * @property Carbon $deleted_at
 */
abstract class Undeletable extends Model
{
    use SoftDeletes;

    /**
     * @var array
     */
    protected $dates = ['deleted_at'];
}
