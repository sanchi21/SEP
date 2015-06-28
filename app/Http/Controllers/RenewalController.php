<?php namespace App\Http\Controllers;

use App\Hardware;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\req;
use App\User;
use Illuminate\Support\Facades\Redirect;
use Input;
use App\ServiceProvider;
use Illuminate\Support\Facades\DB;

use Request;
use App\Renewal;
use App\EmployeeAllocation;
use Illuminate\Support\Facades\Mail;

class RenewalController extends Controller {



    public function great()

    {
        echo 'hello';

    }


	public function index()
	{
		//$hold = DB::table('reqs')->where('status',0)->where('renewal', 0)->get();

        //$requests = DB::table('renewal')->where('status',0)->get();

        $hold = DB::table('reqs')
            ->join('requesths', 'reqs.request_id', '=', 'requesths.request_id')
            ->select( 'requesths.project_id','reqs.item','reqs.device_type','reqs.request_id'
                    ,'reqs.sub_id', 'reqs.assigned_date', 'reqs.required_upto','reqs.status','reqs.renewal')
            ->where('reqs.status',"Allocated")->where('reqs.renewal',0)->get();

        $requests = DB::table('renewal')
        ->join('reqs', 'renewal.id', '=', 'reqs.request_id')
        ->join('requesths', 'reqs.request_id', '=', 'requesths.request_id')
        ->select('renewal.id', 'renewal.sid', 'renewal.name','renewal.req_upto','requesths.project_id')
        ->where('renewal.status', 0)->groupBy('renewal.name')
        ->get();

        $prCode = DB::table('versions')->get();


        return view('pages.renew')->with('allocated',$hold )
                                ->with('requests', $requests)
                                ->with('prCode', $prCode);

	}

    public function searchResource()
    {
        $input = Request::all();

       // $name = $input['resourceName'];
        //$prCode2 = $input['prCode'];

        $prCode = DB::table('reqs')
            ->join('requesths', 'reqs.request_id', '=', 'requesths.request_id')
            ->select('requesths.project_id')->groupBy('requesths.project_id')->get();

        $prCode = DB::table('versions')->get();

        $hold = DB::table('reqs')
            ->join('requesths', 'reqs.request_id', '=', 'requesths.request_id')
            ->select( 'requesths.project_id','reqs.item','reqs.device_type','reqs.request_id'
                ,'reqs.sub_id', 'reqs.assigned_date', 'reqs.required_upto','reqs.status','reqs.renewal')
            ->where('reqs.status',"Allocated")
            ->where('reqs.renewal',0)
            ->where(function($query)
            {
                $input = Request::all();

                $name = $input['resourceName'];

                $query->where('reqs.item','LIKE', '%'.$name.'%')
                    ->orWhere('requesths.project_id','LIKE', '%'.$name.'%')
                    ->orWhere('reqs.device_type', 'LIKE', '%'.$name.'%');
            })
            ->get();


        $requests = DB::table('renewal')
            ->join('reqs', 'renewal.id', '=', 'reqs.request_id')
            ->join('requesths', 'reqs.request_id', '=', 'requesths.request_id')
            ->select('renewal.id', 'renewal.sid', 'renewal.name','renewal.req_upto','requesths.project_id')
            ->where('renewal.status', 0)->groupBy('renewal.name')
            ->get();

        return view('pages.renew')->with('allocated',$hold )
            ->with('requests', $requests)
            ->with('prCode', $prCode);


    }

    public function cancelRequest()
    {

        $input = Request::all();
        $id = $input['reqID'];
        $sid = $input['SubID'];

        $status1 = DB::table('reqs')->where('request_id', $id)
            ->where('sub_id',$sid)
            ->update(array('renewal'=>0));

        $status2 = DB::table('renewal')->where('id', $id)->where('sid',$sid)->delete();

        if($status1 && $status2)
            \Session::flash('flash_message','Renewal request cancelled');
        else
            \Session::flash('flash_message_error','Renewal request failed to cancel');

        return Redirect::action('RenewalController@index');

    }

    public function adminView()
    {

//        $requests = DB::table('renewal')
//            ->join('reqs', 'renewal.id', '=', 'reqs.request_id')
//            ->join('requesths', 'reqs.request_id', '=', 'requesths.request_id')
//            ->select('renewal.id', 'renewal.sid', 'renewal.name','renewal.req_upto','requesths.project_id')
//            ->where('renewal.status', 0)->groupBy('renewal.name')
//            ->get();

        $requests = DB::table('renewal')
            ->join('reqs', 'renewal.id', '=', 'reqs.request_id')
            ->join('requesths', 'reqs.request_id', '=', 'requesths.request_id')
            ->select('renewal.id', 'renewal.sid', 'renewal.name','renewal.req_upto','requesths.project_id','reqs.required_upto')
            ->where('renewal.status', 0)->groupBy('renewal.name')
            ->get();

//        $requests = DB::table('renewal')
//            ->join('requesths', 'renewal.id', '=', 'requesths.request_id')->where('renewal.sid')
//            ->select('renewal.id', 'renewal.sid', 'renewal.name','renewal.req_upto','requesths.project_id','requesths.required_upto' )
//            ->where('renewal.status',0)->groupBy('renewal.name')->get();


        return view('pages.acceptRequest')->with('requests',$requests);

    }

