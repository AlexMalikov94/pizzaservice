<?php

namespace App\Models;


use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\ProductVariation;
use App\Models\PaymentMethod;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Support\Facades\Hash;
use App\Models\Address;
use App\Models\Order;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'gateway_customer_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public static function boot()
    {
        parent::boot();
        static::creating(function($user){
           $user->password = Hash::make($user->password);
        });
    }

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getJWTIdentifier()
    {
        return $this->id;
    }
     public function getJWTCustomClaims()
     {
         return [];
     }
     public function cart()
     {
        return $this->belongsToMany(ProductVariation::class, 'cart_user')
                                  ->withPivot('quantity')
                                  ->withTimestamps();
     }

     public function addresses(){
        return $this->hasMany(Address::class);
     }

     public function orders() 
     {
        return $this->hasMany(Order::class);
     }

     public function paymentMethods() 
     {
        return $this->hasMany(PaymentMethod::class);
     }
}
