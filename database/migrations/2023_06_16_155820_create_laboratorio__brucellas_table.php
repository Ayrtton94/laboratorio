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
            $table->string('compani_id')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('laboratorio_detalles_brucellas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('brucellas_id'); 
            $table->string('temperatura')->nullable(); 
            $table->date('date_of_muestra');
			$table->date('date_of_recepcion');
		    $table->date('date_of_resultado');
            $table->string('observacion')->nullable();         
            $table->softDeletes();
            $table->timestamps();
        
            // Clave foránea a la tabla de guides
            $table->foreign('brucellas_id')
                  ->references('id')
                  ->on('laboratorio_brucellas')
                  ->onDelete('cascade');
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
