<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Role;

class RoleController extends Controller
{
    public function index(){
      return Role::select(['name','id','display_name'])->get();
    }
}
