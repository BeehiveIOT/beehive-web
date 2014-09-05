<?php
class Command extends Eloquent {
    protected $table = 'commands';

    /**
     * Returns the template that can execute this command
     * @return Eloquent belongs to relation
     */
    public function template() {
        return $this->belongsTo('Template');
    }
}
