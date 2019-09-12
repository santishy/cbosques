<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Cycle;
Use Carbon\Carbon;

class DateGreaterThan implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
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
        $created_at = Cycle::max('created_at');
        $finalized_at =Cycle::max('finalized_at');
        $date = Carbon::create($value);
        return $date->greaterThan($created_at) && $date->greaterThan($finalized_at);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Esta fecha está dentro del rango de un ciclo existente';
    }
}
