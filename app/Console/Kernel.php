<?php

namespace App\Console;

use App\Bell;
use App\Sound;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Schema;
use DateInterval;
use DateTime;
use DB;

class Kernel extends ConsoleKernel
{
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
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        if (Schema::hasTable('bells')) {
            $soundTable = (new Sound)->getTable();
            $bellTable = (new Bell)->getTable();
            $bells = Bell::leftJoin($soundTable .' as sound1_table', 'sound1_table.id', '=', $bellTable.'.sound1_id')
                ->leftJoin($soundTable. ' as sound2_table', 'sound2_table.id', '=', $bellTable.'.sound2_id')
                ->orderBy("name", "asc")
                ->select(
                    $bellTable.'.*',
                    'sound2_table.title as sound2_title',
                    'sound2_table.file as sound2_file',
                    'sound1_table.title as sound1_title',
                    'sound1_table.file as sound1_file'
                )
                ->get();

            foreach ( $bells as $bell ) {
                $today = strtolower(date('l'));
                if($bell->{$today}) {
                    $schedule->call( function () use ( $bell ) {
                        // Turn on the switches here.
                        shell_exec('/usr/bin/python ' . base_path('scripts/gpio.py') . " {$bell->sw1} {$bell->sw2} {$bell->sw3} {$bell->sw4}");
                    } )->{$today.'s'}()->at( $bell->switch_on );

                    $schedule->call( function () use ( $bell ) {
                        $mpg321 = '/usr/bin/mpg321';
                        $cmd = $mpg321 . ' -g ' . $bell->sound1_volume . ' ' . storage_path('app/' . $bell->sound1_file);

                        if($bell->sound2_id) {
                            $cmd .= ' && ' . $mpg321 . ' -g ' . $bell->sound2_volume . ' ' . storage_path('app/' . $bell->sound2_file);
                        }

                        $cmd .= ' && /usr/bin/python ' . base_path('scripts/gpio_off.py');

                        shell_exec( $cmd );
                    } )->{$today.'s'}()->at( $bell->time );
                }
            }
        }
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
