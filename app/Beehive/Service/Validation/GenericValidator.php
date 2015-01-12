<?php
namespace Beehive\Service\Validation;

use Illuminate\Validation\Factory as Validator;
use Beehive\Service\Validation\Validator as MyValidator;

abstract class GenericValidator implements MyValidator {

    /**
     * Validator
     * @var Illuminate\Validation\Factory
     */
    protected $validator;

    /**
     * Validation data, key=>value
     * @var array
     */
    protected $data;

    /**
     * Validaton rules, key=>value
     * @var array
     */
    protected $rules;

    /**
     * Validation messages
     * @var array
     */
    protected $messages;

    /**
     * Validation errors
     * @var array
     */
    protected $errors;

    public function __construct(Validator $validator) {
        $this->validator = $validator;
    }

    public function with(array $input) {
        $this->data = $input;
        return $this;
    }

    public function passes() {
        $validator = null;
        if ($this->messages) {
            $validator = $this->validator->make($this->data, $this->rules, $this->messages);
        } else {
            $validator = $this->validator->make($this->data, $this->rules);
        }

        if ($validator->fails()) {
            $this->errors = $validator->messages();
            return false;
        }

        return true;
    }

    public function errors() {
        return $this->errors;
    }
}
