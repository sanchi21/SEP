<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\file;
use App\version;
use App\sfuser;
use App\User;
use App\req;
use App\requesth;
use Request;
use Input;
use Auth;
use Illuminate\Support\Facades\DB;
class FtpController extends Controller
{

    Public function FindU()
    {


        $sys_users = DB::table('system_users')->get();
        $pros = version::all();
        $ftp = file::all();
        $sf = sfuser::all();
        $req = req::all();

        $project_id = Input::get('project_id');
        $id = requesth::where('project_id', '=', $project_id)->pluck('request_id');
        $getAllFtpRequests = file::where('request_id', '=', $id)->get();
        $getAllFolderRequests=sfuser::where('request_id', '=', $id)->get();

        return view('Requests.ftpreq', compact('sys_users', 'ftp', 'sf', 'req', 'pros','getAllFtpRequests','getAllFolderRequests','project_id'));

    }

    Public function ViewConnectivity()
    {
        $pros = version::all();
        $protocols = DB::table('protocol')->get();
        $connectivity = DB::table('connectivity')->get();
        $project_id = Input::get('project_id');
        $id = requesth::where('project_id', '=', $project_id)->pluck('request_id');
        $all_table = DB::table('connectivityreq')->where('request_id', '=', $id)->get();

        return view('Requests.Connectivity')->with('pros', $pros)->with('protocols', $protocols)->with('connectivity', $connectivity)->with('project_id', $project_id)->with('all_table', $all_table);
    }

    public function SendConnRequest()
    {
        $send = Input::get('connect');
        $view = Input::get('view');
        $input = Request::all();
        $project_id = $input['project_id'];

        $getConnectivity = $input['connectivity'];
        $getProtocol = $input['protocol'];
        $getPort = $input['port'];
        $getSever = $input['sever'];
        $getIp = $input['ip'];

        $id = requesth::where('project_id', '=', $project_id)->get();
        $get_id = $id->first();

        if ($send) {
            $rows1 = $input['count_rows'];

            if ($get_id != null) {

                for ($i = 0; $i < $rows1; $i++) {

                    $req_id = $get_id->request_id;
                    $connectivity = $getConnectivity[$i];
                    $protocol = $getProtocol[$i];
                    $port = $getPort[$i];
                    $sever = $getSever[$i];
                    $ip = $getIp[$i];

                    if (!filter_var($ip, FILTER_VALIDATE_IP) === false) {

                        $max_subID = DB::table('connectivityreq')->where('request_id', '=', $req_id)->max('sub_id');
                        $subId = $max_subID + 1;

                        $insert = DB::table('connectivityreq')->insert(array('request_id' => $req_id,
                                'sub_id' => $subId,
                                'type' => $connectivity,
                                'protocol' => $protocol,
                                'port' => $port,
                                'sever_name' => $sever,
                                'ip_address' => $ip)
                        );
                    } else {
                        \Session::flash('flash_message_error', 'Invalid IP Address');
                        return redirect('Connectivity');
                    }

                }

                \Session::flash('flash_message', 'Request Sent Successfully');
                return redirect('Connectivity');
            } else {

                $maxRequestId = DB::table('requesths')->max('request_id');
                $newRequestId = $maxRequestId + 1;

                $user_id = Auth::User()->employeeID;
                //$user_id = 8;
                $init = new requesth;
                $init->request_id = $newRequestId;
                $init->required_from = date('yyyy-MM-dd');
                $init->required_upto = date('yyyy-MM-dd');
                $init->project_id = $project_id;
                $init->user_id = $user_id;
                $init->request_status = 1;
                $init->save();

                $subId = 1;
                for ($i = 0; $i < $rows1; $i++) {

                    $connectivity = $getConnectivity[$i];
                    $protocol = $getProtocol[$i];
                    $port = $getPort[$i];
                    $sever = $getSever[$i];
                    $ip = $getIp[$i];

//               if (empty($port) || empty($sever) || empty($ip)) {
//                    \Session::flash('flash_message_error', 'Port or Sever or Ip address Fields Cannot Be Empty');
//                    return redirect('Connectivity');
//                }
                    if (!filter_var($ip, FILTER_VALIDATE_IP) === false) {

                        $insert = DB::table('connectivityreq')->insert(array('request_id' => $newRequestId,
                                'sub_id' => $subId,
                                'type' => $connectivity,
                                'protocol' => $protocol,
                                'port' => $port,
                                'sever_name' => $sever,
                                'ip_address' => $ip)
                        );
                    } else {
                        \Session::flash('flash_message_error', 'Invalid IP Address');
                        return redirect('Connectivity');
                    }
                    $subId = $subId + 1;

                }

            }
        }

        if ($view) {
            $pros = version::all();
            $protocols = DB::table('protocol')->get();
            $connectivity = DB::table('connectivity')->get();
            $project_id = Input::get('project_id');
            $id = requesth::where('project_id', '=', $project_id)->pluck('request_id');
            $all_table = DB::table('connectivityreq')->where('request_id', '=', $id)->get();


            \Session::flash('flash_av', '');
            return view('Requests.Connectivity')->with('pros', $pros)->with('protocols', $protocols)->with('connectivity', $connectivity)->with('project_id', $project_id)->with('all_table', $all_table);
        }

    }

