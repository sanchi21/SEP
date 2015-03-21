<?php namespace App\Http\Controllers;

use App\operating_system;
use App\make;
use App\ScreenSize;
use App\ServiceProvider;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Request;
use Input;

class AddResourcePortion extends Controller {

	public function index(){

        $operatingSystems = operating_system::paginate(2);//operating_system::showAllOperatingSystems();
        $makes = make::showAllMakes();
        $sizes = ScreenSize::showAllSizes();
        $providers = ServiceProvider::showAllProviders();


        return view('pages.addResourcePortion')->with('operatingSystems', $operatingSystems)
                                                ->with('makes', $makes)
                                                ->with('sizes', $sizes)
                                                ->with('providers', $providers);
    }

    public function delete($type,$id){

        $status = true;


        if ($type=='OS'){

            //$tableName= 'operating_systems';

            $status = operating_system::deleteOS($id);

            if ($status)
                \Session::flash('flash_message', 'Operating System deleted successfully!');
            else
                \Session::flash('flash_message_error', 'Operating System not deleted!');

            return Redirect::action('AddResourcePortion@index');

        }
        elseif($type =='make')
        {
            $status = make::deleteMake($id);

            if ($status)
                \Session::flash('flash_message', 'Make deleted successfully!');
            else
                \Session::flash('flash_message_error', 'Make not deleted!');

            return Redirect::action('AddResourcePortion@index');
        }

        elseif($type =='screen')
        {
            $status = ScreenSize::deleteScreen($id);

            if ($status)
                \Session::flash('flash_message', 'Screen Size deleted successfully!');
            else
                \Session::flash('flash_message_error', 'Screen Size not deleted!');

            return Redirect::action('AddResourcePortion@index');
        }

        elseif($type =='provider')
        {
            $status = ServiceProvider::deleteProvider($id);

            if ($status)
                \Session::flash('flash_message', 'Service Provider deleted successfully!');
            else
                \Session::flash('flash_message_error', 'Service Provider not deleted!');

            return Redirect::action('AddResourcePortion@index');
        }

    }

    public function addOS(){


        $status = true;

        $input = Request::all();
        $os_name = $input['os_name'];

        $os =  new operating_system();
        $os->OS_Name = $os_name;

        $status = $os->save() ? true : false;

        if($status)
            \Session::flash('flash_message','New Operating System added successfully!');
        else
            \Session::flash('flash_message_error','Operating System Addition Failed!');

        return Redirect::action('AddResourcePortion@index');

    }

    public function updateOS(){

        $status = true;
        $input = Request::all();


        $os_id = $input['OS_id'];
        $operatingSystem = operating_system::find($os_id);
        $sizes =

        $operatingSystem->OS_Name = $input['os_name'];
        $status = $operatingSystem->save() ? true : false;



        if ($status)
            \Session::flash('flash_message', 'Operating System Updated successfully!');
        else
            \Session::flash('flash_message_error', 'Operating System not Updated!');

        return Redirect::action('AddResourcePortion@index');


    }

    public function addMake(){


        $status = true;

        $input = Request::all();
        $make_name = $input['make_name'];

        $make =  new make();
        $make->Make_Name = $make_name;

        $status = $make->save() ? true : false;

        if($status)
            \Session::flash('flash_message','New Make added successfully!');
        else
            \Session::flash('flash_message_error','Make Addition Failed!');

        return Redirect::action('AddResourcePortion@index');

    }

    public function updateMake(){

        $status = true;
        $input = Request::all();


        $make_id = $input['make_id'];
        $make = Make::find($make_id);

        $make->Make_Name = $input['make_name'];
        $status = $make->save() ? true : false;



        if ($status)
            \Session::flash('flash_message', 'Make Updated successfully!');
        else
            \Session::flash('flash_message_error', 'Make not Updated!');

        return Redirect::action('AddResourcePortion@index');

    }

    public function addScreen(){


        $status = true;

        $input = Request::all();
        $screen_name = $input['screen_name'];

        $screen =  new ScreenSize();
        $screen->Screen_Size = $screen_name;

        $status = $screen->save() ? true : false;

        if($status)
            \Session::flash('flash_message','New Screen Size added successfully!');
        else
            \Session::flash('flash_message_error','Screen Size Addition Failed!');

        return Redirect::action('AddResourcePortion@index');

    }



    public function updateScreen(){

        $status = true;
        $input = Request::all();


        $screen_id = $input['screen_id'];
        $screen = ScreenSize::find($screen_id);

        $screen->Screen_Size = $input['screenName'];
        $status = $screen->save() ? true : false;



        if ($status)
            \Session::flash('flash_message', 'Screen Size Updated successfully!');
        else
            \Session::flash('flash_message_error', 'Screen Size not Updated!');

        return Redirect::action('AddResourcePortion@index');

    }

    public function addProvider(){


        $status = true;

        $input = Request::all();
        $provider_name = $input['provider_name'];

        $provider =  new ServiceProvider();
        $provider->Provider_Name = $provider_name;

        $status = $provider->save() ? true : false;

        if($status)
            \Session::flash('flash_message','New Service Provider added successfully!');
        else
            \Session::flash('flash_message_error','Service Provider Addition Failed!');

        return Redirect::action('AddResourcePortion@index');

    }



    public function updateProvider(){

        $status = true;
        $input = Request::all();


        $provider_id = $input['provider_id'];
        $provider = ServiceProvider::find($provider_id);

        $provider->Provider_Name = $input['ProviderName'];
        $status = $provider->save() ? true : false;



        if ($status)
            \Session::flash('flash_message', 'Service Provider Updated successfully!');
        else
            \Session::flash('flash_message_error', 'Service Provider not Updated!');

        return Redirect::action('AddResourcePortion@index');

    }





//    public function changeOS(){
//
//
//        $status = true;
//        $input = Request::all();
//        $delete = Input::get('delete');
//
//        $os_id = $input['OS_id'];
//
//
//        $operatingSystem = make::find($os_id);
//
//        if(!$delete){
//            $operatingSystem->OS_Name = $input['os_name'];
//        $status = $operatingSystem->save() ? true : false;
//
//        if ($status)
//            \Session::flash('flash_message', 'Operating System Updated successfully!');
//        else
//            \Session::flash('flash_message_error', 'Operating System not Updated!');
//
//        return Redirect::action('AddResourcePortion@index');
//
//    }
//
//        else {
//
//            $status = operating_system::deleteOS($os_id);
//
//            if ($status)
//                \Session::flash('flash_message', 'Operating System deleted successfully!');
//            else
//                \Session::flash('flash_message_error', 'Operating System not deleted!');
//
//            return Redirect::action('AddResourcePortion@index');
//        }
//
//    }

//    public function changeMake(){
//
//
//        $status = true;
//        $input = Request::all();
//        $delete = Input::get('make_delete');
//
//        $os_id = $input['OS_id'];
//
//        $make = make::find($os_id);
//
//        if(!$delete){
//
//            $make->Make_Name = $input['make_name'];
//            $status = $make->save() ? true : false;
//
//            if ($status)
//                \Session::flash('flash_message', 'Make Updated successfully!');
//            else
//                \Session::flash('flash_message_error', 'Make not Updated!');
//
//            return Redirect::action('AddResourcePortion@index');
//
//        }
//
//        else {
//
//            $status = make::deleteMake($os_id);
//
//            if ($status)
//                \Session::flash('flash_message', 'Make deleted successfully!');
//            else
//                \Session::flash('flash_message_error', 'Make not deleted!');
//
//            return Redirect::action('AddResourcePortion@index');
//        }



}