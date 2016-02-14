<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('users', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('name', 32);
            $table->string('email', 320);
            $table->string('password', 64);
            $table->string('city', 64);
            $table->string('street', 64);
            $table->string('doorCode', 64);
            $table->string('postalCode', 64);
            $table->string('telephoneNumber', 64);
            $table->string('telephoneNumberDriver', 64);
            $table->string('additionalInfo', 300);
            $table->string('interval', 300);
            $table->string('startDate', 32);
            $table->string('skipDate', 300);
            $table->string('extraProductCurrent', 32);
            $table->string('extraProductNext', 32);
            $table->string('extraProductPrice', 32);
            $table->string('dinnerProduct', 32);
            $table->string('dinnerProductAlternative', 32);
            $table->string('dinnerProductAlternativePrice', 32);
            $table->string('dinnerProductAmount', 32);
            $table->string('dinnerProductPrice', 32);
            $table->string('payexID', 128);
            $table->boolean('active');
            $table->boolean('payed');
            $table->string('role', 32);
            $table->rememberToken();
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
        Schema::drop('users');
	}

}
