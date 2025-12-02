<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Inventory;
use Illuminate\Support\Facades\DB;

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
        // Base query
        $baseQuery = Inventory::with('unit_category')->orderBy('id', 'desc');

        // Search filter
        if ($this->search) {
            $baseQuery->where(function ($q) {
                $q->where('control_no', 'like', "%{$this->search}%")
                    ->orWhere('model_name', 'like', "%{$this->search}%")
                    ->orWhere('serial', 'like', "%{$this->search}%");
            });
        }

        // Final query with pagination
        $inventory = $baseQuery->paginate(10);

        return view('livewire.inventory-table', [
            'inventory' => $inventory,
        ]);
    }
}
