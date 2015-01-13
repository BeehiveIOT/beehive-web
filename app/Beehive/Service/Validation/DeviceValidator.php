<?php
namespace Beehive\Service\Validation;

class DeviceValidator extends GenericValidator {
    protected $rules = [
        'name'=>'required|min:3',
        // 'template_id' => 'required'
    ];

    // protected $messages = [
    // ];
}
