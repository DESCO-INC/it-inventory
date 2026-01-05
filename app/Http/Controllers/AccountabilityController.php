<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Accountability;
use App\Models\Inventory;

class AccountabilityController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $department = $request->input('department');

        // 🔹 Get UNIQUE departments for the select
        $departments = Accountability::query()->whereNotNull('department')->distinct()->orderBy('department')->pluck('department', 'department'); // ['IT' => 'IT']

        $accountability = Accountability::with('inventory')
            ->whereIn('id', function ($sub) {
                $sub->selectRaw('MAX(id)')->from('accountability')->groupBy('inventory_id');
            })
            // 🔹 filter by department
            ->when($department, function ($q) use ($department) {
                $q->where('department', $department);
            })
            // 🔹 existing search
            ->when($search, function ($q) use ($search) {
                $q->where(function ($query) use ($search) {
                    $query
                        ->where('name', 'LIKE', "%{$search}%")
                        ->orWhere('department', 'LIKE', "%{$search}%")
                        ->orWhere('location', 'LIKE', "%{$search}%")
                        ->orWhere('date_received', 'LIKE', "%{$search}%")
                        ->orWhereHas('inventory', function ($inv) use ($search) {
                            $inv->where('control_no', 'LIKE', "%{$search}%")
                                ->orWhere('model_name', 'LIKE', "%{$search}%")
                                ->orWhere('status', 'LIKE', "%{$search}%");
                        });
                });
            })
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString(); // 🔹 keep filters on pagination

        return view('accountability.index', compact('accountability', 'search', 'departments', 'department'));
    }

    public function print(Request $request)
    {
        // Get the inventory_id from the query parameter
        $inventoryId = $request->query('inventory_id');

        // If inventory_id is missing, you can redirect or abort gracefully
        if (!$inventoryId) {
            return redirect()->back()->with('error', 'No inventory ID provided.');
        }

        $accountabilities = Accountability::where('inventory_id', $inventoryId)->get();
        $inventory = Inventory::find($inventoryId);

        // Pass data to view
        return view('accountability.print', [
            'accountabilities' => $accountabilities,
            'inventory' => $inventory,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'inventory_id' => ['required'],
            'name' => 'required',
            'department' => 'required',
            'location' => 'required',
            'date_received' => 'required',
        ]);

        $validated['created_by'] = Auth::user()->name ?? 'System';

        Accountability::create($validated);

        return redirect()->back()->with('success', 'New Accountability has been successfully added!');
    }

    public function update(Request $request, $id)
    {
        $account = Accountability::findOrFail($id);

        // Store the original date_returned before updating
        $originalDateReturned = $account->date_returned;

        // Update fields from request
        $account->fill($request->all());

        // Check if date_returned was changed
        if ($request->filled('date_returned') && $request->date_returned !== $originalDateReturned) {
            $account->returned_to = Auth::user()->name; // or session('name') if you store name manually
        }

        $account->save();

        return redirect()->back()->with('success', 'Accountability updated successfully.');
    }
    
    public function destroy($id)
    {
        $accountability = Accountability::findOrFail($id);

        try {
            $unitId = $accountability->inventory_id; // get the unit ID before deleting
            $accountability->delete();

            // redirect to the unit edit page
            return redirect()->route('units.edit', $unitId)->with('success', 'Accountability deleted successfully.');
        } catch (\Exception $e) {
            // redirect to the unit edit page even if delete fails
            return redirect()->route('units.edit', $accountability->inventory_id)->with('error', 'Failed to delete accountability. Please try again.');
        }
    }
}
