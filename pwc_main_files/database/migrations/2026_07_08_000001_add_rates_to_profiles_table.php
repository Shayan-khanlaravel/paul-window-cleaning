<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->decimal('training_rate', 10, 2)->nullable()->after('address');
            $table->decimal('normal_rate', 10, 2)->nullable()->after('training_rate');
        });
    }

    public function down(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->dropColumn(['training_rate', 'normal_rate']);
        });
    }
};
