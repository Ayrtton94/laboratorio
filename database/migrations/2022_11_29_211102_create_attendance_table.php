<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttendanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		if(!Schema::hasTable('attendance')){
			Schema::create('attendance', function (Blueprint $table) {
				$table->id();
				$table->unsignedBigInteger('staff_id');
				$table->date('date_of_issue')->nullable();
				$table->time('hour_start')->nullable();
				$table->time('hour_end')->nullable();
				$table->time('hour_start_1')->nullable();
				$table->time('hour_end_2')->nullable();
				$table->integer('delays_min')->nullable();
				$table->integer('ouput_min')->nullable();
				$table->integer('extra_hours')->nullable();
				$table->integer('justification_hours_cg')->nullable();
				$table->integer('justification_hours_sg')->nullable();
				$table->integer('comp_hours')->nullable();
				$table->unsignedBigInteger('schedule_id');
				$table->timestamps();

				$table->foreign('staff_id')->references('id')->on('persons');
				$table->foreign('schedule_id')->references('id')->on('schedule');
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
        Schema::dropIfExists('attendance');
    }
}
