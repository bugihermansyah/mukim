<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Auth;

class Announcement extends Model
{
    use HasFactory;

    protected $fillable = [
        'announcement_type',
        'title',
        'description',
        'user_id',
        'photo',
        'is_gender',
        'is_religion',
        'status',
    ];

    protected $casts = [
        'is_religion' => 'array',
        'is_gender' => 'array',
    ];

    public static function getUrl($notice, $tenantId)
    {
        return route('filament.user.resources.announcements.view', ['tenant' => $tenantId, 'record' => $notice]);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);    
    }

    public function buildings(): BelongsToMany
    {
        return $this->belongsToMany(Building::class, 'announcement_user', 'announcement_id','building_id');    
    }
}
