<?php

namespace App\Rules;

use App\Item;
use Illuminate\Contracts\Validation\Rule;

class ValidateQuoteAmount implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    protected $qty;
    public function __construct($item_id)
    {
        $this->qty = Item::find($item_id)->specification->qty;
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
        return  $this->qty >= $value;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The validation error message.';
    }
}
