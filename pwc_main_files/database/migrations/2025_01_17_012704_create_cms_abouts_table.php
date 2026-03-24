<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateCmsAboutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cms_abouts', function (Blueprint $table) {
            $table->id();
			$table->text('section_one_heading')->nullable();
			$table->text('section_one_description')->nullable();
			$table->text('section_two_heading')->nullable();
			$table->text('two_sub_section_one_heading')->nullable();
			$table->text('two_sub_section_one_description')->nullable();
			$table->text('two_sub_section_one_link_one')->nullable();
			$table->text('two_sub_section_one_link_two')->nullable();
			$table->text('two_sub_section_two_heading')->nullable();
			$table->text('two_sub_section_two_description')->nullable();
			$table->text('two_sub_section_two_link_one')->nullable();
			$table->text('two_sub_section_two_link_two')->nullable();
			$table->text('two_sub_section_three_heading')->nullable();
			$table->text('two_sub_section_three_description')->nullable();
			$table->text('two_sub_section_three_link_one')->nullable();
			$table->text('two_sub_section_three_link_two')->nullable();
			$table->text('two_sub_section_four_heading')->nullable();
			$table->text('two_sub_section_four_description')->nullable();
			$table->text('two_sub_section_four_link_one')->nullable();
			$table->text('two_sub_section_four_link_two')->nullable();
			$table->text('two_sub_section_five_heading')->nullable();
			$table->text('two_sub_section_five_description')->nullable();
			$table->text('two_sub_section_five_link_one')->nullable();
			$table->text('two_sub_section_five_link_two')->nullable();
			$table->text('section_one_image')->nullable();
			$table->text('two_sub_section_one_image')->nullable();
			$table->text('two_sub_section_two_image')->nullable();
			$table->text('two_sub_section_three_image')->nullable();
			$table->text('two_sub_section_four_image')->nullable();
			$table->text('two_sub_section_five_image')->nullable();
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
        Schema::dropIfExists('cms_abouts');
    }
}
