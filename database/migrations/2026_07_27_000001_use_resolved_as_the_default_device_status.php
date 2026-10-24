<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('devices')->where('status', 'Available')->update(['status' => 'Resolved']);

        Schema::table('devices', function (Blueprint $table) {
            $table->string('status')->default('Resolved')->change();
        });
    }

    public function down(): void
    {
        Schema::table('devices', function (Blueprint $table) {
            $table->string('status')->default('Available')->change();
        });
    }
};
