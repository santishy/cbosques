<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\DatabaseNotification;

class NotificationsController extends Controller
{
    public function index(){
      return response()->json(['unreadNotifications' => Auth::user()->unreadNotifications,
                               'readNotifications' => Auth::user()->readNotifications]);
    }
    public function read($id){
      DatabaseNotification::find($id)->markAsRead();
      return;
    }
    public function destroy($id){
      DatabaseNotification::find($id)->delete();
      return;
    }
}
