<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationsController extends Controller
{
    public function __contruct()
    {
        $this->middleware('auth');
    }
    public function index(User $user)
    {
        $notifications = Auth::user()->notifications()->paginate(20);
        Auth::user()->markAsRead();
        return view('notifications.index', compact('notifications'));
    }
}
