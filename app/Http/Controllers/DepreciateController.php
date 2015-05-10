<?php namespace App\Http\Controllers;

use App\Depreciation;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use App\Http\Requests\AddDepreciateRequest;

class DepreciateController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return 'Depreciation';
	}

		/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(AddDepreciateRequest $request)
	{
		$input = Input::all();
        $inventory_code = $input['inventory_code_dep'];
        $method = $input['method'];

        $resource = new Depreciation();
        $resource->inventory_code = $inventory_code;
        $resource->method = $method;

        if($method = "Straight Line")
        {
            $resource->residual = $input['residual'];
            $resource->year = $input['year'];
        }
        else
        {
            $resource->percentage = $input['percentage'];
        }

        if($resource->save())
            \Session::flash('flash_message', 'Hardware '.$inventory_code.' added for depreciation successfully!');
        else
            \Session::flash('flash_message_error', 'Could not set depreciation!');

        return Redirect::action('DepreciateController@index');
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
