<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Budget;
class ValidateQty implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    protected $budget;
    public function __construct($budget_id)
    {
        $this->budget = Budget::find($budget_id);
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
        return $value <= $this->budget->specification->qty;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Esta cantidad supera el saldo del presupuesto';
    }
}
