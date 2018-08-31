<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePanoramaAuthorTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('panorama_author', function(Blueprint $table)
		{
			$table->integer('id_author', true);
			$table->integer('id_bnf')->nullable();
			$table->string('id_wikidata', 50)->nullable();
			$table->string('gender', 50)->nullable();
			$table->string('pseudonym');
			$table->string('first_name')->nullable();
			$table->string('last_name')->nullable();
			$table->string('date_of_birth', 5)->nullable();
			$table->string('date_of_death', 5)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('panorama_author');
	}

}
