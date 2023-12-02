<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesRep extends Model
{
    protected $table = 'sales_person';
    protected $fillable = ['region','first_name','repid'];
    protected $primaryKey = 'sales_person_id';

    use HasFactory;
    public function clients()
    {
        return $this->hasMany(Customer::class, 'repid', 'repid');
    }
    public function orders()
    {
        return $this->hasManyThrough(Order::class, Customer::class, 'repid', 'customer_id', 'id');
    }
}
