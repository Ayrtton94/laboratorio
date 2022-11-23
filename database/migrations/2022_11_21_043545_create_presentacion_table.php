<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePresentacionTable extends Migration
{

	public function up()
	{
		if (!Schema::hasTable('presentaciones')) {
			Schema::create('presentaciones', function (Blueprint $table) {
				$table->id();
				$table->string('description');
				$table->tinyInteger('estado')->default(1);
				$table->timestamps();
			});
		}

		if (!Schema::hasTable('especies')) {
			Schema::create('especies', function (Blueprint $table) {
				$table->id();
				$table->string('description');
				$table->tinyInteger('estado')->default(1);
				$table->timestamps();
			});
		}

		if (!Schema::hasTable('subespecies')) {
			Schema::create('subespecies', function (Blueprint $table) {
				$table->id();
				$table->unsignedBigInteger('especie_id');
				$table->string('description');
				$table->tinyInteger('estado')->default(1);
				$table->timestamps();
				$table->foreign('especie_id')->references('id')->on('especies');
			});
		}

		if (!Schema::hasTable('matrices')) {
			Schema::create('matrices', function (Blueprint $table) {
				$table->id();
				$table->string('description');
				$table->tinyInteger('estado')->default(1);
				$table->timestamps();
			});
		}

		if (!Schema::hasTable('muestras')) {
			Schema::create('muestras', function (Blueprint $table) {
				$table->id();
				$table->unsignedBigInteger('matriz_id');
				$table->string('description');
				$table->tinyInteger('estado')->default(1);
				$table->timestamps();
				$table->foreign('matriz_id')->references('id')->on('matrices');
			});
		}

		if (!Schema::hasTable('laboratorios')) {
			Schema::create('laboratorios', function (Blueprint $table) {
				$table->id();
				$table->string('name');
				$table->string('description');
				$table->tinyInteger('estado')->default(1);
				$table->timestamps();
			});
		}

		if (!Schema::hasTable('metodos')) {
			Schema::create('metodos', function (Blueprint $table) {
				$table->id();
				$table->string('name');
				$table->string('description');
				$table->tinyInteger('estado')->default(1);
				$table->timestamps();
			});
		}

		if (!Schema::hasTable('pruebas')) {
			Schema::create('pruebas', function (Blueprint $table) {
				$table->id();
				$table->unsignedBigInteger('muestra_id');
				$table->unsignedBigInteger('matriz_id');
				$table->string('name')->nullable();
				$table->decimal('price',10,2)->nullable();
				$table->unsignedBigInteger('laboratorio_id')->nullable();
				$table->unsignedBigInteger('metodo_id')->nullable();
				$table->string('condicion')->nullable();
				$table->string('time_entrega')->nullable();
				$table->tinyInteger('estado')->default(1);
				$table->timestamps();
				$table->foreign('muestra_id')->references('id')->on('muestras');
				$table->foreign('matriz_id')->references('id')->on('matrices');
				$table->foreign('laboratorio_id')->references('id')->on('laboratorios');
				$table->foreign('metodo_id')->references('id')->on('metodos');
			});
		}
	}

	public function down()
	{
		Schema::dropIfExists('presentaciones');
		Schema::dropIfExists('especies');
		Schema::dropIfExists('subespecies');
		Schema::dropIfExists('matrices');
		Schema::dropIfExists('muestras');
		Schema::dropIfExists('laboratorios');
		Schema::dropIfExists('metodos');
		Schema::dropIfExists('pruebas');
	}
}
