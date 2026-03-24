<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateStaffRequirementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('staff_requirements', function (Blueprint $table) {
            $table->id();
			$table->string('staff_id')->nullable();
			$table->string('name')->nullable();
			$table->string('quantity')->nullable();
			$table->string('description')->nullable();
			$table->string('status')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('staff_requirements');
    }
}
