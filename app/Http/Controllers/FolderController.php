<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\requesth;
use Input;
use App\file;
use App\sfuser;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\SystemUser;
use Illuminate\Support\Facades\Mail;


use Illuminate\Http\Request;

class FolderController extends Controller {

    Public function ViewFolder(){

        $Allocation_id =1;
        $status='Not Assigned';
        $ids = requesth::where('request_status', '=',$Allocation_id)->get();
        $request_id = Input::get('');

        $sub_id = Input::get('value2');

        $ftp_account=file::where('request_id', '=',$request_id)->where('status','=',$status)->get();
        $ftp_count=$ftp_account->count();

        $sharedFolderRequests=sfuser::where('request_id', '=',$request_id)->where('status','=','Not Assigned')->get();
        $count_of_folder=$sharedFolderRequests->count();

        return view('Requests.AssignFolder')->with('ids',$ids)->with('ftp_account',$ftp_account)->with('sharedFolderRequests',$sharedFolderRequests)->with('folder_count',$count_of_folder)->with('sub_id',$sub_id)->with('ftp_count',$ftp_count);
    }


    Public function ViewFolderRequests()
    {

    try {

        $project_id = Input::get('project_ids');
        $request_id = requesth::where('project_id', '=', $project_id)->pluck('request_id');

        $status = 'Not Assigned';
        $Allocation_id = 1;
        $sub_id = Input::get('hid_subid');

        $ids = requesth::where('request_status', '=', $Allocation_id)->get();
        $ftp_account = file::where('request_id', '=', $request_id)->where('status', '=', $status)->get();

        $count_of_ftp = $ftp_account->count();
        $project = requesth::where('request_id', '=', $request_id)->pluck('project_id');

        $sharedFolderRequests = sfuser::where('request_id', '=', $request_id)->where('status', '=', 'Not Assigned')->get();
        $count_of_folder = $sharedFolderRequests->count();

        for ($a = 0; $a < $count_of_ftp; $a++) {


            $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?";
            $password = substr(str_shuffle($chars), 0, 8);

            $passwords[$a] = $password;

            $chars1 = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
            $uid = substr(str_shuffle($chars1), 0, 4);
            $username = $project . "-" . $uid;

            $usernames[$a] = $username;

        }

        if ($count_of_ftp != 0) {
            \Session::flash('flash_ViewRequests', '');
            return view('Requests.AssignFolder')->with('ids', $ids)->with('ftp_account', $ftp_account)->with('sharedFolderRequests', $sharedFolderRequests)->with('folder_count', $count_of_folder)->with('ftp_count', $count_of_ftp)->with('sub_id', $sub_id)->with('password', $passwords)->with('username', $usernames)->with('project_id', $project_id);
        } else {
            \Session::flash('flash_ViewRequests', '');
            return view('Requests.AssignFolder')->with('ids', $ids)->with('ftp_account', $ftp_account)->with('sharedFolderRequests', $sharedFolderRequests)->with('folder_count', $count_of_folder)->with('ftp_count', $count_of_ftp)->with('sub_id', $sub_id)->with('project_id', $project_id);

        }
    }
    catch(\Exception $e)
    {
        return Redirect::back()->withErrors($e->getMessage());
    }

    }


    Public function  AssignDataToDb()
    {

    try {

        $sub_id = Input::get('hid_s');
        $req_id = Input::get('hid_r');
        $username = Input::get('username');
        $password = Input::get('psw');
        $link = Input::get('link');

        $status = 'Assigned';
        $status1 = 'Not Assigned';
        $Allocation_id = 1;

        $ids = requesth::where('request_status', '=', $Allocation_id)->get();
        $ftp_account = file::where('request_id', '=', $req_id)->where('status', '=', $status1)->get();
        $count_of_ftp = $ftp_account->count();

        $project = requesth::where('request_id', '=', $req_id)->pluck('project_id');


        $sharedFolderRequests = sfuser::where('request_id', '=', $req_id)->where('status', '=', 'Not Assigned')->get();
        $count_of_folder = $sharedFolderRequests->count();

        for ($a = 0; $a < $count_of_ftp; $a++) {


            $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?";
            $password1 = substr(str_shuffle($chars), 0, 8);

            $passwords[$a] = $password1;

            $chars1 = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
            $uid = substr(str_shuffle($chars1), 0, 4);
            $username1 = $project . "-" . $uid;

            $usernames[$a] = $username1;

        }


        if (preg_match("#^[a-zA-Z0-9]*[:.][/]+[a-zA-Z0-9]+#",$link)) {

            $r = DB::table('files')
                ->where('request_id', $req_id)
                ->where('sub_id', $sub_id)
                ->update(array('username' => $usernames[0], 'password' => $passwords[0], 'link' => $link, 'status' => $status));


            $username1 = $usernames[0];
            $password1 = $passwords[0];

            $ftp_account = file::where('request_id', '=', $req_id)->where('status', '=', $status1)->get();
            $count_of_ftp = $ftp_account->count();

            $user_id = requesth::where('request_id', '=', $req_id)->pluck('user_id');
            $user_d = SystemUser::where('id', $user_id)->get();

            $user_data = $user_d[0];
            $user = $user_data->username;
            $email = $user_data->email;
            $date = date('d-M-y');


            Mail::send('Requests.FtpAccountEmail', array('user' => $user, 'project' => $project, 'date' => $date, 'username' => $username1, 'password' => $password1, 'link' => $link), function ($message) use ($user, $email) {
                $message->to($email, $user)->subject('Ftp AccountAllocation');
            });


            $passwords[] = "";
            $usernames[] = "";


            \Session::flash('flash_message_url_success', 'Ftp Account Has Successfully Assigned ');
            return view('Requests.AssignFolder')->with('project_id', $project)->with('ftp_account', $ftp_account)->with('sharedFolderRequests', $sharedFolderRequests)->with('folder_count', $count_of_folder)->with('ftp_count', $count_of_ftp)->with('ids', $ids)->with('password', $passwords)->with('sub_id', $sub_id)->with('username', $usernames);

        } else {

            $ftp_account = file::where('request_id', '=', $req_id)->where('status', '=', $status1)->get();
            $count_of_ftp = $ftp_account->count();

            \Session::flash('flash_message_url_error', 'Invalid Url Type');
            return view('Requests.AssignFolder')->with('project_id', $project)->with('ftp_account', $ftp_account)->with('sharedFolderRequests', $sharedFolderRequests)->with('folder_count', $count_of_folder)->with('ftp_count', $count_of_ftp)->with('ids', $ids)->with('password', $passwords)->with('sub_id', $sub_id)->with('username', $usernames);

        }
    }

    catch(\Exception $e)
    {
        return Redirect::back()->withErrors($e->getMessage());
    }


    }

