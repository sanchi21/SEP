<?php namespace App\Http\Controllers;

use App\GRequest;
use App\Group;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Column;
use App\Validation;
use App\Http\Requests\RequestTypeRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\RequestType;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App\DropDown;

class RequestTableController extends Controller {

    public function index()
    {
        $id='New';
        $requestTypes = RequestType::all();
        $groups = Group::all();
        $validation = Validation::all();
        $delete_column = Column::where('category',"New")->get();
        $rGroup = 2;
        $aGroup = 1;
        return view('NewRequest.createNewRequest',compact('id','validation','requestTypes','groups','delete_column','rGroup','aGroup'));
    }


    public function store(RequestTypeRequest $request)
    {
        try
        {
            $input = Input::all();
            $requestType = substr($input['request_type'], 14);
            $attributeNames = '';
            $attributeTypes = '';
            $attributeMins = '';
            $attributeMaxs = '';
            $attributeDrops = '';
            $attributeValidates = '';
            $isDropdown = 0;
            $tableData = array();

            $newTitle = str_replace('-','_',strtolower($requestType));
//            $multipleRequest = 'No';

//            if(isset($input['multiple_request']))
//                $multipleRequest = 'Yes';

            $newRequestType = new RequestType();
            $requestIdColumn = new Column();
            $requestStatusColumn = new Column();


            if($requestType == 'New')
            {
                $title = $input['new_title'];
                $newTitle = str_replace('-','_',strtolower($title));

                $requestCode = $input['request_code'];
                $requestGroup = $input['request_group'];
                $approvingGroup = $input['approve_group'];

                $newRequestType->request_type = $newTitle;
                $newRequestType->key = $requestCode;
//                $newRequestType->multiple_request = $multipleRequest;
                $newRequestType->requester_group = $requestGroup;
                $newRequestType->approving_group = $approvingGroup;

                $requestIdColumn->category = $newTitle;
                $requestIdColumn->table_column =  'request_id';
                $requestIdColumn->column_type =  'string';
                $requestIdColumn->column_name =  'Request ID';
                $requestIdColumn->min = ' ';
                $requestIdColumn->max = ' ';
                $requestIdColumn->validation =  '0';
                $requestIdColumn->dropDown =  '0';

                $requestStatusColumn->category = $newTitle;
                $requestStatusColumn->table_column =  'status';
                $requestStatusColumn->column_type =  'string';
                $requestStatusColumn->column_name =  'Status';
                $requestStatusColumn->min = ' ';
                $requestStatusColumn->max = ' ';
                $requestStatusColumn->validation =  '0';
                $requestStatusColumn->dropDown =  '1';
            }


            if (isset($input['attribute_name']))
            {
                $attributeNames = $input['attribute_name'];
                $attributeTypes = $input['attribute_type'];
                $attributeMins = $input['attribute_min'];
                $attributeMaxs = $input['attribute_max'];
                $attributeDrops = $input['attribute_drop'];
                $attributeValidates = $input['attribute_validation'];

                for($i=0 ; $i<count($attributeNames); $i++)
                {
                    $newColumns = array();
                    $newColumns = array_add($newColumns,'category',$newTitle);
                    $newColumns = array_add($newColumns,'table_column',str_replace(' ','_',strtolower($attributeNames[$i])));
                    $newColumns = array_add($newColumns,'column_type',$attributeTypes[$i]);
                    $newColumns = array_add($newColumns,'column_name',$attributeNames[$i]);
                    $newColumns = array_add($newColumns,'min',$attributeMins[$i]);
                    $newColumns = array_add($newColumns,'max',$attributeMaxs[$i]);
                    $newColumns = array_add($newColumns,'validation',$attributeValidates[$i]);
                    $newColumns = array_add($newColumns,'dropDown',$attributeDrops[$i]);

                    array_push($tableData,$newColumns);
                }
            }

            DB::beginTransaction();
            $status = true;
            if($requestType == 'New')
            {
                $status = $newRequestType->save() ? true : false;
                $status = $requestIdColumn->save() ? true : false;
                $status = $requestStatusColumn->save() ? true :false;
                $this->createTable($newTitle);
            }

            if($status)
            {
                Column::insert($tableData);
                $this->addColumns($newTitle,$tableData);

                DB::commit();
                \Session::flash('flash_message', 'Settings Saved Successfully!');
            }
            else
            {
                DB::rollback();
                \Session::flash('flash_message_error', 'Settings could not be changed!');
            }
        }
        catch(\Exception $e)
        {
            \Session::flash('flash_message_error', $e->getMessage());
        }
        return Redirect::action('RequestTableController@index');

    }

    public function edit($id)
    {
        $requestTypes = RequestType::all();
        $groups = Group::all();
        $validation = Validation::all();
        $title = str_replace('-','_',strtolower($id));
        $delete_column = Column::where('category',$title)->where('table_column','<>','request_id')->get();
        $type = RequestType::find($title);
        $rGroup = $type->requester_group;
        $aGroup = $type->approving_group;

        return view('NewRequest.createNewRequest',compact('id','validation','requestTypes','groups','delete_column','rGroup','aGroup'));
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
    public function destroy()
    {
        $input = Input::all();
        $deleteAttribute = Input::get('delete_attribute');
        $attributes = '';

        $title = $input['modal_category'];
        $requestType = str_replace('-','_',strtolower($title));

        if($deleteAttribute != "")
        {
            if (isset($input['modal_attribute']))
            {
                $attributes = $input['modal_attribute'];
            }
            else
            {
                \Session::flash('flash_message_error', 'No Attributes Set for Deletion!');
                return Redirect::action('RequestTableController@index');
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


                    $this->removeColumn($requestType,$column);
                }
            }
            \Session::flash('flash_message', 'Attribute Deleted Successfully!');
        }
        else
        {
            $cols = Column::where('category',$requestType)->get();

            foreach ($cols as $col)
            {
                $column = $col->table_column;
                $col->delete();

                $new_col = Column::where('table_column',$column)->first();
                if(is_null($new_col))
                {
                    $this->removeColumn($requestType,$column);
                }
            }
            $cat = RequestType::find($requestType);
            $cat->delete();

            $gRequest = GRequest::where('type',$requestType)->get();

            if(!is_null($gRequest))
            {
                foreach ($gRequest as $gR)
                {
                    $gR->delete();

                }
            }
            $this->deleteTable($requestType);
            \Session::flash('flash_message', 'Request Type Deleted Successfully!');
        }

        return Redirect::action('RequestTableController@index');

    }

    private function createTable($tableName)
    {
        Schema::create($tableName, function($table)
        {
            $table->increments('id');
            $table->string('request_id',20);
            $table->string('status',10);
            $table->string('remarks');
        });
    }

    private function deleteTable($tableName)
    {
        Schema::dropIfExists($tableName);
    }

    private function addColumns($tableName,$col)
    {

        foreach($col as $c)
        {
            $temp = array();
            array_push($temp, array_pull($c,'table_column'));
            array_push($temp, array_pull($c,'column_type'));
            $this->changeSchema($tableName, $temp);
        }

    }

    private function changeSchema($tableName,$col)
    {
        Schema::table($tableName, function ($table) use ($col) {
            $colName = $col[0];
            $colType = $col[1];
            $table->$colType($colName);
        });
    }

    private function removeColumn($tableName,$column)
    {
        Schema::table($tableName, function($table) use ($column)
        {
            $table->dropColumn($column);
        });
    }

}
