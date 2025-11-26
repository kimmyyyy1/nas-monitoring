<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FacilityReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'type_of_facility',
        'date_project_completed',
        'date_certified',
        'certifying_body',
        'movs',
    ];
}