<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class QuoteRequestAdminController extends Controller
{
    public function index(Request $request)
    {
        // Simple password protection
        if ($request->session()->get('admin_authenticated') !== true) {
            if ($request->has('password')) {
                if ($request->input('password') === env('ADMIN_PASSWORD', 'oncube2025')) {
                    $request->session()->put('admin_authenticated', true);
                } else {
                    return redirect()->back()->with('error', 'Invalid password');
                }
            } else {
                return view('admin.login');
            }
        }

        $query = DB::table('quote_requests')->orderBy('created_at', 'desc');

        // Apply filters
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('company_name', 'like', "%{$search}%")
                  ->orWhere('company_email', 'like', "%{$search}%")
                  ->orWhere('contact_name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        if ($request->has('type') && $request->type) {
            $query->where('inquiry_type', $request->type);
        }

        if ($request->has('from') && $request->from) {
            $query->whereDate('created_at', '>=', $request->from);
        }

        if ($request->has('to') && $request->to) {
            $query->whereDate('created_at', '<=', $request->to);
        }

        $requests = $query->paginate(20);

        // Calculate statistics
        $total = DB::table('quote_requests')->count();
        $thisMonth = DB::table('quote_requests')
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();
        $today = DB::table('quote_requests')
            ->whereDate('created_at', Carbon::today())
            ->count();

        return view('admin.quote-requests', compact('requests', 'total', 'thisMonth', 'today'));
    }

    public function logout(Request $request)
    {
        $request->session()->forget('admin_authenticated');
        return redirect()->route('admin.quotes');
    }
}
