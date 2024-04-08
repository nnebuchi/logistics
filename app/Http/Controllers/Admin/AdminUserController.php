<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AdminUserController extends Controller
{
    public function show()
    {
        $data['user'] = User::find(Auth::user()->id);

        $data['customers'] = User::where('is_admin', 0)->with('account')->get();

        return view('admin.users.index')->with($data);
    }

    public function showUser(Request $request)
    {
        $data['user'] = User::find($request->id);

        return view('admin.users.view-user')->with($data);
    }
}
