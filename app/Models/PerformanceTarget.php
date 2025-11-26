<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerformanceTarget extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'indicator_name', 'q1_target', 'q2_target', 'q3_target', 'q4_target'
    ];
}