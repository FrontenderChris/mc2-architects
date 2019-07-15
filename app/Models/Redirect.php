<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Redirect extends Model
{
    protected $fillable = [
        'redirect_from',
        'redirect_to',
        'code',
    ];

    /**
     * @param $path
     * @return self
     */
    public static function hasRedirect($path)
    {
        return self::where('redirect_from', '=', $path)->first();
    }
}
