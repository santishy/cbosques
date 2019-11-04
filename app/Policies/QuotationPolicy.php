<?php

namespace App\Policies;

use App\User;
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
      return $user->isAdmin();
    }
    public function update(User $user,$quotation){
      return $user->id != $quotation->user_id;
    }
}
