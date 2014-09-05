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
		Schema::create('countries', function($t) {
			$t->string('code')->primary();
			$t->string('name');
			$t->timestamps();
		});
		Schema::create('users', function($t) {
			$t->increments('id');
			$t->string('name');
			$t->string('username')->unique();
			$t->string('email')->unique();
			$t->string('password');
			$t->string('country');
			$t->string('organization')->nullable();
			$t->string('website')->nullable();
			$t->string('picture_url')->default('user.png');
			$t->string('remember_token')->nullable();
			$t->timestamps();
		});
		Schema::create('templates', function($t) {
			$t->increments('id');
			$t->string('name');
			$t->string('description');
			$t->integer('user_id')->unsigned();
			$t->timestamps();

			$t->foreign('user_id')
				->references('id')->on('users')->onDelete('set null');
		});
		Schema::create('commands', function($t) {
			$t->increments('id');
			$t->string('name');
			$t->string('description')->default('');
			$t->string('short_cmd');
			$t->string('cmd_type');
			$t->string('argument_name');
			$t->string('argument_type');
			$t->string('argument_control');
			$t->integer('argument_min');
			$t->integer('argument_max');
			$t->integer('template_id')->unsigned();
			$t->timestamps();

			$t->foreign('template_id')
				->references('id')->on('templates')->onDelete('cascade');
		});
		Schema::create('devices', function($t) {
			$t->increments('id');
			$t->string('uuid');
			$t->string('device_secret');
			$t->string('name');
			$t->boolean('public');
			$t->integer('template_id')->nullable();
			$t->timestamps();

			$t->foreign('template_id')
				->references('id')->on('template')->onDelete('set null');
		});
		Schema::create('device_admin', function($t) {
			$t->increments('id');
			$t->integer('user_id')->unsigned();
			$t->integer('device_id')->unsigned();
			$t->timestamps();

			$t->foreign('user_id')
				->references('id')->on('users')->onDelete('cascade');
			$t->foreign('device_id')
				->references('id')->on('devices')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('countries');
		Schema::drop('device_admin');
		Schema::drop('devices');
		Schema::drop('commands');
		Schema::drop('templates');
		Schema::drop('users');
	}
}
