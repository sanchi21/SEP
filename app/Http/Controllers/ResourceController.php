<?php namespace App\Http\Controllers;

use App\Column;
use App\Depreciation;
use App\DropDown;
use App\Hardware;
use App\Http\Requests;
use App\Resource;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use App\Type;
use Illuminate\Support\Facades\Input;
use Request;
use App\Http\Requests\AddHardwareRequest;

class ResourceController extends Controller {

	public function index()
    {
        $types = Type::all();

        $columns = Column::where('category', 'Office-Equipment')->get();
        $id = "Office-Equipment";
        $key = Hardware::getInventoryCode($id);

        $dropValues = $this->getDropDownValues($columns);
        $count = count($dropValues);

        return view('ManageResource.addHardware',compact('dropValues','types','columns','count','id','key'));
    }

    public function hardware($id)
    {
        $types = Type::all();

        $columns = Column::where('category', $id)->get();
        $count = 0;
        $key = Hardware::getInventoryCode($id);

        $dropValues = $this->getDropDownValues($columns);
        $count = count($dropValues);

        return view('ManageResource.addHardware',compact('dropValues','types','columns','count','id','key'));
    }

    public function store()
    {
        $input = Request::all();
        $quantity = $input['quantity'];
        $category = substr($input['category'],10);

        $contents = array();
        $columns = Column::where('category', $category)->get();
        $status = true;

        foreach($columns as $cols)
        {
            if($cols->table_column != 'cid')
            {
                $temp = $input[$cols->table_column];
                array_push($contents, $temp);
            }
        }

        for ($i = 0; $i < $quantity; $i++)
        {
            $x=0;

            $resource = new Resource();
            $hardware = new Hardware();
            $status = true;

            DB::beginTransaction();

            foreach($contents as $attribute)
            {
                if($x == 0)
                {
                    $resource->inventory_code = $attribute[$i];
                    $hardware->inventory_code = $attribute[$i];
                    $hardware->type = $category;
                }
                else
                {
                    $t = $columns[$x]->table_column;
                    $hardware->$t = $attribute[$i];
                }
                $x++;
            }

            if ($resource->save()) {
                $status = $hardware->save() ? true : false;
            }
            else
            {
                $status = false;
            }

            if ($status)
            {
                DB::commit();
            }
            else
            {
                DB::rollback();
                break;
            }
        }

        if($status)
            \Session::flash('flash_message','Resource(s) added successfully!');
        else
            \Session::flash('flash_message_error','Resource(s) addition failed!');

        return Redirect::action('ResourceController@index');
    }

    public function editAll()
    {
        $hardwares = Hardware::paginate(30);
        $types = Type::all();
        $id = "All";
        $column = 'inventory_code';
        $columns = Column::select('table_column','column_name','cid')->groupBy('table_column')->orderBy('cid')->get();

        return view('ManageResource.editHardware',compact('hardwares','types','id','column','columns'));
    }

    public function edit($id)
    {
        $types = Type::all();
        $column = "inventory_code";
        $columns = Column::where('category', $id)->get();
        if($id == 'All')
        {
            $hardwares = Hardware::paginate(30);
            $columns = Column::all();
        }
        else
        {
            $hardwares = Hardware::where('type', $id)->paginate(30);
        }

        return view('ManageResource.editHardware',compact('hardwares','types','id','column','columns'));
    }


