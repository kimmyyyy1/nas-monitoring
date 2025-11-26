<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AthletesTrainedReport extends Model
{
    use HasFactory;

    // Siguraduhin na ang namespace ay "App\Models"

    protected $fillable = [
        'quarter',
        'grade_level',
        'focus_sports',
        'male_count',
        'female_count',
    ];
}