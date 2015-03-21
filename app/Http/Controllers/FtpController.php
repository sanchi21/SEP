<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\file;
use App\sfuser;
use App\User;
use App\requesth;
use Request;
use Input;

class FtpController extends Controller {

    Public function FindU(){

        $sys_users=User::all();
        return view('Requests.ftpreq',compact('sys_users') );

    }

    Public function view(){
        return view('Requests.ftpreq');
    }

    public function Ftp()
    {
        $ftp = Input::get('ftp');
        $input = Request::all();
        $type = "ftp account";
        $type1 = "Share Folder";
        $project_id = $input['project_id'];

        if (!$ftp) {
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
                        $take=User::where('username', '=',$temp)->get();
                        $take1=$take->first();
                        $user_id=$take1->id;

                        $sf = new sfuser;
                        $sf->request_id = $req_id;
                        $sf->sub_id = $subId;
                        $sf->user_id = $user_id;
                        $sf->user_name =$temp;
                        $sf->type = $type1;
                        $sf->save();
                    }

                      \Session::flash('flash_message', 'Shared Folder Request Sent');
                       return redirect('ftpreq');

                }

                else
                {
                    \Session::flash('flash_message', 'Request for this project does not exist');
                    return redirect('ftpreq');
                }


                 }

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
                    $ftp->type = $type;
                    $ftp->save();
                    \Session::flash('flash_message', 'FTP Request Sent');
                    return redirect('ftpreq');

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
