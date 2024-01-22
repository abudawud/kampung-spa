<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\Sys\Role;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
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
        'employee_id',
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

    public function getIsAdminAttribute() {
        return $this->roles?->pluck('name')->contains(Role::ADMIN);
    }

    public function getNameAttribute() {
        return $this->employee->name;
    }

    public function adminlte_desc() {
        return $this->employee->position->name;
    }

    public function employee() {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function roleIs($roleName) {
        return $this->roles->pluck('name')->contains($roleName);
    }

    public function availableSites() {
        $sites = Site::active();
        if (!$this->roleIs(Role::ADMIN)) {
            $sites->where('id', $this->employee->site_id);
        }

        return $sites;
    }
}
