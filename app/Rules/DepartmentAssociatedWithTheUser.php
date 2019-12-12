<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class DepartmentAssociatedWithTheUser implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public $user;
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return false;
        return $user->has('departments')->doesntExist();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'El usuario ya tiene asociado un departamento';
    }
}
