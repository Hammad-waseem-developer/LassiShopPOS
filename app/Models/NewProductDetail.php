<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewProductDetail extends Model
{
    use HasFactory;

    protected $table = 'new_product_details';

    protected $fillable = ['new_product_id', 'base_product_id', 'unit_id', 'qty', 'created_at', 'updated_at'];

    public function NewProduct()
    {
        return $this->belongsTo(NewProduct::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}
