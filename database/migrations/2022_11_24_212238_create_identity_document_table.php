<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIdentityDocumentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('identity_document', function (Blueprint $table) {
            $table->string('id',2)->index();
			$table->boolean('status');
			$table->string('description');
            $table->timestamps();
        });

		DB::table('identity_document')->insert([
			['id' => '0', 'status' => false, 'description' => 'Sin Documento'],
			['id' => '1', 'status' => true, 'description' => 'DNI'],
			['id' => '6', 'status' => true, 'description' => 'RUC']
		]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('identity_document');
    }
}
