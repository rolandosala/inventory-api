<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Software extends Model
{
    use SoftDeletes;

    protected $table = 'software';

    protected $fillable = [
        'name',
        'publisher',
        'version',
        'category',
        'license_type',
        'licenses',
        'installed',
        'expiry',
        'status',
        'icon',
        'color',
        'description',
    ];
    protected $casts = [
        'expiry' => 'date',
        'licenses' => 'integer',
        'installed' => 'integer',
    ];

    public function assets()
    {
        return $this->belongsToMany(
            Asset::class,
            'asset_software'
        )->withPivot([
                    'installed_at',
                    'license_key',
                    'status',
                    'remarks',
                ])->withTimestamps();
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}