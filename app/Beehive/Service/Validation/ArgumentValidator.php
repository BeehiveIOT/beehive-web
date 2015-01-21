<?php
namespace Beehive\Service\Validation;

class ArgumentValidator extends GenericValidator {
    protected $rules = [
        'name' => 'required|min:2',
        'type' => 'required|in:number,string'
    ];
}
