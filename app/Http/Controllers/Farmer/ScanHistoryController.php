<?php

namespace App\Http\Controllers\Farmer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ScanHistoryController extends Controller
{
    public function index()
    {
        return view('farmer.scan-history');
    }
}
