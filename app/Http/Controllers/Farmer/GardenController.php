<?php

namespace App\Http\Controllers\Farmer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GardenController extends Controller
{
    public function index()
    {
        return view('farmer.garden');
    }
    
    public function update(Request $request)
    {
        $request->validate([
            'land_area' => 'nullable|numeric|min:0',
            'garden_location' => 'nullable|string|max:255',
            'latitude' => 'nullable|string|max:50',
            'longitude' => 'nullable|string|max:50',
            'soil_type' => 'nullable|string|max:255',
            'planting_year' => 'nullable|integer|min:1900|max:' . date('Y'),
        ]);
        
        $user = auth()->user();
        $user->land_area = $request->land_area;
        $user->garden_location = $request->garden_location;
        $user->save();
        
        return back()->with('success', 'Data kebun berhasil diperbarui');
    }
}
