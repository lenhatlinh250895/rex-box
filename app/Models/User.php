<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'User_ID';
    protected $fillable = [
        'User_ID',
        'User_Email',
        'User_Password',
        'User_Agency_Level',
        'User_Level',
        'User_Parent',
        'User_Tree',
        'User_RegisteredDatetime',
        'User_Status'
    ];
    public $timestamps = false;


}
