<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Inventory;

class InventoryDashboard extends Component
{
    
    public function render()
    {
        $inventory = Inventory::with('unit_category')->get();
        $totalItems = $inventory->count();
        $statusCounts = [
            'active'   => $inventory->filter(fn($i) => strtoupper($i->status) === 'ACTIVE')->count(),
            'inactive' => $inventory->filter(fn($i) => strtoupper($i->status) === 'INACTIVE')->count(),
            'disposed' => $inventory->filter(fn($i) => strtoupper($i->status) === 'DISPOSED')->count(),
        ];
        
        return view('livewire.inventory-dashboard')->with([
            'totalItems' => $totalItems,
            'statusCounts' => $statusCounts,
        ]);
    }
}
