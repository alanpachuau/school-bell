<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBellsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bells', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('sound');
            $table->string('day'); // Every day, every mondays, every sundays etc.
            $table->string('time'); // 11:00, 23:59
	        $table->integer('amp_off_after'); // turn off amp, X minutes after sound play finish
	        $table->integer('amp_on_before'); // turn on amp, X minutes before sound play begins
	        $table->boolean('light1_on')->default(false); // turn on light 1
	        $table->boolean('light2_on')->default(false); // turn on light 2
	        $table->boolean('light3_on')->default(false); // turn on light 3
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
        Schema::dropIfExists('bells');
    }
}
