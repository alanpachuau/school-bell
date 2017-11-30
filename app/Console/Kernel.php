<?php

namespace App\Console;

use DateInterval;
use DateTime;
use DB;
use Illuminate\Console\Scheduling\Schedule;
use Laravel\Lumen\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel {
	/**
	 * The Artisan commands provided by your application.
	 *
	 * @var array
	 */
	protected $commands = [
		//
	];

	/**
	 * Define the application's command schedule.
	 *
	 * @param  \Illuminate\Console\Scheduling\Schedule $schedule
	 *
	 * @return void
	 */
	protected function schedule( Schedule $schedule ) {
		$bells = DB::table( 'bells' )->get();
		foreach ( $bells as $bell ) {
			$date     = new DateTime( $bell->time . ":00" );
			$interval = new DateInterval( 'PT' . $bell->amp_on_before . 'M' );
			$date->sub( $interval );
			$onTime   = $date->format( "H:i" );
			$interval = new DateInterval( 'PT' . ( $bell->amp_on_before + $bell->amp_off_after ) . 'M' );
			$date->add( $interval );
			$offTime = $date->format( "H:i" );

			$schedule->call( function () use ( $bell ) {
				// Turn on the Amplifier here.
				DB::table( 'mytable' )->insert( array( "text" => $bell->name . " : ON " . date( 'Y-m-d H:i:s', time() ) ) );
			} )->{$bell->day}()->at( $onTime );

			$schedule->call( function () use ( $bell ) {
				// Turn off the Amplifier here.
				DB::table( 'mytable' )->insert( array( "text" => $bell->name . " : OFF " . date( 'Y-m-d H:i:s', time() ) ) );
			} )->{$bell->day}()->at( $offTime );

			$schedule->call( function () use ( $bell ) {
				shell_exec( '/usr/local/bin/mpg321 -g 90 /Users/alanpachuau/Work/mine/school-bell/public/bubbling_water_1.mp3' );
				DB::table( 'mytable' )->insert( array( "text" => $bell->name . " : " . date( 'Y-m-d H:i:s', time() ) ) );
			} )->{$bell->day}()->at( $bell->time );
		}
		/**
		 * Alarm Conditions
		 * 1. Everyday @ H:M
		 * 2. Every mondays @ H:M
		 * 3. Every tuesdays @ H:M
		 */
//	    $schedule->call(function () {
//		    DB::table('mytable')->insert(array("text"=>date('Y-m-d H:i:s',time())));
//	    })->dailyAt('01:45');
//	    $schedule->call(function () {
//		    // Do something here
//	    	DB::table('mytable')->insert(array("text"=>date('Y-m-d H:i:s',time())));
//	    })->everyMinute();
//	    $schedule->call(function () {
//		    // Do something here
//	    	DB::table('mytable')->insert(array("text"=>"Tuesday: " . date('Y-m-d H:i:s',time())));
//	    })->daily()->tuesdays()->at("1:52");
//	    $schedule->call(function () {
//		    // Do something here
//	    	DB::table('mytable')->insert(array("text"=>"Tuesday: " . date('Y-m-d H:i:s',time())));
//	    })->tuesdays()->everyMinute();
	}
}
