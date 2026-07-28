<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Auditable;

class InventorySoftware extends Model
{
    use HasFactory, Auditable;
    protected $table = 'inventory_software';
    protected $guarded = [];

    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }

    public function software()
    {
        return $this->belongsTo(Software::class);
    }

    public function getStatusAttribute()
    {
        return match (true) {
            is_null($this->date_expired) => 'NO EXPIRY',
            $this->date_expired < now() => 'EXPIRED',
            $this->date_expired <= now()->addMonth() => 'EXPIRING',
            default => 'ACTIVE',
        };
    }
}
