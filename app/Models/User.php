<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use BezhanSalleh\FilamentShield\Traits\HasPanelShield;
use Filament\Facades\Filament;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasTenants;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements FilamentUser, HasTenants
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function rtrws() : BelongsToMany 
    {
        return $this->belongsToMany(Rtrw::class);
    }
    
    // public function getTenants(Panel $panel): array|Collection
    // {
    //     return $this->rtrws;
    // }

    // public function canAccessTenant(Model $tenant): bool
    // {
    //     return $this->rtrws->contains($tenant);
    // }

    public function buildings() : BelongsToMany 
    {
        return $this->belongsToMany(Building::class);
    }
    
    public function getTenants(Panel $panel): array|Collection
    {
        return $this->buildings;
    }

    public function canAccessTenant(Model $tenant): bool
    {
        return $this->buildings->contains($tenant);
    }

    public function canAccessPanel(Panel $panel): bool
    {
        $roles = Auth::user()->getRoleNames();

        // return match($panel->getId()) {
        //     'admin' => $role === 'super_admin',
        //     'user' => $role === 'warga',
        //     default => false
        // };
        if ($panel->getId() === 'admin' && $roles->contains('super_admin')) {
            return true;
        }else if ($panel->getId() === 'admin' && $roles->contains('pengurus')) {
            return true;
        }else{
            return false;
        }
    }

    // public function rtrw()
    // {
    //     return $this->rtrws()->where('rtrw_id', Filament::getTenant()->id);
    // }
}
