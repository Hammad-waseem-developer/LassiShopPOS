<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HoldOrder extends Model
{
    use HasFactory;

    protected $table = 'hold_orders';
    protected $fillable = [
        'warehouse_id',
        'client_id',
        'reference_no',
        'shipping',
        'orderTax',
        'discount',
        'discountType',
        'created_at',
        'updated_at',
    ];

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function holdProducts()
    {
        return $this->hasMany(HoldProduct::class);
    }
}
