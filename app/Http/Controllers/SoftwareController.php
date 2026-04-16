<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Software;
use App\Models\InventorySoftware;

class SoftwareController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = InventorySoftware::with(['inventory', 'software'])->when($search, function ($q) use ($search) {
            $q->where(function ($query) use ($search) {
                $query
                    // Search in SOFTWARE table
                    ->whereHas('software', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    })

                    // OR search in INVENTORY table
                    ->orWhereHas('inventory', function ($q) use ($search) {
                        $q->where('control_no', 'like', "%{$search}%")->orWhere('serial', 'like', "%{$search}%");
                    });
            });
        });

        $softwares = $query->orderByRaw('date_expired IS NULL ASC')->orderBy('date_expired', 'asc')->paginate(10);
        
        return view('software.index', compact('softwares', 'search'));
    }

    public function store(Request $request)
    {
        $validation = $request->validate([
            'name' => ['required', 'string'],
            'supplier' => ['required', 'string'],
            'category' => ['required', 'string'],
        ]);

        $validation['created_by'] = Auth::user()->name ?? 'System';
        // Convert all values to uppercase
        $validation = array_map('strtoupper', $validation);

        $software = Software::create($validation);

        return back()->with('success', 'Software Added Successfully');
    }

    public function update(Request $request, $id)
    {
        $software = Software::findOrFail($id);

        $validation = $request->validate([
            'name' => ['required', 'string'],
            'supplier' => ['required', 'string'],
            'category' => ['required', 'string'],
        ]);

        $validation = array_map('strtoupper', $validation);

        $software->update($validation);
        return back()->with('success', 'Software Updated Successfully');
    }

    public function destroy($id)
    {
        $software = Software::findOrFail($id);
        $software->delete();

        return back()->with('success', 'Software Deleted Successfully');
    }
}
