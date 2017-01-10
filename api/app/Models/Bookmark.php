<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use JWTAuth;

class Bookmark extends Model {

	protected static function boot() {
		parent::boot();

		// Set order default
		$user = JWTAuth::parseToken()->toUser();
		static::addGlobalScope('me', function (Builder $builder) use ($user) {
			$builder->where('user_id', $user->id);
		});
	}

	/**
	 * The attributes that are mass assignable.
	 * @var array
	 */
	protected $fillable = [
		'user_id', 'title', 'url',
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
	];

	/**
	 * The attributes that should be mutated to dates.
	 *
	 * @var array
	 */
	protected $dates = [
		'created_at', 'updated_at'
	];

}
