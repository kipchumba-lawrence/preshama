<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;

    protected $table = 'material';
    
    protected $primaryKey = 'material_id';

    public function salesman()
    {
        return $this->belongsToMany(User::class, 'material_allocation', 'material_id', 'user_id')->withPivot('amount');
    }
    
    public function allocations()
    {
        return $this->hasMany(MaterialAllocation::class, 'material_id', 'material_id');
    }
}
