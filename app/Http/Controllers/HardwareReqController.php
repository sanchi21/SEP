<?php namespace App\Http\Controllers;
use App\HardwareReq;
use App\hrequest;
use App\hw;
use App\requesth;
use App\req;
use App\version;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Request;


class HardwareReqController extends Controller {

    Public function version(){
        $versions=version::all();
        $types=hw::all();
        $user_id=1;
        $id= requesth::where('user_id','=',$user_id)->get();
        $a = $id->first();
        $req_id = $a->request_id;
        $all_requests=req::where('request_id','=',$req_id)->get();

        return view('Requests.hardwarereq',compact('versions','types','all_requests'));


    }

    Public function save(){


        $input=Request::all();

        //get table row counts
        $rows1=$input['test'];
        $rows=$input['test1'];

        //all input field values
        $start_date=$input['start_date'];
        $end_date=$input['end_date'];

        $project_id=$input['project_id'];
        $user_id='U002';
        $request_status=1;

        $item=$input['item'];
        $os_version=$input['os_version'];
        $additional_information=$input['additional_information'];
        $device_type=$input['device_type'];
        $model=$input['model'];
        $additional_information_sw=$input['additional_information_sw'];

        $date_today=date('m/d/Y');

        $id= requesth::where('project_id','=',$project_id)->get();
        $a = $id->first();
        $b=$id->count();

        if(empty($project_id)){
            \Session::flash('flash_message','Prject_ID And Date Fields Cannot Be Empty');
            return redirect ('hardwarereq');
        }
        else {
            if ($b != 0) {

                    $req_id = $a->request_id;
                    for ($i = 0; $i < $rows1; $i++) {
                        $max_subID = req::where('request_id', '=', $req_id)->max('sub_id');
                        $subId = $max_subID + 1;

                        $temp = $item[$i];
                        $temp1 = $os_version[$i];
                        $temp2 = $additional_information[$i];
                        $req = new req;
                        $req->request_id = $req_id;
                        $req->sub_id = $subId;
                        $req->item = $temp;
                        $req->os_version = $temp1;
                        $req->additional_information = $temp2;
                        $req->save();


                    }
                    for ($i = 0; $i < $rows; $i++) {
                        $max_subID = req::where('request_id', '=', $req_id)->max('sub_id');
                        $subId = $max_subID + 1;

                        $temp = $device_type[$i];
                        $temp1 = $model[$i];
                        $temp2 = $additional_information_sw[$i];
                        $req = new req;
                        $req->request_id = $req_id;
                        $req->sub_id = $subId;
                        $req->device_type = $temp;
                        $req->model = $temp1;
                        $req->additional_information = $temp2;
                        $req->save();


                    }
                    \Session::flash('flash_message', 'Request Sent Successfully');
                    return redirect('hardwarereq');

                }
               else {
                   if( empty($start_date) || empty($end_date)){
                       \Session::flash('flash_message', 'Date Fields Cannot Be Empty');
                       return redirect('hardwarereq');
                   }

                   elseif (strtotime($start_date) >strtotime($end_date)) {
                        \Session::flash('flash_message', 'Invalid Dates');
                        return redirect('hardwarereq');

                    }
                    elseif (strtotime($start_date) <strtotime($date_today)) {
                        \Session::flash('flash_message', 'Invalid Required From');
                        return redirect('hardwarereq');
                    }
                    else {
                        $max_requestID = requesth::max('request_id');
                        $new_reqID = $max_requestID + 1;
                        $init = new requesth;
                        $init->request_id = $new_reqID;
                        $init->required_from = $start_date;
                        $init->required_upto = $end_date;
                        $init->project_id = $project_id;
                        $init->user_id = $user_id;
                        $init->request_status = $request_status;
                        $init->save();

                        $subId = 1;
                        for ($i = 0; $i < $rows1; $i++) {

                            $temp = $item[$i];
                            $temp1 = $os_version[$i];
                            $temp2 = $additional_information[$i];
                            $req = new req;
                            $req->request_id = $new_reqID;
                            $req->sub_id = $subId;
                            $req->item = $temp;
                            $req->os_version = $temp1;
                            $req->additional_information = $temp2;
                            $req->save();

                            $max_subID = req::where('request_id', '=', $new_reqID)->max('sub_id');
                            $subId = $max_subID + 1;
                        }
                        for ($i = 0; $i < $rows; $i++) {
                            $max_subID = req::where('request_id', '=', $new_reqID)->max('sub_id');
                            $subId = $max_subID + 1;

                            $temp = $device_type[$i];
                            $temp1 = $model[$i];
                            $temp2 = $additional_information_sw[$i];
                            $req = new req;
                            $req->request_id = $new_reqID;
                            $req->sub_id = $subId;
                            $req->device_type = $temp;
                            $req->model = $temp1;
                            $req->additional_information = $temp2;
                            $req->save();


                        }
                    }
                    \Session::flash('flash_message', 'Request Sent Successfully');
                    return redirect('hardwarereq');
                }


        }


    }

    Public function v(){

        return view('Requests.hardwarereq');


        }









}
