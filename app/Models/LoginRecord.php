<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoginRecord extends Model
{
    protected $table='login_records';
    protected $fillable =['full_name','user_type','login_time','user_id','username'];
    use HasFactory;
}
