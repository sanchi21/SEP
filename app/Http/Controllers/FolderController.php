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
use Illuminate\Support\Facades\Redirect;


use Illuminate\Http\Request;

class FolderController extends Controller {


    /**
     * returns all the request made for ftp accounts and
     * shared folder
     * Retrieved separately for each and every projects
     *
     * @return $this
     */

    Public function ViewFolder()
    {

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


    /**
     * Loads the view of the blade page
     *
     * @return \Illuminate\View\View
     */

    Public function getViewAccounts()
    {

        return view('Requests.ViewAccounts');

    }


    /**
     * Edit method for ftp accounts
     * Passwords and username are editable
     * View assigned accounts and edit if necessary
     *
     * @return $this
     */

    Public function EditAccountChanges()
    {

        $username=Input::get('username');
        $password=Input::get('psw');
        $link=Input::get('link');
        $requestID=Input::get('hid_r');
        $subId=Input::get('hid_s');
        $project_id = Input::get('hid_p');
        $status="Assigned";
        $save=Input::get('save');

        $checkUsername=file::where('username', '=', $username)->get();
        $firstRow = $checkUsername->first();


        if($save)                 /* If save button is pressed */
        {

            if ($username == "" || $password == "")   /* Validate username and password */
            {

                $ftpAccountAllocations = file::where('request_id', '=', $requestID)->where('status', '=', $status)->get();

                \Session::flash('flash_message_error', 'Username and password cannot be empty');

                return view('Requests.ViewAccounts')->with('project_id', $project_id)->with('ftpAccountAllocations', $ftpAccountAllocations);

            }

            elseif($firstRow != null)
            {

                $ftpAccountAllocations = file::where('request_id', '=', $requestID)->where('status', '=', $status)->get();

                \Session::flash('flash_message_error', 'This Username Is Already in Use!');

                return view('Requests.ViewAccounts')->with('project_id', $project_id)->with('ftpAccountAllocations', $ftpAccountAllocations);

            }

            else
            {
                $UpdatePRequest = file::where('request_id', $requestID)
                    ->where('sub_id', $subId)
                    ->update(array('username' => $username, 'password' => $password));

                /* Get user information */

                $user_id = requesth::where('request_id', '=', $requestID)->pluck('user_id');
                $user_d = SystemUser::where('id', $user_id)->get();

                /* Get project information */

                $project = requesth::where('request_id', '=', $requestID)->pluck('project_id');

                $user_data = $user_d[0];
                $user = $user_data->username;
                $email = $user_data->email;
                $date = date('d-M-y');


                /* Send email to the account requester */

                Mail::send('Requests.EditFtpMail', array('user' => $user, 'project' => $project, 'date' => $date, 'username' => $username, 'password' => $password, 'link' => $link), function ($message) use ($user, $email) {
                    $message->to($email, $user)->subject('Change Of FTP Username');
                });



                $ftpAccountAllocations = file::where('request_id', '=', $requestID)->where('status', '=', $status)->get();


                \Session::flash('flash_message', 'Modifications saved successfully');
                return view('Requests.ViewAccounts')->with('project_id', $project_id)->with('ftpAccountAllocations', $ftpAccountAllocations);

            }

        }

        else      /* Cancel the edited information */
        {

            $ftpAccountAllocations = file::where('request_id', '=', $requestID)->where('status', '=', $status)->get();

            \Session::flash('flash_message', 'Modifications were NOT SAVED');
            return view('Requests.ViewAccounts')->with('project_id', $project_id)->with('ftpAccountAllocations', $ftpAccountAllocations);

        }


    }


    /**
     * View all the requests made for shared folder
     * return the requests for projects
     *
     * @return $this
     */

    Public function ViewFolderRequests()
    {

        try
        {

            $views=Input::get('ViewRequests');
            $allocations=Input::get('allocation');

            if($views)
            {

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

                $username = $project;

                if ($count_of_ftp != 0)
                {

                    \Session::flash('flash_ViewRequests', '');
                    return view('Requests.AssignFolder')->with('ids', $ids)->with('ftp_account', $ftp_account)->with('sharedFolderRequests', $sharedFolderRequests)->with('folder_count', $count_of_folder)->with('ftp_count', $count_of_ftp)->with('sub_id', $sub_id)->with('username', $username)->with('project_id', $project_id);

                }

                else
                {

                    \Session::flash('flash_ViewRequests', '');
                    return view('Requests.AssignFolder')->with('ids', $ids)->with('ftp_account', $ftp_account)->with('sharedFolderRequests', $sharedFolderRequests)->with('folder_count', $count_of_folder)->with('ftp_count', $count_of_ftp)->with('sub_id', $sub_id)->with('project_id', $project_id);

                }

            }

            else  /* view assigned ftp accounts */
            {

                    $status="Assigned";
                    $project_id = Input::get('project_ids');   //from drop down

                    $request_id = requesth::where('project_id', '=', $project_id)->pluck('request_id');
                    $ftpAccountAllocations = file::where('request_id', '=', $request_id)->where('status','=',$status)->get();

                    return view('Requests.ViewAccounts')->with('project_id', $project_id)->with('ftpAccountAllocations',$ftpAccountAllocations);


            }

        }

        catch(\Exception $e)
        {

            return Redirect::back()->withErrors($e->getMessage());

        }

    }


    /**
     * Assign the relevant information to ftp
     * retrieve password, username and ftp url
     * assign them database
     * save status to assigned
     *
     * @return $this
     */

    Public function  AssignDataToDb()
    {

        try
        {

            $sub_id = Input::get('hid_s');
            $req_id = Input::get('hid_r');
            $username = Input::get('username');
            $password = Input::get('psw');
            $link = Input::get('link');

            $status = 'Assigned';
            $status1 = 'Not Assigned';
            $Allocation_id = 1;

            $ids = requesth::where('request_status', '=', $Allocation_id)->get();

            $project = requesth::where('request_id', '=', $req_id)->pluck('project_id');


            $sharedFolderRequests = sfuser::where('request_id', '=', $req_id)->where('status', '=', 'Not Assigned')->get();
            $count_of_folder = $sharedFolderRequests->count();

            $checkUsername=file::where('username', '=', $username)->get();
            $firstRow = $checkUsername->first();


            if($firstRow != null)  /* Check whether the username is already in use */
            {

                 $usernames = $project;

                 $ftp_account = file::where('request_id', '=', $req_id)->where('status', '=', $status1)->get();
                 $count_of_ftp = $ftp_account->count();

                \Session::flash('flash_message_url_error', 'This username is already in use.Try a new username.');
                return view('Requests.AssignFolder')->with('project_id', $project)->with('ftp_account', $ftp_account)->with('sharedFolderRequests', $sharedFolderRequests)->with('folder_count', $count_of_folder)->with('ftp_count', $count_of_ftp)->with('ids', $ids)->with('sub_id', $sub_id)->with('username', $usernames);

            }

            elseif( $username == "" || $password == "" || $link == "")
            {

                $usernames = $project;

                $ftp_account = file::where('request_id', '=', $req_id)->where('status', '=', $status1)->get();
                $count_of_ftp = $ftp_account->count();

                \Session::flash('flash_message_url_error', 'Username or password or url cannot be empty');
                return view('Requests.AssignFolder')->with('project_id', $project)->with('ftp_account', $ftp_account)->with('sharedFolderRequests', $sharedFolderRequests)->with('folder_count', $count_of_folder)->with('ftp_count', $count_of_ftp)->with('ids', $ids)->with('sub_id', $sub_id)->with('username', $usernames);

            }


             elseif(!filter_var($link, FILTER_VALIDATE_URL) === false) /* Validate URL */
             {

                 $r = DB::table('files')
                     ->where('request_id', $req_id)
                     ->where('sub_id', $sub_id)
                     ->update(array('username' => $username, 'password' => $password, 'link' => $link, 'status' => $status));


                 $ftp_account = file::where('request_id', '=', $req_id)->where('status', '=', $status1)->get();
                 $count_of_ftp = $ftp_account->count();

                 $user_id = requesth::where('request_id', '=', $req_id)->pluck('user_id');
                 $user_d = SystemUser::where('id', $user_id)->get();

                 $user_data = $user_d[0];
                 $user = $user_data->username;
                 $email = $user_data->email;
                 $date = date('d-M-y');


                 /* Send email to the account requester */

                 Mail::send('Requests.FtpAccountEmail', array('user' => $user, 'project' => $project, 'date' => $date, 'username' => $username, 'password' => $password, 'link' => $link), function ($message) use ($user, $email) {
                     $message->to($email, $user)->subject('Ftp AccountAllocation');
                 });

                 $usernames = $project;


                 \Session::flash('flash_message_url_success', 'Ftp Account Has Successfully Assigned ');
                 return view('Requests.AssignFolder')->with('project_id', $project)->with('ftp_account', $ftp_account)->with('sharedFolderRequests', $sharedFolderRequests)->with('folder_count', $count_of_folder)->with('ftp_count', $count_of_ftp)->with('ids', $ids)->with('sub_id', $sub_id)->with('username', $usernames);

             }

             else
            {

                $ftp_account = file::where('request_id', '=', $req_id)->where('status', '=', $status1)->get();
                $count_of_ftp = $ftp_account->count();

                \Session::flash('flash_message_url_error', 'Invalid Url Type');
                return view('Requests.AssignFolder')->with('project_id', $project)->with('ftp_account', $ftp_account)->with('sharedFolderRequests', $sharedFolderRequests)->with('folder_count', $count_of_folder)->with('ftp_count', $count_of_ftp)->with('ids', $ids)->with('sub_id', $sub_id)->with('username', $usernames);

            }

        }

        catch(\Exception $e)
        {

             return Redirect::back()->withErrors($e->getMessage());

        }


    }


    /**
     * Cancel the ftp account request
     * save the status as cancelled
     *
     * @return $this
     */


    Public function CancelAccount()
    {

        try
        {

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


            $usernames=$project;

            if ($catch == 'true')
            {

                $r = DB::table('files')
                    ->where('request_id', $req_id)
                    ->where('sub_id', $sub_id)
                    ->update(array('status' => $status2));


                $ftp_account = file::where('request_id', '=', $req_id)->where('status', '=', $status1)->get();
                $count_of_ftp = $ftp_account->count();


                \Session::flash('flash_message_url_success', 'Ftp Account Request Has Been Cancelled');
                return view('Requests.AssignFolder')->with('project_id', $project)->with('ftp_account', $ftp_account)->with('sharedFolderRequests', $sharedFolderRequests)->with('folder_count', $count_of_folder)->with('ftp_count', $count_of_ftp)->with('ids', $ids)->with('sub_id', $sub_id)->with('username', $usernames);

            }

            else
            {

                return view('Requests.AssignFolder')->with('project_id', $project)->with('ftp_account', $ftp_account)->with('sharedFolderRequests', $sharedFolderRequests)->with('folder_count', $count_of_folder)->with('ftp_count', $count_of_ftp)->with('ids', $ids)->with('sub_id', $sub_id)->with('username', $usernames);

            }

        }

        catch(\Exception $e)
        {

             return Redirect::back()->withErrors($e->getMessage());

        }

    }


    /**
     * Assign the relevant information to shared folder
     * retrieve shared folder path
     * assign the values database
     * save status to assigned
     *
     * @return $this
     */


    Public function AssignSharedFolder()
    {

        try
        {

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


            $usernames=$project;

            if(preg_match("#^[a-zA-Z0-9_\\\\:.-]+#",$path))
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
                return view('Requests.AssignFolder')->with('project_id', $project)->with('ftp_account', $ftp_account)->with('sharedFolderRequests', $sharedFolderRequests)->with('folder_count', $count_of_folder)->with('ftp_count', $count_of_ftp)->with('ids', $ids)->with('sub_id', $folderSubId)->with('username', $usernames);

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


    /**
     * Cancel the shared folder request
     * save the status as cancelled
     *
     * @return $this
     */

    Public function CancelSharedFolder()
    {

        try
        {

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

            $usernames=$project;


            if ($value == 'true')
            {

                $r = DB::table('sfusers')
                    ->where('request_id', $folderRequestId)
                    ->where('sub_id', $folderSubId)
                    ->update(array('status' => 'Cancelled'));


                $sharedFolderRequests = sfuser::where('request_id', '=', $folderRequestId)->where('status', '=', 'Not Assigned')->get();
                $count_of_folder = $sharedFolderRequests->count();


                \Session::flash('flash_message_url_success', '');
                return view('Requests.AssignFolder')->with('project_id', $project)->with('ftp_account', $ftp_account)->with('sharedFolderRequests', $sharedFolderRequests)->with('folder_count', $count_of_folder)->with('ftp_count', $count_of_ftp)->with('ids', $ids)->with('sub_id', $folderSubId)->with('username', $usernames);

            }

            else
            {

                return view('Requests.AssignFolder')->with('project_id', $project)->with('ftp_account', $ftp_account)->with('sharedFolderRequests', $sharedFolderRequests)->with('folder_count', $count_of_folder)->with('ftp_count', $count_of_ftp)->with('ids', $ids)->with('sub_id', $folderSubId)->with('username', $usernames);

            }
        }

        catch(\Exception $e)
        {

            return Redirect::back()->withErrors($e->getMessage());

        }

    }


}
