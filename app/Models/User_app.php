<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_app extends Model
{
    use HasFactory;
    
    protected $table = 'users_app';
    protected $primaryKey = 'user_id';

    public function materialAllocations()
    {
        return $this->belongsToMany(Material::class, 'material_allocation', 'user_id', 'material_id');
    }
}
