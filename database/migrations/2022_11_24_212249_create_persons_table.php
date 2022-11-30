<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('persons', function (Blueprint $table) {
            $table->id();
			$table->enum('type', ['customers', 'suppliers', 'staff']);
            $table->string('identity_document_id', 2);
			$table->string('number');
            $table->string('name');
			$table->string('ap_lastname')->nullable();
			$table->string('am_lastname')->nullable();
			$table->char('country_id', 2)->nullable();
			$table->char('department_id', 2)->nullable();
            $table->char('province_id', 4)->nullable();
            $table->char('district_id', 6)->nullable();
            $table->string('address')->nullable();
			$table->string('reference_address')->nullable();
            $table->string('email')->nullable();
            $table->string('telephone')->nullable();
			$table->string('additional_phone')->nullable();
			$table->boolean('sexo')->default(1);
			$table->string('imagen')->nullable();
			$table->string('path_imagen')->nullable();
			$table->string('signature')->nullable();
			$table->boolean('status')->default(1);
			$table->boolean('user_account')->default(0);
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
        Schema::dropIfExists('persons');
    }
}