<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
			$table->string('user_id')->nullable();
			$table->string('client_type')->nullable();
			$table->string('payment_type')->nullable();
			$table->string('service_frequncy')->nullable();
			$table->string('start_date')->nullable();
			$table->string('end_date')->nullable();
			$table->string('start_hour')->nullable();
			$table->string('end_hour')->nullable();
			$table->string('price_type')->nullable();
			$table->string('inside_cost')->nullable();
			$table->string('outside_cost')->nullable();
			$table->string('custom_cost')->nullable();
			$table->string('cost_description')->nullable();
			$table->string('fornt_image')->nullable();
			$table->string('back_image')->nullable();
			$table->string('additional_note')->nullable();
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
        Schema::dropIfExists('clients');
    }
}
