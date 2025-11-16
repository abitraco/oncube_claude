<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Check session authentication
        if ($request->session()->get('admin_authenticated') !== true) {
            if ($request->has('password')) {
                if ($request->input('password') === env('ADMIN_PASSWORD', 'oncube2024')) {
                    $request->session()->put('admin_authenticated', true);
                    return redirect()->route('admin.dashboard');
                } else {
                    return redirect()->route('admin.login', ['redirect' => 'dashboard'])
                        ->with('error', 'Invalid password');
                }
            } else {
                return redirect()->route('admin.login', ['redirect' => 'dashboard']);
            }
        }

        return view('admin.dashboard');
    }
}
