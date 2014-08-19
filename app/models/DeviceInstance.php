<?php
class DeviceInstance extends Eloquent {
    protected $table = 'device_instances';

    /**
     * Returns the device model of the instance
     * @return Eloquent belongs to relation
     */
    public function device() {
        return $this->belongsTo('Device');
    }

    /**
     * Returns the users that can use the device instance
     * @return Eloquent many to many relation
     */
    public function administrators() {
        return $this->belongsToMany('User', 'device_admin', 'device_instance_id');
    }

    /**
     * Returns the container of the instance
     * @return Eloquent belongs to relation
     */
    public function container(){
        return $this->belongsTo('Container');
    }
}
