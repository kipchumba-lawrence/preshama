<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $table = 'order';
    protected $primaryKey = 'property_id';
    public $timestamps = false;

    public function customer()
    {
        return $this->belongsTo(customer::class,'customer_id');
    }

    public function creditManagerUser(){
        return $this->belongsTo(User::class,'credit_manager');
    }

}
