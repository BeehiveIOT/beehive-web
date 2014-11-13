<?php

class Argument extends Eloquent {
    protected $table = 'arguments';

    /**
     * Returns the owner command of this argument
     * @return Eloquent belongs to relation
     */
    public function command() {
        return $this->belongsTo('Command');
    }
}
