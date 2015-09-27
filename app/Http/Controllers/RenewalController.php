<?php namespace App\Http\Controllers;

use App\Hardware;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\ReleaseRequest;
use App\req;
use App\User;
use Illuminate\Support\Facades\Redirect;
use Input;
use App\ServiceProvider;
use Illuminate\Support\Facades\DB;

use Request;
use App\Renewal;
use App\EmployeeAllocation;
use App\SystemUser;
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

    public function adminSearchView()
    {

        $requests = DB::table('renewal')
            ->join('reqs', 'renewal.id', '=', 'reqs.request_id')
            ->join('requesths', 'reqs.request_id', '=', 'requesths.request_id')
            ->select('renewal.id', 'renewal.sid', 'renewal.name','renewal.req_upto','requesths.project_id','reqs.required_upto')
            ->where('renewal.status', 0)->groupBy('renewal.name')
            ->where(function($query)
            {
                $input = Request::all();

                $name = $input['name'];

                $query->where('renewal.name','LIKE', '%'.$name.'%')
                    ->orWhere('renewal.req_upto','LIKE', '%'.$name.'%')
                    ->orWhere('requesths.project_id', 'LIKE', '%'.$name.'%')
                    ->orWhere('reqs.required_upto', 'LIKE', '%'.$name.'%');
            })
            ->get();

        return view('pages.acceptRequest')->with('requests',$requests);

    }

    public function adminAccept()
    {
        $input = Request::all();
//        $reject = Input::get('reject');

        $action = Input::get('action');

        $date= $input['req_upto'];
        $id = $input['reqID'];
        $sid = $input['SubID'];

//        $prCode = DB::table('requesths')->where('request_id', $id)->first();
//
//        $item = DB::table('reqs')->where('request_id', $id)
//            ->where('sub_id',$sid)->first();
//
//        $code = DB::table('reqs')->where('request_id', $id)
//            ->where('sub_id',$sid)->first();

        $status = true;

        //$temp = count($id);
//        var_dump($action);

        if(count($sid)==0)
        {
            \Session::flash('flash_message_error','Nothing to Update');
        }

        try {

            for ($i = 0; $i < count($sid); $i++)
            {

                if($action[$i]=="accept") {

                    DB::table('reqs')->where('request_id', $id[$i])
                        ->where('sub_id',$sid[$i])
                        ->update(array('renewal'=>0, 'required_upto'=>$date));

                    DB::table('renewal')->where('id', $id[$i])
                        ->where('sid',$sid[$i])
                        ->update(array('status'=>1));

                }

                if($action[$i]=="reject") {

                    DB::table('reqs')->where('request_id', $id)
                        ->where('sub_id',$sid)
                        ->update(array('renewal'=>0));

                    DB::table('renewal')->where('id', $id[$i])
                        ->where('sid',$sid[$i])
                        ->update(array('status'=>2));
                }

            }
        }

        catch(Exception $e)
        {
            $status = false;
        }

        if($status)
        {
            $user_id = DB::table('requesths')->where('request_id',$id)->pluck('user_id');
//                    $user = DB::table('system_users')->where('id', $user_id)->pluck('username');
//                    $email = DB::table('system_users')->where('id', $user_id)->pluck('email');
            $user_d = SystemUser::where('id',$user_id)->get();
            //$user_data = $user_d[0];
            $user = 'Parthi'; //$user_data->username;
            $email = 'paarthipank@gmail.com'; //$user_data->email;

            Mail::send('emails.acceptRenewal', array('user'=>'Parthi',
                'prCode'=>'001','item'=>'New', 'inventory'=>'Hello'),function($messsage) use ($user, $email)
            {
                $messsage->to('paarthipank@gmail.com',$user)->subject('Renewal Accepted');
            });

            \Session::flash('flash_message','Actions Updated');

        }

        else
        {

            \Session::flash('flash_message_error','Failed to Update');
        }

        return Redirect::action('RenewalController@adminView');

        }



    public function requestRenewal()
    {

        $input = Request::all();

        $id = $input['rid'];
        $sid = $input['sid'];
        $renewal_date = $input['req_upto'];
        $name = $input['name'];

        $status = true;

        //var_dump(count($sid));

        for ($i = 0; $i < count($sid); $i++)
        {
            try {
                $renew = new Renewal();

                $renew->id = $id[$i];
                $renew->sid = $sid[$i];
                $renew->req_upto = $renewal_date[$i];
                $renew->name = $name[$i];

                $renew->status = 0;

               DB::table('reqs')->where('request_id', $id[$i])
                    ->where('sub_id',$sid[$i])
                    ->update(array('renewal'=>1));



                $renew->save() ? true : false;

            }
            catch(\Exception $e)
            {
                $status = false;
                return Redirect::back()->withErrors($e->getMessage());
            }
        }

        if($status)
        {
            //$user_id = DB::table('requesths')->where('request_id',$id[0])->pluck('user_id');
            //$user = DB::table('system_users')->where('id', $user_id[0])->pluck('username');

            $prCode = DB::table('requesths')->where('request_id', $id[0])->first();

            $item = DB::table('reqs')->where('request_id', $id[0])
                ->where('sub_id',$sid[0])->first();

            $code = DB::table('reqs')->where('request_id', $id[0])
                ->where('sub_id',$sid[0])->first();

            Mail::send('emails.renewalConfirmation', array('renewalDate'=>$renewal_date[0], 'user'=>'Parthi',
                'prCode'=>$prCode->project_id,'item'=>$item->item, 'inventory'=>$code->inventory_code),function($messsage)
            {
                $messsage->to('paarthipank@gmail.com','Abhayan')->subject('Resource Renewal');
            });

            \Session::flash('flash_message','New Renewal date requested successfully!');

            return Redirect::action('RenewalController@index');

        }

        else{
            \Session::flash('flash_message_error','Renewal request failed');

            return Redirect::action('RenewalController@index');
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

    public function requestReleaseView()
    {

        $hold = DB::table('reqs')
            ->join('requesths', 'reqs.request_id', '=', 'requesths.request_id')
            ->select( 'requesths.project_id','reqs.item','reqs.device_type','reqs.request_id'
                ,'reqs.sub_id', 'reqs.assigned_date', 'reqs.required_upto','reqs.status','reqs.renewal')
            ->where('reqs.release_request',0)->get();


        return view('pages.requestRelease')->with('allocated',$hold);

    }

    public function requestReleaseSearch()
    {

        $hold = DB::table('reqs')
            ->join('requesths', 'reqs.request_id', '=', 'requesths.request_id')
            ->select( 'requesths.project_id','reqs.item','reqs.device_type','reqs.request_id'
                ,'reqs.sub_id', 'reqs.assigned_date', 'reqs.required_upto','reqs.status','reqs.renewal')
            ->where('reqs.release_request',0)
            ->where(function($query)
            {
                $input = Request::all();

                $searchKey = $input['searchKey'];

                $query->where('reqs.item','LIKE', '%'.$searchKey.'%')
                    ->orWhere('requesths.project_id','LIKE', '%'.$searchKey.'%')
                    ->orWhere('reqs.device_type', 'LIKE', '%'.$searchKey.'%');
            })
            ->get();

        return view('pages.requestRelease')->with('allocated',$hold);

    }

    public function requestReleasePost()
    {

        $input = Request::all();

        $id = $input['rid'];
        $sid = $input['sid'];
        $item = $input['item'];
        $type = $input['type'];
        $pID = $input['pID'];
        $assigned_date = $input['assigned_date'];
        $reqUpto = $input['reqUpto'];

        $releaseRequest = new ReleaseRequest();

        $releaseRequest->req_id = $id;
        $releaseRequest->sub_id = $sid;
        $releaseRequest->item_name = $item;
        $releaseRequest->type = $type;
        $releaseRequest->project_code = $pID;
        $releaseRequest->assigned_date = $assigned_date;
        $releaseRequest->required_upto = $reqUpto;


        $status1 = $releaseRequest->save() ? true : false;

        $status2 = DB::table('reqs')->where('request_id', $id)
            ->where('sub_id',$sid)
            ->update(array('release_request'=>1));

        if ($status1 && $status2)
            \Session::flash('flash_message', 'Request Sent Successfully');
        else

            \Session::flash('flash_message_error', 'Request is not sent');

        return Redirect::action('RenewalController@requestReleaseView');


    }

    public function requestReleaseAdminView()
    {

        $requests = DB::table('release_requests')->where('status',0)->get();

        return view('pages.requestReleaseAdmin')->with('requests',$requests);

    }

    public function requestReleaseAdminPost()
    {
        $input = Request::all();
        $reject = Input::get('reject');

        $id = $input['reqID'];
        $sid = $input['SubID'];

        try {
            if ($reject!="Reject") //Accept button has been clicked
            {
                $status1 = DB::table('reqs')->where('request_id', $id)
                    ->where('sub_id',$sid)
                    ->update(array('release_request'=>0));

                $status2 = DB::table('release_requests')->where('id', $id)
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
//                    $user = DB::table('system_users')->where('id', $user_id)->pluck('username');
//                    $email = DB::table('system_users')->where('id', $user_id)->pluck('email');
                    $user_d = SystemUser::where('id',$user_id)->get();
                    $user_data = $user_d[0];
                    $user = $user_data->username;
                    $email = $user_data->email;


                    Mail::send('emails.acceptRenewal', array('user'=>$user,
                        'prCode'=>$prCode->project_id,'item'=>$item->item, 'inventory'=>$code->inventory_code),function($messsage) use ($user, $email)
                    {
                        $messsage->to('paarthipank@gmail.com',$user)->subject('Release Request Accepted');
                    });

                    \Session::flash('flash_message','Release Request Accepted');
                }

                else
                {

                    \Session::flash('flash_message_error','Failed to accept');
                }

                return Redirect::action('RenewalController@requestReleaseAdminView');

            }
            else
            {

                $status1 = DB::table('reqs')->where('request_id', $id)
                    ->where('sub_id',$sid)
                    ->update(array('release_request'=>0));

                $prCode = DB::table('requesths')->where('request_id', $id)->first();

                $item = DB::table('reqs')->where('request_id', $id)
                    ->where('sub_id',$sid)->first();

                $code = DB::table('reqs')->where('request_id', $id)
                    ->where('sub_id',$sid)->first();

                $status2 = DB::table('release_requests')->where('id', $id)->where('sid',$sid)->delete();

                if($status1 && $status2){

                    $user_id = DB::table('requesths')->where('request_id',$id)->pluck('user_id');
//                    $user = DB::table('system_users')->where('id', $user_id)->pluck('username');
//                    $email = DB::table('system_users')->where('id', $user_id)->pluck('email');

                    $user_d = SystemUser::where('id',$user_id)->get();
                    $user_data = $user_d[0];
                    $user = $user_data->username;
                    $email = $user_data->email;

                    Mail::send('emails.rejectRenewal', array('user'=>'srinithy',
                        'prCode'=>$prCode->project_id,'item'=>$item->item, 'inventory'=>$code->inventory_code),function($messsage) use ($user,$email)
                    {
                        $messsage->to('paarthipank@gmail.com',$user)->subject('Release Request Rejected');
                    });

                    \Session::flash('flash_message','Release Request Rejected');
                }

                else
                    \Session::flash('flash_message_error','Failed to reject renewal');

                return Redirect::action('RenewalController@requestReleaseAdminView');

            }

        }
        catch(\Exception $e)
        {
            return Redirect::back()->withErrors($e->getMessage());
        }


    }

    public function requestReleaseAdminSearch()
    {


    }

}
