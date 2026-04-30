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
        Schema::table('payroll_bonuses', function (Blueprint $table) {
            $table->foreignId('route_id')
                ->nullable()
                ->after('staff_id')
                ->constrained('staff_routes')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payroll_bonuses', function (Blueprint $table) {
            $table->dropConstrainedForeignId('route_id');
        });
    }
};
