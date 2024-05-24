<?php

namespace App\Models;

use App\Models\Office;
use App\Models\Division;
use App\Models\Location;
use App\Models\Department;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Machine extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'code',
        'name',
        'brand',
        'model',
        'manufacturer',
        'serial_number',
        'photo',
        'location_id',
        'office_id',
        'division_id',
        'department_id',
        'observation',
        'search',
    ];
    
    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function office()
    {
        return $this->belongsTo(Office::class);
    }

    public function division()
    {
        return $this->belongsTo(Division::class);
    }
    
    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
