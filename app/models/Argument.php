<?php

class Argument extends Eloquent {
    protected $table = 'arguments';
    protected $hidden = ['created_at', 'updated_at'];

    /**
     * Returns the owner command of this argument
     * @return Eloquent belongs to relation
     */
    public function command() {
        return $this->belongsTo('Command');
    }

    public function getIdAttribute($value) {
        return (int)$value;
    }

    public function getMinimumAttribute($value) {
        return (float)$value ?: null;
    }

    public function getMaximumAttribute($value) {
        return (float)$value ?: null;
    }
}
