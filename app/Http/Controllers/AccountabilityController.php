<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Accountability;
use App\Models\Inventory;

class AccountabilityController extends Controller
{
   public function index()
    {
        return view('accountability.index');
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
            'date_returned' => 'nullable',
        ]);

        $validated['created_by'] = Auth::user()->name ?? 'System';

        Accountability::create($validated);

        return redirect()
            ->back()
            ->with('success', 'New Accountability has been successfully added!');
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


}
