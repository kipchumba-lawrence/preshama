<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order_detail extends Model
{
    use HasFactory;
    protected $table = 'order_detail';

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
    public function material()
{
    return $this->belongsTo(Material::class, 'product_id', 'material_id');
}
}
