<?php
class Country extends Eloquent {
    protected $fillable = ['code', 'name'];
    protected $table = 'countries';
}
