<?php namespace App\Http\Controllers;

use App\Hardware;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Type;
use App\Http\Controllers\SubjectCategory;
use App\Http\Controllers\ObserverColumn;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class PrintResourceController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index($category)
	{
        $hardwareCategory = new SubjectCategory();
        $columnObserver = new ObserverColumn();
        $dateColumnObserver = new ObserverDateColumn();
        $valueColumnObserver = new ObserverValueColumn();

        $hardwareCategory->attach($columnObserver);
        $hardwareCategory->attach($dateColumnObserver);
        $hardwareCategory->attach($valueColumnObserver);

        $cols = $hardwareCategory->updateCategory($category);

        $columns = $cols[0];
        $dateColumns = $cols[1];
        $valueColumns = $cols[2];

        $selected = $this->initSelected();

        $types = Type::all();
        $hardwares = '';

        return view('ManageResource.printHardware',compact('types','columns','category','dateColumns','valueColumns','hardwares','selected'));

	}

    public function generateReport()
    {
        $input = Input::all();
        $category = substr($input['category'],17);

        $selectedColumns = $input['columns'];

        $groupBy = array('inventory_code');

        if(isset($input['group_by']))
            $groupBy = $input['group_by'];

        $orderBy = $input['order_by'];
        $order = $input['order'];
        $dateField = $input['date'];
        $valueField = $input['value'];

        $dateStart = '';
        $dateEnd = '';
        $valueStart = '';
        $valueEnd = '';

        if($dateField != 'None')
        {
            $dateStart = $input['start_date'];
            $dateEnd = $input['end_date'];
        }

        if($valueField != 'None')
        {
            $valueStart = $input['value_start'];
            $valueEnd = $input['value_end'];
        }

        $selected = array();
        $selected = array_add($selected,'sColumn',$selectedColumns);
        $selected = array_add($selected,'sGroup',$groupBy);
        $selected = array_add($selected,'sOrder',array($orderBy,$order));
        $selected = array_add($selected,'sdt',$dateField);
        $selected = array_add($selected,'sDtBt',array($dateStart,$dateEnd));
        $selected = array_add($selected,'sVl',$valueField);
        $selected = array_add($selected,'sVlBt',array($valueStart,$valueEnd));


        $hardware = new Hardware();
        $hardwares = $hardware->getHardwareData($selectedColumns,$category,$groupBy,$orderBy,$order,$dateField,$dateStart,$dateEnd,$valueField,$valueStart,$valueEnd);

        $hardwareCategory = new SubjectCategory();
        $columnObserver = new ObserverColumn();
        $dateColumnObserver = new ObserverDateColumn();
        $valueColumnObserver = new ObserverValueColumn();

        $hardwareCategory->attach($columnObserver);
        $hardwareCategory->attach($dateColumnObserver);
        $hardwareCategory->attach($valueColumnObserver);

        $cols = $hardwareCategory->updateCategory($category);

        $columns = $cols[0];
        $dateColumns = $cols[1];
        $valueColumns = $cols[2];

        $types = Type::all();

        return view('ManageResource.printHardware',compact('types','columns','category','dateColumns','valueColumns','hardwares','selected'));

    }

    private function initSelected()
    {
        $selected = array();
        $selected = array_add($selected,'sColumn',array());
        $selected = array_add($selected,'sGroup',array('inventory_code'));
        $selected = array_add($selected,'sOrder',array('inventory_code','asc'));
        $selected = array_add($selected,'sdt','None');
        $selected = array_add($selected,'sDtBt',array('',''));
        $selected = array_add($selected,'sVl','None');
        $selected = array_add($selected,'sVlBt',array('',''));

        return $selected;
    }


}
