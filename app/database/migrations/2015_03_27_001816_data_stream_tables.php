<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DataStreamTables extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('data_streams', function($t) {
			$t->increments('id');
			$t->string('name');
			$t->string('topic_name');
			$t->string('data_type'); // number, string, location
			$t->string('unit')->nullable();
			$t->string('unit_symbol')->nullable();
			$t->string('display_type'); // values: line, bar, map, string
			$t->integer('template_id')->unsigned();
			$t->timestamps();

			$t->foreign('template_id')
				->references('id')->on('templates')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('data_streams');
	}

}
