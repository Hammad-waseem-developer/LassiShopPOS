<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Holiday extends Model
{
    use HasFactory;
    protected $table = 'holiday';
protected $fillable = [
    'name', 
    'company_id', 
    'start_date', 
    'end_date', 
    'status', 
    'details', 
];

public function company()
{
    return $this->belongsTo(Company::class, 'company_id');
}
}
