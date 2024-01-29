<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PosSaleItems extends Model
{
    use HasFactory;

    protected $table = 'pos_sale_items';

    protected $fillable = [
        'sale_id',
        'new_product_id',
        'qty'
    ];

    public function newProduct()
    {
        return $this->belongsTo(NewProduct::class, 'new_product_id');
    }
    public function sale()
    {
        return $this->belongsTo(Sale::class, 'sale_id');
    }
}
