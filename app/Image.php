<?php


namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;

class Image extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'type', 'path', 'fullpath', 'name'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     * Skryte hodnoty, ktotér sa do response nezobrazujú
     * @var array
     */
    protected $hidden = [
        'created_at', 'id', 'id_gallery'
    ];
}
