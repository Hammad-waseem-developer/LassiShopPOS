<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    public $with = ['user', 'newProduct'];
    protected $fillable = ['new_product_id', 'user_id', 'order_no', 'quantity','orignal_quantity'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function newProduct()
    {
        return $this->belongsTo(NewProduct::class);
    }
}
