<?php

namespace App\Models;

use App\Models\User;
use App\Models\Machine;
use App\Models\TypeService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'machine_id',
        'type_service_id',
        'user_id',
        'start',
        'description',
        'status',
        'duration',
        'end',
        'next_service_date',
        'search',
    ];

    public function machine()
    {
        return $this->belongsTo(Machine::class);
    }

    public function typeService()
    {
        return $this->belongsTo(TypeService::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
