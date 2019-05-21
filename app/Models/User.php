<?php

namespace App\Models;

use App\Models\Abstracts\Authenticable;

/**
 * Class User
 *
 * @package App\Model
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $remember_token
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 */
class User extends Authenticable
{
	protected $fillable = [
		'name',
		'email',
		'password'
	];

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function role()
	{
		return $this->belongsTo('Modulatte\Login\Models\Role');
	}
}
