<?php namespace App\Http\Controllers;
use App\HardwareReq;
use App\Type;
use App\requesth;
use App\version;
use App\req;
use App\Operating_system;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Request;
use Input;
use Auth;


class HardwareReqController extends Controller
{

    Public function version()
    {
        $versions = Operating_system::all();
        $pros = version::all();
        $types = Type::all();
        $sws = DB::table('software')->get();
        //$user_id=Auth::user()->userID;
        $user_id = 8;
        $id = requesth::where('user_id', '=', $user_id)->get();
        $ab = $id->count();
        $a = $id->first();

        $req_id = $a->request_id;

        $all_requests = req::where('request_id', '=', $req_id)->get();

        return view('Requests.hardwarereq', compact('versions', 'types', 'all_requests', 'pros', 'sws'));


    }

    Public function save()
    {

        $com = Input::get('request');

        if (!$com) {
            $request_id = Input::get('hid1');
            $sub_id = Input::get('hid2');
            $take = requesth::where('request_id', '=', $request_id)->get();
            $rw = $take->first();
            $status = $rw->request_status;

            if ($status == 1) {
                $req1 = DB::table('reqs')->where('request_id', '=', $request_id)->where('sub_id', '=', $sub_id)->delete();
                \Session::flash('flash_message', 'Request Cancelled');
                return redirect('hardwarereq');

            } else {
                \Session::flash('flash_message', 'Request Cannot Be Cancelled! Its Already Allocated To A Project!');
                return redirect('hardwarereq');
            }

        } else {
            $input = Request::all();

            //get table row counts
            $rows1 = $input['test'];
            $rows = $input['test1'];

            //all input field values
            $start_date = $input['start_date'];
            $end_date = $input['end_date'];

            $project_id = $input['project_id'];
            //$user_id=Auth::user()->userID;
            $user_id = 8;
            $request_status = 1;



            $item = $input['item'];
            $os_version = $input['os_version'];
            $additional_information = $input['additional_information'];
            $device_type = $input['device_type'];
            $model = $input['model'];
            $additional_information_sw = $input['additional_information_sw'];

            $date_today = date('m/d/Y');

            $id = requesth::where('project_id', '=', $project_id)->get();
            $a = $id->first();
            $b = $id->count();

            if (empty($project_id)) {
                \Session::flash('flash_message', 'Prject_ID Cannot Be Empty');
                return redirect('hardwarereq');
            } else {
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
                        if ($temp != "Select Type") {
                            $req->save();
                        }


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
                        if ($temp != "Select Device") {
                            $req->save();
                        }


                    }
                    \Session::flash('flash_message', 'Request Sent Successfully');
                    return redirect('hardwarereq');

                } else {
                    if (empty($start_date) || empty($end_date)) {
                        \Session::flash('flash_message', 'Date Fields Cannot Be Empty');
                        return redirect('hardwarereq');
                    } elseif (strtotime($start_date) < strtotime($end_date)) {
                        \Session::flash('flash_message', 'Invalid Dates');
                        return redirect('hardwarereq');
                    }

//                  } elseif (strtotime($start_date) < strtotime($date_today)) {
//                      \Session::flash('flash_message', 'Invalid Required From');
//                      return redirect('hardwarereq');
//                  }
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
                            if ($temp != "Select Type") {
                                $req->save();
                            }

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
                            if ($temp != "Select Device") {
                                $req->save();
                            }


                        }
                    }

                    \Session::flash('flash_message', 'Request Sent Successfully');
                    return redirect('hardwarereq');
                }


            }
        }


}


    Public function v(){

        return view('Requests.hardwarereq');


        }









}
