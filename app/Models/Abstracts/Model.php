<?php

namespace App\Models\Abstracts;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Support\Facades\DB;

/**
 * Class Model
 * @package App\Models\Abstracts
 *
 * @property int $id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
abstract class Model extends EloquentModel
{
    /**
     * @param bool $fake
     */
    public static function truncate($fake = false)
    {
        if ($fake) {
            DB::table((new static)->getTable())->delete();
        } else {
            parent::truncate();
        }
    }
}
