<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationsController extends Controller
{
    public function index(){
      return response()->json(['unreadNotifications' => Auth::user()->unreadNotifications,
                               'readNotifications' => Auth::user()->readNotifications]);
    }
}
