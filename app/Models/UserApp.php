<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserApp extends Model
{   
    protected $table='users_app';
    protected $primaryKey = 'user_id';
    use HasFactory;
}
