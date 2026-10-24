<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    protected $fillable = [
        'reg_no',
        'device_name',
        'brand',
        'block_code',
        'status',
    ];

    public function laboratory()
    {
        return $this->belongsTo(Laboratory::class, 'block_code', 'block_code');
    }

    public function reports()
    {
        return $this->hasMany(Report::class, 'device_reg_no', 'reg_no');
    }

    public function syncStatusFromReports(): void
    {
        $this->update([
            'status' => $this->reports()->where('status', 'Faulty')->exists()
                ? 'Faulty'
                : 'Resolved',
        ]);
    }
}
