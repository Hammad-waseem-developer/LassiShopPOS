<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewProduct extends Model
{
    use HasFactory;

    protected $table = "new_products";

    protected $fillable = [
        'category_id',
        'warehouse_id',
        'name',
        'img_path',
        'price',
        'created_at',
        'updated_at'
    ];

    public function Product_Deatils()
    {
        return $this->hasMany(NewProductDetail::class);
    }
}
