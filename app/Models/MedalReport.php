<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedalReport extends Model
{
    use HasFactory;

    // Siguraduhin na ang namespace ay "App\Models"

    protected $fillable = [
        'quarter',
        'grade_level',
        'focus_sports',
        'national_gold',
        'national_silver',
        'national_bronze',
        'international_gold',
        'international_silver',
        'international_bronze',
    ];
}