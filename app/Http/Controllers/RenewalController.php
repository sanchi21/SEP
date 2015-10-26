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
use Auth;
use Request;
use App\Renewal;
use App\EmployeeAllocation;
use App\SystemUser;
use Illuminate\Support\Facades\Mail;

class RenewalController extends Controller
{


    public function index()
    {

        $hold = DB::table('reqs')//Retrieve Allocated resources which are not requested for renewal
        ->join('requesths', 'reqs.request_id', '=', 'requesths.request_id')
            ->select('requesths.project_id', 'reqs.item', 'reqs.device_type', 'reqs.request_id'
                , 'reqs.sub_id', 'reqs.assigned_date', 'reqs.required_upto', 'reqs.status', 'reqs.renewal')
            ->where('reqs.status', "Allocated")->where('reqs.renewal', 0)->get();

        $requests = DB::table('renewal')//Retrieve all pending renewal request along with their project code
        ->join('reqs', 'renewal.id', '=', 'reqs.request_id')
            ->join('requesths', 'reqs.request_id', '=', 'requesths.request_id')
            ->select('renewal.id', 'renewal.sid', 'renewal.name', 'renewal.req_upto', 'requesths.project_id')
            ->where('renewal.status', 0)->groupBy('renewal.name')
            ->get();

        $prCode = DB::table('versions')->get();


        return view('pages.renew')->with('allocated', $hold)//Pass all the data to the view
        ->with('requests', $requests)
            ->with('prCode', $prCode);

    }

    public function searchResource()
    {


        $prCode = DB::table('reqs')//Retrieve the PR Code
        ->join('requesths', 'reqs.request_id', '=', 'requesths.request_id')
            ->select('requesths.project_id')->groupBy('requesths.project_id')->get();

        $prCode = DB::table('versions')->get();

        $hold = DB::table('reqs')//Search the Joined table with the search key
        ->join('requesths', 'reqs.request_id', '=', 'requesths.request_id')
            ->select('requesths.project_id', 'reqs.item', 'reqs.device_type', 'reqs.request_id'
                , 'reqs.sub_id', 'reqs.assigned_date', 'reqs.required_upto', 'reqs.status', 'reqs.renewal')
            ->where('reqs.status', "Allocated")
            ->where('reqs.renewal', 0)
            ->where(function ($query) {
                $input = Request::all(); // Get all the POST data from the view

                $name = $input['resourceName']; //Grab the search keyword from the POST data

                $query->where('reqs.item', 'LIKE', '%' . $name . '%')//search the table
                ->orWhere('requesths.project_id', 'LIKE', '%' . $name . '%')
                    ->orWhere('reqs.device_type', 'LIKE', '%' . $name . '%');
            })
            ->get();


        $requests = DB::table('renewal')
            ->join('reqs', 'renewal.id', '=', 'reqs.request_id')
            ->join('requesths', 'reqs.request_id', '=', 'requesths.request_id')
            ->select('renewal.id', 'renewal.sid', 'renewal.name', 'renewal.req_upto', 'requesths.project_id')
            ->where('renewal.status', 0)->groupBy('renewal.name')
            ->get();

        return view('pages.renew')->with('allocated', $hold)
            ->with('requests', $requests)
            ->with('prCode', $prCode);

    }

    public function cancelRequest()
    {

        $input = Request::all(); // Get all the POST data from the view
        $id = $input['reqID']; // Grab the request id from POST
        $sid = $input['SubID']; //Grab the sub id from POST

        $status1 = DB::table('reqs')->where('request_id', $id)// update the renewal status
        ->where('sub_id', $sid)
            ->update(array('renewal' => 0));

        $status2 = DB::table('renewal')->where('id', $id)->where('sid', $sid)->delete(); //delete the request

        if ($status1 && $status2)
            \Session::flash('flash_message', 'Renewal request cancelled'); //Flash message with
        else
            \Session::flash('flash_message_error', 'Renewal request failed to cancel');

        return Redirect::action('RenewalController@index');

    }

