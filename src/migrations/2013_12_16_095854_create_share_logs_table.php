<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateShareLogsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('share_logs', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('participant_id')->default(0);
			$table->integer('video_id')->nullable();
			$table->string('type')->nullable();
			$table->string('ip')->nullable();
			$table->text('detail')->nullable();
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
		Schema::drop('share_logs');
	}

}
