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
	protected $hidden = array('password', 'remember_token');

	/**
	 * Returns the device models the user has created
	 * @return Eloquent has many relation
	 */
	public function deviceModels() {
		return $this->hasMany('Device');
	}

	/**
	 * Returns the device intances in which user is admin
	 * @return Eloquent many to many relation
	 */
	public function deviceInstances() {
		return $this->belongsToMany('DeviceInstance', 'device_admin');
	}

	/**
	 * Returns the containers of a user
	 * @return Eloquent has many relation
	 */
	public function containers() {
		return $this->hasMany('Container');
	}
}
