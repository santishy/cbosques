<?php

namespace App\Policies;

use App\User;
use App\Quotation;
use Illuminate\Auth\Access\HandlesAuthorization;

class QuotationPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
    public function before(User $user){
      if( $user->isAdmin())
        return true;
    }
    public function update(User $user,Quotation $quotation){
      return $user->id != $quotation->user_id;
    }
}
