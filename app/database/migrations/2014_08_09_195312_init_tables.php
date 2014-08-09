<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InitTables extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('users', function($t) {
			$t->increments('id');
			$t->string('name');
			$t->string('email')->unique();
			$t->string('password');
			$t->string('remember_token')->nullable();
			$t->country('country');
			$t->timestamps();
			$t->softDeletes();
		});
		Schema::create('organizations', function($t) {
			$t->increments('id');
			$t->string('name')->unique();
			$t->string('description', 500);
			$t->timestamps();
			$t->softDeletes();
		});
		Schema::create('organization_admin', function($t) {
			$t->increments('id');
			$t->integer('user_id')->unsigned();
			$t->integer('organization_id')->unsigned();
			$t->foreign('user_id')->references('id')->on('users')->onDelete('set null');
			$t->foreign('organization_id')
				->references('id')->on('organizations')->onDelete('set null');
			$t->timestamps();
			$t->softDeletes();
		});
		Schema::create('devices', function($t) {
			$t->increments('id');
			$t->string('name');
			$t->string('description');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		//
	}

}
