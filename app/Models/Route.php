<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    use HasFactory;
    protected $primaryKey = 'route_id';
    protected $table = 'route';

    public function customer()
    {
        return $this->belongsToMany(Customer::class,'customer_dist_channels','route_id','customer_id');
    }
}
