<?php namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use App\requesth;
use App\req;
use App\Hardware;
use App\Software;
use App\User;
use Input;
use make;
use View;
use App\file;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use Request;
use Illuminate\Support\Facades\DB;


class AllocationController extends Controller {

    Public function view()
    {
        $Allocation_id =1;
        $ids = requesth::where('request_status', '=',$Allocation_id)->get();
        return view('Requests.Allocate')->with('ids',$ids);
    }

    Public function ViewRequests(){

        $request_id = Input::get('hid1');
        $project_id = Input::get('hid2');
        $Allocation_id =1;
        //$inventory_code = Input::get('hid11');
        $inventory_code ='e';
        $device_status='Not Allocated';
        \Session::flash('flash_av','');
        $results = req::where('request_id', '=',$request_id)->where('status','=',$device_status)->get();
        $ids = requesth::where('request_status', '=',$Allocation_id)->get();
        $ftp_account=file::where('request_id', '=',$request_id)->get();

        $resource_type=Input::get('resource_type');
        $type=Input::get('type');
        $hardware_types=Hardware::where('status','=',$device_status)->where('type', 'LIKE', '%' . $type . '%')->paginate(30);


        return view('Requests.Allocate')->with('ids',$ids)->with('results',$results)->with('ftp_account',$ftp_account)->with('hardware_types',$hardware_types)->with('inventory_code',$inventory_code);
        //return Redirect::to('SearchResource',[$request_id]);


    }

    Public function ResourceAllocation(){

        $request_id=Input::get('hidr');
        $sub_id=Input::get('hid3');
        $item=Input::get('hid4');
        $serial=Input::get('serial');
        $date=Input::get('date');
        $remarks=Input::get('remarks');
        $status='Allocated';
        $status2='Not Allocated';

        if((empty($serial) || empty($date))){
            \Session::flash('flash_message_error', 'Serial no and date fields cannot be empty');
            return redirect('Allocate');
        }

        else {
            if ($item != '') {
                $hard = Hardware::find($serial);
                $hard->status = $status;
                $hard->save();

                $r = DB::table('reqs')
                    ->where('request_id', $request_id)
                    ->where('sub_id', $sub_id)
                    ->update(array('inventory_code' => $serial, 'assigned_date' => $date, 'remarks' => $remarks, 'status' => $status));

                $user_id =DB::table('requesths')->where('request_id',$request_id)->pluck('user_id');
                $user= User::where('id','=',$user_id);
                $a=$user->count();
                $user=$user->first();

                Mail::send('Requests.AllocationSuccess', array('username'=>$user->username),function($message) use ($user)
                {
                    $message->to($user->email, $user->username)->subject('Resource Allocation');
                });

                \Session::flash('flash_message', 'Hardware Allocated Successfully');
                return redirect('Allocate');

            }
            else {
                $no_of_license = Software::where('inventory_code', '=', $serial)->get();
                $get_first_row = $no_of_license->first();
                $license_count = $get_first_row->no_of_license;
                $get_count = Input::get('hid7');
                if ($get_count <= $license_count) {

                    $soft = Software::find($serial);
                    $soft->status = $status;
                    $soft->save();

                    $r = DB::table('reqs')
                        ->where('request_id', $request_id)
                        ->where('sub_id', $sub_id)
                        ->update(array('inventory_code' => $serial, 'assigned_date' => $date, 'remarks' => $remarks, 'status' => $status));

                    \Session::flash('flash_message', 'Software Allocated Successfully');
                    return redirect('Allocate');
                } else {
                    \Session::flash('flash_message_error', 'Less no of Licenses/ cannot allocate');
                    return redirect('Allocate');
                }
            }

            $no_of_not_allocated = req::where('request_id', '=', $request_id)->where('status', '=', $status2)->get();
            $count = $no_of_not_allocated->count();
            if ($count == 0) {
                $reqh = requesth::find($request_id);
                $reqh->request_status = 0;
                $reqh->save();
            }


        }

    }

