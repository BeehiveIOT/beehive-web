<?php
namespace Beehive\Service\Validation;

interface Validator {

    /**
     * Set data to validate
     * @param  array  $input
     * @return Beehive\Service\Validation\Validator
     */
    public function with(array $input);

    /**
     * Verify whether input is valid or not
     * @return boolean
     */
    public function passes();

    /**
     * Get validation errors
     * @return array
     */
    public function errors();
}
