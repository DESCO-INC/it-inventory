<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

use App\Models\Accountability;
use App\Models\Inventory;

class AccountabilityController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');

        $accountability = Accountability::with('inventory')

            // Search
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

            // Accountability Status Filter
            ->when($status === 'RETURNED', function ($query) {
                $query->whereNotNull('date_returned');
            })
            ->when($status === 'ISSUED', function ($query) {
                $query->whereNull('date_returned');
            })

            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        $departments = Accountability::whereNotNull('department')->distinct()->orderBy('department')->pluck('department', 'department');

        $locations = Accountability::whereNotNull('location')->distinct()->orderBy('location')->pluck('location', 'location');

        $returnedCount = Accountability::whereNotNull('date_returned')->count();
        
        $activeCount = Inventory::where('status', 'ACTIVE')->count();

        $defectiveCount = Accountability::whereHas('inventory', function ($query) {
            $query->where('status', 'DEFECTIVE');
        })->count();

        $disposedCount = Accountability::whereHas('inventory', function ($query) {
            $query->where('status', 'DISPOSED');
        })->count();

        return view('pages.accountability.dashboard', compact('accountability', 'search', 'departments', 'locations', 'returnedCount', 'activeCount', 'defectiveCount', 'disposedCount'));
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
            'history' => 'nullable',
            'date_received' => 'required',
        ]);

        $validated['created_by'] = Auth::user()->name ?? 'System';

        Accountability::create($validated);

        return redirect()->back()->with('success', 'New Accountability has been successfully added!');
    }

    public function update(Request $request, $id)
    {
        $account = Accountability::findOrFail($id);
        $originalDateReturned = $account->date_returned;
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

    public function export(Request $request)
    {
        // Validate inputs
        $request->validate([
            'date_from' => 'required|date',
            'date_to' => 'required|date|after_or_equal:date_from',
        ]);

        $units = Accountability::with('inventory')
            ->whereBetween('created_at', [$request->date_from . ' 00:00:00', $request->date_to . ' 23:59:59'])
            ->when($request->department, function ($query) use ($request) {
                $query->where('department', $request->department);
            })
            ->when($request->location, function ($query) use ($request) {
                $query->where('location', $request->location);
            })
            ->get();

        // Create spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Headers
        $sheet->setCellValue('A1', 'Control Number');
        $sheet->setCellValue('B1', 'Model Name');
        $sheet->setCellValue('C1', 'Serial No.');
        $sheet->setCellValue('D1', 'Purchase Ref.');
        $sheet->setCellValue('E1', 'Purchased Date');
        $sheet->setCellValue('F1', 'Assigned To');
        $sheet->setCellValue('G1', 'Location');
        $sheet->setCellValue('H1', 'Date Received');
        $sheet->setCellValue('I1', 'Date Returned');
        $sheet->setCellValue('J1', 'Remarks');

        // Data
        $row = 2;
        foreach ($units as $unit) {
            $sheet->setCellValue('A' . $row, $unit->inventory->control_no);
            $sheet->setCellValue('B' . $row, $unit->inventory->model_name);
            $sheet->setCellValue('C' . $row, $unit->inventory->serial);
            $sheet->setCellValue('D' . $row, $unit->inventory->purchase_no);
            $sheet->setCellValue('E' . $row, $unit->inventory->purchase_date);
            $sheet->setCellValue('F' . $row, $unit->name);
            $sheet->setCellValue('G' . $row, $unit->location);
            $sheet->setCellValue('H' . $row, $unit->date_received);
            $sheet->setCellValue('I' . $row, $unit->date_return);
            $sheet->setCellValue('J' . $row, $unit->inventory->remarks);
            $row++;
        }

        // Styling
        $sheet->getStyle('A1:J1')->getFont()->setBold(true);

        foreach (range('A', 'J') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Download
        return response()->streamDownload(function () use ($spreadsheet) {
            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
        }, 'accountability.xlsx');
    }
}
