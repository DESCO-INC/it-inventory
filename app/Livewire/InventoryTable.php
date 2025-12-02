<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Inventory;

class InventoryTable extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';
    public $search = '';

    protected $updatesQueryString = ['search'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        // Get all inventory for dashboard counts
        $inventoryAll = Inventory::with('accountability')->get();
        $totalItems = $inventoryAll->count();

        $statusCounts = [
            'active'     => $inventoryAll->filter(fn($i) => strtoupper($i->status) === 'ACTIVE')->count(),
            'inactive'   => $inventoryAll->filter(fn($i) => strtoupper($i->status) === 'INACTIVE')->count(),
            'disposed'   => $inventoryAll->filter(fn($i) => strtoupper($i->status) === 'DISPOSED')->count(),
            'unassigned' => $inventoryAll->filter(fn($i) => $i->accountability->count() === 0)->count(),
        ];

        // Table query with search
        $baseQuery = Inventory::with(['unit_category', 'accountability'])->orderBy('id', 'desc');

        if ($this->search) {
            $search = $this->search;

            if (strtolower($search) === 'unassigned') {
                $baseQuery->doesntHave('accountability');
            } elseif (is_numeric($search)) {
                $baseQuery->withCount('accountability')->having('accountability_count', $search);
            } else {
                $baseQuery->where(function ($q) use ($search) {
                    $q->where('control_no', 'like', "%{$search}%")
                      ->orWhere('model_name', 'like', "%{$search}%")
                      ->orWhere('serial', 'like', "%{$search}%")
                      ->orWhere('purchase_no', 'like', "%{$search}%")
                      ->orWhere('purchase_date', 'like', "%{$search}%")
                      ->orWhere('depreciation_date', 'like', "%{$search}%")
                      ->orWhere('status', 'like', "%{$search}%");
                });
            }
        }

        $inventory = $baseQuery->paginate(10);

        return view('livewire.inventory-table', [
            'totalItems'   => $totalItems,
            'statusCounts' => $statusCounts,
            'inventory'    => $inventory,
        ]);
    }
}
