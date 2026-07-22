<?php

namespace App\Models;

use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EmailSettings extends Model
{
    use HasFactory;
    protected $table = 'email_settings';
    protected $guarded = [];
}
