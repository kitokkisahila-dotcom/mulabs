<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Laboratory extends Model
{
    protected $fillable=[
        'block_code',
        'block_name',
        'capacity',
     ];
    public function device(){
        return $this->hasMany(Device::class,'block_code','block_code'); 
    }
}
