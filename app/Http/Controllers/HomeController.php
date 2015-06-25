<?php namespace App\Http\Controllers;
use App\User;
use App\system_users;
use DB;
use  App\Hardware;
use App\requesth;
use App\Type;
use Auth;
use adLDAP\adLDAP;


class HomeController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Home Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders your application's "dashboard" for users that
	| are authenticated. Of course, you are free to change or remove the
	| controller as you wish. It is just here to get your app started!
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		return view('home');
	}
    public function getHomeAdminFull()
    {






        //count pending resource requests
        $count_pendingResourceRequests = DB::table('reqs')->where('status', 'Not Allocated')->count();

        //count total available resources
        $count_totalHardwareResources = DB::table('hardware')->count();                                                 //count total hardwares
        $count_totalSoftwareResources =  DB::table('software')->count();                                                //count total softwares
        $count_allocatedHardwares = DB::table('reqs')->where('status', 'Allocated')->whereNotNull('item')->count();     //count allocated softwares
        $count_availableHardware = $count_totalHardwareResources-$count_allocatedHardwares;                             //count available hardwares
        $count_pendingHardwares = DB::table('reqs')->where('status', 'Not Allocated')->whereNotNull('item')->count();   //count pending hardwares requests
        $count_allocatedSoftwares = DB::table('reqs')->where('status', 'Allocated')->whereNull('item')->count();        //count allocated softwares
        $count_availableSoftware = $count_totalSoftwareResources-$count_allocatedSoftwares;                             //count available softwares
        $count_pendingSoftwares = DB::table('reqs')->where('status', 'Not Allocated')->whereNull('item')->count();      //count pending softwares requests
        $count_totalResources = $count_totalHardwareResources+$count_totalSoftwareResources;                            //count total resources
        $count_allocatedResourceRequests = DB::table('reqs')->where('status', 'Allocated')->count();                    //count allocated resources
        $count_totalAvailableResources = $count_totalResources - $count_allocatedResourceRequests;                      //count available resources



        //count total users
        $count_systemUsers = DB::table('system_users')->count();

        //count total pending renewal requests
        $count_pendingRenewalRequests = DB::table('renewal')->where('status', '0')->count();

        //get recent requests
        $recentRequests = DB::table('reqs')
            ->join('requesths', 'reqs.request_id','=', 'requesths.request_id')
            ->join('system_users', 'requesths.user_id','=', 'system_users.id')
            ->select('requesths.request_id', 'requesths.user_id','reqs.required_upto','reqs.assigned_date','reqs.required_from','requesths.project_id','reqs.item','reqs.device_type','system_users.username')->where('reqs.status','=','Not Allocated')
            ->get();

        //access hardware table
        $types = Hardware::select('type')->groupBy('type')->get();

        $count = Hardware::select('type',DB::raw('count(*) as count'))->groupBy('type')->get();

        //last logon
        $lastLogonUsers = DB::table('system_users')->orderBy('updated_at','desc')->take(5)->get();

        //current user
//        $currentUser = DB::table('system_users')->where('username','=',Auth::User()->username)->get();





        return view('home',compact('data')) ->with('countPendingResourceRequests',$count_pendingResourceRequests)
                            ->with('countTotalAvailableResources',$count_totalAvailableResources)
                            ->with('countSystemUsers',$count_systemUsers)
                            ->with('countPendingRenewalRequests',$count_pendingRenewalRequests)
                            ->with('countTotalHardware',$count_totalHardwareResources)
                            ->with('countTotalSoftware',$count_totalSoftwareResources)
                            ->with('countAllocatedSoftware',$count_allocatedSoftwares)
                            ->with('countAvailableSoftware',$count_availableSoftware)
                            ->with('countPendingSoftwares',$count_pendingSoftwares)
                            ->with('countAllocatedHardware',$count_allocatedHardwares)
                            ->with('countAvailableHardware',$count_availableHardware)
                            ->with('countPendingHardwares',$count_pendingHardwares)
                            ->with('recentRequests',$recentRequests)
                            ->with('types',$count->lists('type'))
                            ->with('lastLogonUsers',$lastLogonUsers)
//                            ->with('currentUser',$currentUser)
                            ->with('count',$count->lists('count'));
//                            ->with('count',$count->lists('count'));




    }
    public function getHomeProjectManager()
    {
        $userid = 8; //change to auth user id

        $requests = DB::table('reqs')
            ->join('requesths', 'reqs.request_id','=', 'requesths.request_id')
            ->select('requesths.request_id', 'requesths.user_id','reqs.required_upto','reqs.required_from','requesths.project_id','reqs.item','reqs.device_type')->where('user_id','=',$userid)->where('reqs.status','=','Allocated')
            ->get();

        $count_pendingRequests  = DB::table('reqs')                  //count pending requests
            ->join('requesths', 'reqs.request_id','=', 'requesths.request_id')
            ->select('requesths.request_id', 'requesths.user_id','requesths.project_id','reqs.status')->where('user_id','=',$userid)->where('reqs.status','=','Not Allocated')
            ->count();

        $count_acceptedRequests  = DB::table('reqs')                  //count accepted requests
            ->join('requesths', 'reqs.request_id','=', 'requesths.request_id')
            ->select('requesths.request_id', 'requesths.user_id','requesths.project_id','reqs.status')->where('user_id','=',$userid)->where('reqs.status','=','Allocated')
            ->count();

        $count_pendingRenewal  = DB::table('renewal')                  //count pending renewal
            ->join('requesths', 'renewal.id','=', 'requesths.request_id')
            ->select('requesths.request_id', 'requesths.user_id','renewal.status')->where('user_id','=',$userid)->where('renewal.status','=',0)
            ->count();

        $count_acceptedRenewal  = DB::table('renewal')                  //count accepted renewal
        ->join('requesths', 'renewal.id','=', 'requesths.request_id')
            ->select('requesths.request_id', 'requesths.user_id','renewal.status')->where('user_id','=',$userid)->where('renewal.status','=',1)
            ->count();

                     //count accepted renewal

        $hardware = hardware::select('type')->groupBy('type')->count();

        $count_enrolledProjects = requesth::select('project_id','user_id')->groupBy('project_id')->distinct()->where('user_id','=',$userid)->count();

        return view('home-projectManager')  ->with('requests',$requests)
                                            ->with('countPendingResourceRequests',$count_pendingRequests)
                                            ->with('countAcceptedRequests',$count_acceptedRequests)
                                            ->with('countPendingRenewal',$count_pendingRenewal)
                                            ->with('countAcceptedRenewal',$count_acceptedRenewal)
                                            ->with('countEnrolledProjects',$hardware);

    }
    public function getHomeAdminLimited()
    {
        return view('home-adminLimit');
    }
    public function getAccessPermissionDenied()
    {
        return view('authentication.accessPermissionDenied');
    }

}
