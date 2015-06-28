<?php namespace App\Http\Controllers;

use App\DropDown;
use App\HardDisk;
use App\Hardware;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Resource;
use App\Validation;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Schema;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Column;
use App\Type;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TableController extends Controller {

	public function index()
    {
        $types = Type::all();

        $validation = Validation::all();
        $delete_column = Column::where('category',"New")->get();
        $columns = Column::select('table_column','column_name','cid')->where('table_column','<>','inventory_code')->groupBy('table_column')->orderBy('cid')->get();
        $id = "New";

        return view('ManageResource.changeColumns',compact('types','id','columns','validation','delete_column'));
    }

    public function edit($id)
    {
        $types = Type::all();
        $c = array();
        $validation = Validation::all();
        $delete_column = Column::where('category',$id)->where('table_column','<>','inventory_code')->get();

        foreach ($delete_column as $cl)
        {
            array_push($c,$cl->table_column);
        }

        $columns = Column::whereNotIn('table_column',$c)->groupBy('table_column')->get();

        return view('ManageResource.changeColumns',compact('types','id','columns','validation','delete_column'));
    }

    public function store(Requests\ChangeColumnRequest $request)
    {
        $input = Input::all();

        $category = substr($input['category'],17);;
        $new_category = '';
        $existing_attributes = '';
        $attribute_name = null;
        $isDropdown = 0;
        $err = '';

        if(isset($input['existing_attribute']))
            $existing_attributes = $input['existing_attribute'];

        if(isset($input['attribute_name']))
            $attribute_name = $input['attribute_name'];

        $attribute_type = $input['attribute_type'];
        $attribute_min = $input['attribute_min'];
        $attribute_max = $input['attribute_max'];
        $attribute_drop = $input['attribute_drop'];
        $attribute_validation = $input['attribute_validation'];

        $status = true;
        DB::beginTransaction();

        if($category == 'New') {
            $type = new Type();
            $inventory_pattern = $input['inv'];
            $new_category = $input['new_category'];

            $type->category = $new_category;
            $type->key = $inventory_pattern;

            $status = $type->save() ? true : false;

            $inv_column = new Column();
            $inv_column->category = $new_category;
            $inv_column->table_column =  'inventory_code';
            $inv_column->column_type =  'string';
            $inv_column->column_name =  'Inventory Code';
            $inv_column->dropDown =  '0';
            $inv_column->save();
        }
        else
        {
            $new_category = $category;
        }


        if($existing_attributes != '')
        {
            foreach ($existing_attributes as $existing_attribute)
            {
                $column = new Column();
                $e_column = Column::where('table_column', $existing_attribute)->get()->first();
                $column->category = $new_category;
                $column->table_column = $e_column->table_column;
                $column->column_type = $e_column->column_type;
                $column->column_name = $e_column->column_name;
                $column->min = $e_column->min;
                $column->max = $e_column->max;
                $column->validation = $e_column->validation;
                $column->dropDown = $e_column->dropDown;

                if ($column->save()) {
                    $status = true;
                } else {
                    $status = false;
                    break;
                }
            }
        }

        if($attribute_name[0]!=null)
        {
            $count = count($attribute_name);

            for ($x = 0; $x < $count; $x++) {
                $col = array();
                $attr_name = str_replace(' ','_',strtolower($attribute_name[$x]));
                $col_name = Column::where('table_column',$attr_name)->get();
                if(!is_null($col_name))
                {
                    $status = false;
                    $err = $attr_name.' Duplicate Column Name. ';
                    break;
                }

                $column2 = new Column();
                $column2->category = $new_category;
                $column2->table_column = $attr_name;
                $column2->column_type = $attribute_type[$x];
                $column2->column_name = $attribute_name[$x];
                $column2->min = $attribute_min[$x];
                $column2->max = $attribute_max[$x];
                $column2->validation = $attribute_validation[$x];
                $column2->dropDown = $attribute_drop[$x];



                if($attribute_drop[$x] == 1)
                    $isDropdown++;

                array_push($col, $attr_name);
                array_push($col, $attribute_type[$x]);

                $this->changeSchema($col);

                if ($column2->save()) {
                    $status = true;
                } else {
                    $status = false;
                    break;
                }
            }
        }

        if($status)
        {
            DB::commit();
            if($isDropdown>0)
            {
                \Session::flash('flash_message', 'Settings Saved Successfully! Define Values to New Attributes');
                return Redirect::action('DropDownController@index');
            }
            else
            {
                \Session::flash('flash_message', 'Settings Saved Successfully!');
            }
        }
        else
        {
            DB::rollback();
            \Session::flash('flash_message_error', $err.'Settings could not be changed!');
        }

        return Redirect::action('TableController@index');
    }

    private function changeSchema($col)
    {
        Schema::table('hardware', function ($table) use ($col) {
        $colName = $col[0];
        $colType = $col[1];
        $table->$colType($colName);
        });
    }

    public function remove()
    {
        $delete_attribute = Input::get('delete_attribute');
        $input = Input::all();
        $attributes = '';
        $status = false;

        $category = $input['modal_category'];

        if($delete_attribute!="")
        {
            if(isset($input['modal_attribute']))
            {
                $attributes = $input['modal_attribute'];
            }
            else
            {
                \Session::flash('flash_message_error', 'No Attributes Set for Deletion!');
                return Redirect::action('TableController@index');
            }


            foreach($attributes as $attribute)
            {
                $col = Column::find($attribute);
                $column = $col->table_column;
                $col->delete();

                $new_col = Column::where('table_column',$column)->first();
                if(is_null($new_col))
                {
                    $dropDown = DropDown::where('table_column',$column)->get();

                    if(!is_null($dropDown))
                    {
                        foreach ($dropDown as $drop)
                        {
                            $drop->delete();
                        }
                    }


                    $this->removeColumn($column);
                }
            }
            $status = true;
            \Session::flash('flash_message', 'Attribute Deleted Successfully!');
        }
        else
        {
            $cols = Column::where('category',$category)->get();

            foreach ($cols as $col)
            {
                $column = $col->table_column;
                $col->delete();

                $new_col = Column::where('table_column',$column)->first();
                if(is_null($new_col))
                {
                    $this->removeColumn($column);
                }
            }
            $cat = Type::find($category);
            $cat->delete();

            $hardware = Hardware::where('type',$category)->get();

            foreach($hardware as $hard)
            {
                $inv = $hard->inventory_code;
                $hard->delete();

                $resource = Resource::find($inv);
                $resource->delete();
            }

            $status = true;
            \Session::flash('flash_message', 'Category Deleted Successfully!');
        }

        if(!$status)
            \Session::flash('flash_message_error', 'Error! Settings Unchanged!');
        return Redirect::action('TableController@index');
    }

    private function removeColumn($column)
    {
        Schema::table('hardware', function($table) use ($column)
        {
            $table->dropColumn($column);
        });
    }


}
