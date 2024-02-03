<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    protected $table = 'notification';

    protected $fillable = [
        'messages',
        'created_at',
        'updated_at'
    ];

    public function NotificationDetail()
    {
        return $this->hasMany(NotificationDetail::class, 'notification_id', 'id');
    }
}
