<?php

namespace App\Models;

use App\Enums\VehicleColor;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vehicle extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'nopol',
        'type',
        'merk_type',
        'color',
        'information',
        'user_id'
    ];

    protected $casts = [
        'color' => VehicleColor::class
    ];
    
    public function buildings() : BelongsToMany
    {
        return $this->belongsToMany(Building::class);
    }
}
