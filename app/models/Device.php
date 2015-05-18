<?php
class Device extends Eloquent {
    protected $table = 'devices';
    // protected $hidden = ['created_at', 'update_at'];

    /**
     * Returns the template of this device
     * @return Eloquent belongs to relation
     */
    public function template() {
        return $this->belongsTo('Template');
    }

    /**
     * Returns the commands of this device
     * @return Eloquent has many through relation
     */
    public function commands() {
        return $this->hasManyThrough('Command', 'Template');
    }

    /**
     * Returns the users that can use the device instance
     * @return Eloquent many to many relation
     */
    public function administrators()
    {
        return $this->belongsToMany('User', 'device_admin', 'device_id')
            ->withPivot('can_read', 'can_update', 'can_delete', 'user_id');
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
