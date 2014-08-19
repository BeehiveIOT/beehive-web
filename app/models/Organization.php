<?php
class Organization extends Eloquent {
    protected $table = 'organizations';

    /**
     * Returns the administrators of the organization
     * @return Eloquent many to many relation
     */
    public function administrators() {
        return $this->belongsToMany('User', 'organization_admin');
    }

    /**
     * Returns the devices that belongs to the organization
     * @return Eloquent hasMany relation
     */
    public function devices() {
        return $this->hasMany('Device');
    }
}
