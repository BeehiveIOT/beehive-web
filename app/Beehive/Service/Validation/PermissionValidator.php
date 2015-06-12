<?php

namespace Beehive\Service\Validation;

class PermissionValidator extends GenericValidator {
    protected $rules = [
        'username' => 'required|min:3',
        'can_read' => 'required|in:true,false',
        'can_execute' => 'required|in:true,false'
    ];
}
