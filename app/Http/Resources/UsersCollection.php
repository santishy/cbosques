<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class UsersCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
      return $this->collection->transform(function($user){
        return [
          'id' => $user->id,
          'name' => $user->name,
          'email' => $user->email,
          'abilitys' => $user->roles->pluck('name')->implode(", "),
          'roles' => $user->roles,
        ];
      });
    }
}
