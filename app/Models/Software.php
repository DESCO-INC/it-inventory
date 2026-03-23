<?php

namespace App\Models;

use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Software extends Model
{
    use HasFactory;
    protected $table = 'software';
    protected $guarded = [];
}
