<?php namespace App\Http\Controllers;


use App\active_users;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\User;
use App\system_users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Auth;
use URL;




class Authentication_Controller extends Controller {


    public function getChangePassword()
    {
        return view('authentication.changePassword');
    }
    public function postChangePassword()
    {
        $validator = validator::make(Input::all(),
            array(
                'old_password' =>'required',
                'password' => 'required|min:6',
                'password_again' => 'required|same:password'
            )
        );
        if($validator->fails())
        {
            //redirect
            return Redirect::route('account-change-password')->withErrors($validator);
        }
        else
        {
            //change password
            $user = User::find(Auth::user()->id);
            $old_password = Input::get('old_password');
            $password = Input::get('password');

            if(Hash::check($old_password,$user->getAuthPassword()))
            {
                //password user provided matches!
                $user->password = Hash::make($password);
                if($user->save())
                {
                    \Session::flash('flash_message_success','your password has been changed');
                    return Redirect::route('account-change-password');
                }
            }
            \Session::flash('flash_message','Your old password is incorrect');
            return Redirect::route('account-change-password');
            //return Redirect::route('account-change-password')->with('global','Your old password is incorrect');
        }
        return Redirect::route('account-change-password')->with('global','Your password could not be changed');
    }

    public function getForgotPassword()
    {
        return view('authentication.forgotPassword');
    }

    public function postForgotPassword()
    {
        $validator= validator::make(input::all(),
            array
            (
                'email' => 'required|email'
            )
        );

        if($validator->fails())
        {
            return Redirect::route('forgotPassword')->withErrors($validator)->withInput();
        }
        else
        {
            //change password
            $user = User::where('email','=',Input::get('email'));

            if($user->count())
            {
                $user = $user->first();

                //generate a new code and password
                $code = str_random(60);
                $password = str_random(10);

                $user->code = $code;
                $user->password_temp = Hash::make($password);

                if($user->save())//once the user save successfully
                {
                    Mail::send('emails.forgotPassword', array('link' => URL::route('forgot-password-recover',$code), 'username'=>$user->username, 'password'=> $password),function($message) use ($user)
                    {
                        $message->to($user->email, $user->username)->subject('Your new password');
                    });

                    \Session::flash('flash_message_success','We have sent you an email that you can use to change your password');
                    return Redirect::route('account-login');
                }
            }
        }
        return Redirect::route('forgotPassword')->with('global','could not request new password');
    }

    public function getRecover($code)
    {
        $user = User::Where('code','=',$code)->where('password_temp','!=','');

        if($user->count())
        {
            $user = $user->first();
            $user->password=$user->password_temp;
            $user->password_temp='';
            $user->code='';

            if($user->save())
            {
                return Redirect::route('home')->with('global','your account has been recovered and you can sign in with your new password');
            }
        }
        return Redirect::route('home')->with('global','could not recover your account');
    }


    public function getLogin()
    {
        return view('authentication.login');
    }

    public function postLogin()
    {
        // validate the info, create rules for the inputs
        $rules = array(
            'email'    => 'required|email', // make sure the email is an actual email
            'password' => 'required|min:3' // password can only be alphanumeric and has to be greater than 3 characters
        );

        // run the validation rules on the inputs from the form
        $validator = Validator::make(Input::all(), $rules);

        // if the validator fails, redirect back to the form
        if ($validator->fails()) {
            //return Redirect::to('login')
            return Redirect::route('account-login')
                ->withErrors($validator) // send back all errors to the login form
                ->withInput(Input::except('password')); // send back the input (not the password) so that we can repopulate the form
        } else {
            $remember = (Input::has('remember')) ? true : false;

            $auth = Auth::attempt(array(
                'email'     => Input::get('email'),
                'password'  => Input::get('password'),
                'active'     => 1
            ), $remember);



            // attempt to do the login
            if ($auth) {

                // validation successful!
                //return Redirect::intended('/');
                if(Auth::user()->permissions=='Administrator Full')
                {
                    return Redirect::route('home-admin-full');
                }
                elseif(Auth::user()->permissions=='Administrator Limit')
                {
                    return Redirect::route('home-admin-limited');
                }
                elseif(Auth::user()->permissions=='Project Manager')
                {
                    return Redirect::route('hardwarereq');
                }


            } else {

                // validation not successful, send back to form
                \Session::flash('flash_message','No record match or account is not activated');
                return Redirect::route('account-login');
//                return Redirect::intended('/');

            }

        }
        \Session::flash('flash_message','There was a problem signing you');
        return Redirect::route('account-login');

    }

