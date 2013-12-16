<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateParticipantsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('participants', function(Blueprint $table) {
			$table->increments('id');
			$table->string('network_id')->nullable();
			$table->string('fullname')->nullable();
			$table->string('username')->nullable();
			$table->string('email')->nullable();
			$table->text('address')->nullable();
			$table->string('city')->nullable();
			$table->string ('phone')->nullable();
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
		Schema::drop('participants');
	}

}
