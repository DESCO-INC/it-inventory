<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

use App\Models\InventorySoftware;

class InventorySoftwareController extends Controller
{
    public function store(Request $request)
    {
        // Validate form fields
        $validated = $request->validate([
            'inventory_id' => 'required',
            'software_id' => 'required',
            'product_key' => 'nullable',
            'installed_at' => 'required|date',
        ]);

        // Add created_by using logged-in user name
        $validated['installed_by'] = Auth::user()->name ?? 'System';
        $validated = array_map('strtoupper', $validated);

        $inventorySoftware = InventorySoftware::create($validated);
        return back()->with('success', 'Application added successfully!');
    }

    public function update(Request $request, $id)
    {
        $software = InventorySoftware::findOrFail($id);

        $validated = $request->validate([
            'software_id' => [
                'required',
                Rule::unique('inventory_software')
                    ->where(function ($query) use ($software) {
                        return $query->where('inventory_id', $software->inventory_id);
                    })
                    ->ignore($software->id),
            ],
            'product_key' => 'nullable',
            'installed_at' => 'required|date',
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
