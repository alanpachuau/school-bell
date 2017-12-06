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
            $table->integer('sound1_id');
            $table->integer('sound2_id');
            $table->string('day'); // monday, sunday, tuesday, ...
            $table->string('time'); // 11:00, 23:59
            $table->integer('switch_on_before'); // turn on active switches X minutes before sound play begins
	        $table->integer('switch_off_after'); // turn off switches X minutes after sound play finish
	        $table->boolean('sw1')->default(false); // switch 1
	        $table->boolean('sw2')->default(false); // switch 2
	        $table->boolean('sw3')->default(false); // switch 3
	        $table->boolean('sw4')->default(false); // switch 4
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
