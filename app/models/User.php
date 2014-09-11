<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token', 'pivot');

	/**
	 * Returns the device intances in which user is admin
	 * @return Eloquent many to many relation
	 */
	public function devices() {
		return $this->belongsToMany('Device', 'device_admin');
	}

	/**
	 * Returns the templates user has created
	 * @return Eloquent has many relation
	 */
	public function templates() {
		return $this->hasMany('Template');
	}
}