    Public function CancelAccount()
    {

    try {

        $sub_id = Input::get('cancel_subid');
        $req_id = Input::get('cancel_requestid');

        $status2 = 'Canceled';
        $catch = Input::get('valueCancel');

        $status1 = 'Not Assigned';
        $Allocation_id = 1;

        $ids = requesth::where('request_status', '=', $Allocation_id)->get();

        $ftp_account = file::where('request_id', '=', $req_id)->where('status', '=', $status1)->get();
        $count_of_ftp = $ftp_account->count();

        $project = requesth::where('request_id', '=', $req_id)->pluck('project_id');


        $sharedFolderRequests = sfuser::where('request_id', '=', $req_id)->where('status', '=', 'Not Assigned')->get();
        $count_of_folder = $sharedFolderRequests->count();


        for ($a = 0; $a < $count_of_ftp; $a++) {


            $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?";
            $password1 = substr(str_shuffle($chars), 0, 8);

            $passwords[$a] = $password1;

            $chars1 = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
            $uid = substr(str_shuffle($chars1), 0, 4);
            $username1 = $project . "-" . $uid;

            $usernames[$a] = $username1;

        }

        if ($catch == 'true') {

            $r = DB::table('files')
                ->where('request_id', $req_id)
                ->where('sub_id', $sub_id)
                ->update(array('status' => $status2));


            $ftp_account = file::where('request_id', '=', $req_id)->where('status', '=', $status1)->get();
            $count_of_ftp = $ftp_account->count();


            \Session::flash('flash_message_url_success', 'Ftp Account Request Has Been Cancelled');
            return view('Requests.AssignFolder')->with('project_id', $project)->with('ftp_account', $ftp_account)->with('sharedFolderRequests', $sharedFolderRequests)->with('folder_count', $count_of_folder)->with('ftp_count', $count_of_ftp)->with('ids', $ids)->with('password', $passwords)->with('sub_id', $sub_id)->with('username', $usernames);

        } else {

            return view('Requests.AssignFolder')->with('project_id', $project)->with('ftp_account', $ftp_account)->with('sharedFolderRequests', $sharedFolderRequests)->with('folder_count', $count_of_folder)->with('ftp_count', $count_of_ftp)->with('ids', $ids)->with('sub_id', $sub_id)->with('password', $passwords)->with('username', $usernames);

        }

    }

    catch(\Exception $e)
    {
        return Redirect::back()->withErrors($e->getMessage());
    }

    }

