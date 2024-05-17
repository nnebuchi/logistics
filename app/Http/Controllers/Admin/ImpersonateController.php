<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;

class ImpersonateController extends Controller
{
    public function impersonate($user_id)
    {
        $user = User::findOrFail($user_id);

        // Check if the current admin can impersonate
        if (Auth::guard('admin')->user()->canImpersonate() && $user->canBeImpersonated()) {
            // Save current admin ID in session
            session()->put('admin_id', Auth::guard('admin')->id());

            // Impersonate the user
            Auth::guard('web')->login($user);

            return redirect('/'); // Redirect to the desired route after impersonation
        }

        return redirect()->back()->with('error', 'Impersonation failed.');
    }

    public function leave()
    {
        // Get the admin ID from session
        $adminId = session()->pull('admin_id');

        // Ensure admin ID is set
        if ($adminId) {
            // Log out from the user guard
            Auth::guard('web')->logout();

            // Log back in as admin
            $admin = Admin::find($adminId);
            Auth::guard('admin')->login($admin);
        }

        return redirect('/admin'); // Redirect to the admin dashboard or desired route
    }
}