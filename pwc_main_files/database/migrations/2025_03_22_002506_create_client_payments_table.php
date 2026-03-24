<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateClientPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_payments', function (Blueprint $table) {
            $table->id();
			$table->string('client_id');
			$table->string('route_id');
			$table->string('price_id');
			$table->string('option');
			$table->string('option_two');
			$table->string('option_three');
			$table->string('option_four');
			$table->string('reason');
			$table->string('scope');
			$table->string('price_charge_one');
			$table->string('price_charge_two');
			$table->string('amount');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('client_payments');
    }
}
