<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'notification_preference',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    //A User can have One/Many roles
    public function roles(){
        return $this->belongsToMany('\App\Role', 'user_role', 'user_id', 'role_id');
    }

    public function tenant(){
        return $this->hasOne('\App\Tenant');
    }

    public function admin(){
        return $this->hasOne('\App\Admin');
    }

    //checks the Roles ($roles) needed for one to access the resource
    public function hasAnyRole($roles)
    {
        if (is_array($roles)) {
            foreach ($roles as $role) {
                if ($this->hasRole($role)) {
                    return true;
                }
            }
        } else {
            if ($this->hasRole($roles)) {
                return true;
            }
        }
        return false;
    }
    
    //checks if the user has a specified Role ($role) to access the resource
    public function hasRole($role)
    {
        if ($this->roles()->where('name', $role)->first()) {
            return true;
        }
        return false;
    }

    // roles available for users
    public function roleOptions(){
        return [
            'admin' => 'Admin',
            'user' => 'User',
        ];
    }
}
