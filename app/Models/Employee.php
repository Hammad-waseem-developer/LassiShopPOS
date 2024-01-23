<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    protected $table = "employee_shift";
    protected $fillable = [
        'first_name',
        'last_name',
        'phone',
        'office_id',
        'designation_id',
        'department_id',
        // Add other fillable fields as needed
    ];

    // Define relationships with other models
    public function office()
    {
        return $this->belongsTo(Office::class, 'office_id');
    }

    public function designation()
    {
        return $this->belongsTo(Designation::class, 'designation_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }
}
