<?php
namespace Beehive\Service\Validation;

class TemplateValidator extends GenericValidator {
    protected $rules = [
        'name'=>'required|min:3'
    ];
}
