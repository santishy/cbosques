<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\DatabaseNotification;

class NotificationsController extends Controller
{
    public function __construct(){
      $this->middleware('roles:admin,autorizador,cotizador');
    }
    public function index(){
      return response()->json(['unreadNotifications' => Auth::user()->unreadNotifications,
                               'readNotifications' => Auth::user()->readNotifications]);
    }
    public function unreadNotifications(){
      return response()->json(['unreadNotifications' => Auth::user()->unreadNotifications]);
    }
    public function read($id){
      $this->authorize('read',DatabaseNotification::find($id));
      return DatabaseNotification::find($id)->markAsRead();
    }
    public function destroy($id){
      return response()->json(['notificationDeleted'=>DatabaseNotification::find($id)->delete()]);
    }
    public function allRead(){
      auth()->user()->unreadNotifications->markAsRead();
      return $this->readNotifications();
    }
    public function readNotifications()
    {
      return auth()->user()->readNotifications;
    }
}