    public function adminAccept()
    {
        $input = Request::all();
        $reject = Input::get('reject');

        $date= $input['req_upto'];
        $id = $input['reqID'];
        $sid = $input['SubID'];

        try {
            if ($reject!="Reject") //Accept button has been clicked
            {
                $status1 = DB::table('reqs')->where('request_id', $id)
                    ->where('sub_id',$sid)
                    ->update(array('renewal'=>0, 'required_upto'=>$date));

                $status2 = DB::table('renewal')->where('id', $id)
                    ->where('sid',$sid)
                    ->update(array('status'=>1));

                $prCode = DB::table('requesths')->where('request_id', $id)->first();

                $item = DB::table('reqs')->where('request_id', $id)
                    ->where('sub_id',$sid)->first();

                $code = DB::table('reqs')->where('request_id', $id)
                    ->where('sub_id',$sid)->first();

                if($status1 && $status2)
                {
                    $user_id = DB::table('requesths')->where('request_id',$id)->pluck('user_id');
                    $user = DB::table('system_users')->where('id', $user_id)->pluck('username');
                    $email = DB::table('system_users')->where('id', $user_id)->pluck('email');




                    Mail::send('emails.acceptRenewal', array('user'=>$user,
                        'prCode'=>$prCode->project_id,'item'=>$item->item, 'inventory'=>$code->inventory_code),function($messsage) use ($user,$email)
                    {
                        $messsage->to($email,$user)->subject('Renewal Accepted');
                    });

                    \Session::flash('flash_message','Renewal Accepted');
                }


                else
                {


                    \Session::flash('flash_message_error','Failed to accept');
                }


                return Redirect::action('RenewalController@adminView');

            }
            else
            {

                $status1 = DB::table('reqs')->where('request_id', $id)
                    ->where('sub_id',$sid)
                    ->update(array('renewal'=>0));

                $prCode = DB::table('requesths')->where('request_id', $id)->first();

                $item = DB::table('reqs')->where('request_id', $id)
                    ->where('sub_id',$sid)->first();

                $code = DB::table('reqs')->where('request_id', $id)
                    ->where('sub_id',$sid)->first();


                $status2 = DB::table('renewal')->where('id', $id)->where('sid',$sid)->delete();

                if($status1 && $status2){

                    $user_id = DB::table('requesths')->where('request_id',$id)->pluck('user_id');
                    $user = DB::table('system_users')->where('id', $user_id)->pluck('username');
                    $email = DB::table('system_users')->where('id', $user_id)->pluck('email');

                    Mail::send('emails.rejectRenewal', array('user'=>'srinithy',
                        'prCode'=>$prCode->project_id,'item'=>$item->item, 'inventory'=>$code->inventory_code),function($messsage)use ($user,$email)
                    {
                        $messsage->to($email,$user)->subject('Renewal Rejected');
                    });

                    \Session::flash('flash_message','Renewal Rejected');
                }

                else
                    \Session::flash('flash_message_error','Failed to reject renewal');

                return Redirect::action('RenewalController@adminView');

            }


        }
        catch(\Exception $e)
        {
            return Redirect::back()->withErrors($e->getMessage());
        }

    }

    public function requestRenewal(Requests\RenewalRequest $request)

    {

        $input = Request::all();

        $id = $input['rid'];
        $sid = $input['sid'];
        $renewal_date = $input['req_upto'];
        $name = $input['name'];

        $renew = new Renewal();

        try {
            $renew->id = $id;
            $renew->sid = $sid;
            $renew->req_upto = $renewal_date;
            $renew->name = $name;

            $renew->status = 0;


            $status1 = DB::table('reqs')->where('request_id', $id)
                ->where('sub_id',$sid)
                ->update(array('renewal'=>1));

            $prCode = DB::table('requesths')->where('request_id', $id)->first();

            $item = DB::table('reqs')->where('request_id', $id)
                ->where('sub_id',$sid)->first();

            $code = DB::table('reqs')->where('request_id', $id)
                ->where('sub_id',$sid)->first();

            $status = $renew->save() ? true : false;




            if($status && $status1)
            {
                $user_id = DB::table('requesths')->where('request_id',$id)->pluck('user_id');
                $user = DB::table('system_users')->where('id', $user_id)->pluck('username');

                Mail::send('emails.renewalConfirmation', array('renewalDate'=>$renewal_date, 'user'=>$user,
                    'prCode'=>$prCode->project_id,'item'=>$item->item, 'inventory'=>$code->inventory_code),function($messsage)
                {
                    $messsage->to('sabhayans@gmail.com','Abhayan')->subject('Resource Renewal');
                });

                \Session::flash('flash_message','New Renewal date requested successfully!');

                return Redirect::action('RenewalController@index');

            }


            else{
                \Session::flash('flash_message_error','Renewal request failed');

                return Redirect::action('RenewalController@index');

            }

        }

        catch(\Exception $e)
        {
            return Redirect::back()->withErrors($e->getMessage());
        }


    }

