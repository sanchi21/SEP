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
use Illuminate\Support\Facades\DB;
class FtpController extends Controller {

    Public function FindU(){

        //$sys_users=User::all();
		$sys_users=DB::table('system_users')->get();
		
        $pros=version::all();
        $ftp=file::all();
        $sf=sfuser::all();
        $req=req::all();
        return view('Requests.ftpreq',compact('sys_users','ftp','sf','req','pros') );

    }

    Public function ViewConnectivity(){
        $pros=version::all();
        $protocols=DB::table('protocol')->get();
        $connectivity=DB::table('connectivity')->get();
        return view('Requests.Connectivity')->with('pros',$pros)->with('protocols',$protocols)->with('connectivity',$connectivity);
    }

    public function SendConnRequest()
    {
        //$type=Input::get('project_id');
        $send = Input::get('connect');
        $view = Input::get('view');
        $input = Request::all();
        $project_id = $input['project_id'];
        $connectivity = $input['connectivity'];
        $protocol = $input['protocol'];
        $port = $input['port'];
        $sever = $input['sever'];
        $ip = $input['ip'];
        $id = requesth::where('project_id', '=', $project_id)->get();
        $get_id = $id->first();
        $req_id = $get_id->request_id;
        $max_subID = DB::table('connectivityreq')->where('request_id', '=', $req_id)->max('sub_id');
        $subId = $max_subID + 1;

        if ($send)
        {
            if (empty($port) || empty($sever) || empty($ip)) {
                \Session::flash('flash_message_error', 'Port or Sever or Ip address Fields Cannot Be Empty');
                return redirect('Connectivity');
            }
            else{
                if (!filter_var($ip, FILTER_VALIDATE_IP) === false) {
                    $insert=DB::table('connectivityreq')->insert(array('request_id' =>$req_id,
                            'sub_id' => $subId,
                            'type' => $connectivity,
                            'protocol' => $protocol,
                            'port' => $port,
                            'sever_name' => $sever,
                            'ip_address' =>$ip)
                    );
                    \Session::flash('flash_message', 'Request Sent Successfully');
                    return redirect('Connectivity');
                }
                else {
                    \Session::flash('flash_message_error', 'Invalid IP Address');
                    return redirect('Connectivity');
                }
            }
        }

       if($view)
        {
            $pros=version::all();
            $protocols=DB::table('protocol')->get();
            $connectivity=DB::table('connectivity')->get();
            $project_id = Input::get('project_id');
            $id = requesth::where('project_id', '=', $project_id)->pluck('request_id');
            $all_table =DB::table('connectivityreq')->where('request_id','=',$id)->get();


            \Session::flash('flash_av','');
            return view('Requests.Connectivity')->with('pros',$pros)->with('protocols',$protocols)->with('connectivity',$connectivity)->with('project_id',$project_id)->with('all_table',$all_table);


        }

    }

    public function Ftp()
    {
        $ftp = Input::get('ftp');
        $folder=Input::get('folder');
        $set=Input::get('set');
        $input = Request::all();
        $project_id = $input['project_id'];

        if ($folder) {
            if (empty($project_id)) {
                \Session::flash('flash_message', 'Prject_ID cannot be empty');
                return redirect('ftpreq');
            }
            else {
                $id = requesth::where('project_id', '=', $project_id)->get();
                $b = $id->count();


                if($b!=0)
                {
                    $a = $id->first();
                    $req_id = $a->request_id;
                    $users=$input['user'];
                    $size=sizeof($users);
                    $max_subID = sfuser::where('request_id', '=', $req_id)->max('sub_id');
                    $subId = $max_subID + 1;
                    for($a=0; $a<$size;$a++) {
                        $temp = $users[$a];
                        //$take=User::where('username', '=',$temp)->get();
						$take=DB::table('system_users')->where('username', '=',$temp)->pluck('id');
                        $user_id=$take;
						//$take1=$take->first();
                        //$user_id=$take1->id;

                        $sf = new sfuser;
                        $sf->request_id = $req_id;
                        $sf->sub_id = $subId;
                        $sf->user_id = $user_id;
                        $sf->user_name =$temp;
                        $sf->type ='Shared Folder';
                        $sf->save();
                    }
                    $set_users=sfuser::where('sub_id', '=', $subId)->get();
                    $sys_users=User::all();
                    $pros=version::all();
                    $ftp=file::all();
                    $sf=sfuser::all();
                    $req=req::all();
                    \Session::flash('flash_permission','');
                    return view('Requests.ftpreq')->with('sys_users',$sys_users)->with('pros',$pros)->with('ftp',$ftp)->with('sf',$sf)->with('req',$req)->with('set_users',$set_users);



//                      \Session::flash('flash_message', 'Shared Folder Request Sent');
//                       return redirect('ftpreq');

                }

                else
                {
                    \Session::flash('flash_message', 'Request for this project does not exist');
                    return redirect('ftpreq');
                }


                 }

        }

        if($set){

            $input = Request::all();
            $sf_users=$input['hid3'];
            $permission=$input['permission'];
            $rid=$input['hid1'];
            $sid=$input['hid2'];

            $size=sizeof($sf_users);

            for($a=0; $a<$size;$a++) {
                $temp = $sf_users[$a];
                $temp2=$permission[$a];
                $r = DB::table('sfusers')
                    ->where('request_id', $rid)
                    ->where('sub_id', $sid)
                    ->where('user_name',$temp)
                    ->update(array('permision' => $temp2));

            }
            \Session::flash('flash_message', 'Permissions successfully set');
            return redirect('ftpreq');

        }

        else {

            if (empty($project_id)) {
                \Session::flash('flash_message', 'Prject_ID cannot be empty');
                return redirect('ftpreq');
            }
            else {
                $id = requesth::where('project_id', '=', $project_id)->get();
                $b = $id->count();

                if($b!=0)
                {
                    $a = $id->first();
                    $req_id = $a->request_id;

                    $max_subID = file::where('request_id', '=', $req_id)->max('sub_id');
                    $subId = $max_subID + 1;
                    $ftp = new file;

                    $ftp->request_id = $req_id;
                    $ftp->sub_id = $subId;
                    $ftp->type = "Ftp Account";
                    if($ftp->save()) {
                        \Session::flash('flash_message', 'FTP Request Sent');
                        return redirect('ftpreq');
                    }
                    else{
                        \Session::flash('flash_message', 'Request Failure');
                        return redirect('ftpreq');
                    }
                }

                else
                {
                    \Session::flash('flash_message', 'Request for this project does not exist');
                    return redirect('ftpreq');
                }

            }

        }
    }




}
