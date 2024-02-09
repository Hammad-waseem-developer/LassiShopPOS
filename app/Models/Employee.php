<?php

namespace App\Models;

use App\Models\Company;
use App\Models\Experience;
use App\Models\BankAccount;
use App\Models\SocialMedia;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employee extends Model
{
    use HasFactory;
        protected $table = "employee_shift";
        protected $fillable = [
            'user_id',
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
            'company_id',
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
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }
}
