<?php

namespace App\Models;

use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\Auditable;

class Accountability extends Model
{
    use HasFactory, Auditable;
    protected $table = 'accountability';
    protected $guarded = [];

    public function Inventory(){
        return $this->belongsTo(Inventory::class);
    }
}
