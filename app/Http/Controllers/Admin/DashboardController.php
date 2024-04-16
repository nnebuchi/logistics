<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        //$user = Admin::find(Auth::user()->id);
        
        $user = User::find(7);
        return view('admin.index', compact('user'));
    }
}