    public function adminView() //Administrators view for renewal requests
    {


        $requests = DB::table('renewal')//Get all the renewal requests
        ->join('reqs', 'renewal.id', '=', 'reqs.request_id')
            ->join('requesths', 'reqs.request_id', '=', 'requesths.request_id')
            ->select('renewal.id', 'renewal.sid', 'renewal.name', 'renewal.req_upto', 'requesths.project_id', 'reqs.required_upto')
            ->where('renewal.status', 0)->groupBy('renewal.name')
            ->get();

        return view('pages.acceptRequest')->with('requests', $requests);

    }

    public function adminSearchView() //Search renewal requests
    {
        $prCodes = $this->getPRCodes();

       $requests = DB::table('renewal')
            ->join('reqs', 'renewal.id', '=', 'reqs.request_id')
            ->join('requesths', 'reqs.request_id', '=', 'requesths.request_id')
            ->select('renewal.id', 'renewal.sid', 'renewal.name', 'renewal.req_upto', 'requesths.project_id', 'reqs.required_upto')
            ->where('renewal.status', 0)->groupBy('renewal.name')
            ->where(function ($query) {
                $input = Request::all(); //Get all the POST data
                $name = $input['name']; //Grab the search keyword

                $query->where('renewal.name', 'LIKE', '%' . $name . '%')//search the table with the keyword
                ->orWhere('renewal.req_upto', 'LIKE', '%' . $name . '%')
                    ->orWhere('requesths.project_id', 'LIKE', '%' . $name . '%')
                    ->orWhere('reqs.required_upto', 'LIKE', '%' . $name . '%');
            })
            ->get();

        return view('pages.acceptRequest')->with('requests', $requests);

    }

