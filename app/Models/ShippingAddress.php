<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShippingAddress extends Model
{
    protected $fillable = [
        'address_line_1', 
        'address_line_2', 
        'city', 
        'postcode', 
        'country', 
        'is_default'
    ];
    
    public function shippingAddresses()
    {
        return $this->hasMany(ShippingAddress::class);
    }
}
