<?php
class Container extends Eloquent {
    protected $table = 'containers';

    /**
     * Returns devince instances in the container
     * @return Eloquent has many relation
     */
    public function deviceInstances() {
        return $this->hasMany('DeviceInstance');
    }

    /**
     * Returns the owner user of the container
     * @return Eloquent belongs to relation
     */
    public function owner() {
        return $this->belongsTo('User');
    }
}
