<?php namespace App\Http\Controllers;

use App\GRequest;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\RequestType;
use App\Column;
use App\DropDown;
use Illuminate\Support\Facades\DB;
use App\req;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;

class OtherRequestController extends Controller {

	/**
	 * Display initial request form for other requests.
	 *
	 * @return Other Request form
	 */
	public function index()
	{
        //Get all the other request types available
        $requestTypes = RequestType::all();

        //get the first type to load the form
        $firstRequest = $requestTypes[0];

        //get the columns/fields of the request type table to load the html page
        $columns = Column::where('category', $firstRequest->request_type)->get();

        //set the request type for the html page
        $id = $firstRequest->request_type;

        //get primary key starting pattern
        $tempKey = $firstRequest->key;

        //create the primary key/ request id for the request type
        $key = $tempKey.'_'.date('YmdHis');

        //retrieve the dropdown values for columns of the request type
        $dropValues = $this->getDropDownValues($columns);
        $count = count($dropValues);

        return view('NewRequest.otherRequest',compact('dropValues','requestTypes','columns','count','id','key'));
	}


	/**
	 * show the request form for the given request type
	 *
     * @param Request Type
     *
	 * @return Request Type form
	 */
	public function create($id)
	{
        //Get all the other request types available
        $requestTypes = RequestType::all();

        //get the columns/fields of the request type table to load the html page
        $columns = Column::where('category', $id)->get();

        //initialize dropdown column count to zero
        $count = 0;

        //retrieve the request type record for the given type
        $request = RequestType::find($id);

        //get primary key starting pattern
        $tempKey = $request->key;

        //create the primary key/ request id for the request type
        $key = $tempKey.'_'.date('YmdHis');

        //retrieve the dropdown values for columns of the request type
        $dropValues = $this->getDropDownValues($columns);
        $count = count($dropValues);

        return view('NewRequest.otherRequest',compact('dropValues','requestTypes','columns','count','id','key'));
	}


    /**
     * store the request details of the request type
     *
     *
     * @return Response
     */

	public function store()
	{
        //get all the input values
		$input = Input::all();

        //get the request type
        $requestType = substr($input['request_type'],15);

        //count the no of requests
        $count = count($input['count']);

        //array to get the request type column names
        $contents = array();

        //array to hold the request details to insert
        $requestData = array();

        //retrieve the columns for the request type
        $columns = Column::where('category', $requestType)->get();

        //object to get the general request details
        $gRequest = new GRequest();

        //get the details from the submitted form and assign it to the fields to store
        $gRequest->request_id = $input['request_key'];
        $gRequest->type = $requestType;
        $gRequest->date = date('Y-m-d');
        $gRequest->pr_code = $input['PR_Code'];
        $gRequest->from = $input['from_date'];
        $gRequest->to = $input['to_date'];
        $gRequest->g_status = 1;
        $gRequest->user_id = $input['user_id'];

        try
        {
            //get the columns of the request type and store it to an array
            foreach ($columns as $cols)
            {
                if ($cols->table_column != 'cid')
                {
                    $temp = $input[$cols->table_column];
                    array_push($contents, $temp);
                }
            }
        }
        catch(\Exception $e)
        {
            return Redirect::back()->withErrors($e->getMessage());
        }

        //get all the multiple request details
        for ($i = 0; $i < $count; $i++)
        {
            //to track the request_id column and status column
            $index = 0;

            //temp array to hold a single request data
            $requests = array();

            try
            {
                //get the columns and for each column retrieve input data form form
                foreach ($contents as $attribute)
                {
                    if ($index == 0)
                    {
                        $requests = array_add($requests,'request_id',$attribute[$i]);
                    }
                    else if ($index == 1)
                    {
                        $requests = array_add($requests,'status',$attribute[$i]);
                    }
                    else
                    {
                        $t = $columns[$index]->table_column;
                        $requests = array_add($requests,$t,$attribute[$i]);
                    }

                    $index++;
                }

                //store the multiple request data in the requestData array to store it to DB
                array_push($requestData,$requests);

            }
            catch(\Exception $e)
            {
                return Redirect::back()->withErrors($e->getMessage());
            }
        }

        try
        {
            //Database transaction begin
            DB::beginTransaction();

            //store general request data
            $gRequest->save();

            //store other or multiple request data as a single batch
            DB::table($requestType)->insert($requestData);

            //commit transaction
            DB::commit();
            \Session::flash('flash_message','Request sent successfully!');
        }
        catch(\Exception $e)
        {
            //rollback Database transaction if insert fails
            DB::rollback();
            \Session::flash('flash_message_error','Request failed to send!');
        }

        return Redirect::action('OtherRequestController@index');
	}


    /**
     * show the pending requests for approval or rejection
     *
     *
     * @return Other request type approval form
     */

    public function showRequests()
    {
        //get only the pending requests
        $temp = GRequest::select('type')->where('g_status',1)->get();

        //ifthere are no pending requests to process redirect to home page with message
        if(count($temp) == 0)
        {
            \Session::flash('flash_message', 'There are no requests to process!');
            return Redirect::to('/home');
        }

        //if there are pending requests get the first type to load
        $id = $temp[0]->type;

        //get the PR Codes for the request type
        $prCodes = GRequest::select('pr_code')->where('type',$id)->groupBy('pr_code')->get();

        //get the first PR Code to load
        $pr = $prCodes[0]->pr_code;

        //retrieve the general request data for the given PR Code
        $gRequests = GRequest::where('pr_code',$pr)->where('g_status',1)->get();

        //get all the request types
        $requestTypes = RequestType::all();

        //retrieve the request data for approval
        $requests = DB::table($id)->join('g_requests',$id.'.request_id','=','g_requests.request_id')->where('g_requests.g_status','=',1)->get();

        //retrieve the columns of the request type
        $columns = Column::select('table_column', 'column_name', 'cid')->where('category',$id)->orderBy('cid')->get();

        return view('NewRequest.otherRequestAccept',compact('gRequests','requestTypes','requests','columns','id','prCodes','pr'));
    }

