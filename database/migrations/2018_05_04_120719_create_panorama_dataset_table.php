<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePanoramaDatasetTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('panorama_dataset', function(Blueprint $table)
		{
			$table->integer('dataset_id', true);
			$table->string('name');
			$table->integer('stats_type_id_FK');
			$table->text('description', 65535)->nullable();
			$table->date('date_begin')->nullable();
			$table->date('date_end')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('panorama_dataset');
	}

}
