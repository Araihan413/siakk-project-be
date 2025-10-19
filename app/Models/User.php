<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    protected $fillable = ['name', 'email', 'password', 'role'];


    //RELASI DISINI
    public function createdForms()
    {
        return $this->hasMany(Form::class, 'created_by');
    }


    //BAGIAN INI SENSITIV CASE
    //JANGAN DIOTAK ATIK...
    //TAMBAHAN RELASI JIKA ADA DI BAGIAN ATAS SEBELUM INI
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
