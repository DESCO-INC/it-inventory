<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Database\QueryException;

use App\Models\InventorySoftware;

class InventorySoftwareController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'inventory_id' => 'required',
            'software_id' => 'required',
            'product_key' => 'nullable',
            'date_installed' => 'required|date',
            'date_expired' => 'nullable|date',
        ]);

        $validated['installed_by'] = Auth::user()->name ?? 'System';
        if (!empty($validated['product_key'])) {
            $validated['product_key'] = strtoupper($validated['product_key']);
        }

        try {
            InventorySoftware::create($validated);
            return back()->with('success', 'Application added successfully!');
        } catch (Exception $e) {
            return back()->with('error', 'Error Occured When Adding a Software.');
        }
    }

    public function update(Request $request, $id)
    {
        $software = InventorySoftware::findOrFail($id);

        $validated = $request->validate([
            'software_id' => 'required',
            'product_key' => 'nullable',
            'date_installed' => 'required|date',
            'date_expired' => 'nullable|date',
        ]);

        $validated = array_map('strtoupper', $validated);

        $software->update($validated);

        return back()->with('success', 'Application Updated Successfully');
    }

    public function destroy($id)
    {
        $software = InventorySoftware::findOrFail($id);
        $software->delete();

        return back()->with('success', 'Application Deleted Successfully');
    }
}
