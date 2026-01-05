<?php

namespace App\Models;
use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class UnitCategory extends Model
{
    use HasFactory;
    protected $table = 'unit_category';
    protected $guarded = [];

    public function inventory(){
        return $this->hasMany(Inventory::class);
    }
}
