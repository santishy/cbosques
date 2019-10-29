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
    protected $iva;
    protected $status;
    public function __construct($item_id,$iva)
    {
        // Aquí es para validar que exista el item dado que me fallo en el validate() , ya que esto es un rule y aun
        //no pasa la validacion y por eso no me lo validaba bien.
        $array=func_get_args();
        if(count($array)>2)
          $this->status = $array[2]; //cojo el status
        if($this->item = Item::find($item_id)){
          $this->qty = $this->item->specification->qty;
          $this->iva = $iva;
        }
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
        if($this->status === 'RECHAZADO')
          return true;
        if($this->iva)
          $value*=1.16;
        return  $this->qty >= $value;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'La cantidad es mayor al presupuesto elegido. (Tome en cuenta el IVA)';
    }
}
