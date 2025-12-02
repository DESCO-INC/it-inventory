<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Accountability;
use App\Models\Inventory;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Carbon\Carbon;

class AccountabilityTable extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';
    public $selectedDept = null;
    public $search = '';

    protected $updatesQueryString = ['search', 'selectedDept'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingSelectedDept()
    {
        $this->resetPage();
    }

    public function render()
    {
        // Base query
        $baseQuery = Accountability::query();

        // Filter by department first
        if ($this->selectedDept) {
            $baseQuery->where('department', $this->selectedDept);
        }

        // Search filter
        if ($this->search) {
            $baseQuery->where(function ($q) {
                $q->where('name', 'like', "%{$this->search}%")
                    ->orWhere('department', 'like', "%{$this->search}%")
                    ->orWhereHas('inventory', function ($iq) {
                        $iq->where('control_no', 'like', "%{$this->search}%")
                            ->orWhere('model_name', 'like', "%{$this->search}%")
                            ->orWhere('purchase_no', 'like', "%{$this->search}%");
                    });
            });
        }

        // Subquery to get latest accountability ID per inventory
        $latestIds = $baseQuery->select(DB::raw('MAX(id) as id'))->groupBy('inventory_id')->pluck('id');

        // Final query to get the records
        $accountability = Accountability::with('inventory')->whereIn('id', $latestIds)->orderBy('id', 'desc')->paginate(10);

        // Get all departments for the selector
        $departments = Accountability::select('department')->distinct()->pluck('department');

        return view('livewire.accountability-table', [
            'accountability' => $accountability,
            'departments' => $departments,
        ]);
    }

    public function exportAccountability()
    {
        // Base query
        $baseQuery = Accountability::query();

        // Latest accountability per inventory
        $latestIds = $baseQuery->select(DB::raw('MAX(id) as id'))->groupBy('inventory_id')->pluck('id');

        $records = Accountability::with('inventory')->whereIn('id', $latestIds)->orderBy('id', 'desc')->get();

        // Create Spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set headers
        $headers = ['Name', 'Department', 'Inventory Control No', 'Model Name', 'Serial No', 'Date Received', 'Status'];
        $sheet->fromArray($headers, null, 'A1');

        // Fill data
        $rowNumber = 2;
        foreach ($records as $rec) {
            $sheet->setCellValue("A$rowNumber", $rec->name);
            $sheet->setCellValue("B$rowNumber", $rec->department);
            $sheet->setCellValue("C$rowNumber", $rec->inventory?->control_no ?? '');
            $sheet->setCellValue("D$rowNumber", $rec->inventory?->model_name ?? '');
            $sheet->setCellValue("E$rowNumber", $rec->inventory?->serial ?? '');
            $dateReceived = $rec->date_received ? Carbon::parse($rec->date_received)->format('Y-m-d') : '';
            $sheet->setCellValue("F$rowNumber", $dateReceived);
            $sheet->setCellValue("G$rowNumber", $rec->inventory?->status ?? '');
            $rowNumber++;
        }

        // Auto-size all columns (A to G)
        foreach (range('A', 'G') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Prepare Excel writer
        $writer = new Xlsx($spreadsheet);
        $fileName = 'accountability_export_' . now()->format('Ymd_His') . '.xlsx';

        // Stream download
        return response()->streamDownload(
            function () use ($writer) {
                $writer->save('php://output');
            },
            $fileName,
            [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            ],
        );
    }
}
