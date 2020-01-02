<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class HowItWorks extends Migration {

	public function up()
	{
		Schema::create('how_it_works', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('title', 400);
			$table->string('text', 1600);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('how_it_works');
	}
}
