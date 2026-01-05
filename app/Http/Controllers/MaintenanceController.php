<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventory;

class MaintenanceController extends Controller
{
    public function reports()
    {
        $count = Inventory::count();
        return view('maintenance.reports', compact('count'));
    }
}
