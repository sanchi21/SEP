<?php namespace App\Http\Controllers;

use App\Approval;
use App\CCList;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Column;
use App\DropDown;
use App\Item;
use App\PItem;
use App\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use App\Http\Requests\DropDownRequest;
use App\Http\Requests\ItemRequest;

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

        $items = Item::all();
        $vendors = Vendor::all();
        $pItems = PItem::all();
        $approvals = Approval::all();
        $ccList = CCList::all();

		return view('ManageResource.dropDown',compact('columns','dropValues','count','items','vendors','pItems','approvals','ccList'));
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

    public function handle2(ItemRequest $request)
    {
        $add_button = Input::get('add_button');
        $update_button = Input::get('update_button');
        $status = false;

        if($add_button != "")
        {
            $new_item = Input::get('new_value');
            $dropDown = new Item();
            $dropDown->category = $new_item;

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
            $item = Item::find($did);
            $item->category = $new_value;

            $status = $item->save() ? true : false;

            if($status)
                \Session::flash('flash_message', 'Value updated successfully!');
            else
                \Session::flash('flash_message_error', 'Update failed!');

        }
        else
        {
            $did = Input::get('dropDown');
            $item = Item::find($did);

            $status = $item->delete() ? true :false;

            if($status)
                \Session::flash('flash_message', 'Value deleted successfully!');
            else
                \Session::flash('flash_message_error', 'Deletion failed!');
        }


        return Redirect::action('DropDownController@index');
    }

    public function handle3()
    {
        $add_button = Input::get('add_button');
        $update_button = Input::get('update_button');
        $status = false;
        $input = Input::all();

        if($add_button != "")
        {
            if(isset($input['new_value_V']))
            {
                $new_item = $input['new_value_V'];
                $nVendor = new Vendor();
                $nVendor->vendor_name = $new_item;

                $status =  $nVendor->save() ? true : false;
            }
            elseif(isset($input['new_value_I']))
            {
                $new_item = $input['new_value_I'];
                $nItem = new PItem();
                $nItem->item = $new_item;

                $status =  $nItem->save() ? true : false;
            }
            elseif(isset($input['new_value_A']))
            {
                $new_item = $input['new_value_A'];
                $nAproval = new Approval();
                $nAproval->email = $new_item;
                $nAproval->user = $new_item;

                $status =  $nAproval->save() ? true : false;
            }
            elseif(isset($input['new_value_C']))
            {
                $new_item = $input['new_value_C'];
                $nCC = new CCList();
                $nCC->email = $new_item;
                $nCC->user = $new_item;

                $status =  $nCC->save() ? true : false;
            }


            if($status)
                \Session::flash('flash_message', 'Value added successfully!');
            else
                \Session::flash('flash_message_error', 'Addition failed!');

        }
        elseif($update_button != "")
        {
            $input = Input::all();

            if(isset($input['dropDown_V']))
            {
                $did = $input['dropDpwn_V'];
                $new_value = $input['new_value_V'];
                $vendor = Vendor::find($did);
                $vendor->vendor_name = $new_value;

                $status = $vendor->save() ? true : false;
            }
            elseif(isset($input['dropDown_I']))
            {
                $did = $input['dropDpwn_I'];
                $new_value = $input['new_value_I'];
                $pItem = PItem::find($did);
                $pItem->item = $new_value;

                $status = $pItem->save() ? true : false;
            }
            elseif(isset($input['dropDown_A']))
            {
                $did = $input['dropDpwn_A'];
                $new_value = $input['new_value_A'];
                $approve = Approval::find($did);
                $approve->email = $new_value;

                $status = $approve->save() ? true : false;
            }
            elseif(isset($input['dropDown_C']))
            {
                $did = $input['dropDpwn_C'];
                $new_value = $input['new_value_C'];
                $ccl = CCList::find($did);
                $ccl->email = $new_value;

                $status = $ccl->save() ? true : false;
            }

            if($status)
                \Session::flash('flash_message', 'Value updated successfully!');
            else
                \Session::flash('flash_message_error', 'Update failed!');

        }
        else
        {
            $input = Input::all();

            if(isset($input['dropDown_V']))
            {
                $did = $input['dropDown_V'];
                $vendor = Vendor::find($did);

                if(!is_null($vendor))
                    $status = $vendor->delete() ? true : false;
            }
            elseif(isset($input['dropDown_I']))
            {
                $did = $input['dropDown_I'];
                $pItem = PItem::find($did);

                if(!is_null($pItem))
                    $status = $pItem->delete() ? true : false;
            }

            elseif(isset($input['dropDown_A']))
            {
                $did = $input['dropDown_A'];
                $approval = Approval::find($did);

            if (!is_null($approval))
                $status = $approval->delete() ? true : false;
            }
            elseif(isset($input['dropDown_C']))
            {
                $did = $input['dropDown_C'];
                $list = CCList::find($did);

                if (!is_null($list))
                    $status = $list->delete() ? true : false;
            }

            if($status)
                \Session::flash('flash_message', 'Value deleted successfully!');
            else
                \Session::flash('flash_message_error', 'Deletion failed!');
        }


        return Redirect::action('DropDownController@index');
    }

}