    public function postAddUser()
    {
            $newUsername = Input::get('activeUserNames');
            $permissions = Input::get('sltPermissions');

        $system_users =  User::where('username','=',$newUsername);
        $count = ($system_users->count());

        if($count == 1){
            \Session::flash('flash_message','User already exists');
            return Redirect::route('add-user');
        }
        else
        {



        $active_users = active_users::where('username','=',$newUsername);

            if($active_users->count()) {
                $active_user = $active_users->first(); //picking first record for the above condition in active user table

                //get user records from existing directory

                //generate a new code and password
                $code = str_random(60);
                $password = str_random(5);
                $active_user_email = $active_user->email;
                $user = User::create(array(
                        'username' => $newUsername,
                        'password_temp' => Hash::make($password),
                        'code' => $code,
                        'active' => 0,
                        'email' => $active_user_email,
                        'role_id' => 1,
                        'permissions' => $permissions
                    )
                );



                if($user->save())//once the user save successfully
                {
                    Mail::send('emails.userActivation', array('link' => URL::route('activate',$code), 'username'=>$user->$newUsername, 'password'=> $password),function($message) use ($user)
                    {
                        $message->to($user->email, $user->username)->subject('Your new password');
                    });


                    \Session::flash('flash_message','User is connected with this system');
                    return Redirect::route('add-user');
                }
                else
                {

                }




            }
            else
            {
                \Session::flash('flash_message','User is not registered in zone24');
                return Redirect::route('add-user');
            }




        }
    }

    public function test()
    {
        return 'asdasd';
    }
    public function showSystemUsers()
    {
        $system_users= User::all();
        $active_users= active_users::all();
    }
    public function getAddUser()
    {
//        $system_users= User::all();
//        $active_users= active_users::all();
//        if (Auth::user() && Auth::user()->role_id ==0 )
//        {
//
//            return view('authentication.addUsers')->with('systemUsers',$system_users);
//        }
//            return view('authentication.login');

//
        $system_users= User::all();
        $active_users= active_users::all();

        return view('authentication.addUsers')->with('systemUsers',$system_users)->with('activeUsers',$active_users);

    }

    public function getActivate($code)
    {
        $user = User::Where('code','=',$code)->where('password_temp','!=','');

        if($user->count())
        {
            $user = $user->first();
            $user->password=$user->password_temp;
            $user->password_temp='';
            $user->code='';
            $user->active =1; //activate account

            if($user->save())
            {
                return Redirect::route('home')->with('global','Activated! you can now login in');
            }
        }
//
//        $user = User::where('code','=',$code)->where('active','=',0);
//
//        if($user->count())
//        {
//            $user = $user->first(); //picking first record for the above condition
//
//            //update user to active state
//            $user->active =1; //activate account
//            $user->code = ''; //remove code
//
//            if($user->save()) //save
//            {
//                return Redirect::route('home')->with('global','Activated! you can now login in');
//            }
//        }
        return Redirect::route('home')->with('global','we could not activate your account. try again later');
    }

    public function getSignOut()
    {

        Auth::logout();
        return Redirect::route('account-login');
    }

    public function postDelete()
    {
//        DB::table('users')->where('votes', '<', 100)->delete();

        $id = Input::get('hiddenId');
        $currentUser = Auth::User()->id;

        $user = new User();

            if($currentUser==$id)
            {
                \Session::flash('flash_message', 'Cannot delete current user');
                return Redirect::route('add-user');
            }
        else {
            $user = User::find($id);


            $user->delete();

            \Session::flash('flash_message', 'User removed from our system');
            return Redirect::route('add-user');
        }
        



    }

    public function postUpdatePermission()
    {
        $id = Input::get('hiddenId');
        $permission = Input::get('sltPermission');
//      $user = User::table('system_users')->where('id','=',$id);
        $user = new User();
        $user = User::find($id);
        $user->permissions = $permission;

        if ($user->save()) {
            \Session::flash('flash_message','User permission changed successfully');
            return Redirect::route('add-user');
        }
        else
        {
            \Session::flash('flash_message','User permission  changed failed');
            return Redirect::route('add-user');
        }
    }

    public function accountDeactivate()
    {
        $id = Input::get('hiddenId');

        $user = new User();
        $user = User::find($id);

        if($user->active == 0)
        {
            $active = 1;
        }
        else
        {
            $active = 0;
        }

        $user->active = $active;

        if ($user->save()) {
            \Session::flash('flash_message','Account status changed successfully');
            return Redirect::route('add-user');
        }
        else
        {
            \Session::flash('flash_message','Account status changed failed');
            return Redirect::route('add-user');
        }

    }
//    ublic function systemUsers()
//    {
//        $term      = Input::get('term');
//        $users = array();
//
//        $search = DB::select("
//	select username
//	from system_users
//	where match(username) against ('+{$term}*' IN BOOLEAN MODE)
//	");
//
//        foreach ($search as $result) {
//            $users[] = $result;
//
//        }
//
//        return json_encode($users);
//    }

//




    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

}
