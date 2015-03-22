<?php namespace App\Http\Controllers;

use App\Http\Requests\CreateDiskRequest;
use App\Http\Requests\CreateMakeRequest;
use App\Http\Requests\CreateOSRequest;
use App\Http\Requests\CreateProviderRequest;
use App\Http\Requests\CreateRamRequest;
use App\Http\Requests\CreateScreenRequest;
use App\Http\Requests\UpdateDiskRequest;
use App\Http\Requests\UpdateMakeRequest;
use App\Http\Requests\updateOSRequest;
use App\Http\Requests\UpdateProviderRequest;
use App\Http\Requests\UpdateRamRequest;
use App\Http\Requests\UpdateScreenRequest;
use App\operating_system;
use App\make;
use App\ScreenSize;
use App\ServiceProvider;
use App\RAM;
use App\HardDisk;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Request;
use Input;

class AddResourcePortion extends Controller {

	public function index(){

        $operatingSystems = operating_system::get();
        $makes = make::get();
        $sizes = ScreenSize::get();
        $providers = ServiceProvider::get();
        $rams = RAM::get();
        $disks = HardDisk::get();

        return view('pages.addResourcePortion')->with('operatingSystems', $operatingSystems)
                                                ->with('makes', $makes)
                                                ->with('sizes', $sizes)
                                                ->with('providers', $providers)
                                                ->with('rams', $rams)
                                                ->with('disks', $disks);
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

        elseif($type =='ram')
        {
            $status = RAM::deleteRamSize($id);

            if ($status)
                \Session::flash('flash_message', 'Ram Size deleted successfully!');
            else
                \Session::flash('flash_message_error', 'Ram Size not deleted!');

            return Redirect::action('AddResourcePortion@index');
        }

        elseif($type =='disk')
        {
            $status = HardDisk::deleteDiskSize($id);

            if ($status)
                \Session::flash('flash_message', 'Disk Size deleted successfully!');
            else
                \Session::flash('flash_message_error', 'Disk Size not deleted!');

            return Redirect::action('AddResourcePortion@index');
        }

    }

    public function addOS(CreateOSRequest $request){



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

    public function updateOS(updateOSRequest $request){

        $status = true;
        $input = Request::all();


        $os_id = $input['OS_id'];
        $operatingSystem = operating_system::find($os_id);

        $operatingSystem->OS_Name = $input['osName'];
        $status = $operatingSystem->save() ? true : false;



        if ($status)
            \Session::flash('flash_message', 'Operating System Updated successfully!');
        else
            \Session::flash('flash_message_error', 'Operating System not Updated!');

        return Redirect::action('AddResourcePortion@index');


    }

    public function addMake(CreateMakeRequest $request){


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

    public function updateMake(UpdateMakeRequest $request){

        $status = true;
        $input = Request::all();


        $make_id = $input['make_id'];
        $make = Make::find($make_id);

        $make->Make_Name = $input['makeName'];
        $status = $make->save() ? true : false;



        if ($status)
            \Session::flash('flash_message', 'Make Updated successfully!');
        else
            \Session::flash('flash_message_error', 'Make not Updated!');

        return Redirect::action('AddResourcePortion@index');

    }

    public function addScreen(CreateScreenRequest $request){


        $status = true;

        $input = Request::all();
        $screen_size = $input['screen_size'];

        $screen =  new ScreenSize();
        $screen->Screen_Size = $screen_size;

        $status = $screen->save() ? true : false;

        if($status)
            \Session::flash('flash_message','New Screen Size added successfully!');
        else
            \Session::flash('flash_message_error','Screen Size Addition Failed!');

        return Redirect::action('AddResourcePortion@index');

    }



    public function updateScreen(UpdateScreenRequest $request){

        $status = true;
        $input = Request::all();


        $screen_id = $input['screen_id'];
        $screen = ScreenSize::find($screen_id);

        $screen->Screen_Size = $input['screenSize'];
        $status = $screen->save() ? true : false;



        if ($status)
            \Session::flash('flash_message', 'Screen Size Updated successfully!');
        else
            \Session::flash('flash_message_error', 'Screen Size not Updated!');

        return Redirect::action('AddResourcePortion@index');

    }

    public function addProvider(CreateProviderRequest $request){


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



    public function updateProvider(UpdateProviderRequest $request){

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

    public function addRam(CreateRamRequest $request){


        $status = true;

        $input = Request::all();
        $ram_size = $input['ram_size'];

        $ramSize =  new RAM();
        $ramSize->Ram_Size = $ram_size;

        $status = $ramSize->save() ? true : false;

        if($status)
            \Session::flash('flash_message','New Ram Size added successfully!');
        else
            \Session::flash('flash_message_error','Ram Size Addition Failed!');

        return Redirect::action('AddResourcePortion@index');

    }

    public function updateRam(UpdateRamRequest $request){

        $status = true;
        $input = Request::all();


        $ram_id = $input['ram_id'];
        $ram = RAM::find($ram_id);

        $ram->Ram_Size = $input['ramSize'];
        $status = $ram->save() ? true : false;



        if ($status)
            \Session::flash('flash_message', 'Ram Size Updated successfully!');
        else
            \Session::flash('flash_message_error', 'Ram Size not Updated!');

        return Redirect::action('AddResourcePortion@index');

    }

    public function addHardDisk(CreateDiskRequest $request){


        $status = true;

        $input = Request::all();
        $disk_size = $input['disk_size'];

        $diskSize =  new HardDisk();
        $diskSize->Disk_Size = $disk_size;

        $status = $diskSize->save() ? true : false;

        if($status)
            \Session::flash('flash_message','New Disk Size added successfully!');
        else
            \Session::flash('flash_message_error','Disk Size Addition Failed!');

        return Redirect::action('AddResourcePortion@index');

    }

    public function updateHardDisk(UpdateDiskRequest $request){

        $status = true;
        $input = Request::all();


        $disk_id = $input['disk_id'];
        $disk = HardDisk::find($disk_id);

        $disk->Disk_Size = $input['diskSize'];
        $status = $disk->save() ? true : false;



        if ($status)
            \Session::flash('flash_message', 'Disk Size Updated successfully!');
        else
            \Session::flash('flash_message_error', 'Disk Size not Updated!');

        return Redirect::action('AddResourcePortion@index');

    }



}