    Public function SearchResource(){
        $resource_type=Input::get('resource_type');
        $type=Input::get('type');
        $inventory_code = Input::get('hid11');

      $request_id =Input::get('r1');
       // $request_id =1;
        $Allocation_id =1;
        $device_status='Not Allocated';

        $results = req::where('request_id', '=',$request_id)->where('status','=',$device_status)->get();
        $ids = requesth::where('request_status', '=',$Allocation_id)->get();
        $ftp_account=file::where('request_id', '=',$request_id)->get();


        if($resource_type=='Hardware'){
            $hardware_types=Hardware::where('status','=',$device_status)->where('type', 'LIKE', '%' . $type . '%')->paginate(30);
        }
        else{
            $hardware_types=Software::where('status','=',$device_status)->where('name', 'LIKE', '%' . $type . '%')->paginate(30);
        }
        \Session::flash('flash_search','');
        return view('Requests.Allocate')->with('hardware_types',$hardware_types)->with('results',$results)->with('ids',$ids)->with('ftp_account',$ftp_account)->with('inventory_code',$inventory_code);

    }

    Public function SendResource(){
        $inventory_code = Input::get('hid11');

        //$request_id = 1;
        $request_id =Input::get('r2');
        $Allocation_id =1;
        $device_status='Not Allocated';
        $resource_type=Input::get('resource_type');
        $type=Input::get('type');

        $results = req::where('request_id', '=',$request_id)->where('status','=',$device_status)->get();
        $ids = requesth::where('request_status', '=',$Allocation_id)->get();
        $ftp_account=file::where('request_id', '=',$request_id)->get();
        $type=Input::get('type');
        if($resource_type=='Hardware'){
            $hardware_types=Hardware::where('status','=',$device_status)->where('type', 'LIKE', '%' . $type . '%')->paginate(30);
        }
        else{
            $hardware_types=Software::where('status','=',$device_status)->where('name', 'LIKE', '%' . $type . '%')->paginate(30);
        }

        \Session::flash('flash_get','');
        return view('Requests.Allocate')->with('hardware_types',$hardware_types)->with('results',$results)->with('ids',$ids)->with('ftp_account',$ftp_account)->with('inventory_code', $inventory_code);

    }

    Public function getViewAll(){
        return view('Requests.ViewAll');
    }

    Public function ViewAll()
    {
        $request_id = Input::get('hid1');
        $project_id = Input::get('hid2');
        $device_status='Allocated';
        $project=requesth::where('request_id', '=',$request_id);
        $row=$project->first();
        $project_code=$row->project_id;
        $results = req::where('request_id', '=',$request_id)->where('status','=',$device_status)->get();
        return view('Requests.ViewAll')->with('results',$results)->with('project_code',$project_code);

    }

//----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

    Public function getTrackResource(){
        return view('Requests.TrackResource');
    }

    Public function Track(){
        $resource_type=Input::get('resource_type');
        $type=Input::get('type');

        if($resource_type=='Hardware'){
            $hardware_types=Hardware::where('type', 'LIKE', '%' . $type . '%')->paginate(30);
        }
        else{
            $hardware_types=Software::where('name', 'LIKE', '%' . $type . '%')->paginate(30);
        }
        //$get_serial_no=Input::get('hid_serial_code');
        $get_serial_no='';
        $history=req::where('inventory_code', '=',$get_serial_no)->get();

        \Session::flash('flash_search_resource','');
        return view('Requests.TrackResource')->with('hardware_types',$hardware_types)->with('history',$history)->with('get_serial_no',$get_serial_no);

    }

    Public function FindHistory()
    {
        $resource_type=Input::get('resource_type');
        $type=Input::get('type');

        if($resource_type=='Hardware'){
            $hardware_types=Hardware::where('type', 'LIKE', '%' . $type . '%')->paginate(30);
        }
        else{
            $hardware_types=Software::where('name', 'LIKE', '%' . $type . '%')->paginate(30);
        }

        $get_serial_no=Input::get('hid_serial_code');
        $history=req::where('inventory_code', '=',$get_serial_no)->get();
        \Session::flash('flash_search_history','');
        return view('Requests.TrackResource')->with('hardware_types',$hardware_types)->with('history',$history)->with('get_serial_no',$get_serial_no);

    }

}
