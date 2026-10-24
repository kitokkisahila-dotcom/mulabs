<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
            Schema::create('departments', function (Blueprint $table) {
            $table->id();
            $table->string('department_id')->unique();
            $table->string('department_name');
            $table->string('faculty_id');
            $table->timestamps();
            $table->foreign('faculty_id')
            ->references('faculty_id')
            ->on('faculties')
            ->onDelete('cascade');
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('departments');
    }
};
