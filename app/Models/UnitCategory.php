<?php

namespace App\Models;
use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;


class UnitCategory extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'unit_category';
    protected $guarded = [];

    public function inventory(){
        return $this->hasMany(Inventory::class);
    }
}
