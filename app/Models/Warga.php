<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Warga extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['rtrw_id','building_id','full_name','nik','gender','birthplace','dob','religion','blood_type','work_type','education_id','photo','relationship_family','handphone','telephone','citizen','life','status'];

    public function building() : BelongsTo
    {
        return $this->belongsTo(Building::class);
    }

    public function user() : HasOne
    {
        return $this->hasOne(User::class);
    }

    public function rtrw() : BelongsTo
    {
        return $this->belongsTo(Rtrw::class);
    }

    public function documents() : HasMany
    {
        return $this->hasMany(Document::class);
    }
}
