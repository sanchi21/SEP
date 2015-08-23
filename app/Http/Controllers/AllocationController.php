<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\System_User;
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
use App\SystemUser;
use Illuminate\Support\Facades\DB;


class AllocationController extends Controller {

    Public function view()
    {
        $Allocation_id =1;
        $ids = requesth::where('request_status', '=',$Allocation_id)->get();
        $request_id = Input::get('hid1');
        $device_status='Not Allocated';
        $hardware_types='Allocated';
        $results='';
       // $results = req::where('request_id', '=',$request_id)->where('status','=',$device_status)->get();
        return view('Requests.Allocate')->with('ids',$ids)->with('results',$results)->with('hardware_types',$hardware_types);
    }

    Public function ViewRequests(){

        $request_id = Input::get('hid1');
        $project_id = Input::get('hid2');
        $Allocation_id =1;
        //$inventory_code = Input::get('hid11');
        $sub='';
        $inventory_code ='e';
        $device_status='Not Allocated';
        \Session::flash('flash_av','');
        $results = req::where('request_id', '=',$request_id)->where('status','=',$device_status)->get();
        $ids = requesth::where('request_status', '=',$Allocation_id)->get();
        $ftp_account=file::where('request_id', '=',$request_id)->get();

        $resource_type=Input::get('resource_type');
        $type=Input::get('type');
        $hardware_types=Hardware::where('status','=',$device_status)->where('type', 'LIKE', '%' . $type . '%')->paginate(30);


        return view('Requests.Allocate')->with('ids',$ids)->with('results',$results)->with('ftp_account',$ftp_account)->with('hardware_types',$hardware_types)->with('inventory_code',$inventory_code)->with('sub',$sub);
        //return Redirect::to('SearchResource',[$request_id]);


    }

