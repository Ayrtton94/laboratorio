<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerBrucelasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_brucelas', function (Blueprint $table) {
            $table->id();
            $table->string('identity_document_id', 2);
			$table->string('number');
            $table->string('name');
            
            $table->string('address')->nullable();
            $table->char('country_id', 2)->nullable();
			$table->char('department_id', 2)->nullable();
            $table->char('province_id', 4)->nullable();
            $table->char('district_id', 6)->nullable();
           
            $table->string('email')->nullable();
            $table->string('telephone')->nullable();
            $table->boolean('status')->default(1);
            $table->boolean('customer_brucelas')->default(0);

            $table->string('code_porongo')->nullable();
            $table->string('route')->nullable();
            $table->string('companies')->nullable();
            $table->string('tipo')->nullable();
            

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('identity_document_id')->references('id')->on('identity_document');
			$table->foreign('country_id')->references('id')->on('countries');
            $table->foreign('department_id')->references('id')->on('departments');
            $table->foreign('province_id')->references('id')->on('provinces');
            $table->foreign('district_id')->references('id')->on('districts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_brucelas');
    }
}
