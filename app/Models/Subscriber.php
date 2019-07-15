<?php

namespace App\Models;

use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Subscriber
 *
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class Subscriber extends Model
{
    protected $fillable = [
        'name',
        'email',
    ];

    public static function boot()
    {
        parent::boot();

        self::saving(function($model) {
            $model->name = (empty($model->name) ? null : $model->name);
            $model->phone = (empty($model->phone) ? null : $model->phone);
        });
    }

    public static function search($search)
    {
        $search = trim($search);
        $query = '%' . $search . '%';

        return self::where('name', 'LIKE', $query)
            ->orWhere('email', 'LIKE', $query)
            ->orWhere('phone', 'LIKE', $query);
    }

    /**
     * Encrypt a value to be used in the unsubscribe URL
     * @param $value
     * @return string
     */
    public static function encrypt($value)
    {
        return \Crypt::encrypt($value);
    }

    /**
     * @param $value
     * @return bool|string
     */
    public static function decrypt($value)
    {
        try {
            return \Crypt::decrypt($value);
        } catch (DecryptException $e) {
            return false;
        }
    }

    /**
     * @return string
     */
    public function getUnsubscribeUrl()
    {
        return route('unsubscribe', [
            'id' => self::encrypt($this->id),
            'email' => $this->email,
        ]);
    }

    /**
     * @param $query
     * @param $email
     * @return mixed
     */
    public function scopeEmail($query, $email)
    {
        return $query->where('email', '=', $email);
    }

    public function scopeNoRelation($query)
    {
        return $query->whereNull('subscribeable_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function subscribeable()
    {
        return $this->morphTo();
    }
}
