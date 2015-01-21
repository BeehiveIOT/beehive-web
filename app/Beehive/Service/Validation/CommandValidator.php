<?php
namespace Beehive\Service\Validation;

class CommandValidator extends GenericValidator {
    protected $rules = [
        'name' => 'required|min:3',
        'short_cmd' => 'required',
        'type' => 'required|in:int,string',
        'template_id' => 'exists:templates,id'
    ];
}
