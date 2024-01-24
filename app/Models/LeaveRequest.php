<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveRequest extends Model
{
    use HasFactory;
    protected $table = 'leave_request';
  // Example using $fillable
protected $fillable = ['company_id', 'emp_id', 'dept_id', 'leave_id', 'start_date', 'end_date', 'status', 'file_path', 'reason'];


    public function employee()
    {
        return $this->belongsTo(Employee::class, 'emp_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'dept_id');
    }

    public function leave()
    {
        return $this->belongsTo(LeaveType::class, 'leave_id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

}
