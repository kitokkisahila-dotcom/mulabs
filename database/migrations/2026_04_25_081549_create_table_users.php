<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
            Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('second_name');
            $table->string('last_name');
            $table->string('registration_no')->unique()->nullable();
            $table->string('email')->unique();
            $table->string('phone')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->enum('sex', ['Male', 'Female']);
            $table->enum('role', [
                'student',
                'staff',
                'lab_technician',
                'admin'
            ]);
           //Since parent keys are strings
            $table->string('program_id')->nullable();
            $table->string('department_id')->nullable();
            $table->string('image')->unique();
            $table->foreign('program_id')
                  ->references('program_id')
                  ->on('programs')
                  ->nullOnDelete();
            $table->foreign('department_id')
                  ->references('department_id')
                  ->on('departments')
                  ->nullOnDelete();
            $table->rememberToken();
            $table->timestamps();
        });
    }
    public function down(): void
    {
          Schema::dropIfExists('users');
    }
};
