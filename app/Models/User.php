<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'first_name',
        'second_name',
        'last_name',
        'username',
        'registration_no',
        'email',
        'phone',
        'sex',
        'role',
        'password',
        'program_id',
        'department_id',
        'image',
        ];
    
    public function program(){
        return $this->belongsTo(Program::class,'program_id','program_id');
    }
    
    public function department(){
        return $this->belongsTo(Department::class,'department_id','department_id');
    }
 
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
