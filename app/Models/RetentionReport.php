<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RetentionReport extends Model
{
    use HasFactory;

    // PAALALA: Siguraduhin na ang namespace ay "App\Models"

    protected $fillable = [
        'quarter',
        'grade_level',
        'focus_sports',
        'initial_enrollment_male',
        'initial_enrollment_female',
        'transfer_male',
        'transfer_female',
        'dropped_male',
        'dropped_female',
        'projected_enrollees_male',
        'projected_enrollees_female',
    ];
}