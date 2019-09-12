<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Specification;
class ValidateConcept implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    protected $model;
    public function __construct($model)
    {
        $this->model = $model;
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
        return  Specification::where([
                                      ['specificationable_type',$this->model],
                                      ['cycle_id',session('cycle')->id],
                                      ['concept',$value]
                                      ])->doesntExist();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'El concepto ya existe en este ciclo escolar';
    }
}