    public function Ftp()
    {

        $folder = Input::get('folder');
        $view = Input::get('view_all');
        $input = Request::all();
        $project_id = $input['project_id'];
        $rows2 = $input['count_rows_folder'];

        if ($folder) {

            $requestIds = requesth::where('project_id', '=', $project_id)->get();
            $requestIdCount = $requestIds->count();
            $users = $input['user'];
            $folderPermission = $input['permissions'];

            if ($users[0] == "Users" && Input::get('ftp_account') != 'yes') {
                \Session::flash('flash_message_error', 'No Requests Made');
                return redirect('ftpreq');
            }
            else {

                if ($requestIdCount != 0) {
                    $firstRow = $requestIds->first();
                    $reqId = $firstRow->request_id;

                    $max_subID = sfuser::where('request_id', '=', $reqId)->max('sub_id');
                    $subId = $max_subID + 1;

                    for ($a = 0; $a < $rows2; $a++) {
                        $username = $users[$a];
                        $permission = $folderPermission[$a];

                        if ($username != "Users") {
                            $userSeparate = explode('|', $username);
                            $uName = $userSeparate[0];
                            $uId = $userSeparate[1];

                            $sf = new sfuser;
                            $sf->request_id = $reqId;
                            $sf->sub_id = $subId;
                            $sf->user_id = $uId;
                            $sf->user_name = $uName;
                            $sf->permision = $permission;
                            $sf->type = 'Shared Folder';

                            $sf->save();
                        }

                    }
                    if (Input::get('ftp_account') === 'yes') {
                        $maxSubIdFtp = file::where('request_id', '=', $reqId)->max('sub_id');
                        $subIdFtp = $maxSubIdFtp + 1;
                        $status = 'Not Assigned';

                        $ftp = new file;

                        $ftp->request_id = $reqId;
                        $ftp->sub_id = $subIdFtp;
                        $ftp->type = "Ftp Account";
                        $ftp->status = $status;
                        $ftp->save();
                    }
                    \Session::flash('flash_message', 'Request Successfuly Sent !');
                    return redirect('ftpreq');


                }
                else {
                    $maxRequestId = DB::table('requesths')->max('request_id');
                    $newRequestId = $maxRequestId + 1;
                    $user_id = Auth::User()->employeeID;
                    //$user_id = 8;
                    $init = new requesth;
                    $init->request_id = $newRequestId;
                    $init->required_from = date('yyyy-MM-dd');
                    $init->required_upto = date('yyyy-MM-dd');
                    $init->project_id = $project_id;
                    $init->user_id = $user_id;
                    $init->request_status = 1;
                    $init->save();

                    $newSubId = 1;

                    for ($a = 0; $a < $rows2; $a++) {
                        $username = $users[$a];
                        $permission = $folderPermission[$a];

                        if ($username != "Users") {
                            $userSeparate = explode('|', $username);
                            $uName = $userSeparate[0];
                            $uId = $userSeparate[1];

                            $sf = new sfuser;
                            $sf->request_id = $newRequestId;
                            $sf->sub_id = $newSubId;
                            $sf->user_id = $uId;
                            $sf->user_name = $uName;
                            $sf->permision = $permission;
                            $sf->type = 'Shared Folder';
                            $sf->save();
                        }
                        $newSubId = $newSubId + 1;
                    }
                    if (Input::get('ftp_account') === 'yes') {
                        $maxSubIdFtp = 1;
                        $status = 'Not Assigned';

                        $ftp = new file;

                        $ftp->request_id = $newRequestId;
                        $ftp->sub_id = $maxSubIdFtp;
                        $ftp->type = "Ftp Account";
                        $ftp->status = $status;
                        $ftp->save();
                    }
                    \Session::flash('flash_message', 'Request Successfuly Sent !');
                    return redirect('ftpreq');
                }

            }

        }
        if ($view) {

            $project_id = Input::get('project_id');
            $id = requesth::where('project_id', '=', $project_id)->pluck('request_id');
            $getAllFtpRequests = file::where('request_id', '=', $id)->get();
            $getAllFolderRequests=sfuser::where('request_id', '=', $id)->get();
            $sys_users = DB::table('system_users')->get();
            $pros = version::all();
            $ftp = file::all();
            $sf = sfuser::all();
            $req = req::all();

            \Session::flash('flash_view_accounts','');
            return view('Requests.ftpreq', compact('sys_users', 'ftp', 'pros', 'sf','req','getAllFtpRequests','getAllFolderRequests','project_id'));

        }
    }

}