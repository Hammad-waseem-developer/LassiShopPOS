<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Office extends Model
{
    use HasFactory;
    protected $table = 'office_shift';
    protected $fillable = [
        'name',
        'clock_in',
        'clock_out',
        'company_id', 
        ];

        public function company()
        {
            return $this->belongsTo(Company::class ,'company_id' ,'id');

        }
}
