<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class GoogleAuth extends Model{
    protected $table = "google2fa";

    protected $fillable = ['google2fa_ID','google2fa_User', 'google2fa_Secret'];

    public $timestamps = false;

}

