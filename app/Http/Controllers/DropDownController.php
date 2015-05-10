<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Column;
use App\DropDown;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use App\Http\Requests\DropDownRequest;

class DropDownController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        $columns = Column::select('table_column','column_name')->where('dropDown', '1')->groupBy('column_name')->get();
        $dropValues = $this->getDropDownValues($columns);
        $count = count($dropValues);

		return view('ManageResource.dropDown',compact('columns','dropValues','count'));
	}

    public function getDropDownValues($columns)
    {
        $dropValues = array();
        foreach($columns as $c)
        {
            $temp = DropDown::where('table_column',$c->table_column)->get();
            array_push($dropValues,$temp);

        }
        return $dropValues;
    }


	public function handle(DropDownRequest $request)
	{
		$add_button = Input::get('add_button');
        $update_button = Input::get('update_button');
        $status = false;

        if($add_button != "")
        {
            $new_item = Input::get('new_value');
            $table_column = Input::get('table_column');
            $dropDown = new DropDown();
            $dropDown->table_column =$table_column;
            $dropDown->value = $new_item;

            $status =  $dropDown->save() ? true : false;

            if($status)
                \Session::flash('flash_message', 'Value added successfully!');
            else
                \Session::flash('flash_message_error', 'Addition failed!');

        }
        elseif($update_button != "")
        {
            $did = Input::get('dropDown');
            $new_value = Input::get('new_value');
            $item = DropDown::find($did);
            $item->value = $new_value;

            $status = $item->save() ? true : false;

            if($status)
                \Session::flash('flash_message', 'Value updated successfully!');
            else
                \Session::flash('flash_message_error', 'Update failed!');

        }
        else
        {
            $did = Input::get('dropDown');
            $item = DropDown::find($did);

            $status = $item->delete() ? true :false;

            if($status)
                \Session::flash('flash_message', 'Value deleted successfully!');
            else
                \Session::flash('flash_message_error', 'Deletion failed!');
        }


        return Redirect::action('DropDownController@index');
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