    public function search()
    {
        $key = Input::get('search_t');
        $type = Input::get('category');
        $id = substr($type,15);
        $ascend = Input::get('ascend');
        $descend = Input::get('descend');
        $column = Input::get('sort');
        $columns = Column::select('table_column','column_name','cid')->groupBy('table_column')->orderBy('cid')->get();

        $types = Type::all();

        if($ascend=='ascend')
        {
            if($id=='All')
                $hardwares = DB::table('Hardware')->orderBy($column,'asc')->paginate(30);
            else
                $hardwares = DB::table('Hardware')->where('type',$id)->orderBy($column,'asc')->paginate(30);
        }
        elseif($descend=='descend')
        {
            if($id=='All')
                $hardwares = DB::table('Hardware')->orderBy($column,'desc')->paginate(30);
            else
                $hardwares = DB::table('Hardware')->where('type',$id)->orderBy($column,'desc')->paginate(30);
        }
        else
        {
            $hardwares = Hardware::where('inventory_code', 'LIKE', '%' . $key . '%')->
            orWhere(function ($query) use ($key) {
                    $query->where('serial_no', 'LIKE', '%' . $key . '%');
                })->
            orWhere(function ($query) use ($key) {
                    $query->where('description', 'LIKE', '%' . $key . '%');
                })->
            orWhere(function ($query) use ($key) {
                    $query->where('ip_address', 'LIKE', '%' . $key . '%');
                })->
            orWhere(function ($query) use ($key) {
                    $query->where('make', 'LIKE', '%' . $key . '%');
                })->
            orWhere(function ($query) use ($key) {
                    $query->where('model', 'LIKE', '%' . $key . '%');
                })->
            orWhere(function ($query) use ($key) {
                    $query->where('purchase_date', 'LIKE', '%' . $key . '%');
                })->
            orWhere(function ($query) use ($key) {
                    $query->where('warranty_exp', 'LIKE', '%' . $key . '%');
                })->
            orWhere(function ($query) use ($key) {
                    $query->where('insurance', 'LIKE', '%' . $key . '%');
                })->
            orWhere(function ($query) use ($key) {
                    $query->where('value', 'LIKE', '%' . $key . '%');
                })->
            paginate(30);
        }

        return view('ManageResource.editHardware',compact('hardwares','types','id','column','columns'));
    }

    public function editSpecific($d)
    {
        $id = urldecode(base64_decode($d));
        $inventory_code = str_replace('-','/',$id);//Input::get('inventory_code');
        $resource = Depreciation::find($inventory_code);
        $depreciation = false;

        if(is_null($resource))
            $depreciation = true;
        else
            $depreciation = false;

        $hardware = Hardware::find($inventory_code);
        $type = $hardware->type;
        $columns = Column::where('category', $type)->get();
        $dropValues = $this->getDropDownValues($columns);
        $count = count($dropValues);

        return view('ManageResource.editHardwareForm',compact('hardware','type','columns','dropValues','count','depreciation'));
    }

    public function getDropDownValues($columns)
    {
        $dropValues = array();
        foreach($columns as $c)
        {
            if($c->dropDown == '1')
            {
                $temp = DropDown::where('table_column',$c->table_column)->get();
                array_push($dropValues,$temp);
            }
        }
        return $dropValues;
    }

    public function update(Requests\EditHardwareRequest $request)
    {
        $input = Request::all();
        $status = true;
        $delete = Input::get('delete');
        $inventory_code = $input['inventory_code'];
        $type = Input::get('type');
        $columns = Column::where('category', $type)->where('table_column','<>','inventory_code')->get();

        $hardware = Hardware::find($inventory_code);

        if ($delete!="Delete")
        {
            foreach ($columns as $col)
            {
                $attribute = $col->table_column;
                $temp = $input[$attribute];

                $hardware->$attribute = $temp;
            }

            $status = $hardware->save() ? true : false;


            if ($status) {
                \Session::flash('flash_message', 'Hardware '.$inventory_code.' updated successfully!');
            } else {
                \Session::flash('flash_message_error', 'Hardware update failed!');
            }

        }
        else
        {
            $this->remove($inventory_code);
        }
        return Redirect::action('ResourceController@editAll');

    }

    public function remove($inventory_code)
    {
        $status = true;
        $hardware = Hardware::find($inventory_code);

        DB::beginTransaction();

        if ($hardware->delete())
            if (Resource::find($inventory_code)->delete())
                $status = true;
            else
                $status = false;

        if ($status)
        {
            DB::commit();
            \Session::flash('flash_message_error', 'Hardware '.$inventory_code.' Deleted!');
        }
        else
        {
            DB::rollback();
            \Session::flash('flash_message_error', 'Hardware deletion failed!');
        }
    }
}
