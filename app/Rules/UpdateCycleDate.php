<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Cycle;
use Carbon\Carbon;
class UpdateCycleDate implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    protected $id;
    public function __construct($id)
    {
        $this->id = $id;
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
        return !Cycle::where('id','!=',$this->id)
                        ->where([
                                ['created_at','<=',Carbon::create($value)],
                                ['finalized_at','>=',Carbon::create($value)]
                               ])->exists();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'El ciclo modificado no puede estar dentro de otro rango de ciclo.';
    }
}
