<?php
class Device extends Eloquent {
    protected $table = 'devices';
    protected $hidden = ['pivot'];

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


    /**
     * Accessors
     */
    public function getIdAttribute($value) {
        return (int)$value;
    }
    public function getIsPublicAttribute($value) {
        return (bool)$value;
    }
}
