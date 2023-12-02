<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $primaryKey = 'customer_id';
    protected $table = 'customer';
    protected $fillable = ['customer_code', 'customer_name', 'customer_no', 'credit_limit', 'credit_exposure', 'repid', 'salesrep', 'route'];

    public $timestamps = false;

    public function salesman()
    {
        return $this->belongsToMany(User::class, 'customer_dist_channels', 'customer_id', 'sales_person_id')->withPivot('route_id');
    }
    public function salesrep()
    {
        return $this->belongsTo(SalesRep::class, 'rep_id', 'repid');
    }
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    public function routes()
    {
        return $this->belongsToMany(Route::class, 'customer_dist_channels', 'customer_id', 'route_id');
    }
}
