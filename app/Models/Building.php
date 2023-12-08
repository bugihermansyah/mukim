<?php

namespace App\Models;

use App\Enums\EconomicStatus;
use App\Enums\HouseStatus;
use App\Enums\HunianStatus;
use Filament\Models\Contracts\HasName;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Building extends Model implements HasName
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'block', 
        'number',
        'slug',
        'owner',
        'phone',
        'is_used',
        'rate',
        'is_house',
        'is_economic',
        'rtrw_id'
    ];

    protected $casts = [
        'is_used' => HunianStatus::class,
        'is_house' => HouseStatus::class,
        'is_economic' => EconomicStatus::class,
    ];

    public function getFilamentName(): string
    {
        return "{$this->block}/{$this->number}";
    }
    
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function vehicles(): BelongsToMany
    {
        return $this->belongsToMany(Vehicle::class);
    }    

    public function documents(): BelongsToMany
    {
        return $this->belongsToMany(Document::class);
    }
    
    public function rtrw() : BelongsTo
    {
        return $this->belongsTo(Rtrw::class);    
    }

    public function wargas(): HasMany
    {
        return $this->hasMany(Warga::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
  
    public function announcements(): BelongsToMany
    {
        return $this->belongsToMany(Announcement::class, 'announcement_user', 'announcement_id','building_id');    
    }
}