    Public function ResourceAllocation(){



            $request_id = Input::get('hidr');
            $sub_id = Input::get('hid3');
            $item = Input::get('hid4');
            $device_type = Input::get('hid6');
            $serial = Input::get('serial');
            $date = Input::get('date');
            $remarks = Input::get('remarks');
            $status = 'Allocated';
            $status2 = 'Not Allocated';

            $check_device = Hardware::where('inventory_code', '=', $serial)->pluck('type');
            $check_software = Software::where('inventory_code', '=', $serial)->pluck('name');

            if ((empty($serial) || empty($date))) {
                \Session::flash('flash_message_error', 'Serial no and date fields cannot be empty');
                return redirect('Allocate');
            } else {
                if ($item != '') {

                    if ($item != $check_device) {
                        \Session::flash('flash_message_error', 'Requested hardware doest match with the allocation');
                        return redirect('Allocate');
                    }

                    else {
                        $count=Hardware::where('inventory_code', '=', $serial)->pluck('count');
                        $new_count=$count+1;
                        $hard = Hardware::find($serial);
                        $hard->status = $status;
                        $hard->count=$new_count;
                        $hard->save();

                        $r = DB::table('reqs')
                            ->where('request_id', $request_id)
                            ->where('sub_id', $sub_id)
                            ->update(array('inventory_code' => $serial, 'assigned_date' => $date, 'remarks' => $remarks, 'status' => $status));

                        $user_id = DB::table('requesths')->where('request_id', $request_id)->pluck('user_id');
//                        $user = DB::table('system_users')->where('id', $user_id)->pluck('username');
//                        $email = DB::table('system_users')->where('id', $user_id)->pluck('email');

                        $user_d = SystemUser::where('id',$user_id)->get();
                        $user_data = $user_d[0];
                        $user = $user_data->username;
                        $email = $user_data->email;

                        //$user = User::where('id', '=', $user_id);
                        //$a = $user->count();
                        //$user = $user->first();

                    try {

                        Mail::send('Requests.AllocationSuccess', array('username' => $user, 'date' => $date, 'name' => $check_device), function ($message) use ($user, $email) {
                            $message->to($email, $user)->subject('Resource Allocation');
                        });

                        \Session::flash('flash_message', 'Hardware Allocated Successfully');
                        return redirect('Allocate');
                    }

                    catch(\Exception $e)
                    {
                        return Redirect::back()->withErrors($e->getMessage());
                    }

                    }
                }


                else {
                    $no_of_license = Software::where('inventory_code', '=', $serial)->get();
                    $get_first_row = $no_of_license->first();
                    $license_count = $get_first_row->no_of_license;
                    $name=$get_first_row->name;
                    $get_count = Input::get('hid7');
                    $new_count = $license_count - $get_count;

                    if ($device_type != $check_software) {
                        \Session::flash('flash_message_error', 'Requested software doest match with the allocation');
                        return redirect('Allocate');
                    } else {
                        if ($get_count <= $license_count) {

                            $soft = Software::find($serial);   //update software table
                            $soft->status = $status;
                            $soft->no_of_license = $new_count;
                            $soft->save();

                            $r = DB::table('reqs')
                                ->where('request_id', $request_id)
                                ->where('sub_id', $sub_id)
                                ->update(array('inventory_code' => $serial, 'assigned_date' => $date, 'remarks' => $remarks, 'status' => $status));


                            //Email function

                            $user_id = DB::table('requesths')->where('request_id', $request_id)->pluck('user_id');

//                            $user = DB::table('system_users')->where('id', $user_id)->pluck('username');
//                            $email = DB::table('system_users')->where('id', $user_id)->pluck('email');
                            $user_d = SystemUser::where('id',$user_id)->get();
                            $user_data = $user_d[0];
                            $user = $user_data->username;
                            $email = $user_data->email;

                            Mail::send('Requests.AllocationSuccess', array('username' => $user,'date' => $date,'name' => $name), function ($message) use ($user, $email) {
                                $message->to($email, $user)->subject('Resource Allocation');
                            });

                            ////

                            \Session::flash('flash_message', 'Software Allocated Successfully');
                            return redirect('Allocate');
                        } else {
                            \Session::flash('flash_message_error', 'Less no of Licenses/ cannot allocate');
                            return redirect('Allocate');
                        }
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


            try {

                $resource_type = Input::get('resource_type');
                $type = Input::get('type');
                $inventory_code = Input::get('hid11');

                $request_id = Input::get('r1');
                //$request_id =1;
                $Allocation_id = 1;
                $device_status = 'Not Allocated';
                $sub = '';
                $device_status_allocated = 'Allocated';
                $results = req::where('request_id', '=', $request_id)->where('status', '=', $device_status)->get();
                $ids = requesth::where('request_status', '=', $Allocation_id)->get();
                $ftp_account = file::where('request_id', '=', $request_id)->get();


                if ($resource_type == 'Hardware') {
                    $hardware_types = Hardware::where('status', '=', $device_status)->where('type', 'LIKE', '%' . $type . '%')->paginate(30);
                    $count_hard = $hardware_types->count();
                } elseif ($resource_type == 'Allocated Hardware') {
                    $hardware_types = Hardware::where('status', '=', $device_status_allocated)->where('type', 'LIKE', '%' . $type . '%')->paginate(30);
                    $count_hard = $hardware_types->count();
                } else {
                    $hardware_types = Software::where('name', 'LIKE', '%' . $type . '%')->paginate(30);
                    $count_hard = $hardware_types->count();

                }

                if ($count_hard == 0) {
                    \Session::flash('flash_message_search', 'Search results not found');
                    return redirect('Allocate');
                } else {
                    \Session::flash('flash_search', '');
                    return view('Requests.Allocate')->with('hardware_types', $hardware_types)->with('results', $results)->with('ids', $ids)->with('ftp_account', $ftp_account)->with('inventory_code', $inventory_code)->with('sub', $sub);
                }

            } catch (\Exception $e) {
                return Redirect::back()->withErrors($e->getMessage());
            }


    }

    Public function SendResource(){

        try {

            $inventory_code = Input::get('hid11');
            $request_id = Input::get('r2');
            //$request_id =1;
            $Allocation_id = 1;
            $device_status = 'Not Allocated';
            $resource_type = Input::get('resource_type');
            $type = Input::get('type');

            $sub = Input::get('sub');

            $results = req::where('request_id', '=', $request_id)->where('status', '=', $device_status)->get();
            $ids = requesth::where('request_status', '=', $Allocation_id)->get();
            $ftp_account = file::where('request_id', '=', $request_id)->get();
            $type = Input::get('type');
            if ($resource_type == 'Hardware') {
                $hardware_types = Hardware::where('status', '=', $device_status)->where('type', 'LIKE', '%' . $type . '%')->paginate(30);
            } else {
                $hardware_types = Software::where('name', 'LIKE', '%' . $type . '%')->paginate(30);
            }

            \Session::flash('flash_get', '');
            return view('Requests.Allocate')->with('hardware_types', $hardware_types)->with('results', $results)->with('ids', $ids)->with('ftp_account', $ftp_account)->with('inventory_code', $inventory_code)->with('sub', $sub);

        }
        catch(\Exception $e)
        {
            return Redirect::back()->withErrors($e->getMessage());
        }
    }

    Public function getViewAll(){
        return view('Requests.ViewAll');
    }

    Public function getViewOfAllocations(){
        return view('Requests.ViewHardwareResources');
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

    Public function viewAllocatedHardware(){

        $inventory_code = Input::get('hid11');
        $results = req::where('inventory_code', '=', $inventory_code)->get();
        $inventoryType=Input::get('typeView');

        $a=0;
        foreach ($results as $item){
            $first[$a]=$item->request_id;
            $a=$a+1;
         }

        for ($a = 0;  $a < sizeof($first); $a++) {

            $projectCodes[$a]=requesth::where('request_id', '=',$first[$a])->pluck('project_id');

        }
        return view('Requests.ViewHardwareResources')->with('inventoryType',$inventoryType)->with('projectCodes',$projectCodes)->with('results',$results)->with('inventory_code',$inventory_code);

    }



//---------------------------------------------------Hardware Resource History-------------------------------------------------------------------------------------------------------------------------------------

    Public function getTrackResource(){
        return view('Requests.TrackResource');
    }

    Public function Track(){

        try {

            $resource_type = Input::get('resource_type');
            $type = Input::get('type');

            if ($resource_type == 'Hardware') {
                $hardware_types = Hardware::where('type', 'LIKE', '%' . $type . '%')->paginate(30);
            } else {
                $hardware_types = Software::where('name', 'LIKE', '%' . $type . '%')->paginate(30);
            }
            //$get_serial_no=Input::get('hid_serial_code');
            $get_serial_no = '';
            $history = req::where('inventory_code', '=', $get_serial_no)->get();

            \Session::flash('flash_search_resource', '');
            return view('Requests.TrackResource')->with('hardware_types', $hardware_types)->with('history', $history)->with('get_serial_no', $get_serial_no);
        }
        catch(\Exception $e)
        {
            return Redirect::back()->withErrors($e->getMessage());
        }
    }

    Public function FindHistory()
    {

        try {
            $resource_type = Input::get('resource_type');
            $type = Input::get('type');

            if ($resource_type == 'Hardware') {
                $hardware_types = Hardware::where('type', 'LIKE', '%' . $type . '%')->paginate(30);
            } else {
                $hardware_types = Software::where('name', 'LIKE', '%' . $type . '%')->paginate(30);
            }

            $get_serial_no = Input::get('hid_serial_code');
            $history = req::where('inventory_code', '=', $get_serial_no)->get();
            \Session::flash('flash_search_history', '');
            return view('Requests.TrackResource')->with('hardware_types', $hardware_types)->with('history', $history)->with('get_serial_no', $get_serial_no);
        }
        catch(\Exception $e)
        {
            return Redirect::back()->withErrors($e->getMessage());
        }
    }

//-------------------------------------------------------Hardware Maintenance---------------------------------------------------------------------------------------------------------------------------
    Public function getHardwareMaintenance(){

        $hardware=Hardware::all();
        return view('Requests.HardwareMaintenance',compact('hardware'));
    }

    Public function SaveHardwareCost()
    {

        try {

            $save = Input::get('save');
            $view = Input::get('view');
            $inventory_code = Input::get('hw');
            $remarks = Input::get('remarks');
            $date = Input::get('date');
            $cost = Input::get('cost');
            $pattern = '/^(?:0|[1-9]\d*)(?:\.\d{2})?$/';

            if ($save) {

                if ((empty($date) || empty($cost))) {
                    \Session::flash('flash_message_error', 'Date And Cost Fields Cannot Be Empty');
                    return redirect('HardwareMaintenance');
                } else {

                    if (preg_match($pattern, $cost) == '0') {
                        \Session::flash('flash_message_error', 'Invalid cost type');
                        return redirect('HardwareMaintenance');
                    } else {
                        $insert = DB::table('maintenance')->insert(array('inventory_code' => $inventory_code,
                                'remarks' => $remarks,
                                'date' => $date,
                                'cost' => $cost)
                        );
                        \Session::flash('flash_message', 'Maintenance Cost Added successfully');
                        return redirect('HardwareMaintenance');
                    }

                }
            }

            if ($view) {
                $inventory_code = Input::get('hw');
                $finds = DB::table('maintenance')->where('inventory_code', '=', $inventory_code)->get();
                $total_cost = DB::table('maintenance')->where('inventory_code', '=', $inventory_code)->sum('cost');
                $hardware = Hardware::all();
                $stats = 0;

                \Session::flash('flash_total_c', '');
                return view('Requests.HardwareMaintenance')->with('hardware', $hardware)->with('finds', $finds)->with('total_cost', $total_cost)->with('$stats', $stats);
            }

        }
        catch (\Exception $e) {
            return Redirect::back()->withErrors($e->getMessage());
        }
    }



}