    /**
     * show the pending requests for approval or rejection
     *
     * @param request_type
     *
     * @return Other request type approval form
     */

	public function editAll($id)
	{
        if($id=='')
        {
            $temp = GRequest::select('type')->where('g_status',1)->get();
            $id = $temp[0]->type;
        }
        $prCodes = GRequest::select('pr_code')->where('type',$id)->groupBy('pr_code')->get();
        $pr = $prCodes[0]->pr_code;
        $gRequests = GRequest::where('pr_code',$pr)->where('g_status',1)->get();
        $requestTypes = RequestType::all();
        $requests = DB::table($id)->join('g_requests',$id.'.request_id','=','g_requests.request_id')->where('g_requests.g_status','=',1)->get();
        $columns = Column::select('table_column', 'column_name', 'cid')->where('category',$id)->orderBy('cid')->get();

        return view('NewRequest.otherRequestAccept',compact('gRequests','requestTypes','requests','columns','id','prCodes','pr'));
	}

    /**
     * show the pending requests for approval or rejection
     *
     * @param request_type, pr_code
     *
     * @return Other request type approval form
     */
	public function edit($id,$pr)
	{
        $prCodes = GRequest::select('pr_code')->where('type',$id)->groupBy('pr_code')->get();
        $gRequests = GRequest::where('pr_code',$pr)->where('g_status',1)->get();
        $requestTypes = RequestType::all();
        $requests = DB::table($id)->join('g_requests',$id.'.request_id','=','g_requests.request_id')->where('g_requests.g_status','=',1)->get();
        $columns = Column::select('table_column', 'column_name', 'cid')->where('category',$id)->orderBy('cid')->get();

        return view('NewRequest.otherRequestAccept',compact('gRequests','requestTypes','requests','columns','id','prCodes','pr'));
	}


    /**
     * update the other requests
     *
     *
     * @return Response
     */

	public function update()
	{
        //get all the inputs
        $input = Input::all();

        $requestId = $input['request_id'];
        $subId = $input['sub_id'];
        $requestType = $input['request_type'];
        $requestStatus = $input['status'];
        $remarks = $input['remarks'];

        //begin database transaction
        DB::beginTransaction();

        //status to check errors
        $status = true;

        try
        {
            //get the request data and update them
            for ($i = 0; $i < count($subId); $i++)
            {
                DB::table($requestType)->where('request_id', $requestId[$i])->where('id', $subId[$i])
                    ->update(array('status' => $requestStatus[$i], 'remarks' => $remarks[$i]));

                //update the general request record status
                $this->updateRequest($requestId[$i],$requestType);
            }
        }
        catch(Exception $e)
        {
            $status = false;
        }

        if($status)
        {
            //commit database
            DB::commit();

            //send email to with the request type and id data
            $this->sendEmail($requestType,$requestId);
            \Session::flash('flash_message', 'Update Successful!');
        }
        else
        {
            DB::rollback();
            \Session::flash('flash_message_error', 'Update Failed!');
        }

        return Redirect::to('/home');

	}

    public function updateRequest($requestId,$requestType)
    {
        //variable to track the pending multiple requests
        $count = 0;

        //retrieve the request data for the given type and request id
        $requests = DB::table($requestType)->where('request_id',$requestId)->get();

        //check if the status is pending and break if found
        foreach($requests as $request)
        {
            if($request->status == 'Pending')
            {
                $count++;
                break;
            }
        }

        //if no pending requests (all are approved or rejected) then update the general request status
        if($count == 0)
        {
            $gRequest = GRequest::find($requestId);
            $gRequest->g_status = 0;
            $gRequest->save();
        }
    }

	public function destroy($id)
	{
		//
	}

    /**
     * Get the dropdown values for a given column
     *
     * @param column
     *
     * @return dropdown values array
     */
    public function getDropDownValues($columns)
    {
        $dropValues = array();
        try {
            foreach ($columns as $c) {
                if ($c->dropDown == '1') {
                    $temp = DropDown::where('table_column', $c->table_column)->get();
                    array_push($dropValues, $temp);
                }
            }
        }
        catch(\Exception $e)
        {
            return Redirect::back()->withErrors($e->getMessage());
        }

        return $dropValues;
    }


    /**
     * send email to the requester
     *
     * @param request_type, request_id
     *
     * @return void
     */


    private function sendEmail($requestType,$requestId)
    {
        try
        {
            //get unique request id
            $reqs = array_unique($requestId);

            //for each request id retrieve the multiple requests details and send mail with the details
            foreach($reqs as $req)
            {
                $uid = GRequest::find($req)->user_id;
                $email = $this->getEmail($uid);
                $requestData = DB::table($requestType)->where('request_id',$req)->get();

                Mail::send('emails.otherRequestAccept', array('requestNo' => $req, 'type' => $requestType, 'requestData' => $requestData),
                    function ($messsage) use ($email,$requestType)
                    {
                        $messsage->to($email, 'Requester')->subject('Request - '.$requestType);
                    });
            }

        }
        catch(Exception $e)
        {

        }
    }

    private function getEmail($uid)
    {
        $email = '';
        if($uid == '1')
            $email = 'sabhayans@gmail.com';
        elseif($uid == '2')
            $email = 'pathnithyasri@gmail.com';
        elseif($uid == '3')
            $email = 'paarthipank@gmail.com';
        else
            $email = 'sanchayan@live.com';

        return $email;
    }
}
