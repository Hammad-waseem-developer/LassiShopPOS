<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HoldProduct extends Model
{
    use HasFactory;

    protected $table = 'hold_products';

    protected $fillable = [
        'hold_order_id',
        'product_id',
        'name',
        'price',
        'quantity',
        'img_path',
        'created_at',
        'updated_at',
    ];

    public function holdOrder()
    {
        return $this->belongsTo(HoldOrder::class, 'hold_order_id', 'id');
    }
}
