<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Faculty extends Model
{
    protected $fillable=[
        'faculty_id',
        'faculty_name',
    ];

    public function departments(){
        return $this->hasMany(Department::class,'faculty_id','faculty_id');
    }

    public function programe(){
        return $this->hasMany(Program::class,'faculty_id','faculty_id');
    }
}
