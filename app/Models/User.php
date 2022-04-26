<?php

namespace App\Models;


use App\Notifications\ResetPasswordNotification;


use App\Notifications\VerifyEmailNotification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'two_factor_type',
        'phone_number',
        'is_superuser',
        'is_staff'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmailNotification());
    }


    public function activeCode() {
        return $this->hasMany(ActiveCode::class);
    }

    public function hasTwoFactorAuthenticatedEnabled() {
        return $this->two_factor_type !== 'off';
    }

    public function isSuperUser() {
       return $this->is_superuser;
    }

    public function isStaffUser() {
        return $this->is_staff;
    }

    public function roles() {
        return $this->belongsToMany(Role::class);
    }
    public function permissions(){
        return $this->belongsToMany(Permission::class);
    }

    public function hasPermission($permission) {
        //dd($this->permissions()->get());
        //dd($this->permissions);

        return  $this->permissions->contains('name' , $permission->name) || $this->hasRole($permission->roles);


    }

    public function hasRole($roles) {
        return !! $roles->intersect($this->roles)->all();
    }

    public function products() {
        return $this->hasMany(Product::class);
    }
}
