<?php
class Argument extends Eloquent {
    protected $table = 'arguments';

    /**
     * Returns the command that has this argument
     * @return Eloquent belongs to relation
     */
    public function command() {
        return $this->belongsTo('Command', 'command_id');
    }
}
