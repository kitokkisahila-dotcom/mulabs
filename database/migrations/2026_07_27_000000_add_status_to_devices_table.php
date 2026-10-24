<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('devices', function (Blueprint $table) {
            $table->string('status')->default('Available')->after('block_code');
        });

        $faultyDeviceRegistrationNumbers = DB::table('reports')
            ->where('status', 'Faulty')
            ->pluck('device_reg_no');

        DB::table('devices')
            ->whereIn('reg_no', $faultyDeviceRegistrationNumbers)
            ->update(['status' => 'Faulty']);
    }

    public function down(): void
    {
        Schema::table('devices', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
