<?php
class DataStream extends Eloquent
{
    protected $table = 'data_streams';
    protected $hidden = ['created_at', 'updated_at'];
}
