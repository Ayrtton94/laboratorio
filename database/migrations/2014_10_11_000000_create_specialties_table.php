<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSpecialtiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('specialties', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description')->nullable();
            $table->timestamps();
        });

		DB::table('specialties')->insert([
			['id' => '1', 'name' => 'Especialidad 1', 'description' => '', 'created_at' => DB::raw('NOW()'), 'updated_at' => DB::raw('NOW()')],
			['id' => '2', 'name' => 'Especialidad 2', 'description' => '', 'created_at' => DB::raw('NOW()'), 'updated_at' => DB::raw('NOW()')]
		]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('specialties');
    }
}
