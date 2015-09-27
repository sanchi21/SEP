<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\System_User;
use Illuminate\Support\Facades\Redirect;
use App\requesth;
use App\req;
use App\Hardware;
use App\Software;
use App\User;
use App\Item;
use Input;
use make;
use View;
use App\file;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use Request;
use App\SystemUser;
use Illuminate\Support\Facades\DB;


class AllocationController extends Controller {


    /**
     *
     * This method returns the view to the allocation blade
     *
     * @return
     */

    Public function view()
    {
        $Allocation_id =1;
        $ids = requesth::where('request_status', '=',$Allocation_id)->get();
        $request_id = Input::get('hid1');
        $device_status='Not Allocated';

        $hardware_types='Allocated';
        $results='';

        return view('Requests.Allocate')->with('ids',$ids)->with('results',$results)->with('hardware_types',$hardware_types);

    }


    /**
     *
     * This method retrieves all the hardware and software requests
     *
     * @return hardware & software requests
     */

    Public function ViewRequests()
    {

        try {

            /* attribute values from the blade page */

            $request_id = Input::get('hid1');
            $project_id = Input::get('hid2');
            $Allocation_id = 1;

            $sub = '';
            $inventory_code = 'e';
            $device_status = 'Not Allocated';

            \Session::flash('flash_av', '');
            $results = req::where('request_id', '=', $request_id)->where('status', '=', $device_status)->get();

            $ids = requesth::where('request_status', '=', $Allocation_id)->get();
            $ftp_account = file::where('request_id', '=', $request_id)->get();

            $resource_type = Input::get('resource_type');
            $type = Input::get('type');
            $hardware_types = Hardware::where('status', '=', $device_status)->where('type', 'LIKE', '%' . $type . '%')->paginate(30);


            return view('Requests.Allocate')->with('ids', $ids)->with('results', $results)->with('ftp_account', $ftp_account)->with('hardware_types', $hardware_types)->with('inventory_code', $inventory_code)->with('sub', $sub);

        }

        catch (\Exception $e)
        {

            return Redirect::back()->withErrors($e->getMessage());

        }

    }


    /**
     *
     * Allocates a hardware or software for a viewed request.
     * Checks for the correct date and correct allocation
     *
     * @return emails to the pr.
     *
     */

