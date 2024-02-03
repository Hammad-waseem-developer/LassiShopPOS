<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationDetail extends Model
{
    use HasFactory;
    protected $table = 'notification_details';

    protected $fillable = ['notification_id', 'user_id', 'status', 'read_at', 'created_at', 'updated_at'];

    public function notification()
    {
        return $this->belongsTo(Notification::class);
    }
}
