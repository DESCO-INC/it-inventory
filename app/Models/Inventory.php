<?php

namespace App\Models;

use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Inventory extends Model
{
    use HasFactory;
    protected $table = 'inventory';
    protected $guarded = [];

    public function unit_category(){
        return $this->belongsTo(UnitCategory::class);
    }

    public function accountability()
    {
        return $this->hasMany(Accountability::class);
    }
}
