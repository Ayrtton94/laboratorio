<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLaboratorioBrucellasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('laboratorio_brucellas', function (Blueprint $table) {
            $table->id();
            $table->string('series_id')->nullable();
            $table->string('date_of_issue')->nullable();
            $table->string('customer_id')->nullable();
            $table->string('responsable_id')->nullable();
            $table->string('referencia')->nullable();
            $table->string('temperatura')->nullable(); 
            $table->date('date_of_muestra')->nullable();
			$table->date('date_of_recepcion')->nullable();
		    $table->date('date_of_resultado')->nullable();
            $table->string('observacion')->nullable();
            $table->boolean('status')->default(1);   
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('laboratorio_detalles_brucellas', function (Blueprint $table) {
            $table->id();  
            $table->string('laboratorio_brucellas_id');  
            $table->string('ruta')->nullable();
            $table->string('codigo')->nullable();
            $table->string('nombre')->nullable();
            $table->string('peso')->nullable();
            $table->string('v_prodccion')->nullable();
            $table->string('t_hato')->nullable();   
            $table->string('estado')->nullable();
            $table->string('dato1')->nullable();
            $table->string('dato2')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('laboratorio_brucellas');
        Schema::dropIfExists('laboratorio_detalles_brucellas');
    }
}
