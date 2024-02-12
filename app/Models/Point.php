<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Point extends Model
{
    use HasFactory;
    protected $table = 'points';

    protected $fillable = [
        'user_id',
        'total_user_point',
        'remaining_user_point',
        'created_at',
        'updated_at',
    ];

    public function Clients()
    {
        return $this->belongsTo(Client::class, 'user_id', 'id');
    }
}
