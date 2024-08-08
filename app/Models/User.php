<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    public $table = 'user';
    protected $fillable = ['name','email','phone','description','profile','role_id'];

    public function role(){
        return $this->Belongsto(Role::class, 'role_id');
    }
}
