<?php
class Device extends Eloquent {
    protected $table = 'devices';

    /**
     * Returns the owner user
     * @return Eloquent belongs to relation
     */
    public function user() {
        return $this->belongsTo('User');
    }

    /**
     * Returns the instances of a device
     * @return Eloquent has many relation
     */
    public function deviceInstances() {
        return $this->hasMany('DeviceInstance');
    }

    /**
     * Returns the commands of a device
     * @return Eloquent has many relation
     */
    public function commands() {
        return $this->hasMany('Command');
    }
}
