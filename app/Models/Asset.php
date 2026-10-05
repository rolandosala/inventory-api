<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Asset extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'asset_tag',
        'property_number',
        'ics_number',
        'par_number',

        'category_id',
        'supplier_id',
        'department_id',
        'location_id',

        'item_name',
        'brand',
        'model',
        'serial_number',
        'specifications',

        'purchase_order_number',
        'purchase_request_number',
        'purchase_date',
        'date_received',

        'unit_cost',
        'total_cost',

        'fund_source',
        'fund_cluster',

        'acquisition_type',

        'warranty_start',
        'warranty_expiry',

        'status',
        'condition',

        'accountable_user_id',
        'accountability_date',

        'disposal_date',
        'disposal_reference',
        'disposal_reason',

        'remarks',
    ];

    protected $casts = [
        'purchase_date' => 'date',
        'date_received' => 'date',
        'warranty_start' => 'date',
        'warranty_expiry' => 'date',
        'accountability_date' => 'date',
        'disposal_date' => 'date',

        'unit_cost' => 'decimal:2',
        'total_cost' => 'decimal:2',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    public function accountableUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'accountable_user_id');
    }

    public function assignments(): HasMany
    {
        return $this->hasMany(AssetAssignment::class);
    }

    public function maintenanceRecords(): HasMany
    {
        return $this->hasMany(MaintenanceRecord::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(InventoryTransaction::class);
    }
    public function software()
    {
        return $this->belongsToMany(
            Software::class,
            'asset_software'
        )->withPivot([
                    'installed_at',
                    'license_key',
                    'status',
                    'remarks',
                ])->withTimestamps();
    }
}