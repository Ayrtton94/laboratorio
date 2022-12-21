<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderTable extends Migration
{

	public function up()
	{



		if (!Schema::hasTable('companies')) {
			Schema::create('companies', function (Blueprint $table) {
				$table->id();
				$table->string('identity_document_type_id', 2);
				$table->string('number');
				$table->string('name');
				$table->string('trade_name')->nullable();
				$table->char('soap_type_id',2)->nullable();
				$table->string('soap_username')->nullable();
				$table->string('soap_password')->nullable();
				$table->string('certificate')->nullable();
				$table->string('address')->nullable();
				$table->string('telephone')->nullable();
				$table->string('phone')->nullable();
				$table->timestamps();

				$table->foreign('identity_document_type_id')->references('id')->on('cat_identity_document_types');
				// $table->foreign('soap_type_id')->references('id')->on('soap_types');
			});
		}
		if (!Schema::hasTable('establishments')) {
			Schema::create('establishments', function (Blueprint $table) {
				$table->id();
				$table->string('description');
				$table->char('country_id', 2);
				$table->char('department_id', 2);
				$table->char('province_id', 4);
				$table->char('district_id', 6);
				$table->string('address');
				$table->string('email');
				$table->string('telephone');
				$table->string('code');
				$table->timestamps();

				$table->foreign('country_id')->references('id')->on('countries');
				$table->foreign('department_id')->references('id')->on('departments');
				$table->foreign('province_id')->references('id')->on('provinces');
				$table->foreign('district_id')->references('id')->on('districts');
			});
		}

		if (!Schema::hasTable('series')) {
			Schema::create('series', function (Blueprint $table) {
				$table->id();
				$table->unsignedBigInteger('establishment_id');
				$table->char('document_type_id',3);
				$table->string('serie');
				$table->integer('number');
				$table->tinyInteger('estado')->default(1);
				$table->timestamps();
			});
		}

		if (!Schema::hasTable('laboratorio_orders')) {
			Schema::create('laboratorio_orders', function (Blueprint $table) {
				$table->increments('id');
				$table->unsignedBigInteger('user_id')->nullable();
				$table->unsignedBigInteger('establishment_id')->nullable();
            	$table->json('establishment')->nullable();
				$table->char('state_type_id', 2)->nullable();
				$table->char('group_id', 2)->nullable();
				$table->string('document_type_id', 3)->nullable();
				$table->char('series', 4);
				$table->integer('number');
				$table->date('date_of_issue');
				$table->time('time_of_issue');
				$table->unsignedBigInteger('customer_id')->nullable();
				$table->json('customer')->nullable();
				$table->string('currency_type_id', 4)->nullable();
                $table->unsignedInteger('tporden_id')->nullable();
				$table->unsignedInteger('responsable_id')->nullable();
				$table->string('documento_referencia')->nullable();
				$table->decimal('total_value', 12, 2)->default(0);
				$table->decimal('total_igv', 12, 2)->default(0);
				$table->decimal('total', 12, 2);

				$table->json('legends')->nullable();
				$table->string('filename')->nullable();
				$table->boolean('estado')->default(1);
				$table->string('type_document_fact',3)->nullable();
				$table->tinyInteger('status_paid')->default(0);
				$table->tinyInteger('status_order')->default(0);
				$table->text('comentario')->nullable();
				$table->smallInteger('tipo')->default(1)->nullable();

				$table->timestamps();
				$table->foreign('user_id')->references('id')->on('users');
				$table->foreign('establishment_id')->references('id')->on('establishments');
				$table->foreign('customer_id')->references('id')->on('persons');
				$table->foreign('document_type_id')->references('id')->on('cat_document_types');
				$table->foreign('currency_type_id')->references('id')->on('cat_currency_types');
			});
		}

		if (!Schema::hasTable('laboratorio_order_details')) {
			Schema::create('laboratorio_order_details', function (Blueprint $table) {
					$table->increments('id');
					$table->unsignedInteger('laboratorio_order_id');
					$table->unsignedInteger('matriz_id');
					$table->unsignedInteger('muestra_id');
					$table->unsignedInteger('prueba_id');
					$table->unsignedInteger('especie_id');
					$table->unsignedInteger('subespecie_id');
					$table->unsignedInteger('presentacion_id');
					$table->decimal('quantity',10,3);
					$table->string('observacion')->nullable();
					$table->date('date_of_muestra');
					$table->date('date_of_recepcion');
					$table->date('date_of_resultado');
					$table->string('temperatura')->nullable();
					$table->decimal('unit_value', 12, 2);
					$table->decimal('unit_price', 12, 2);
					$table->decimal('total_igv', 12, 2);
					$table->decimal('total_value', 12, 2);
					$table->decimal('total', 12, 2);
					$table->json('attributes')->nullable();
					$table->boolean('estado')->default(1);

					$table->foreign('laboratorio_order_id')->references('id')->on('laboratorio_orders')->onDelete('cascade');

				});
		}

		if (!Schema::hasTable('programa_brucellas')) {
			Schema::create('programa_brucellas', function (Blueprint $table) {
				$table->id();
				$table->unsignedBigInteger('muestra_id');
				$table->string('ruta');
				$table->unsignedBigInteger('supplier_id');
				$table->decimal('peso',10,2);
				$table->decimal('parcela',10,2);
                $table->decimal('v_produccion',10,2);
				$table->decimal('t_hato',10,2);
				$table->tinyInteger('accion')->default(0);
				$table->tinyInteger('asignar_modulo');
				$table->timestamps();
			});
		}
	}

	public function down()
	{

		Schema::dropIfExists('companies');
		Schema::dropIfExists('establishments');
		Schema::dropIfExists('laboratorio_orders');
		Schema::dropIfExists('laboratorio_order_details');
		Schema::dropIfExists('programa_brucellas');
	}
}
