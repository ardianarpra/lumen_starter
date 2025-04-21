<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
// Model implements AuthenticatableContract, AuthorizableContract
{
    // use Authenticatable, Authorizable, HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $table = "table_mahasiswa";
    protected $fillable = ['nama','nim','jurusan','alamat'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var string[]
     */
}
