<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateCmsHomesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cms_homes', function (Blueprint $table) {
            $table->id();
			$table->string('section_one_heading')->nullable();
			$table->string('section_one_description')->nullable();
			$table->string('section_two_heading')->nullable();
			$table->string('two_sub_section_one_heading')->nullable();
			$table->string('two_sub_section_one_title')->nullable();
			$table->string('two_sub_section_two_heading')->nullable();
			$table->string('two_sub_section_two_title')->nullable();
			$table->string('section_three_heading')->nullable();
			$table->string('section_three_description')->nullable();
			$table->string('three_sub_section_one_heading')->nullable();
			$table->string('three_sub_section_one_description')->nullable();
			$table->string('three_sub_section_one_link')->nullable();
			$table->string('section_two_image_one')->nullable();
			$table->string('section_two_image_two')->nullable();
			$table->string('two_sub_section_one_icon')->nullable();
			$table->string('two_sub_section_two_icon')->nullable();
			$table->string('three_sub_section_one_image')->nullable();
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
        Schema::dropIfExists('cms_homes');
    }
}
