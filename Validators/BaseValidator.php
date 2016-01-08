<?php namespace Modules\Core\Validators;

use Illuminate\Validation\Factory;
use Prettus\Validator\AbstractValidator;

/**
 * Class LaravelValidator
 * @package Prettus\Validator
 */
class BaseValidator extends AbstractValidator {

    /**
     * Validator
     *
     * @var \Illuminate\Validation\Factory
     */
    protected $validator;

    /**
     * Construct
     *
     * @param \Illuminate\Validation\Factory $validator
     */
    public function __construct(Factory $validator)
    {
        $this->validator = $validator;
    }

    /**
     * Pass the data and the rules to the validator
     *
     * @param string $action
     * @return bool
     */
    public function passes($action = null)
    {
        $rules     = $this->getRules($action);
        $validator = $this->validator->make($this->data, $rules);

        if( $validator->fails() )
        {
            $this->errors = $validator->messages();
            return false;
        }

        return true;
    }

    /**
     * Check if the validation fails
     *
     * @param string $action
     * @return bool
     */
    public function fails($action = null)
    {
        return ! $this->passes($action);
    }

}
