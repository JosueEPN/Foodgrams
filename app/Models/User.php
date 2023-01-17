<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasRoles;

   
    protected $fillable = [
        'name',
        'nick_name',
        'email',
        'password',
        'web_site',
        'presentation',
        'status',
        
    ];

  
    protected $hidden = [
        'remember_token',
        'password',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * Get all of the post for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */

    public function post()
    {
        return $this->hasMany(Posts::class);
    }

    public function followers()
    {
        return $this->hasMany(Followers::class);
    }

    public function receivesBroadcastNotificationsOn(){
        return 'App.Models.User.'.$this->id;
    }

    public static function getUserSearch($nick_name){

        $querry = (new static)
        ->where('nick_name' ,'like' ,'%'.$nick_name."%")
        ->get();
      
        return $querry;
        
    }
}
