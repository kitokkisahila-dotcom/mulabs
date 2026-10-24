<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
           Schema::create('programs', function (Blueprint $table){
           $table->id();
           $table->string('program_id')->unique();
           $table->string('program_name');
           $table->string('faculty_id');
           $table->foreign('faculty_id')
          ->references('faculty_id')
          ->on('faculties')
          ->onDelete('cascade');
          $table->timestamps();
});
  }
    public function down(): void
    {
        Schema::dropIfExists('programs');
    }
};
