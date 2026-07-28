<?php

namespace App\Models;

use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\Auditable;

class Inventory extends Model
{
    use HasFactory, Auditable;
    protected $table = 'inventory';
    protected $guarded = [];

    public function unit_category()
    {
        return $this->belongsTo(UnitCategory::class);
    }

    public function accountability()
    {
        return $this->hasMany(Accountability::class);
    }

    public function latestAccountability()
    {
        return $this->hasOne(Accountability::class)->latestOfMany();
    }

    public static function stats()
    {
        // Define all possible statuses
        $allStatuses = ['ACTIVE', 'DEFECTIVE', 'DISPOSED'];

        // Total inventory
        $totalInventory = self::count();

        // Count per status
        $statusCounts = self::select('status')->selectRaw('COUNT(*) as count')->groupBy('status')->pluck('count', 'status')->toArray();

        // Fill missing statuses with 0
        foreach ($allStatuses as $status) {
            if (!isset($statusCounts[$status])) {
                $statusCounts[$status] = 0;
            }
        }

        // Total unassigned inventory
        $totalUnassigned = self::with('latestAccountability')
            ->get()
            ->filter(function ($unit) {
                $latest = $unit->latestAccountability;
                return !$latest || $latest->date_returned !== null;
            })
            ->count();

        // Merge everything into a single array
        return array_merge(['TOTAL' => $totalInventory], $statusCounts, ['UNASSIGNED' => $totalUnassigned]);
    }
}
