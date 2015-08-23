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
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        $requestTypes = RequestType::all();

        $firstRequest = $requestTypes[0];
        $columns = Column::where('category', $firstRequest->request_type)->get();
        $id = $firstRequest->request_type;
        $tempKey = $firstRequest->key;
        $key = $tempKey.'_'.date('YmdHis');

        $dropValues = $this->getDropDownValues($columns);
        $count = count($dropValues);

        return view('NewRequest.otherRequest',compact('dropValues','requestTypes','columns','count','id','key'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create($id)
	{
        $requestTypes = RequestType::all();

        $columns = Column::where('category', $id)->get();
        $count = 0;
        $request = RequestType::find($id);
        $tempKey = $request->key;
        $key = $tempKey.'_'.date('YmdHis');

        $dropValues = $this->getDropDownValues($columns);
        $count = count($dropValues);

        return view('NewRequest.otherRequest',compact('dropValues','requestTypes','columns','count','id','key'));
	}


	public function store()
	{
		$input = Input::all();
        $requestType = substr($input['request_type'],15);
        $count = count($input['count']);

        $contents = array();
        $requestData = array();
        $columns = Column::where('category', $requestType)->get();

        $gRequest = new GRequest();
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

        for ($i = 0; $i < $count; $i++)
        {
            $index = 0;

            $requests = array();

//            try {

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

                array_push($requestData,$requests);

//            }
//            catch(\Exception $e)
//            {
//                return Redirect::back()->withErrors($e->getMessage());
//            }
        }

        try
        {
            DB::beginTransaction();
            $gRequest->save();
            DB::table($requestType)->insert($requestData);
            DB::commit();
            \Session::flash('flash_message','Request sent successfully!');
        }
        catch(\Exception $e)
        {
            DB::rollback();
            \Session::flash('flash_message_error','Request failed to send!');
        }

        return Redirect::action('OtherRequestController@index');
	}


    public function showRequests()
    {
        $temp = GRequest::select('type')->where('g_status',1)->get();
        if(count($temp) == 0)
        {
            \Session::flash('flash_message', 'There are no requests to process!');
            return Redirect::to('/home');
        }

        $id = $temp[0]->type;
        $prCodes = GRequest::select('pr_code')->where('type',$id)->groupBy('pr_code')->get();
        $pr = $prCodes[0]->pr_code;
        $gRequests = GRequest::where('pr_code',$pr)->where('g_status',1)->get();
        $requestTypes = RequestType::all();
        $requests = DB::table($id)->join('g_requests',$id.'.request_id','=','g_requests.request_id')->where('g_requests.g_status','=',1)->get();
        $columns = Column::select('table_column', 'column_name', 'cid')->where('category',$id)->orderBy('cid')->get();

        return view('NewRequest.otherRequestAccept',compact('gRequests','requestTypes','requests','columns','id','prCodes','pr'));
    }

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

	public function edit($id,$pr)
	{
        $prCodes = GRequest::select('pr_code')->where('type',$id)->groupBy('pr_code')->get();
        $gRequests = GRequest::where('pr_code',$pr)->where('g_status',1)->get();
        $requestTypes = RequestType::all();
        $requests = DB::table($id)->join('g_requests',$id.'.request_id','=','g_requests.request_id')->where('g_requests.g_status','=',1)->get();
        $columns = Column::select('table_column', 'column_name', 'cid')->where('category',$id)->orderBy('cid')->get();

        return view('NewRequest.otherRequestAccept',compact('gRequests','requestTypes','requests','columns','id','prCodes','pr'));
	}


	public function update()
	{
        $input = Input::all();
        $requestId = $input['request_id'];
        $subId = $input['sub_id'];
        $requestType = $input['request_type'];
        $requestStatus = $input['status'];
        $remarks = $input['remarks'];
        $requestData = array();

        DB::beginTransaction();
        $status = true;

        try
        {
            for ($i = 0; $i < count($subId); $i++)
            {
                DB::table($requestType)->where('request_id', $requestId[$i])->where('id', $subId[$i])
                    ->update(array('status' => $requestStatus[$i], 'remarks' => $remarks[$i]));

                $this->updateRequest($requestId[$i],$requestType);
            }
        }
        catch(Exception $e)
        {
            $status = false;
        }

        if($status)
        {
            DB::commit();
            $this->sendEmail($requestType,$requestId);
            \Session::flash('flash_message', 'Update Successful!');
        }
        else
        {
            DB::rollback();
            \Session::flash('flash_message_error', 'Update Failed!');
        }

        return Redirect::action('OtherRequestController@showRequests');

	}

    public function updateRequest($requestId,$requestType)
    {
        $count = 0;
        $requests = DB::table($requestType)->where('request_id',$requestId)->get();

        foreach($requests as $request)
        {
            if($request->status == 'Pending')
            {
                $count++;
                break;
            }
        }

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

    private function sendEmail($requestType,$requestId)
    {
        try
        {
            $reqs = array_unique($requestId);

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
