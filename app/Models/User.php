<?php
namespace App;

namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class User extends Authenticatable
{   use HasFactory;

    protected $table = 'verify'; // The name of your users table in the database
    public $timestamps = false;

    protected $primaryKey = 'gamer_id'; 
    protected $fillable = [
      'gamer_username','password','fullname'
      
    ];

    protected $hidden = [
        'password', // Hide the password attribute when converting the model to an array or JSON
    ];

}