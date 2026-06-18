<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('deposits', function (Blueprint $table) {
            if (!Schema::hasColumn('deposits', 'schedule_id')) {
                $table->unsignedBigInteger('schedule_id')->nullable()->after('staff_id');
                $table->index('schedule_id');
            }
            if (!Schema::hasColumn('deposits', 'client_payment_id')) {
                $table->unsignedBigInteger('client_payment_id')->nullable()->after('schedule_id');
                $table->index('client_payment_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('deposits', function (Blueprint $table) {
            if (Schema::hasColumn('deposits', 'client_payment_id')) {
                $table->dropIndex(['client_payment_id']);
                $table->dropColumn('client_payment_id');
            }
            if (Schema::hasColumn('deposits', 'schedule_id')) {
                $table->dropIndex(['schedule_id']);
                $table->dropColumn('schedule_id');
            }
        });
    }
};
