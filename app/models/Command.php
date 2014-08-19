<?php
class Command extends Eloquent {
    protected $table = 'commands';

    /**
     * Returns the device that can execute this command
     * @return Eloquent belongst to relation
     */
    public function device() {
        return $this->belongsTo('Device');
    }

    /**
     * Returns the arguments of the command
     * @return Eloquent has many relation
     */
    public function arguments() {
        return $this->hasMany('Argument');
    }
}
