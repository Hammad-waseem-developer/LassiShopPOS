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
            'email',
            'address',
            'country',
            'city',
            'province',
            'zip',
            'family_status',
            'gender',
            'employment_type',
            'birth_date',
            'join_date',
            'leaving_date',
            'annual_leave',
            'remaining_leave',
            'hourly_late',
            'salary',
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
    public function social()
    {
        return $this->hasMany(SocialMedia::class, 'emp_id');
    }

    public function bank()
    {
        return $this->hasOne(BankAccount::class, 'emp_id');
    }
    public function experience()
    {
        return $this->hasMany(Experience::class, 'emp_id');
    }
}
