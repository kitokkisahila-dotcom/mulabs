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
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->string('device_reg_no');
            $table->string('user_id');
            $table->text('description');

            // Report Status
            $table->enum('status', ['Faulty', 'Resolved'])
                  ->default('Faulty');

            $table->timestamps();

            // Foreign Keys
            $table->foreign('device_reg_no')
                  ->references('reg_no')
                  ->on('devices')
                  ->onDelete('cascade');

            $table->foreign('user_id')
                  ->references('registration_no')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
      public function down(): void
    {
        Schema::table('reports', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};