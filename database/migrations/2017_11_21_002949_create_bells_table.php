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
            $table->integer('sound1_id')->default(0);
            $table->integer('sound1_volume')->default(90);
            $table->integer('sound2_id')->nullable()->default(0);
            $table->integer('sound2_volume')->nullable()->default(90);
            $table->boolean('monday')->default(false);
            $table->boolean('tuesday')->default(false);
            $table->boolean('wednesday')->default(false);
            $table->boolean('thursday')->default(false);
            $table->boolean('friday')->default(false);
            $table->boolean('saturday')->default(false);
            $table->boolean('sunday')->default(false);
            $table->string('time'); // 11:00, 23:59
            $table->string('switch_on'); // turn on active switches X minutes before sound play begins
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
