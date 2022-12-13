<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScheduleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		if(!Schema::hasTable('schedule')){
			Schema::create('schedule', function (Blueprint $table) {
				$table->id();
				$table->string('description')->nullable();
				$table->time('hour_start')->nullable();
				$table->time('hour_end')->nullable();
				$table->boolean('status')->default(1);
				$table->timestamps();
			});
		}
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('schedule');
    }
}
