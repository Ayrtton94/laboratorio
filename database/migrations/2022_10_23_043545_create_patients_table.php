<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientsTable extends Migration
{

	public function up()
	{
		Schema::create('patients', function (Blueprint $table) {
			$table->id();
			$table->string('name');
			$table->string('codigo_historial_clinico');
			$table->string('last_name');
			$table->integer('document');
			$table->string('sexo');
			$table->date('birth_date')->nullable();
			$table->string('lugar_nacimiento');
			$table->string('ocupacion');
			$table->string('email');
			$table->integer('phone');
			$table->string('address');
			$table->string('imagen')->nullable();
			$table->string('path_image')->nullable();
			$table->char('country_id', 2);
			$table->char('department_id', 2);
			$table->char('province_id', 4)->nullable();
			$table->char('district_id', 6)->nullable();
			$table->tinyInteger('estado')->default(1);
			$table->timestamps();

			$table->foreign('country_id')->references('id')->on('countries');
			$table->foreign('department_id')->references('id')->on('departments');
			$table->foreign('province_id')->references('id')->on('provinces');
			$table->foreign('district_id')->references('id')->on('districts');
		});
	}

	public function down()
	{
		Schema::dropIfExists('patients');
	}
}