    Public function ResourceAllocation()
    {
        /* Get the values from view */

        $request_id = Input::get('hidr');
        $sub_id = Input::get('hid3');
        $item = Input::get('hid4');
        $device_type = Input::get('hid6');
        $serial = Input::get('serial');
        $date = Input::get('date');
        $remarks = Input::get('remarks');

        $status = 'Allocated';
        $status2 = 'Not Allocated';


        $check_device = Hardware::where('inventory_code', '=', $serial)->pluck('type');
        $check_software = Software::where('inventory_code', '=', $serial)->pluck('name');

        /* Validate dates*/

        if ((empty($serial) || empty($date)))
        {

                \Session::flash('flash_message_error', 'Serial no and date fields cannot be empty');
                return redirect('Allocate');

        }

        else
        {
                if ($item != '')
                {

                    if ($item != $check_device)
                    {

                        \Session::flash('flash_message_error', 'Requested hardware doest match with the allocation');
                        return redirect('Allocate');

                    }

                    else
                    {

                        $count=Hardware::where('inventory_code', '=', $serial)->pluck('count');
                        $new_count=$count+1;
                        $hard = Hardware::find($serial);
                        $hard->status = $status;
                        $hard->count=$new_count;
                        $hard->save();

                        $r = DB::table('reqs')
                            ->where('request_id', $request_id)
                            ->where('sub_id', $sub_id)
                            ->update(array('inventory_code' => $serial, 'assigned_date' => $date, 'remarks' => $remarks, 'status' => $status));

                        $user_id = DB::table('requesths')->where('request_id', $request_id)->pluck('user_id');

                        $user_d = SystemUser::where('id',$user_id)->get();
                        $user_data = $user_d[0];
                        $user = $user_data->username;
                        $email = $user_data->email;



                        try
                        {

                            Mail::send('Requests.AllocationSuccess', array('username' => $user, 'date' => $date, 'name' => $check_device), function ($message) use ($user, $email) {
                                $message->to($email, $user)->subject('Resource Allocation');
                            });

                            \Session::flash('flash_message', 'Hardware Allocated Successfully');
                            return redirect('Allocate');

                        }

                        catch(\Exception $e)
                        {


                        }

                    }

                }

                else
                {

                    $no_of_license = Software::where('inventory_code', '=', $serial)->get();
                    $get_first_row = $no_of_license->first();
                    $license_count = $get_first_row->no_of_license;
                    $name=$get_first_row->name;
                    $get_count = Input::get('hid7');
                    $new_count = $license_count - $get_count;

                    if ($device_type != $check_software)
                    {

                        \Session::flash('flash_message_error', 'Requested software doest match with the allocation');
                        return redirect('Allocate');

                    }

                    else
                    {

                        if ($get_count <= $license_count)
                        {

                            $soft = Software::find($serial);   //update software table
                            $soft->status = $status;
                            $soft->no_of_license = $new_count;
                            $soft->save();

                            $r = DB::table('reqs')
                                ->where('request_id', $request_id)
                                ->where('sub_id', $sub_id)
                                ->update(array('inventory_code' => $serial, 'assigned_date' => $date, 'remarks' => $remarks, 'status' => $status));


                            $user_id = DB::table('requesths')->where('request_id', $request_id)->pluck('user_id');

                            $user_d = SystemUser::where('id',$user_id)->get();
                            $user_data = $user_d[0];
                            $user = $user_data->username;
                            $email = $user_data->email;

                            Mail::send('Requests.AllocationSuccess', array('username' => $user,'date' => $date,'name' => $name), function ($message) use ($user, $email) {
                                $message->to($email, $user)->subject('Resource Allocation');
                            });



                            \Session::flash('flash_message', 'Software Allocated Successfully');
                            return redirect('Allocate');

                        }

                        else
                        {

                            \Session::flash('flash_message_error', 'Less no of Licenses/ cannot allocate');
                            return redirect('Allocate');

                        }

                    }

                }

                $no_of_not_allocated = req::where('request_id', '=', $request_id)->where('status', '=', $status2)->get();
                $count = $no_of_not_allocated->count();

                if ($count == 0)
                {

                    $reqh = requesth::find($request_id);
                    $reqh->request_status = 0;
                    $reqh->save();

                }


        }


    }


    /**
     *
     * Searches for a resource by the given item name
     * Both hardware and software resource
     * Displays the search results
     *
     * @return mixed
     */

    Public function SearchResource()
    {

        try
        {

                $resource_type = Input::get('resource_type');
                $type = Input::get('type');
                $inventory_code = Input::get('hid11');

                $request_id = Input::get('r1');
                $Allocation_id = 1;
                $device_status = 'Not Allocated';
                $sub = '';
                $device_status_allocated = 'Allocated';

                $results = req::where('request_id', '=', $request_id)->where('status', '=', $device_status)->get();
                $ids = requesth::where('request_status', '=', $Allocation_id)->get();
                $ftp_account = file::where('request_id', '=', $request_id)->get();


                if ($resource_type == 'Hardware')
                {

                    $hardware_types = Hardware::where('status', '=', $device_status)->where('type', 'LIKE', '%' . $type . '%')->paginate(30);
                    $count_hard = $hardware_types->count();

                }

                elseif ($resource_type == 'Allocated Hardware')
                {

                    $hardware_types = Hardware::where('status', '=', $device_status_allocated)->where('type', 'LIKE', '%' . $type . '%')->paginate(30);
                    $count_hard = $hardware_types->count();

                }

                else
                {

                    $hardware_types = Software::where('name', 'LIKE', '%' . $type . '%')->paginate(30);
                    $count_hard = $hardware_types->count();

                }

                if ($count_hard == 0)
                {

                    \Session::flash('flash_message_search', 'Search results not found');
                    return redirect('Allocate');

                }

                else
                {

                    \Session::flash('flash_search', '');
                    return view('Requests.Allocate')->with('hardware_types', $hardware_types)->with('results', $results)->with('ids', $ids)->with('ftp_account', $ftp_account)->with('inventory_code', $inventory_code)->with('sub', $sub);

                }

        }

        catch (\Exception $e)
        {

                return Redirect::back()->withErrors($e->getMessage());

        }


    }


