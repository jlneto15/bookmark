<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Bookmark;

class User extends Authenticatable {

	use Notifiable;

	protected static function boot() {
		parent::boot();
		
		// Set order default
		static::addGlobalScope('order', function (Builder $builder) {
			$builder->orderBy('id', 'asc');
		});
	}

	/**
	 * The attributes that are mass assignable.
	 * @var array
	 */
	protected $fillable = [
		'name', 'email', 'password',
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password', 'remember_token'
	];

	/**
	 * The attributes that should be casted to native types.
	 *
	 * @var array
	 */
	protected $casts = [
		'is_root' => 'boolean',
	];

	/**
	 * The attributes that should be mutated to dates.
	 *
	 * @var array
	 */
	protected $dates = [
		'created_at', 'updated_at', 'deleted_at'
	];

	/**
	 * Set the user's password.
	 *
	 * @param  string  $value
	 * @return void
	 */
	public function setPasswordAttribute($value) {
		$this->attributes['password'] = bcrypt($value);
	}

	public function scopeBookmark () {
		return $this->hasMany('App\Models\Bookmark', 'user_id', 'id');
	}

}
