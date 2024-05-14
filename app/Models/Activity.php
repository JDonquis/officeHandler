<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $table = 'activities';

    protected $fillable = 
    [
            'code',
            'status_id',
            'area_id',
            'user_id',
            'type_activity_id',
            'title',
            'today_date',
            'start_date',
            'end_date',
            'location_id',
            'office_id',
            'division_id',
            'department_id',
            'progress',
            'observation',
    ];

    
}