    /**
     *
     * One of the searched results will be allocated to a certain request
     * One hardware to one request
     *
     * @return mixed
     */

    Public function SendResource(){

        try
        {

            $inventory_code = Input::get('hid11');
            $request_id = Input::get('r2');

            $Allocation_id = 1;
            $device_status = 'Not Allocated';
            $resource_type = Input::get('resource_type');
            $type = Input::get('type');

            $sub = Input::get('sub');

            $results = req::where('request_id', '=', $request_id)->where('status', '=', $device_status)->get();
            $ids = requesth::where('request_status', '=', $Allocation_id)->get();

            $ftp_account = file::where('request_id', '=', $request_id)->get();
            $type = Input::get('type');


            if ($resource_type == 'Hardware')
            {

                $hardware_types = Hardware::where('status', '=', $device_status)->where('type', 'LIKE', '%' . $type . '%')->paginate(30);

            }

            else
            {

                $hardware_types = Software::where('name', 'LIKE', '%' . $type . '%')->paginate(30);

            }

            \Session::flash('flash_get', '');
            return view('Requests.Allocate')->with('hardware_types', $hardware_types)->with('results', $results)->with('ids', $ids)->with('ftp_account', $ftp_account)->with('inventory_code', $inventory_code)->with('sub', $sub);

        }

        catch(\Exception $e)
        {

            return Redirect::back()->withErrors($e->getMessage());

        }

    }


    /**
     *
     *Load the blade page of allocation
     *
     * @return mixed
     */

    Public function getViewAll()
    {

        return view('Requests.ViewAll');

    }


    /**
     * Load the blade page pf multiple hardware allocation
     *
     * @return mixed
     */

    Public function getViewOfAllocations()
    {

        return view('Requests.ViewHardwareResources');

    }


    /**
     * Send all the allocations for a certain project to the ViewAll blade
     * A table view of allocations
     *
     * @return mixed
     */

    Public function ViewAll()
    {

        $request_id = Input::get('hid1');
        $project_id = Input::get('hid2');
        $device_status='Allocated';

        $project=requesth::where('request_id', '=',$request_id);
        $row=$project->first();
        $project_code=$row->project_id;

        $results = req::where('request_id', '=',$request_id)->where('status','=',$device_status)->get();

        return view('Requests.ViewAll')->with('results',$results)->with('project_code',$project_code);

    }


    /**
     *
     * Multiple allocation of a hardware
     * A table view
     *
     * @return mixed
     */

    Public function viewAllocatedHardware()
    {

        $inventory_code = Input::get('hid11');
        $results = req::where('inventory_code', '=', $inventory_code)->get();
        $inventoryType=Input::get('typeView');

        $a=0;

        try
        {

            foreach ($results as $item)
            {

                $first[$a] = $item->request_id;
                $a = $a + 1;

            }

            for ($a = 0; $a < sizeof($first); $a++)
            {

                $projectCodes[$a] = requesth::where('request_id', '=', $first[$a])->pluck('project_id');

            }

            return view('Requests.ViewHardwareResources')->with('inventoryType', $inventoryType)->with('projectCodes', $projectCodes)->with('results', $results)->with('inventory_code', $inventory_code);

        }

        catch(\Exception $e)
        {

            return Redirect::back()->withErrors($e->getMessage());

        }

    }



    /******************************Hardware Resource History************************************************************/


