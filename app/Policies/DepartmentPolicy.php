<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DepartmentPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {

    }
    public function before(User $user){
      if($user->isAdmin()){
        return true;
      }
    }
    public function store(User $user){
      return $user->isAdmin();
    }
    public function update(User $user){
      return $this->hasRoles(['admin','autorizador']);
    }
    
}
