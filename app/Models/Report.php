<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = [
        'device_reg_no',
        'user_id',
        'description',
        'status',
    ];

    public function device()
    {
        return $this->belongsTo(Device::class, 'device_reg_no', 'reg_no');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'registration_no');
    }
}