    /**
     * Load the trackResource blade page
     *
     * @return View
     */

    Public function getTrackResource()
    {

        return view('Requests.TrackResource');

    }


    /**
     * Track a hardware resource by projects
     * lists down the projects where a certain hardware was used
     *
     * @return mixed
     */

    Public function Track()
    {

        try
        {

            $resource_type = Input::get('resource_type');
            $type = Input::get('type');

            if ($resource_type == 'Hardware')
            {

                $hardware_types = Hardware::where('type', 'LIKE', '%' . $type . '%')->paginate(30);

            }

            else
            {

                $hardware_types = Software::where('name', 'LIKE', '%' . $type . '%')->paginate(30);

            }

            $get_serial_no = '';
            $history = req::where('inventory_code', '=', $get_serial_no)->get();

            \Session::flash('flash_search_resource', '');
             return view('Requests.TrackResource')->with('hardware_types', $hardware_types)->with('history', $history)->with('get_serial_no', $get_serial_no);
        }

        catch(\Exception $e)
        {

            return Redirect::back()->withErrors($e->getMessage());

        }

    }


    /**
     * Track a hardware resource by projects
     * lists down the projects where a certain hardware was used
     *
     * @return mixed
     */

    Public function FindHistory()
    {

        try
        {

            $resource_type = Input::get('resource_type');
            $type = Input::get('type');

            if ($resource_type == 'Hardware')
            {

                $hardware_types = Hardware::where('type', 'LIKE', '%' . $type . '%')->paginate(30);

            }

            else
            {

                $hardware_types = Software::where('name', 'LIKE', '%' . $type . '%')->paginate(30);

            }

            $get_serial_no = Input::get('hid_serial_code');
            $history = req::where('inventory_code', '=', $get_serial_no)->get();

            \Session::flash('flash_search_history', '');
            return view('Requests.TrackResource')->with('hardware_types', $hardware_types)->with('history', $history)->with('get_serial_no', $get_serial_no);

        }

        catch(\Exception $e)
        {
            return Redirect::back()->withErrors($e->getMessage());

        }

    }


    /******************************Hardware Maintenance*****************************************************************/

    /**
     * Load maintenance blade page
     * with the relevant details
     *
     * @return mixed
     */

    Public function getHardwareMaintenance()
    {

        $hardware = Hardware::all();
        $finds = "";
        $total_cost = "";
        $inventory_code = 'CMB/COM/0001';

        $stats = DB::table('maintenance')->where('inventory_code', '=', $inventory_code)->get();
        $data = "";

        return view('Requests.HardwareMaintenance')->with('stats', $stats)->with('hardware', $hardware)->with('finds', $finds)->with('total_cost', $total_cost)->with('inventory_code',$inventory_code);

    }

    /**
     * Get or retrieve all the cost information from the page
     * Save the maintenance cost in the data base
     * Retrieve cost details and chart
     *
     * @return success or error message
     */