    Public function AssignSharedFolder(){

    try{

        $folderRequestId=Input::get('folderRequestId');
        $folderSubId=Input::get('folderSubId');
        $path=Input::get('path');

        $Allocation_id =1;
        $ids = requesth::where('request_status', '=',$Allocation_id)->get();

        $project=requesth::where('request_id', '=',$folderRequestId)->pluck('project_id');

        $ftp_account=file::where('request_id', '=',$folderRequestId)->where('status','=','Not Assigned')->get();
        $count_of_ftp=$ftp_account->count();

        $sharedFolderRequests = sfuser::where('request_id', '=', $folderRequestId)->where('status', '=', 'Not Assigned')->get();
        $count_of_folder = $sharedFolderRequests->count();

        $passwords[]="";
        $usernames[]="";

        for($a=0;$a<$count_of_ftp;$a++) {


            $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?";
            $password1 = substr(str_shuffle($chars), 0, 8);

            $passwords[$a]=$password1;

            $chars1 = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
            $uid = substr(str_shuffle($chars1), 0, 4);
            $username1 = $project . "-" . $uid;

            $usernames[$a]=$username1;

        }


        if(!filter_var($path, FILTER_VALIDATE_URL) === false)
        {

            $AssignFolder = DB::table('sfusers')
                ->where('request_id', $folderRequestId)
                ->where('sub_id', $folderSubId)
                ->update(array('path' => $path, 'status' => 'Assigned'));


            $sharedFolderRequests = sfuser::where('request_id', '=', $folderRequestId)->where('status', '=', 'Not Assigned')->get();
            $count_of_folder = $sharedFolderRequests->count();


            $user_id=requesth::where('request_id', '=',$folderRequestId)->pluck('user_id');
            $user_d = SystemUser::where('id',$user_id)->get();

            $user_data = $user_d[0];
            $user = $user_data->username;
            $email = $user_data->email;
            $date=date('d-M-y');


            Mail::send('Requests.AccountFolderEmail', array('project' => $project,'user' => $user,'date' => $date,'path' => $path), function ($message) use ($user, $email) {
                $message->to($email, $user)->subject('Shared Folder Allocation');
            });


            \Session::flash('flash_message_url_success', 'Shared folder is assigned to project');
            return view('Requests.AssignFolder')->with('project_id', $project)->with('ftp_account', $ftp_account)->with('sharedFolderRequests', $sharedFolderRequests)->with('folder_count', $count_of_folder)->with('ftp_count', $count_of_ftp)->with('ids', $ids)->with('sub_id', $folderSubId)->with('password', $passwords)->with('username', $usernames);

        }

        else
        {

            \Session::flash('flash_message_url_error', 'Invalid Path For Shared Folder');
            return view('Requests.AssignFolder')->with('project_id',$project)->with('ftp_account',$ftp_account)->with('sharedFolderRequests',$sharedFolderRequests)->with('folder_count',$count_of_folder)->with('ftp_count',$count_of_ftp)->with('ids',$ids)->with('password',$passwords)->with('sub_id',$folderSubId)->with('username',$usernames);

        }
    }

    catch(\Exception $e)
    {
        return Redirect::back()->withErrors($e->getMessage());
    }

    }

    Public function CancelSharedFolder(){

    try {

        $folderRequestId = Input::get('cancelFolderRequestId');
        $folderSubId = Input::get('cancelFolderSubId');

        $value = Input::get('folderCancelVale');

        $Allocation_id = 1;
        $ids = requesth::where('request_status', '=', $Allocation_id)->get();

        $project = requesth::where('request_id', '=', $folderRequestId)->pluck('project_id');


        $ftp_account = file::where('request_id', '=', $folderRequestId)->where('status', '=', 'Not Assigned')->get();
        $count_of_ftp = $ftp_account->count();


        $sharedFolderRequests = sfuser::where('request_id', '=', $folderRequestId)->where('status', '=', 'Not Assigned')->get();
        $count_of_folder = $sharedFolderRequests->count();

        $passwords[] = "";
        $usernames[] = "";

        for ($a = 0; $a < $count_of_ftp; $a++) {


            $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?";
            $password1 = substr(str_shuffle($chars), 0, 8);

            $passwords[$a] = $password1;

            $chars1 = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
            $uid = substr(str_shuffle($chars1), 0, 4);
            $username1 = $project . "-" . $uid;

            $usernames[$a] = $username1;

        }

        if ($value == 'true') {

            $r = DB::table('sfusers')
                ->where('request_id', $folderRequestId)
                ->where('sub_id', $folderSubId)
                ->update(array('status' => 'Cancelled'));


            $sharedFolderRequests = sfuser::where('request_id', '=', $folderRequestId)->where('status', '=', 'Not Assigned')->get();
            $count_of_folder = $sharedFolderRequests->count();


            \Session::flash('flash_message_url_success', 'Shared Folder Request Has Been Cancelled');
            return view('Requests.AssignFolder')->with('project_id', $project)->with('ftp_account', $ftp_account)->with('sharedFolderRequests', $sharedFolderRequests)->with('folder_count', $count_of_folder)->with('ftp_count', $count_of_ftp)->with('ids', $ids)->with('password', $passwords)->with('sub_id', $folderSubId)->with('username', $usernames);

        } else {

            return view('Requests.AssignFolder')->with('project_id', $project)->with('ftp_account', $ftp_account)->with('sharedFolderRequests', $sharedFolderRequests)->with('folder_count', $count_of_folder)->with('ftp_count', $count_of_ftp)->with('ids', $ids)->with('sub_id', $folderSubId)->with('password', $passwords)->with('username', $usernames);

        }
    }

    catch(\Exception $e)
    {
        return Redirect::back()->withErrors($e->getMessage());
    }

    }



}
