<?php namespace App\Http\Controllers;

use App\Column;
use App\Depreciation;
use App\DropDown;
use App\Hardware;
use App\Http\Requests;
use App\ProcurementItem;
use App\Resource;
use App\SelectedColumn;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use App\Type;
use Illuminate\Support\Facades\Input;
use League\Flysystem\Exception;
use Request;
use Illuminate\Support\Facades\Schema;
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
        $resource_data = array();
        $hardware_data = array();
        $columns = Column::where('category', $category)->get();

        try {
            foreach ($columns as $cols) {
                if ($cols->table_column != 'cid') {
                    $temp = $input[$cols->table_column];
                    array_push($contents, $temp);
                }
            }
        }
        catch(\Exception $e)
        {
            return Redirect::back()->withErrors($e->getMessage());
        }

        for ($i = 0; $i < $quantity; $i++)
        {
            $x=0;

            $resource = array();
            $hardware = array();

            try {

                foreach ($contents as $attribute) {
                    if ($x == 0) {
                        $resource = array_add($resource,'inventory_code',$attribute[$i]);
                        $hardware = array_add($hardware,'inventory_code',$attribute[$i]);
                        $hardware = array_add($hardware,'type',$category);
                    } else {
                        $t = $columns[$x]->table_column;
                        $hardware = array_add($hardware,$t,$attribute[$i]);
                    }

                    $x++;
                }

                $hardware = array_add($hardware,'status',"Not Allocated");
                array_push($resource_data,$resource);
                array_push($hardware_data,$hardware);

            }
            catch(\Exception $e)
            {
                return Redirect::back()->withErrors($e->getMessage());
            }
        }

        try {
            DB::beginTransaction();
            Resource::insert($resource_data);
            Hardware::insert($hardware_data);
            DB::commit();
            \Session::flash('flash_message','Resource(s) added successfully!');
        }
        catch(\Exception $e)
        {
            DB::rollback();
            \Session::flash('flash_message_error','Resource(s) addition failed!');
        }

        return Redirect::action('ResourceController@index');
    }

    public function editAll()
    {
        $hardwares = Hardware::paginate(30);
        $types = Type::all();
        $id = "All";
        $column = 'inventory_code';
        $userId = Auth::User()->id;

        $selected = SelectedColumn::where('user_id',$userId)->where('table_name','hardware')->where('type','All')->first();

        $selectedColumns = array('0');
        if(!is_null($selected))
            $selectedColumns = explode('-',$selected->columns);

        try
        {
            $columns = Column::select('table_column', 'column_name', 'cid')->join('types','types.category','=','columns.category')->groupBy('table_column')->orderBy('cid')->get();
            $columns2 = Column::select('table_column', 'column_name', 'cid')->whereIn('cid',$selectedColumns)->join('types','types.category','=','columns.category')->groupBy('table_column')->orderBy('cid')->get();
        }
        catch(\Exception $e)
        {
            return Redirect::back()->withErrors($e->getMessage());
        }

        return view('ManageResource.editHardware',compact('hardwares','types','id','column','columns','selectedColumns','columns2'));
    }

    public function edit($id)
    {
        $types = Type::all();
        $column = "inventory_code";
        $userId = Auth::User()->id;
        $selected = SelectedColumn::where('user_id',$userId)->where('table_name','hardware')->where('type',$id)->first();

        $selectedColumns = array('0');
        if(!is_null($selected))
            $selectedColumns = explode('-',$selected->columns);

        try
        {
            $columns = Column::join('types','types.category','=','columns.category')->where('types.category', $id)->get();
            $columns2 = Column::whereIn('cid',$selectedColumns)->join('types','types.category','=','columns.category')->get();
            if ($id == 'All') {
                $hardwares = Hardware::paginate(30);
                $columns = Column::all();
            } else {
                $hardwares = Hardware::where('type', $id)->paginate(30);
            }
        }
        catch(\Exception $e)
        {
            return Redirect::back()->withErrors($e->getMessage());
        }

        return view('ManageResource.editHardware',compact('hardwares','types','id','column','columns','selectedColumns','columns2'));
    }


    public function search()
    {
        try
        {
            $key = Input::get('search_t');
            $type = Input::get('category');
            $id = substr($type, 15);
            $ascend = Input::get('ascend');
            $descend = Input::get('descend');
            $column = Input::get('sort');
            $search = Input::get('search');
            $selectedColumns = Input::get('existing_attribute');
            $user_id = Auth::User()->id;

            $columns = Column::select('table_column', 'column_name', 'cid')->join('types','types.category','=','columns.category')->groupBy('columns.table_column')->orderBy('columns.cid')->get();
            $columns2 = Column::whereIn('cid',$selectedColumns)->join('types','types.category','=','columns.category')->get();

            if($id!='All')
                $columns = Column::join('types','types.category','=','columns.category')->where('types.category', $id)->get();

            $types = Type::all();

            if ($ascend == 'ascend') {
                if ($id == 'All')
                    $hardwares = DB::table('Hardware')->orderBy($column, 'asc')->paginate(30);
                else
                    $hardwares = DB::table('Hardware')->where('type', $id)->orderBy($column, 'asc')->paginate(30);
            } elseif ($descend == 'descend') {
                if ($id == 'All')
                    $hardwares = DB::table('Hardware')->orderBy($column, 'desc')->paginate(30);
                else
                    $hardwares = DB::table('Hardware')->where('type', $id)->orderBy($column, 'desc')->paginate(30);
            } elseif($search == 'search'){

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
            else
            {
                $this->storeColumns($selectedColumns,$id,$user_id);
                if($id=='All')
                    $hardwares = DB::table('Hardware')->orderBy($column, 'asc')->paginate(30);
                else
                    $hardwares = DB::table('Hardware')->where('type', $id)->paginate(30);
            }
        }
        catch(\Exception $e)
        {
            return Redirect::back()->withErrors($e->getMessage());
        }

        return view('ManageResource.editHardware',compact('hardwares','types','id','column','columns','selectedColumns','columns2'));
    }

    public function storeColumns($columns,$category,$userId)
    {
        if(!is_null($columns))
        {
            $columnIds = '';

            foreach ($columns as $column)
            {
                $columnIds = $columnIds.$column.'-';
            }

            $colData = DB::table('selected_columns')->where('user_id',$userId)->where('table_name','hardware')->where('type',$category)->first();
            if(!is_null($colData))
            {
                $colData = DB::table('selected_columns')->where('user_id',$userId)->where('table_name','hardware')->where('type',$category)
                    ->update(['columns' => $columnIds]);
            }
            else
            {
                $columnData = new SelectedColumn();
                $columnData->user_id = $userId;
                $columnData->table_name = 'hardware';
                $columnData->type = $category;
                $columnData->columns = $columnIds;

                $columnData->save();
            }
        }
    }

    public function editSpecific($d)
    {
        try {
            $id = urldecode(base64_decode($d));
            $inventory_code = str_replace('-', '/', $id);//Input::get('inventory_code');
            $resource = Depreciation::find($inventory_code);
            $depreciation = false;

            if (is_null($resource))
                $depreciation = true;
            else
                $depreciation = false;

            $hardware = Hardware::find($inventory_code);
            $type = $hardware->type;
            $columns = Column::where('category', $type)->get();
            $dropValues = $this->getDropDownValues($columns);
            $count = count($dropValues);
        }
        catch(\Exception $e)
        {
            return Redirect::back()->withErrors($e->getMessage());
        }

        return view('ManageResource.editHardwareForm',compact('hardware','type','columns','dropValues','count','depreciation'));
    }

    public function getDropDownValues($columns)
    {
        $dropValues = array();
        try {
            foreach ($columns as $c) {
                if ($c->dropDown == '1') {
                    $temp = DropDown::where('table_column', $c->table_column)->get();
                    array_push($dropValues, $temp);
                }
            }
        }
        catch(\Exception $e)
        {
            return Redirect::back()->withErrors($e->getMessage());
        }

        return $dropValues;
    }

    public function update(Requests\EditHardwareRequest $request)
    {
        $input = Request::all();
        $status = true;

        try {

            $delete = Input::get('delete');
            $inventory_code = $input['inventory_code'];
            $type = Input::get('type');
            $columns = Column::where('category', $type)->where('table_column', '<>', 'inventory_code')->get();

            $hardware = Hardware::find($inventory_code);

            if ($delete != "Dispose") {
                foreach ($columns as $col) {
                    $attribute = $col->table_column;
                    $temp = $input[$attribute];

                    $hardware->$attribute = $temp;
                }

                $status = $hardware->save() ? true : false;

            }
            else
            {
                $hardware->status = 'Disposed';
                $status = $hardware->save() ? true : false;
                //$this->remove($inventory_code);
            }

            if ($status) {
                \Session::flash('flash_message', 'Hardware ' . $inventory_code . ' updated successfully!');
            }
            else
            {
                \Session::flash('flash_message_error', 'Hardware update failed!');
            }
        }
        catch(\Exception $e)
        {
            return Redirect::back()->withErrors($e->getMessage());
        }

        return Redirect::action('ResourceController@editAll');

    }

    public function remove($inventory_code)
    {
        $status = true;
        try {
            $hardware = Hardware::find($inventory_code);

            DB::beginTransaction();

            if ($hardware->delete())
                if (Resource::find($inventory_code)->delete())
                    $status = true;
                else
                    $status = false;
        }
        catch(\Exception $e)
        {
            return Redirect::back()->withErrors($e->getMessage());
        }

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

    public function inventory($category,$request_id,$item)
    {
        $columns = Column::where('category', $category)->get();
        $id = $category;
        $key = Hardware::getInventoryCode($id);

        $item = ProcurementItem::where('pRequest_no',urldecode(base64_decode($request_id)))->where('item_no',urldecode(base64_decode($item)))->first();

        $dropValues = $this->getDropDownValues($columns);
        $count = count($dropValues);


        return view('Procument.inventory',compact('dropValues','types','columns','count','id','key','item','category'));
    }
}
