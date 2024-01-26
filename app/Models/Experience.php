<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    use HasFactory;
    protected $table = 'experience';

    protected $fillable = [
        'title',
        'company_name',
        'location',
        'start_date',
        'finish_date',
        'employment_type',
        'description',
        'emp_id',
    ];
}
