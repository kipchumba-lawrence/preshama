<?php

namespace App\Models;

use App\Models\User;
use App\Models\Order_detail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;
    protected $table = 'order';
    protected $primaryKey = 'property_id';
    public $timestamps = false;

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
    public function creditManagerUser()
    {
        return $this->belongsTo(User::class, 'credit_manager');
    }
    public function orderDetails()
    {
        return $this->hasMany(Order_detail::class, 'order_id');
    }
}
