<?php

namespace App\Models;

use App\Models\Company;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Attendance extends Model
{
    use HasFactory;
    protected $table = 'attendance';
    protected $fillable = [
        'emp_id',
        'date',
        'clock_in',
        'clock_out',
        'work_duration',
        'break_time',
        'status',
        'created_at',
        'updated_at',
        'office_id',
        'company_id',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'emp_id');
    }

    // Define the One-to-One relationship with Company
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    // Define the One-to-One relationship with Office
    public function office()
    {
        return $this->belongsTo(Office::class, 'office_id');
    }
}
