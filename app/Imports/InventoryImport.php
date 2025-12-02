<?php

namespace App\Imports;

use App\Models\Inventory;
use App\Models\UnitCategory;
use App\Models\Accountability;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;

class InventoryImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Match category code to get unit_category_id
        $category = UnitCategory::where('code', $row['category'])->first();
        if (!$category) {
            return null; // skip if category not found
        }
        
        // Generate control number
        $countIndex = intval($category->count_index);
        $next_inventory_id = Inventory::count() + 1;
        $next_inventory_count = intval(Inventory::where('unit_category_id', $category->id)->count()) + 1;
        $controlNo = $category->code . '-' . $next_inventory_count . '-' . $countIndex . str_pad($next_inventory_id, 4, '0', STR_PAD_LEFT);

        // Convert Excel dates
        $purchaseDate = $this->convertExcelDate($row['purchase_date'] ?? null);
        $manufacturingDate = $this->convertExcelDate($row['manufacturing_date'] ?? null);

        // Calculate depreciation date
        $depreciationDate = null;
        if (!empty($purchaseDate) && $category->years_depreciation) {
            try {
                $depreciationDate = Carbon::parse($purchaseDate)
                    ->addYears(intval($category->years_depreciation))
                    ->format('Y-m-d');
            } catch (\Exception $e) {
                $depreciationDate = null;
            }
        }

        // Update count_index in category
        $category->count_index = $countIndex;
        $category->save();

        // Create Inventory first
        $inventory = Inventory::create([
            'control_no'        => $controlNo,
            'unit_category_id'  => $category->id,
            'model_name'        => strtoupper($row['model_name']) ?? null,
            'serial'            => $row['serial_number'] ?? null,
            'purchase_no'       => $row['purchase_reference'] ?? null,
            'purchase_date'     => $purchaseDate ?? null,
            'manufacturing_date'=> $manufacturingDate ?? null,
            'depreciation_date' => $depreciationDate,
            'status'            => strtoupper($row['status'] ?? 'ACTIVE'),
            'remarks'           => $row['remarks'] ?? null,
            'created_by'        => auth()->user()->name ?? null,
        ]);

        // Create Accountability record
        if ($inventory) {
            Accountability::create([
                'inventory_id' => $inventory->id,
                'name'         => $row['user'] ?? null,
                'department'   => $row['department'] ?? null,
                'location'     => $row['location'] ?? null,
                'date_received'=> $this->convertExcelDate($row['date_received'] ?? null),
                'created_by'   => auth()->user()->name ?? null,
            ]);
        }

        return $inventory;
    }

    /**
     * Convert Excel numeric or string date to Y-m-d
     */
    private function convertExcelDate($value)
    {
        if (empty($value) || $value === 'N/A') return null;

        if (is_numeric($value)) {
            return Carbon::instance(ExcelDate::excelToDateTimeObject($value))->format('Y-m-d');
        }

        try {
            return Carbon::parse($value)->format('Y-m-d');
        } catch (\Exception $e) {
            return null;
        }
    }
}
