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
     * Display querying view.
     *
     * @param category
     * @return Other querying form
     */
	public function index($category)
	{
        //make category a subject to observe
        $hardwareCategory = new SubjectCategory();

        //objects to observe category

        $columnObserver = new ObserverColumn();
        $dateColumnObserver = new ObserverDateColumn();
        $valueColumnObserver = new ObserverValueColumn();

        //attach all the observers (columns) to the subject (category) to observe
        $hardwareCategory->attach($columnObserver);
        $hardwareCategory->attach($dateColumnObserver);
        $hardwareCategory->attach($valueColumnObserver);

        //each observer will be notified and updated when category changes and return the state of the observers
        $cols = $hardwareCategory->updateCategory($category);

        //get each observers (columns) current state
        $columns = $cols[0];
        $dateColumns = $cols[1];
        $valueColumns = $cols[2];

        //initialize the selected columns
        $selected = $this->initSelected();

        $types = Type::all();
        $hardwares = '';

        return view('ManageResource.printHardware',compact('types','columns','category','dateColumns','valueColumns','hardwares','selected'));

	}


    /**
     * return queried data.
     *
     *
     * @return hardware Data
     */
    public function generateReport()
    {
        //get all inputs from form post
        $input = Input::all();

        //get category
        $category = substr($input['category'],17);

        //get selected columns to view
        $selectedColumns = $input['columns'];

        //initialize groupBy attribute (default)
        $groupBy = array('inventory_code');

        //check if group by is set and get the value
        if(isset($input['group_by']))
            $groupBy = $input['group_by'];

        //get order by column
        $orderBy = $input['order_by'];

        //get the order for order by ( asc / desc )
        $order = $input['order'];

        //get the selected date field
        $dateField = $input['date'];

        //get the selected value field
        $valueField = $input['value'];

        //initialize the date and value ranges
        $dateStart = '';
        $dateEnd = '';
        $valueStart = '';
        $valueEnd = '';

        //check if the date field is set and get the range
        if($dateField != 'None')
        {
            $dateStart = $input['start_date'];
            $dateEnd = $input['end_date'];
        }

        //check if the value field is set and get the range
        if($valueField != 'None')
        {
            $valueStart = $input['value_start'];
            $valueEnd = $input['value_end'];
        }

        //set the selected columns to send it back to the form
        $selected = array();
        $selected = array_add($selected,'sColumn',$selectedColumns);
        $selected = array_add($selected,'sGroup',$groupBy);
        $selected = array_add($selected,'sOrder',array($orderBy,$order));
        $selected = array_add($selected,'sdt',$dateField);
        $selected = array_add($selected,'sDtBt',array($dateStart,$dateEnd));
        $selected = array_add($selected,'sVl',$valueField);
        $selected = array_add($selected,'sVlBt',array($valueStart,$valueEnd));


        //get hardware data for the filtered conditions
        $hardware = new Hardware();
        $hardwares = $hardware->getHardwareData($selectedColumns,$category,$groupBy,$orderBy,$order,$dateField,$dateStart,$dateEnd,$valueField,$valueStart,$valueEnd);

        //make category the subject
        $hardwareCategory = new SubjectCategory();

        //create observers (columns) to observe category
        $columnObserver = new ObserverColumn();
        $dateColumnObserver = new ObserverDateColumn();
        $valueColumnObserver = new ObserverValueColumn();

        //attach the observers
        $hardwareCategory->attach($columnObserver);
        $hardwareCategory->attach($dateColumnObserver);
        $hardwareCategory->attach($valueColumnObserver);

        //notify the observers and get the current state
        $cols = $hardwareCategory->updateCategory($category);

        //get each observers (columns) current state
        $columns = $cols[0];
        $dateColumns = $cols[1];
        $valueColumns = $cols[2];

        $types = Type::all();

        return view('ManageResource.printHardware',compact('types','columns','category','dateColumns','valueColumns','hardwares','selected'));

    }


    /**
     * display category summary view.
     *
     *
     * @return category Data
     */
    public function categoryView()
    {
        //get category summary
        $hardware = new Hardware();
        $category = $hardware->getCategoryView();

        return view('ManageResource.printTypes',compact('category'));
    }


    /**
     * initialize selected columns
     *
     *
     * @return selectedColumns
     */
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
