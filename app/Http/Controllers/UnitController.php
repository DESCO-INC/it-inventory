<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Str;

use App\Models\Inventory;
use App\Models\UnitCategory;
use App\Models\Accountability;
use App\Models\Department;
use App\Models\InventorySoftware;
use App\Models\Software;

use App\Imports\InventoryImport;

class UnitController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $unitsQuery = Inventory::with(['unit_category', 'latestAccountability'])
            ->withCount('accountability')
            ->when($search, function ($q) use ($search) {
                $searchUpper = strtoupper($search);

                // Filter by ASSIGNED / UNASSIGNED if typed
                if ($searchUpper === 'ASSIGNED') {
                    $q->whereHas('latestAccountability', function ($q2) {
                        $q2->whereNull('date_returned');
                    });
                } elseif ($searchUpper === 'UNASSIGNED') {
                    $q->whereDoesntHave('latestAccountability', function ($q2) {
                        $q2->whereNull('date_returned');
                    });
                } else {
                    // Normal search for text fields
                    $q->where(function ($query) use ($search) {
                        $query
                            ->where('control_no', 'LIKE', "%{$search}%")
                            ->orWhere('model_name', 'LIKE', "%{$search}%")
                            ->orWhere('serial', 'LIKE', "%{$search}%")
                            ->orWhere('purchase_no', 'LIKE', "%{$search}%")
                            ->orWhere('status', 'LIKE', "%{$search}%")
                            ->orWhere('purchase_date', 'LIKE', "%{$search}%");
                    });
                }
            });

        $units = $unitsQuery->orderByDesc('id')->paginate(10);

        // Map accountability status for each unit
        $units->getCollection()->transform(function ($unit) {
            $latest = $unit->latestAccountability;
            $unit->accountability_status = $latest && !$latest->date_returned ? 'ASSIGNED' : 'UNASSIGNED';
            return $unit;
        });

        $stats = Inventory::stats();

        return view('units.index', compact('units', 'search', 'stats'));
    }

    public function create()
    {
        $category = UnitCategory::get();
        return view('units.create', [
            'category' => $category,
        ]);
    }

    public function store(Request $request)
    {
        // Validate form fields
        $validated = $request->validate([
            'model_name' => 'required',
            'unit_category_id' => 'required',
            'control_no' => 'required',
            'serial' => 'required|unique:inventory,serial',
            'purchase_no' => 'nullable',
            'purchase_date' => 'nullable|date',
            'manufacturing_date' => 'nullable|date',
            'depreciation_date' => 'nullable|date',
            'status' => 'required',
            'remarks' => 'nullable',
        ]);

        // Add created_by using logged-in user name
        $validated['created_by'] = Auth::user()->name ?? 'System';

        $inventory = Inventory::create($validated);
        return redirect()->route('units.index')->with('success', 'New item has been successfully added!');
    }

    public function edit(Inventory $unit)
    {
        $category = UnitCategory::get();
        $accountability = Accountability::where('inventory_id', $unit->id)->orderByDesc('id')->get();
        $department = Department::pluck('department');
        $softwareLists = Software::get();
        $software = InventorySoftware::with('software')->where('inventory_id', $unit->id)->get();
        return view('units.edit', compact('unit', 'category', 'accountability', 'department', 'software', 'softwareLists'));
    }

    public function update(Request $request, Inventory $unit)
    {
        $validated = $request->validate([
            'serial' => 'nullable|string|max:255',
            'purchase_no' => 'nullable|string|max:255',
            'purchase_date' => 'nullable|date',
            'manufacturing_date' => 'nullable|date',
            'depreciation_date' => 'nullable|date',
            'status' => 'required',
            'remarks' => 'nullable|string|max:255',
            'unit_weight' => 'nullable|string|max:255',
            'disposed_location' => 'nullable|string|max:255',
        ]);

        $unit->update($validated);

        return back()->with('success', 'Unit information updated successfully.');
    }

    public function destroy($id)
    {
        $unit = Inventory::findOrFail($id);

        try {
            $unit->delete();
            return redirect()->route('units.index')->with('success', 'Unit deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('units.index')->with('error', 'Failed to delete unit. Please try again.');
        }
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        Excel::import(new InventoryImport(), $request->file('file'));

        return back()->with('success', 'Inventory imported successfully!');
    }

    public function getNextControlNo($categoryId)
    {
        // Get the unit category
        $category = \App\Models\UnitCategory::findOrFail($categoryId);

        // Get the next inventory ID (assuming 'id' is auto-increment in inventory table)
        $nextId = \App\Models\Inventory::max('id') + 1;

        // Count existing inventories for this category
        $totalSameCategory = \App\Models\Inventory::where('unit_category_id', $categoryId)->count();

        // Prepare the response
        return response()->json([
            'code' => $category->code, // e.g., "LGU"
            'nextId' => $nextId, // e.g., 11
            'countIndex' => $category->count_index, // e.g., 2
            'totalSameCategory' => $totalSameCategory, // e.g., 0 (then +1 in JS)
        ]);
    }
}
