<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users' => User::count(),
            'total_farmers' => User::where('role', 'farmer')->count(),
            'total_partners' => User::where('role', 'partner')->count(),
            'total_products' => Product::count(),
            'pending_products' => Product::where('status', 'pending')->count(),
        ];
        
        return view('admin.dashboard', compact('stats'));
    }
}
