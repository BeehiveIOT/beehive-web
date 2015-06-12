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
			$t->string('picture_url')->default('user.png');
			$t->string('remember_token')->nullable();
			$t->string('country');
			$t->string('website')->nullable();
			$t->string('organization')->nullable();
			$t->timestamps();
		});
		Schema::create('templates', function($t) {
			$t->increments('id');
			$t->string('name');
			$t->string('description')->nullable()->default("");
			$t->integer('user_id')->unsigned();
			$t->timestamps();

			$t->foreign('user_id')
				->references('id')->on('users')->onDelete('cascade');
		});
		Schema::create('commands', function($t) {
			$t->increments('id');
			$t->string('name');
			$t->string('short_cmd');
			$t->string('cmd_type');
			$t->integer('template_id')->unsigned();
			$t->timestamps();

			$t->foreign('template_id')
				->references('id')->on('templates')->onDelete('cascade');
		});
		Schema::create('arguments', function($t) {
			$t->increments('id');
			$t->string('name');
			$t->string('type');
			$t->string('default')->nullable();
			$t->decimal('minimum', 5, 2)->nullable();
			$t->decimal('maximum', 5, 2)->nullable();
			$t->integer('command_id')->unsigned();
			$t->timestamps();

			$t->foreign('command_id')
				->references('id')->on('commands')->onDelete('cascade');
		});
		Schema::create('devices', function($t) {
			$t->increments('id');
			$t->string('serial_number');
			$t->string('device_secret');
			$t->string('pub_key');
			$t->string('sub_key');
			$t->string('name');
			$t->string('description');
			$t->boolean('is_public');
			$t->integer('template_id')->unsigned()->nullable();
			$t->timestamps();

			$t->foreign('template_id')
				->references('id')->on('templates')->onDelete('set null');
		});
		Schema::create('device_admin', function($t) {
			$t->increments('id');
			$t->boolean('can_read');
			$t->boolean('can_edit');
			$t->boolean('can_execute');
			$t->boolean('owner');
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
		Schema::drop('arguments');
		Schema::drop('commands');
		Schema::drop('templates');
		Schema::drop('users');
	}
}
