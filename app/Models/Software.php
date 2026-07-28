<?php

namespace App\Models;

use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Auditable;

class Software extends Model
{
    use HasFactory, SoftDeletes, Auditable;
    protected $table = 'software';
    protected $guarded = [];
}