    Public function SaveHardwareCost()
    {

        try
        {

            /* Attributes values from the blade page */

            $save = Input::get('save');
            $view = Input::get('view');
            $inventory_code = Input::get('hw');
            $remarks = Input::get('remarks');
            $date = Input::get('date');
            $cost = Input::get('cost');

            $pattern = '/^(?:0|[1-9]\d*)(?:\.\d{2})?$/';  /* pattern used to validate cost field*/

            /* Save function in the view*/

            if ($save)
            {
                /* Check whether fields are empty */

                if ((empty($date) || empty($cost)))
                {

                    \Session::flash('flash_message_error', 'Date And Cost Fields Cannot Be Empty');
                    return redirect('HardwareMaintenance');

                }

                else
                {
                    /* Check whether provided cost is valid */

                    if (preg_match($pattern, $cost) == '0')
                    {

                        \Session::flash('flash_message_error', 'Invalid cost type');
                        return redirect('HardwareMaintenance');

                    }

                    else
                    {

                        /* Save maintenance cost */

                        $insert = DB::table('maintenance')->insert(array('inventory_code' => $inventory_code,
                                'remarks' => $remarks,
                                'date' => $date,
                                'cost' => $cost)
                        );
                        \Session::flash('flash_message', 'Maintenance Cost Added successfully');
                        return redirect('HardwareMaintenance');

                    }

                }
            }

            if ($view)          /* retrieves the cost and chart for a selected  hardware resource*/
            {

                $inventory_code = Input::get('hw');
                $finds = DB::table('maintenance')->where('inventory_code', '=', $inventory_code)->get();
                $total_cost = DB::table('maintenance')->where('inventory_code', '=', $inventory_code)->sum('cost');
                $hardware = Hardware::all();

                /* Values for bar chart */
                /* values are grouped by the remarks */

                $stats=DB::table('maintenance')
                    ->select(DB::raw('SUM(cost) as cost, remarks'))
                    ->where('inventory_code', '=', $inventory_code)
                    ->groupBy('remarks')
                    ->get();



                \Session::flash('flash_total_c', '');
                return view('Requests.HardwareMaintenance')->with('hardware', $hardware)->with('finds', $finds)->with('total_cost', $total_cost)->with('stats',$stats)->with('inventory_code',$inventory_code);


            }

        }

        catch (\Exception $e)
        {

            return Redirect::back()->withErrors($e->getMessage());

        }

    }


    /****************************** Hardware Device Report *****************************************************************/


    /**
     * Loads the blade page with the provided attributes
     * ViewGraphs.blade
     *
     */

    Public function getAllocationReports()
    {
        try
        {

            /* All the available hardware items */

            $hardwareItems = Item::all();

            $items = Input::get('items');
            $allocatedStatus = 'Allocated';
            $notAllocatedStatus = 'Not Allocated';

            $getDevicesAllocated = Hardware::where('type', '=', $items)->where('status', '=', $allocatedStatus)->get();
            $allocationCount = $getDevicesAllocated->count();

            $getDevicesNotAllocated = Hardware::where('type', '=', $items)->where('status', '=', $notAllocatedStatus)->get();
            $notAllocatedCount = $getDevicesNotAllocated->count();

            return view('Requests.ViewGraphs')->with('hardwareItems', $hardwareItems)->with('getDevicesNotAllocated', $getDevicesNotAllocated)->with('getDevicesAllocated', $getDevicesAllocated)->with('selectedItem', $items)->with('allocationCount', $allocationCount)->with('notAllocatedCount', $notAllocatedCount);

        }

        catch (\Exception $e)
        {

            return Redirect::back()->withErrors($e->getMessage());

        }

    }


    /**
     *
     * All the Allocated and non allocated devices,
     * is included in the report
     * Renders a bar chart for the resources
     *
     * @return a resource allocation report
     */

    Public function ViewAllocationGraph()
    {

        try
        {

            $items=Input::get('items');
            $hardwareItems = Item::all();
            $allocatedStatus='Allocated';
            $notAllocatedStatus='Not Allocated';

            /* Allocated Hardware details*/

            $getDevicesAllocated = Hardware::where('type', '=', $items)->where('status','=',$allocatedStatus)->get();
            $allocationCount=$getDevicesAllocated->count();

            /* Available hardware details */

            $getDevicesNotAllocated = Hardware::where('type', '=', $items)->where('status','=',$notAllocatedStatus)->get();
            $notAllocatedCount=$getDevicesNotAllocated->count();

            return view('Requests.ViewGraphs')->with('hardwareItems',$hardwareItems)->with('getDevicesNotAllocated',$getDevicesNotAllocated)->with('getDevicesAllocated',$getDevicesAllocated)->with('selectedItem', $items)->with('allocationCount',$allocationCount)->with('notAllocatedCount',$notAllocatedCount);

        }

        catch (\Exception $e)
        {

            return Redirect::back()->withErrors($e->getMessage());

        }

    }




}
