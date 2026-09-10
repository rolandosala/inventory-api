<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaintenanceRecord extends Model
{
    protected $fillable = [
        'asset_id',
        'technician_id',
        'maintenance_type',
        'cost',
        'date_reported',
        'date_started',
        'date_completed',
        'problem_description',
        'action_taken',
        'status',
        'remarks'
    ];

    protected $casts = [
        'date_reported' => 'string',
        'cost' => 'decimal:2',
    ];

    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }
}