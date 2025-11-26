<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LearningStandardReport extends Model
{
    use HasFactory;

    /**
     * Ang mga fields na pwedeng i-save.
     */
    protected $fillable = [
        'quarter',
        'grade_level',
        'outstanding_male',
        'outstanding_female',
        'very_satisfactory_male',
        'very_satisfactory_female',
        'satisfactory_male',
        'satisfactory_female',
        'fairly_satisfactory_male',
        'fairly_satisfactory_female',
        'did_not_meet_male',
        'did_not_meet_female',
    ];
}