<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateCmsContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cms_contacts', function (Blueprint $table) {
            $table->id();
			$table->text('section_one_heading')->nullable();
			$table->text('section_one_description')->nullable();
			$table->text('section_one_icon')->nullable();
			$table->text('section_two_heading')->nullable();
			$table->text('section_two_phone')->nullable();
			$table->text('section_two_icon')->nullable();
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
        Schema::dropIfExists('cms_contacts');
    }
}
