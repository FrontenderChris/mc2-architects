<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ContactEntry
 *
 * @property integer $id
 * @property string $name
 * @property string $company
 * @property string $email
 * @property string $phone
 * @property string $message
 * @property string $status
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class ContactEntry extends Model
{
    const STATUS_PENDING = 'pending';
    const STATUS_COMPLETE = 'complete';

    protected $table = 'contact_entries';
    protected $casts = [
        'data' => 'array',
    ];
    protected $fillable = [
        'first_name',
        'last_name',
        'company',
        'email',
        'phone',
        'subject',
        'message',
        'data',
    ];

    public static function boot() {
        parent::boot();

        self::saving(function($model) {
            $model->company = (empty($model->company) ? null : $model->company);
            $model->phone = (empty($model->phone) ? null : $model->phone);
        });
    }
}
