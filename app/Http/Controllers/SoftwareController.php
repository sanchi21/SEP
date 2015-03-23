<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Resource;
use App\Software;
//use Illuminate\Http\Request;
use Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Request;

class SoftwareController extends Controller {

    public function index()
    {
        $key = Software::getInventoryCode();
        return view ('ManageResource.addSoftware',compact('key'));
    }

    public function store()
    {
        $input = Request::all();
        $count = $input['quantity'];
        $inventoryCode = $input['inventory_code_t'];
        $name = $input['name_t'];
        $vendor = $input['vendor_t'];
        $noOfLicense = $input['no_of_license_t'];
        $status = true;

        DB::beginTransaction();
        for($i=0 ; $i<$count ; $i++)
        {
            $resource = new Resource();
            $software = new Software();
            $status = true;

            $resource->inventory_code = $inventoryCode[$i];
            $software->inventory_code = $inventoryCode[$i];
            $software->name = $name[$i];
            $software->vendor = $vendor[$i];
            $software->no_of_license = $noOfLicense[$i];

            $status = $resource->save() ? true : false;
            if($status)
                $status = $software->save() ? true : false;

            if($status)
            {
                DB::commit();
            }
            else {
                DB::rollback();
                break;
            }
        }
        if($status)
            \Session::flash('flash_message','('.$count.') new Software(s) added successfully!');
        else
            \Session::flash('flash_message_error','Software(s) addition failed!');

        return Redirect::action('SoftwareController@edit');
    }

    public function edit()
    {
        $softwares = Software::paginate(10);
        return view ('ManageResource.editSoftware',compact('softwares'));
    }

    public function update()
    {
        $status = true;
        $input = Request::all();
        $delete = Input::get('delete');
        $inventoryCode = $input['inventory_code_t'];
        $software = Software::find($inventoryCode);

        if(!$delete)
        {
            $software->name = $input['name_t'];
            $software->vendor = $input['vendor_t'];
            $software->no_of_license = $input['no_of_license_t'];

            $status = $software->save() ? true : false;

            if($status)
                \Session::flash('flash_message','Software '.$inventoryCode.' updated successfully!');
            else
                \Session::flash('flash_message_error','Software '.$inventoryCode.' update failed!');

        }
        else
        {
            DB::beginTransaction();
            $resource = Resource::find($inventoryCode);

            if($resource->delete())
                $status = $software->delete() ? true : false;


            if($status) {
                DB::commit();
                \Session::flash('flash_message_error', 'Software ' . $inventoryCode . ' deleted!');
            }
            else {
                DB::rollback();
                \Session::flash('flash_message_error', 'Software deletion failed!');
            }
        }



        return Redirect::action('SoftwareController@edit');
    }

}
