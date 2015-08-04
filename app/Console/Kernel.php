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

            $this->releaseReminder();
            $this->releaseResource();

        })->everyFiveMinutes();
	}

    private function releaseReminder()
    {
//        $date = date('Y-m-d H:i:s');
//        $hardware = Hardware::find('CMB/CDV/0001');
//        $hardware->description = 'NOW Updated'.$date;
//        $hardware->save();

        try {
            $requests = DB::table('requesths')->get();

            foreach ($requests as $request) {
                $today = strtotime("+7 day");
                $w_date = date('Y-m-d', $today);
                $release_date = date('Y-m-d', strtotime("+1 day"));
                $release = DB::table('reqs')->where('required_upto', $w_date)->where('request_id', $request->request_id)->get();

                if ($release) {
                    $user_data = SystemUser::where('id', $request->user_id)->get()->first();
//                    $user_data = $user_d[0];
                    $user = $user_data->username;
                    $email = $user_data->email;

                    Mail::send('emails.releaseReminder', array('user' => $user,
                        'prCode' => $request->project_id, 'items' => $release, 'dt' => $release_date), function ($messsage) use ($user, $email) {
                        $messsage->to($email, $user)->subject('Resource Release Reminder');
                    });
                }
            }
        }
        catch(\Exception $e)
        {

        }
    }

    private function releaseResource()
    {
        try
        {
            $requests = DB::table('requesths')->get();

            foreach ($requests as $request)
            {
                $today = strtotime("-1 days");
                $release_date = date('Y-m-d', $today);
                $release_records = DB::table('reqs')->where('required_upto', $release_date)->where('request_id', $request->request_id)->get();
                $resource = array();

                if ($release_records)
                {
                    foreach ($release_records as $release_record)
                    {
                        if ($release_record->renewal == 1)
                        {
                            $renewal_record = DB::table('renewal')->where('req_upto', $release_date)->where('id', $request->request_id)->where('sid', $release_record->sub_id)->get();
                            if (is_null($renewal_record))
                            {
                                continue;
                            }
                        }

                        $data = array();
                        DB::beginTransaction();
                        $hardware = Hardware::find($release_record->inventory_code);
                        $hardware->status = "Not Allocated";
                        $status = $hardware->save() ? true: false;

                        if($status)
                        {
                            $status = DB::table('reqs')->where('request_id', $release_record->request_id)
                                ->where('sub_id',$release_record->sub_id)
                                ->update(array('status'=>"Cleared",'renewal'=>0));
                        }

                        if($status)
                        {
                            DB::commit();
                            $data = array_add($data,'inventory_code',$release_record->inventory_code);
                            $data = array_add($data,'type',$release_record->item);
                            array_push($resource,$data);
                        }
                        else
                            DB::rollback();
                    }
                    $user_data = SystemUser::where('id', $request->user_id)->get()->first();
//                    $user_data = $user_d[0];
                    $user = $user_data->username;
                    $email = $user_data->email;

                    Mail::send('emails.releaseResource', array('user' => $user,
                        'prCode' => $request->project_id, 'items' => $resource, 'dt' => date('Y-m-d')), function ($messsage) use ($user, $email) {
                        $messsage->to($email, $user)->subject('Resource Release');
                    });
                }
            }
        }
        catch(\Exception $e)
        {

        }
    }

}
