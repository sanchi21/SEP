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
use League\Flysystem\Exception;

class RequestTableController extends Controller {

    /**
     * show the other request create page
     *
     *
     * @return Other request type create form
     */

    public function index()
    {
        //set the request type id to New
        $id='New';

        //retrieve all the available request types
        $requestTypes = RequestType::all();

        //retrieve the user groups available
        $groups = Group::all();

        //retrieve all the validation rules available
        $validation = Validation::all();

        //get all the columns available for the given request type
        $delete_column = Column::where('category',"New")->get();

        //set the default approving group to 2
        $rGroup = 2;

        //set the default requesting group to 1
        $aGroup = 1;


        return view('NewRequest.createNewRequest',compact('id','validation','requestTypes','groups','delete_column','rGroup','aGroup'));
    }


    /**
     * store the request type data to database
     *
     * @param RequestTypeRequest
     *
     * @return Response
     */

    public function store(RequestTypeRequest $request)
    {
        try
        {
            //get all the inputs
            $input = Input::all();

            //get the request type
            $requestType = substr($input['request_type'], 14);

            //define variables to get new attribute details
            $attributeNames = '';
            $attributeTypes = '';
            $attributeMins = '';
            $attributeMaxs = '';
            $attributeDrops = '';
            $attributeValidates = '';
            $isDropdown = 0;

            //array to hold new request type details
            $tableData = array();

            //get the new request type name and replace - with _
            $newTitle = str_replace('-','_',strtolower($requestType));

            //array to hold new request type data
            $newRequestType = new RequestType();

            //array to hold new request type's request id column
            $requestIdColumn = new Column();

            //array to new request type request status columns
            $requestStatusColumn = new Column();


            //if it is a new request type

            if($requestType == 'New')
            {
                //get the title
                $title = $input['new_title'];

                //replace the new title - with _
                $newTitle = str_replace('-','_',strtolower($title));

                //check whether request type already exist
                $existingRequest = RequestType::find($newTitle);

                if(!is_null($existingRequest))
                {
                    \Session::flash('flash_message_error', 'Request Type already exist');
                    return Redirect::action('RequestTableController@index');
                }

                //get the new request type data
                $requestCode = $input['request_code'];
                $requestGroup = $input['request_group'];
                $approvingGroup = $input['approve_group'];

                $newRequestType->request_type = $newTitle;
                $newRequestType->key = $requestCode;
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


            //if new columns are created for request type get new column data
            if (isset($input['attribute_name']))
            {
                $attributeNames = $input['attribute_name'];
                $attributeTypes = $input['attribute_type'];
                $attributeMins = $input['attribute_min'];
                $attributeMaxs = $input['attribute_max'];
                $attributeDrops = $input['attribute_drop'];
                $attributeValidates = $input['attribute_validation'];

                //get the new columns details and store it to an array
                for($i=0 ; $i<count($attributeNames); $i++)
                {
                    $cl = Column::where('column_name',$attributeNames[$i])->get();

                    if(!is_null($cl))
                    {
                        \Session::flash('flash_message_error', 'Column Name : '.$attributeNames[$i].' already exist. Settings not saved!');
                        return Redirect::action('RequestTableController@index');
                    }

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

            //begin database transaction
            DB::beginTransaction();

            //to check for error status
            $status = true;

            //store new request type data
            if($requestType == 'New')
            {
                $status = $newRequestType->save() ? true : false;
                $status = $requestIdColumn->save() ? true : false;
                $status = $requestStatusColumn->save() ? true :false;

                //create new request type table in the database
                $this->createTable($newTitle);
            }

            if($status)
            {
                //insert request type column data to database
                Column::insert($tableData);

                //create new columns for the request type
                $this->addColumns($newTitle,$tableData);

                //commit database
                DB::commit();

                if($requestType == 'New')
                    \Session::flash('flash_message', 'Request Type Created Successfully!');
                else
                    \Session::flash('flash_message', 'Settings Saved Successfully!');
            }
            else
            {
                DB::rollback();
                if($requestType == 'New')
                    \Session::flash('flash_message_error', 'Request Type Creation Failed!');
                else
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
     * Remove the request type columns from database
     *
     * @return Response
     */

    public function destroy()
    {
        try
        {
            //get all the inputs
            $input = Input::all();

            //get the request type to check for delete operation
            $deleteAttribute = Input::get('delete_attribute');
            $attributes = '';

            //get the request type
            $title = $input['modal_category'];

            //replace the request type - with _
            $requestType = str_replace('-', '_', strtolower($title));


            //if the request is for delete attributes

            if ($deleteAttribute != "")
            {
                //check for attributes set
                if (isset($input['modal_attribute']))
                {
                    $attributes = $input['modal_attribute'];
                }
                else
                {
                    \Session::flash('flash_message_error', 'No Attributes Set for Deletion!');
                    return Redirect::action('RequestTableController@index');
                }

                //find the attributes set for deletion and remove them from the database and table
                foreach ($attributes as $attribute) {
                    $col = Column::find($attribute);
                    $column = $col->table_column;
                    $col->delete();

                    $new_col = Column::where('table_column', $column)->first();

                    //if there are dropdowns defined delete them

                    if (is_null($new_col)) {
                        $dropDown = DropDown::where('table_column', $column)->get();

                        if (!is_null($dropDown)) {
                            foreach ($dropDown as $drop) {
                                $drop->delete();
                            }
                        }


                        $this->removeColumn($requestType, $column);
                    }
                }
                \Session::flash('flash_message', 'Attribute Deleted Successfully!');
            }

            //delete category

            else
            {
                $cols = Column::where('category', $requestType)->get();

                foreach ($cols as $col) {
                    $column = $col->table_column;
                    $col->delete();

                    $new_col = Column::where('table_column', $column)->first();
                    if (is_null($new_col)) {
                        $this->removeColumn($requestType, $column);
                    }
                }
                $cat = RequestType::find($requestType);
                $cat->delete();

                $gRequest = GRequest::where('type', $requestType)->get();

                if (!is_null($gRequest)) {
                    foreach ($gRequest as $gR) {
                        $gR->delete();

                    }
                }
                $this->deleteTable($requestType);
                \Session::flash('flash_message', 'Request Type Deleted Successfully!');
            }
        }
        catch(\Exception $e)
        {
            return Redirect::back()->withErrors($e->getMessage());
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
