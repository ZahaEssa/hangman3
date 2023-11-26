<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Authenticatable
{
    use HasFactory;

    protected $table = 'verify'; // The name of your users table in the database
    public $timestamps = false;

    protected $primaryKey = 'gamer_id';

    protected $fillable = [
        'gamer_username', 'password', 'fullname', 'email' // Add 'email' to the $fillable array
    ];

    protected $hidden = [
        'password', // Hide the password attribute when converting the model to an array or JSON
    ];

    // Add a validation rule for email uniqueness
    public static function rules($id = null)
    {
        return [
            'gamer_username' => 'required|string',
            'password' => 'required|string',
            'fullname' => 'required|string',
            'email' => 'required|email|unique:verify,email,' . $id . ',gamer_id',
        ];
    }
}
