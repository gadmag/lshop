<?php

namespace App;

use App\Services\HasRolesAndPermissions;
use Illuminate\Notifications\Notifiable;
use App\Notifications\MailResetPasswordToken;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * App\User
 *
 */
class User extends Authenticatable
{
    use Notifiable, HasRolesAndPermissions;

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
