<?php

namespace App\Models;

// use Illuminate\Auth\Authenticatable;
// use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Auth\Authenticatable;

class Staff extends Model 
{
    use Authenticatable;
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */

    protected $table = "table_staff";
    protected $fillable = [
        'nama', 'nip', 'jabatan','email','password','updated_at'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var string[]
     */
    protected $hidden = [
        'password',
    ];

    public function getJWTIdentifier()
    {
        return (string) $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
