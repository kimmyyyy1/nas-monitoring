<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerformanceReport extends Model
{
    use HasFactory;

    /**
     * Ang mga columns na pwedeng i-fill-up.
     */
    protected $fillable = [
        'department_id',
        'report_date',
        'metric_1',
        'metric_2'
    ];
}