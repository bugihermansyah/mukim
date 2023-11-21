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

    protected $fillable = [
        'rtrw_id','building_id','full_name','nik','gender',
        'birthplace','dob','religion','blood_type','employment_id',
        'education_id','photo','relationship_family','handphone',
        'telephone','citizen','address','rtrw','village','subdistrict','life','status'];

    public function building() : BelongsTo
    {
        return $this->belongsTo(Building::class);
    }

    public function employment() : BelongsTo
    {
        return $this->belongsTo(Employment::class);
    }

    public function education() : BelongsTo
    {
        return $this->belongsTo(Education::class);
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
