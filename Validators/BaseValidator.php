<?php

namespace Modules\Core\Validators;

use Illuminate\Validation\Factory;
use Prettus\Validator\AbstractValidator;

/**
 * Class LaravelValidator.
 */
class BaseValidator extends AbstractValidator
{
    /**
     * Validator.
     *
     * @var \Illuminate\Validation\Factory
     */
    protected $validator;

    /**
     * Construct.
     *
     * @param \Illuminate\Validation\Factory $validator
     */
    public function __construct(Factory $validator)
    {
        $this->validator = $validator;
    }

    /**
     * Pass the data and the rules to the validator.
     *
     * @param string $action
     *
     * @return bool
     */
    public function passes($action = null)
    {
        $this->data = $this->sanitize($this->data);

        $rules = $this->getRules($action);
        $validator = $this->validator->make($this->data, $rules);

        if ($validator->fails()) {
            $this->errors = $validator->messages();

            return false;
        }

        return true;
    }

    /**
     * Check if the validation fails.
     *
     * @param string $action
     *
     * @return bool
     */
    public function fails($action = null)
    {
        return !$this->passes($action);
    }

    /**
     * Sanitize input with special rules.
     *
     * @param $request
     *
     * @return mixed
     */
    public function sanitize($request)
    {
        return $request;
    }
}
