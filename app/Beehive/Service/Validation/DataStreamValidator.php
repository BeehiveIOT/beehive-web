<?php

namespace Beehive\Service\Validation;

class DataStreamValidator extends GenericValidator
{
    protected $rules = [
        'name' => 'required|min:3',
        'topic_name' => 'required',
        'data_type' => 'in:number,string,location',
        'display_type' => 'in:line,bar,map'
    ];

    public function passes()
    {
        if (!parent::passes()) {
            return false;
        }

        if ($this->data['data_type'] === 'location') {
            if ($this->data['display_type'] !== 'map') {
                // $this->errors = ['map error'];
                return false;
            }
        }

        // TODO: validate topic_name to only accept [a-z][0-9] symbols

        return true;
    }
}
