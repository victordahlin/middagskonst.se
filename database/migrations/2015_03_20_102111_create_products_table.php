<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('products', function(Blueprint $table)
		{
            $table->increments('id');
            $table->string('title',320);
            $table->integer('dinners');
            $table->integer('persons');
            $table->string('longText', 400);
            $table->string('summaryText', 320);
            $table->string('addonsText', 400);
            $table->string('text', 300);
            $table->string('img', 300);
            $table->string('price', 60);
            $table->string('discount', 60);
            $table->string('type', 60);
            $table->string('reference', 60);
		});
	}

    /**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('products');
	}

}
