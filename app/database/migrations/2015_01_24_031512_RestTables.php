<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RestTables extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('rest_tokens', function($t) {
			$t->increments('id');
			$t->integer('user_id')->unsigned();
			$t->string('token');
			$t->timestamps();

			$t->foreign('user_id')->references('id')->on('users')
				->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('rest_tokens');
	}

}
