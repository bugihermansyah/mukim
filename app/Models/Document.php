<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Document extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'date',
        'warga_id',
        'type',
        'notes',
        'status',
        'user_id',
        'url'
    ];
    
    public function buildings() : BelongsToMany
    {
        return $this->belongsToMany(Building::class);
    }

    public function warga() : BelongsTo
    {
        return $this->belongsTo(Warga::class);
    }

    /**
     * Get all of the signs for the Document
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function signs(): HasMany
    {
        return $this->hasMany(Sign::class);
    }
}
