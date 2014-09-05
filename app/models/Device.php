<?php
class Device extends Eloquent {
    protected $table = 'devices';

    /**
     * Returns the template of this device
     * @return Eloquent belongs to relation
     */
    public function template() {
        return $this->belongsTo('Template');
    }

    /**
     * Returns the users that can use the device instance
     * @return Eloquent many to many relation
     */
    public function administrators() {
        return $this->belongsToMany('User', 'device_admin', 'device_id');
    }
}
