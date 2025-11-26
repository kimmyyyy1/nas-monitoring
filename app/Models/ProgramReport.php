<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramReport extends Model
{
    use HasFactory;

    // ITO ANG PINAKA-MAHALAGANG BAHAGI NA NAWALA
    protected $fillable = [
        'proponent',
        'program_title',
        'target_beneficiaries',
        'output_indicator',
        'accomplishment',
        'date_of_implementation',
        'date_of_completion',
        'movs',
    ];
}