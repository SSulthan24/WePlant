<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();
        
        // Search by name or email
        if ($request->has('search') && $request->search) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }
        
        // Filter by role
        if ($request->has('role') && $request->role && $request->role !== 'Semua Role') {
            $query->where('role', $request->role);
        }
        
        $users = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();
        
        $stats = [
            'total' => User::count(),
            'farmers' => User::where('role', 'farmer')->count(),
            'partners' => User::where('role', 'partner')->count(),
            'admins' => User::where('role', 'admin')->count(),
        ];
        
        return view('admin.users', compact('users', 'stats'));
    }
    
    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('admin.user-detail', compact('user'));
    }
    
    public function create()
    {
        return view('admin.user-create');
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'nullable|string|max:20',
            'password' => ['required', 'confirmed', Password::defaults()],
            'role' => 'required|in:admin,farmer,partner',
            'land_area' => 'nullable|numeric|min:0',
            'garden_location' => 'nullable|string|max:255',
        ]);
        
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'land_area' => $request->land_area,
            'garden_location' => $request->garden_location,
        ]);
        
        return redirect()->route('admin.users')->with('success', 'User berhasil ditambahkan');
    }
    
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.user-edit', compact('user'));
    }
    
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'password' => ['nullable', 'confirmed', Password::defaults()],
            'role' => 'required|in:admin,farmer,partner',
            'land_area' => 'nullable|numeric|min:0',
            'garden_location' => 'nullable|string|max:255',
        ]);
        
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->role = $request->role;
        $user->land_area = $request->land_area;
        $user->garden_location = $request->garden_location;
        
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        
        $user->save();
        
        return redirect()->route('admin.users')->with('success', 'User berhasil diperbarui');
    }
    
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        // Prevent deleting yourself
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun sendiri');
        }
        
        // Prevent deleting the last admin
        if ($user->role === 'admin' && User::where('role', 'admin')->count() <= 1) {
            return back()->with('error', 'Tidak dapat menghapus admin terakhir');
        }
        
        $user->delete();
        
        return back()->with('success', 'User berhasil dihapus');
    }
}
