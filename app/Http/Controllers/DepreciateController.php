<?php namespace App\Http\Controllers;

use App\Depreciation;
use App\Hardware;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use App\Http\Requests\AddDepreciateRequest;

class DepreciateController extends Controller {


    public function show($id)
    {
        $inventory_code = str_replace('-','/',$id);
        $depreciation = Depreciation::find($inventory_code);
        $method = $depreciation->method;
        $depreciate = '';
        $dVal = array();
        $hardware = Hardware::find($inventory_code);

        if($method == "Straight Line")
            $depreciate = $this->straightLineDepreciation($inventory_code);
        else
        {
            $depreciate = $this->declineDepreciation($inventory_code);
        }

        $previous = $hardware->value;

        foreach ($depreciate as $dep)
        {
            $temp = $previous - $dep;
            array_push($dVal,$temp);
            $previous = $dep;
        }


        return view('ManageResource.depreciation',compact('depreciate','hardware','dVal'));
    }


	public function store()
	{
		$input = Input::all();
        $inventory_code = $input['inventory_code_dep'];
        $method = $input['method'];

        $resource = new Depreciation();
        $resource->inventory_code = $inventory_code;
        $resource->method = $method;

        if($method == "Straight Line")
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

        return Redirect::action('ResourceController@editAll');
	}


    private function straightLineDepreciation($id)
    {
        $hardware = Hardware::find($id);
        $value = $hardware->value;
        $purchase_date = $hardware->purchase_date;
        $time = strtotime($purchase_date);
        $purchase_year = date("Y",$time);
        $purchase_month = date("n",$time);
        $current_year = date("Y");

        $asset = Depreciation::find($id);
        $residual = $asset->residual;
        $life_time = $asset->year;

        $depreciation = array();
        $year = intval($purchase_year);
        $range = intval($current_year);
        $book_value = $value;

        while($year<= $range)
        {
            $depreciate_value = ($value - $residual)/$life_time;

            if($year == intval($purchase_year))
                $depreciate_value = $depreciate_value * ((12 - $purchase_month) /12.0);

            $asset_value = $book_value - $depreciate_value;

            if($asset_value >= $residual)
                $book_value = $asset_value;

            $depreciation = array_add($depreciation,$year,intval($book_value));

            $year++;
        }

        return $depreciation;

    }

    private function declineDepreciation($id)
    {
        $hardware = Hardware::find($id);
        $value = $hardware->value;
        $purchase_date = $hardware->purchase_date;
        $time = strtotime($purchase_date);
        $purchase_year = date("Y",$time);
        $purchase_month = date("n",$time);
        $current_year = date("Y");

        $asset = Depreciation::find($id);
        $rate = $asset->percentage;
        $residual = ($rate * $value) / 100.0;

        $depreciation = array();
        $year = intval($purchase_year);
        $range = intval($current_year);
        $book_value = $value;

        while($year<= $range)
        {
            $depreciate_value = ($value * $rate) / 100.0;

            if($year == intval($purchase_year))
                $depreciate_value = $depreciate_value * ((12 - $purchase_month) /12.0);

            $asset_value = $book_value - $depreciate_value;

            if($asset_value >= $residual)
                $book_value = $asset_value;

            $depreciation = array_add($depreciation,$year,$book_value);

            $year++;
        }

        return $depreciation;

    }

}
