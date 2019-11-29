<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use App\Notifications\MailResetPasswordToken;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * App\User
 *
 */
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password', 'blocked'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new MailResetPasswordToken($token));
    }

    public function isATeamManager()
    {
        return false;
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    /** User has many articles
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function articles()
    {
        return $this->hasMany('App\Article');
    }

    public function orders()
    {
        return $this->hasMany('App\Order');
    }

    /** User has many pages
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pages()
    {
        return $this->hasMany('App\Page');
    }

    /** User has many product
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products()
    {
        return $this->hasMany('App\Product');
    }

    /** User has many category
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function catalogs()
    {
        return $this->hasMany('App\Catalog');
    }

    public function roles()
    {
        return $this->belongsToMany('App\Role', 'user_role', 'user_id', 'role_id');
    }

    public function hasAnyRole($roles)
    {
        if (is_array($roles)) {
            foreach ($roles as $role) {
                if ($this->inRole($role)) {
                    return true;
                }
            }
        } else {
            if ($this->inRole($roles)) {
                return true;
            }

        }
        return false;
    }

    public function hasRole($role)
    {
        if ($this->roles()->where('name', $role)->first()) {
            return true;
        }
        return false;
    }

    /**
     * Checks if User has access to $permissions.
     */
    public function hasAccess(array $permissions)
    {
        var_dump($permissions);
        // check if the permission is available in any role
        foreach ($this->roles as $role) {
            var_dump($role->name);
            if ($role->hasAccess($permissions)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Checks if the user belongs to role.
     */
    public function inRole($roleSlug)
    {
        return $this->roles()->where('name', $roleSlug)->count() == 1;
    }


    public function getRoleListAttribute()
    {

        return $this->roles->pluck('id')->all();
    }

    /**
     * Get last order from user
     * @return Order|null
     */
    public function lastOrder()
    {
        if ($this->orders()->exists()) {
            return $this->orders()->latest('created_at')->first();
        }
        return null;
    }
}
