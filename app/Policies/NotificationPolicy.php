<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class NotificationPolicy
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
    public function read(User $user,$notification){
      return $user->id == $notification->notifiable->id;
    }
    public function destroy(User $user,$notification){
      return $this->read($notification);
    }
}
