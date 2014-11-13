<?php
class Command extends Eloquent {
    protected $table = 'commands';
    protected $hidden = ['user_id'];

    /**
     * Returns the template that can execute this command
     * @return Eloquent belongs to relation
     */
    public function template() {
        return $this->belongsTo('Template');
    }

    /**
     * Returns the argument that belongs to this command
     * @return Eloquent has many relation
     */
    public function arguments() {
        return $this->hasMany('Argument');
    }

    public function getCreatedAtAttribute($value) {
        return (new DateTime($value))->format('c');
    }

    public function getUpdatedAtAttribute($value) {
        return (new DateTime($value))->format('c');
    }

    public function getIdAttribute($value) {
        return (int)$value;
    }
}
