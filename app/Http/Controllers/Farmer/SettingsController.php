<?php

namespace App\Http\Controllers\Farmer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    public function index()
    {
        return view('farmer.settings');
    }
    
    public function update(Request $request)
    {
        $user = auth()->user();
        
        // If only avatar is being uploaded (from separate form)
        if ($request->hasFile('avatar') && !$request->filled('name')) {
            $request->validate([
                'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);
            
            // Delete old avatar if exists
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }
            
            // Store new avatar
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $avatarPath;
            $user->save();
            
            return back()->with('success', 'Foto profil berhasil diperbarui');
        }
        
        // Regular form update
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . auth()->id(),
            'phone' => 'nullable|string|max:20',
            'land_area' => 'nullable|numeric|min:0',
            'garden_location' => 'nullable|string|max:255',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'current_password' => 'nullable|required_with:password',
            'password' => 'nullable|min:8|confirmed',
        ]);
        
        // Update name, email, phone
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        
        // Update farmer-specific fields
        if ($request->filled('land_area')) {
            $user->land_area = $request->land_area;
        }
        if ($request->filled('garden_location')) {
            $user->garden_location = $request->garden_location;
        }
        
        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            // Delete old avatar if exists
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }
            
            // Store new avatar
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $avatarPath;
        }
        
        // Update password if provided
        if ($request->filled('password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Password saat ini tidak sesuai']);
            }
            $user->password = Hash::make($request->password);
        }
        
        $user->save();
        
        return back()->with('success', 'Profil berhasil diperbarui');
    }
}
