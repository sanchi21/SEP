<?php namespace App\Console;

use App\Hardware;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\SystemUser;
use Illuminate\Support\Facades\Mail;

class Kernel extends ConsoleKernel {

	/**
	 * The Artisan commands provided by your application.
	 *
	 * @var array
	 */
	protected $commands = [
		'App\Console\Commands\Inspire',
	];

	/**
	 * Define the application's command schedule.
	 *
	 * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
	 * @return void
	 */
	protected function schedule(Schedule $schedule)
	{
		$schedule->command('inspire')
				 ->hourly();

        $schedule->call(function () {
            $date = date('Y-m-d H:i:s');
            $hardware = Hardware::find('CMB/CDV/0001');
            $hardware->description = 'NOW Updated'.$date;
            $hardware->save();

            $requests = DB::table('requesths')->get();

            foreach($requests as $request)
            {
                $today = strtotime("+7 day");
                $w_date = date('Y-m-d',$today);
                $release = DB::table('reqs')->where('required_upto', $w_date)->where('request_id',$request->request_id)->get();

                if($release) {
                    $user_d = SystemUser::where('id', $request->user_id)->get();
                    $user_data = $user_d[0];
                    $user = $user_data->username;
                    $email = $user_data->email;

                    Mail::send('emails.releaseReminder', array('user' => $user,
                        'prCode' => $request->project_id, 'items' => $release, 'dt' => $w_date), function ($messsage) use ($user, $email) {
                        $messsage->to($email, $user)->subject('Resource Release Reminder');
                    });
                }
            }
        })->everyFiveMinutes();
	}

}
