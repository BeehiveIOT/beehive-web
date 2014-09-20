<?php
class Template extends Eloquent {
    protected $table = 'templates';

    /**
     * Returns the owner user
     * @return Eloquent belongs to relation
     */
    public function user() {
        return $this->belongsTo('User');
    }

    /**
     * Returns the devices that use this template
     * @return Eloquent has many relation
     */
    public function devices() {
        return $this->hasMany('Device');
    }

    /**
     * Returns the commands of a device
     * @return Eloquent has many relation
     */
    public function commands() {
        return $this->hasMany('Command');
    }
}