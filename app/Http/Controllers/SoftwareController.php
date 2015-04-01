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
            \Session::flash('flash_message','Software(s) added successfully!');
        else
            \Session::flash('flash_message_error','Software(s) addition failed!');

        return Redirect::action('SoftwareController@index');
    }

    public function edit()
    {
        $softwares = Software::paginate(10);
        $column = "inventory_code";
        return view ('ManageResource.editSoftware',compact('softwares','column'));
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
            $this->remove($inventoryCode);
        }

        return Redirect::action('SoftwareController@edit');
    }

    public function remove($inventoryCode)
    {
        $software = Software::find($inventoryCode);
        $status = true;

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

    public function search()
    {
        $key = Input::get('search_t');
        $ascend = Input::get('ascend');
        $descend = Input::get('descend');
        $column = Input::get('sort_t');
        $softwares = '';

        if($ascend=='ascend')
        {
            $softwares = DB::table('Software')->orderBy($column,'asc')->paginate(10);
        }
        elseif($descend=='descend')
        {
            $softwares = DB::table('Software')->orderBy($column,'desc')->paginate(10);
        }
        else {
            $softwares = Software::where('inventory_code', 'LIKE', '%' . $key . '%')->
            orWhere(function ($query) use ($key) {
                    $query->where('name', 'LIKE', '%' . $key . '%');
                })->
            orWhere(function ($query) use ($key) {
                    $query->where('vendor', 'LIKE', '%' . $key . '%');
                })->
            orWhere(function ($query) use ($key) {
                    $query->where('no_of_license', 'LIKE', '%' . $key . '%');
                })->
            paginate(30);
        }
        return view ('ManageResource.editSoftware',compact('softwares','column'));
    }

}
