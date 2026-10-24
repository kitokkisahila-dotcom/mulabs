<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $fillable=[
         'department_id',
         'department_name',
         'faculty_id',
    ];

    public function faculty(){
         return $this->belongsTo(Faculty::class,'faculty_id','faculty_id');
         
    }


}