    public function adminAccept() //Admin's Renewal request Accept or Delete
    {
        $input = Request::all();


        $action = Input::get('action');

        $date = $input['req_upto'];
        $id = $input['reqID'];
        $sid = $input['SubID'];

//        $prCode = DB::table('requesths')->where('request_id', $id)->first();
//
//        $item = DB::table('reqs')->where('request_id', $id)
//            ->where('sub_id',$sid)->first();
//
//        $code = DB::table('reqs')->where('request_id', $id)
//            ->where('sub_id',$sid)->first();

        $status = false;

        //$temp = count($id);
//        var_dump($action);

        if (count($sid) == 0) //if there is no data Flash a message
        {
            \Session::flash('flash_message_error', 'Nothing to Update');
        }

        try {

        for ($i = 0; $i < count($sid); $i++) //Iterate through each and every requests
        {

//                var_dump($date);


            if ($action[$i] == "accept") { //if the action is accept for this particular request

                DB::table('reqs')->where('request_id', $id[$i])
                    ->where('sub_id', $sid[$i])
                    ->update(array('renewal' => 0)); //update the action in renewal table

              DB::table('reqs')->where('request_id', $id[$i])
                        ->where('sub_id', $sid[$i])
                        ->update(array('required_upto' => $date[$i])); //update the new date

                DB::table('renewal')->where('id', $id[$i])
                    ->where('sid', $sid[$i])
                    ->update(array('status' => 1));

                $status = true;

            }

            if ($action[$i] == "reject") { //if the action is reject for this particular request

                DB::table('reqs')->where('request_id', $id[$i])
                    ->where('sub_id', $sid[$i])
                    ->update(array('renewal' => 0));

                DB::table('renewal')->where('id', $id[$i])
                    ->where('sid', $sid[$i])
                    ->update(array('status' => 2)); //update the action in renewal table
            }

        }
//
        } catch (Exception $e) {

            $status = false;
        }
//
        if ($status) //if actions are updated
        {
//            return 'success';

            $user_id = DB::table('requesths')->where('request_id', $id)->pluck('user_id');
//                    $user = DB::table('system_users')->where('id', $user_id)->pluck('username');
//                    $email = DB::table('system_users')->where('id', $user_id)->pluck('email');
            $user_d = SystemUser::where('id', $user_id)->get();
            //$user_data = $user_d[0];
            $user = 'Parthipan'; //$user_data->username;
            $email = 'paarthipank@gmail.com'; //$user_data->email;

            Mail::send('emails.acceptRenewal', array('user' => 'Parthi', //mail the user
                'prCode' => '001', 'item' => 'New', 'inventory' => 'Hello'), function ($messsage) use ($user, $email) {
                $messsage->to('paarthipank@gmail.com', $user)->subject('Renewal Accepted');
            });

            \Session::flash('flash_message', 'Actions Updated');

        }

        else {

            \Session::flash('flash_message_error', 'Failed to Update');
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

        $action = Input::get('action');

        $status = true;

        for ($i = 0; $i < count($sid); $i++) //Iterate through each and every requests
        {

            if ($action[$i] == "request")
            { //if the action is accept for this particular request

                try {

                    $renew = new Renewal(); //create an instance of Renewal model
                    $renew->id = $id[$i];
                    $renew->sid = $sid[$i];
                    $renew->req_upto = $renewal_date[$i];
                    $renew->name = $name[$i];
                    $renew->status = 0; //add the request data to the instance

                    DB::table('reqs')->where('request_id', $id[$i])
                        ->where('sub_id',$sid[$i])
                        ->update(array('renewal'=>1)); //update renewal table

                    $renew->save() ? true : false;

                    $requesting_id[] = $id[$i];
                    $requesting_sid[] = $sid[$i];
                    $requesting_date[] = $renewal_date[$i];

                }

                catch(\Exception $e)
                {
                    $status = false;
                    return Redirect::back()->withErrors($e->getMessage()); //display the errors if exception occurs
                }
            }


        }

        if($status) //if request is successful mail the user
        {

            $inventory_code = array();
            $item_name = array();
            $pr_code = array();

            for ($j = 0; $j < count($requesting_date); $j++)
            {
                $prCode = DB::table('requesths')->where('request_id', $id[$j])->first();

                $code = DB::table('reqs')->where('request_id', $requesting_id[$j])
                    ->where('sub_id',$requesting_sid[$j])->first();

                array_push( $inventory_code, $code->inventory_code);
                array_push( $item_name,$prCode->project_id);
                array_push( $pr_code,$code->item);

            }



            //$user_id = DB::table('requesths')->where('request_id',$id[0])->pluck('user_id');
            //$user = DB::table('system_users')->where('id', $user_id[0])->pluck('username');

//            $prCode = DB::table('requesths')->where('request_id', $id[0])->first();
//
//            $item = DB::table('reqs')->where('request_id', $id[0])
//                ->where('sub_id',$sid[0])->first();
//
//            $code = DB::table('reqs')->where('request_id', $id[0])
//                ->where('sub_id',$sid[0])->first();
//
            Mail::send('emails.renewalConfirmation', array('renewalDate'=>$requesting_date, 'user'=>'Parthipan',
                'prCode'=>$pr_code,'item'=>$item_name, 'inventory'=>$inventory_code, 'count'=>count($requesting_date)),function($bodyMessage)
            {
                $bodyMessage->to('paarthipank@gmail.com','Abhayan')->subject('Resource Renewal');
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

        $hold = DB::table('reqs') //Get all the allocated resource details
            ->join('requesths', 'reqs.request_id', '=', 'requesths.request_id')
            ->select( 'requesths.project_id','reqs.item','reqs.device_type','reqs.request_id'
                ,'reqs.sub_id', 'reqs.required_upto','reqs.status','reqs.renewal', 'reqs.inventory_code')
            ->where('status',"Allocated")->get();

        $hardware = DB::table('employeeAllocation')->where('status', 1)->get();

        return view('pages.releaseResource')->with('allocated',$hold ) //send it to the view
                                            ->with('hardwares', $hardware);

    }

    public function resourceReleaseProject()
    {
        $input = Request::all(); // Get all the post data

        $id = $input['rid']; //Grab the request id
        $sid = $input['sid']; // Grab the sub id
        $inventory = $input['inventory']; //Grab the inventory

        $hard = Hardware::find($inventory); //search hardware table for the particular inventory

        $hard->status = "Not Allocated"; //Release the resource and update as not allocated
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
        $input = Request::all(); //Ge all the POST data

        $inventory = $input['inventory'];

        $hard = Hardware::find($inventory);//search hardware table for the particular inventory

        $hard->status = "Not Allocated"; //Release the resource and update as not allocated
        $status1 = $hard->save() ? true : false;

//        $username = EmployeeAllocation::find($inventory);
//        $username->status =0;

        //Update the employee allocation table as released
        $status2 = DB::table('employeeAllocation')->where('inventory_code', $inventory)->update(array('status'=>0));



        if($status1 && $status2)
            \Session::flash('flash_message','Resource was successfully released');
        else
            \Session::flash('flash_message_error','Resource not released');

        return Redirect::action('RenewalController@adminReleaseView');

    }

    //EMPLOYEE ALLOCATION

    public function employeeAllocationView()
    {
        $hardware = DB::table('hardware')->where('status',"Not Allocated")->get(); //get all the resources which are free
        $users = DB::table('system_users')->get();

        return view('pages.individualAllocation')->with('hardwares',$hardware )
                                                ->with('users',$users);

    }

    public function searchHardware()
    {

        $hardware = DB::table('hardware')->where('status', "Not Allocated") //search all the table which are not allocated
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


        $users = DB::table('system_users')->get();

        return view('pages.individualAllocation')->with('hardwares',$hardware )
            ->with('users',$users);

    }

    public function employeeAllocation()
    {
        $input = Request::all(); //Get all the POST data

        $inventory_code = $input['inventory_code']; //Grab the inventory code
        $username = $input['username']; //Grab the user name

        $resource = Hardware::find($inventory_code);
        $username2 = User::find($username);


        $status1 = DB::table('hardware')->where('inventory_code', $inventory_code)
            ->update(array('status'=>"Employee Allocated"));

        $empAllocation = new EmployeeAllocation(); //Create an instance of Employee Allocation model

        $empAllocation->inventory_code = $inventory_code;
        $empAllocation->user_name = $username2->username;
        $empAllocation->resource_type = $resource->type;
        $empAllocation->make = $resource->make;
        $empAllocation->model = $resource->model;
        $empAllocation->status = 1; //save all the data to the instance

        $status2 = $empAllocation->save() ? true : false;

        if ($status1 && $status2)
            \Session::flash('flash_message', 'Resource Successfully Allocated!');
        else

           \Session::flash('flash_message_error', 'Resource Not Allocated');

        return Redirect::action('RenewalController@employeeAllocationView');

    }

    public function viewAllocation()

    {
        $allocations = DB::table('employeeAllocation')->where('status', 1)->get(); //view all the individual allocation

        return view('pages.viewAllocations')->with('allocations',$allocations );
    }

    public function requestReleaseView() //request for release
    {

        $hold = DB::table('reqs') //get all the resources which are currently allocated
            ->join('requesths', 'reqs.request_id', '=', 'requesths.request_id')
            ->select( 'requesths.project_id','reqs.item','reqs.device_type','reqs.request_id'
                ,'reqs.sub_id', 'reqs.assigned_date', 'reqs.required_upto','reqs.status','reqs.renewal')
            ->where('reqs.release_request',0)->get();


        return view('pages.requestRelease')->with('allocated',$hold);

    }

    public function requestReleaseSearch()
    {

        $hold = DB::table('reqs') //Search the allocated resources with the key word
            ->join('requesths', 'reqs.request_id', '=', 'requesths.request_id')
            ->select( 'requesths.project_id','reqs.item','reqs.device_type','reqs.request_id'
                ,'reqs.sub_id', 'reqs.assigned_date', 'reqs.required_upto','reqs.status','reqs.renewal')
            ->where('reqs.release_request',0)
            ->where(function($query)
            {
                $input = Request::all(); //Get all the POST data

                $searchKey = $input['searchKey']; //Grab the search keyword

                $query->where('reqs.item','LIKE', '%'.$searchKey.'%')
                    ->orWhere('requesths.project_id','LIKE', '%'.$searchKey.'%')
                    ->orWhere('reqs.device_type', 'LIKE', '%'.$searchKey.'%');
            })
            ->get();

        return view('pages.requestRelease')->with('allocated',$hold);

    }

    public function requestReleasePost()
    {

        $input = Request::all(); //Get all the POST data

        $id = $input['rid']; //Grab the request ID
        $sid = $input['sid']; //Grab the sub id

        //return $sid;
        $item = $input['item']; //Grab the item name
        $type = $input['type']; //Grab the device type
        $pID = $input['pID']; //Grab the project code
        $assigned_date = $input['assigned_date']; //Grab the assigned date
        $reqUpto = $input['reqUpto']; //Grab the required upto date

        $releaseRequest = new ReleaseRequest();

        $releaseRequest->req_id = $id;
        $releaseRequest->sub_id = $sid;
        $releaseRequest->item_name = $item;
        $releaseRequest->type = $type;
        $releaseRequest->project_code = $pID;
        $releaseRequest->assigned_date = $assigned_date;
        $releaseRequest->required_upto = $reqUpto; //save all the data to the Release Resource table


        $status1 = $releaseRequest->save() ? true : false;

        $status2 = DB::table('reqs')->where('request_id', $id)
            ->where('sub_id',$sid)
            ->update(array('release_request'=>1)); //update the table

        if ($status1 && $status2)
            \Session::flash('flash_message', 'Request Sent Successfully');
        else

            \Session::flash('flash_message_error', 'Request is not sent');

        return Redirect::action('RenewalController@requestReleaseView');


    }

    public function requestReleaseAdminView()
    {

        $requests = DB::table('release_requests')->where('status',0)->get(); //get all the release resource requests

        return view('pages.requestReleaseAdmin')->with('requests',$requests);

    }

    public function requestReleaseAdminPost()
    {
        $input = Request::all(); //Get all the POST data
        $reject = Input::get('reject'); //Grab the action made

        $id = $input['reqID']; //Grab the request id
        $sid = $input['SubID']; //Grab the sub id

        try {
            if ($reject!="Reject") //If the Accept button is clicked
            {
                $status1 = DB::table('reqs')->where('request_id', $id)
                    ->where('sub_id',$sid)
                    ->update(array('release_request'=>0)); //update the reqs table

                $status2 = DB::table('release_requests')->where('req_id', $id)
                    ->where('sub_id',$sid)
                    ->update(array('status'=>1)); //update the release request table

                $prCode = DB::table('requesths')->where('request_id', $id)->first();

                $item = DB::table('reqs')->where('request_id', $id)
                    ->where('sub_id',$sid)->first();

                $code = DB::table('reqs')->where('request_id', $id)
                    ->where('sub_id',$sid)->first();

                if($status1 && $status2) //mail the user if the action is successful
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
            else // if the reject button is clicked
            {

                $status1 = DB::table('reqs')->where('request_id', $id)
                    ->where('sub_id',$sid)
                    ->update(array('release_request'=>0)); //update the reqs table

                $prCode = DB::table('requesths')->where('request_id', $id)->first();

                $item = DB::table('reqs')->where('request_id', $id)
                    ->where('sub_id',$sid)->first();

                $code = DB::table('reqs')->where('request_id', $id)
                    ->where('sub_id',$sid)->first();

                $status2 = DB::table('release_requests')->where('req_id', $id)
                    ->where('sub_id',$sid)
                    ->update(array('status'=>1));

                if($status1 && $status2){ //mail the user if the action is successful

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
                    \Session::flash('flash_message_error','Failed to reject request');

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
        $input = Request::all(); //Get all the POST data

        $searchKey = $input['searchKey']; //grab the search keyword

        $requests = DB::table('release_requests')->where('status',0) //search the table
                                                 ->where('item_name','LIKE', '%'.$searchKey.'%')
                                                 ->orWhere('type','LIKE', '%'.$searchKey.'%')
                                                 ->orWhere('project_code','LIKE', '%'.$searchKey.'%')
                                                 ->orWhere('status', 'LIKE', '%'.$searchKey.'%')->get();

        return view('pages.requestReleaseAdmin')->with('requests',$requests);

    }

}
