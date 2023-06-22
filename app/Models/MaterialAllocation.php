<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialAllocation extends Model
{
    use HasFactory;
    protected $table = 'material_allocation';
    
    public function material()
    {
        return $this->belongsTo(Material::class, 'material_id', 'material_id');
    }
}
