<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
            Schema::create('devices', function (Blueprint $table) {
            $table->id();
            $table->string('reg_no')->unique();
            $table->string('device_name');
            $table->string('brand');
            $table->string('block_code');
            $table->timestamps();
            $table->foreign('block_code')
                  ->references('block_code')
                  ->on('laboratories')
                  ->onDelete('cascade');
        });
    }
    public function down(): void
    {
         Schema::dropIfExists('devices');
    }
};
