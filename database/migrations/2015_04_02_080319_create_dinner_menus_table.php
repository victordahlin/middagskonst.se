<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateDinnerMenusTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('dinner_menus', function(Blueprint $table)
		{
            $table->increments('id');
            $table->string('title', 50);
            $table->string('starter', 400);
            $table->string('main', 400);
            $table->string('dessert', 400);
            $table->string('text', 400);
            $table->string('week',50);
            $table->string('order',64);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('dinner_menus');
	}

}
