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
			$t->string('picture_url');
			$t->string('remember_token')->nullable();
			$t->string('country');
			$t->timestamps();
		});
		Schema::create('organizations', function($t) {
			$t->increments('id');
			$t->string('name')->unique();
			$t->string('description', 500);
			$t->string('picture_url');
			$t->timestamps();
		});
		Schema::create('organization_admin', function($t) {
			$t->increments('id');
			$t->integer('user_id')->unsigned();
			$t->integer('organization_id')->unsigned();
			$t->timestamps();

			$t->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
			$t->foreign('organization_id')
				->references('id')->on('organizations')->onDelete('cascade');
		});
		Schema::create('devices', function($t) {
			$t->increments('id');
			$t->string('name');
			$t->string('description');
			$t->string('picture_url');
			$t->string('communication_type');
			$t->integer('organization_id')->unsigned()->nullable();
			$t->timestamps();

			$t->foreign('organization_id')
				->references('id')->on('organizations')->onDelete('set null');
		});
		Schema::create('commands', function($t) {
			$t->increments('id');
			$t->string('name');
			$t->string('short_cmd');
			$t->string('long_cmd');
			$t->string('type');
			$t->integer('device_id')->unsigned();
			$t->timestamps();

			$t->foreign('device_id')->references('id')->on('devices')->onDelete('cascade');
		});
		Schema::create('arguments', function($t) {
			$t->increments('id');
			$t->string('name');
			$t->string('type'); // int, float, string, boolean, array
			$t->string('options')->nullable(); // if array is chosen
			$t->integer('command_id')->unsigned();
			$t->timestamps();

			$t->foreign('command_id')->references('id')->on('commands')->onDelete('cascade');
		});
		Schema::create('containers', function($t) {
			$t->increments('id');
			$t->string('name');
			$t->string('hardware_id')->unique();
			$t->integer('user_id')->unsigned()->nullable();
			$t->timestamps();

			$t->foreign('user_id')->references('id')->on('users')->onDelete('set null');
		});
		Schema::create('device_instances', function($t) {
			$t->increments('id');
			$t->string('name');
			$t->integer('device_id')->unsigned();
			$t->integer('container_id')->unsigned();
			$t->timestamps();

			$t->foreign('device_id')->references('id')->on('devices')->onDelete('cascade');
			$t->foreign('container_id')->references('id')->on('containers')->onDelete('cascade');
		});
		Schema::create('device_admin', function($t) {
			$t->increments('id');
			$t->integer('user_id')->unsigned();
			$t->integer('device_id')->unsigned();
			$t->timestamps();

			$t->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
			$t->foreign('device_id')->references('id')->on('device_instances')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('device_admin');
		Schema::drop('device_instances');
		Schema::drop('containers');
		Schema::drop('arguments');
		Schema::drop('commands');
		Schema::drop('devices');
		Schema::drop('organization_admin');
		Schema::drop('organizations');
		Schema::drop('users');
	}

}
