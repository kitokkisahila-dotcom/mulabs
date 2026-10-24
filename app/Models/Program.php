<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    protected $fillable = [
        'program_id',
        'program_name',
        'faculty_id',
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'program_id', 'program_id');
    }

    public function faculty()
    {
        return $this->belongsTo(Faculty::class, 'faculty_id', 'faculty_id');
    }
}
