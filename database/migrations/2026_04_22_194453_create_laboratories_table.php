<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
            Schema::create('laboratories', function (Blueprint $table) {
            $table->id();
            $table->string('block_code')->unique();
            $table->string('block_name');
            $table->integer('capacity');
            $table->timestamps();
        });
    }
    public function down(): void
    {
          Schema::dropIfExists('laboratories');
    }
};