    public function adminReleaseView()
    {
        $hold = DB::table('reqs')
            ->join('requesths', 'reqs.request_id', '=', 'requesths.request_id')
            ->select( 'requesths.project_id','reqs.item','reqs.device_type','reqs.request_id'
                ,'reqs.sub_id', 'reqs.required_upto','reqs.status','reqs.renewal', 'reqs.inventory_code')
            ->where('status',"Allocated")->get();

        $hardware = DB::table('employeeAllocation')->where('status', 1)->get();

        return view('pages.releaseResource')->with('allocated',$hold )
                                            ->with('hardwares', $hardware);

    }

    public function resourceReleaseProject()
    {
        $input = Request::all();

        $id = $input['rid'];
        $sid = $input['sid'];
        $inventory = $input['inventory'];

        $hard = Hardware::find($inventory);

        $hard->status = "Not Allocated";
        $status1 = $hard->save() ? true : false;


        $status2 = DB::table('reqs')->where('request_id', $id)
            ->where('sub_id',$sid)
            ->update(array('status'=>"Cleared",'renewal'=>0));

        if($status1 && $status2)
            \Session::flash('flash_message','Resource was successfully released');
        else
            \Session::flash('flash_message_error','Resource not released');

        return Redirect::action('RenewalController@adminReleaseView');

    }

    public function resourceReleaseEmployee()
    {
        $input = Request::all();

        $inventory = $input['inventory'];

        $hard = Hardware::find($inventory);

        $hard->status = "Not Allocated";
        $status1 = $hard->save() ? true : false;

//        $username = EmployeeAllocation::find($inventory);
//        $username->status =0;

        $status2 = DB::table('employeeAllocation')->where('inventory_code', $inventory)->update(array('status'=>0));

        //$status2 = $username->save() ? true : false;

        if($status1 && $status2)
            \Session::flash('flash_message','Resource was successfully released');
        else
            \Session::flash('flash_message_error','Resource not released');

        return Redirect::action('RenewalController@adminReleaseView');

    }

    //EMPLOYEE ALLOCATION

    public function employeeAllocationView()
    {
        $hardware = DB::table('hardware')->where('status',"Not Allocated")->get();
        //$types = DB::table('hardware')->select('type','inventory_code')->groupBy('type')->get();
        $users = DB::table('system_users')->get();

        return view('pages.individualAllocation')->with('hardwares',$hardware )
                                                ->with('users',$users);

    }

    public function searchHardware()
    {

        $hardware = DB::table('hardware')->where('status', "Not Allocated")
                                                    ->where(function($query)
                                            {
                                                $input = Request::all();
                                                $make = $input['make'];
                                                $query->where('type','LIKE', '%'.$make.'%')
                                                        ->orWhere('make','LIKE', '%'.$make.'%')
                                                    ->orWhere('inventory_code','LIKE', '%'.$make.'%')
                                                ->orWhere('model','LIKE', '%'.$make.'%');
                                            })
                                            ->get();

//            ->where('status', "Not Allocated")
//                                        ->where('type','LIKE', '%'.$make.'%')
//                                        ->orWhere('make','LIKE', '%'.$make.'%')
//                                        ->orWhere('model','LIKE', '%'.$make.'%')->get();

//        $types = DB::table('hardware')->select('type','inventory_code')->groupBy('type')->get();

        $users = DB::table('system_users')->get();

        return view('pages.individualAllocation')->with('hardwares',$hardware )
            ->with('users',$users);

    }

    public function employeeAllocation()
    {
        $input = Request::all();

        $inventory_code = $input['inventory_code'];
        $username = $input['username'];

        $resource = Hardware::find($inventory_code);
        $username2 = User::find($username);


        $status1 = DB::table('hardware')->where('inventory_code', $inventory_code)
            ->update(array('status'=>"Employee Allocated"));

        $empAllocation = new EmployeeAllocation();

        $empAllocation->inventory_code = $inventory_code;
        $empAllocation->user_name = $username2->username;
        $empAllocation->resource_type = $resource->type;
        $empAllocation->make = $resource->make;
        $empAllocation->model = $resource->model;
        $empAllocation->status = 1;

        $status2 = $empAllocation->save() ? true : false;

        if ($status1 && $status2)
            \Session::flash('flash_message', 'Resource Successfully Allocated!');
        else

           \Session::flash('flash_message_error', 'Resource Not Allocated');

        return Redirect::action('RenewalController@employeeAllocationView');

    }

    public function viewAllocation()

    {
        $allocations = DB::table('employeeAllocation')->where('status', 1)->get();

        return view('pages.viewAllocations')->with('allocations',$allocations );
    }

}
