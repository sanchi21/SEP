<?php namespace App\Http\Controllers;

use App\Client_Device;
use App\Desktop_Laptop;
use App\Dongle_SIM;
use App\Hardware;
use App\Http\Requests;
use App\Resource;
use App\Http\Controllers\Controller;
use App\Server;
use App\Virtual_Server;
use DoctrineTest\InstantiatorTestAsset\SerializableArrayObjectAsset;
use Illuminate\Support\Facades\DB;
use App\Type;
//use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Request;

class ResourceController extends Controller {

	public function index()
    {
        $types = Type::all();
        $id = "Office-Equipment";
        $key = Hardware::getInventoryCode($id);
        return view ('ManageResource.addHardware',compact('types','id','key'));
    }

    public function hardware($id)
    {
        $types = Type::all();
        $key = Hardware::getInventoryCode($id);
        return view ('ManageResource.addHardware',compact('types','id','key'));
    }

    public function store()
    {
        $input = Request::all();
        $count = $input['quantity'];
        $category = substr($input['category_t'],10);
        $inventoryCode = $input['inventory_code_t'];
        $description = $input['description_t'];
        $serialNo = $input['serial_no_t'];
        $ipAddress = $input['ip_address_t'];
        $make = $input['make_t'];
        $model = $input['model_t'];
        $purchaseDate = $input['purchase_date_t'];
        $warrantyExpDate = $input['warranty_exp_t'];
        $insurance = $input['insurance_t'];
        $value = $input['value_t'];
        $cpu = '';
        $ram = '';
        $hardDisk = '';
        $os = '';
        $serverClassification = '';
        $noOfCpu = '';
        $hostServer = '';
        $noOfCore = '';
        $phoneNo = '';
        $serviceProvider = '';
        $dataLimit = '';
        $monthlyRental = '';
        $location = '';
        $deviceType = '';
        $clientName = '';

        if($category == "Desktop" || $category == "Laptop" || $category == "Server" || $category == "Virtual-Server")
        {
            $cpu = $input['cpu_t'];
            $ram = $input['ram_t'];
            $hardDisk = $input['hard_disk_t'];
            $os = $input['os_t'];

            if($category == "Server")
            {
                $serverClassification = $input['server_classification_t'];
                $noOfCpu = $input['no_of_cpu_t'];
            }

            if($category == "Virtual-Server")
            {
                $hostServer = $input['host_server_t'];
                $noOfCore = $input['no_of_core_t'];
            }
        }
        elseif($category == "Dongle" || $category == "SIM")
        {
            $phoneNo = $input['phone_number_t'];
            $serviceProvider = $input['service_provider_t'];
            if($category == "Dongle")
            {
                $dataLimit = $input['data_limit_t'];
                $monthlyRental = $input['monthly_rental_t'];
            }
            else
            {
                $location = $input['location_t'];
            }
        }
        elseif($category == "Client-Device")
        {
            $deviceType = $input['device_type_t'];
            $clientName = $input['client_name_t'];
        }

        for($i=0 ; $i<$count ; $i++)
        {
            DB::beginTransaction();

            $resource = new Resource();
            $hardware = new Hardware();

            $status = true;
            $resource->inventory_code = $inventoryCode[$i];

            $hardware->inventory_code = $inventoryCode[$i];
            $hardware->type = $category;
            $hardware->description = $description[$i];
            $hardware->serial_no = $serialNo[$i];
            $hardware->ip_address = $ipAddress[$i];
            $hardware->make = $make[$i];
            $hardware->model = $model[$i];
            if($purchaseDate[$i]!='')
                $hardware->purchase_date = date("Y-m-d",strtotime($purchaseDate[$i]));
            if($warrantyExpDate[$i]!='')
                $hardware->warranty_exp = date("Y-m-d",strtotime($warrantyExpDate[$i]));
            $hardware->insurance = $insurance[$i];
            $hardware->value = $value[$i];

            if($resource->save()) {
                $status = $hardware->save() ? true : false;

                if ($category == "Desktop" || $category == "Laptop" || $category == "Server" || $category == "Virtual-Server") {
                    $desktop = new Desktop_Laptop();
                    $desktop->inventory_code = $inventoryCode[$i];
                    $desktop->CPU = $cpu[$i];
                    $desktop->RAM = $ram[$i];
                    $desktop->hard_disk = $hardDisk[$i];
                    $desktop->OS = $os[$i];

                    if($status)
                        $status = $desktop->save() ? true : false;

                    if ($category == "Server")
                    {
                        $server = new Server();
                        $server->inventory_code = $inventoryCode[$i];
                        $server->classification = $serverClassification[$i];
                        $server->no_of_cpu = $noOfCpu[$i];

                        if($status)
                            $status = $server->save() ? true : false;
                    }
                    elseif ($category == "Virtual_Server")
                    {
                        $virtualServer = new Virtual_Server();
                        $virtualServer->inventorycode = $inventoryCode[$i];
                        $virtualServer->no_of_cores = $noOfCore[$i];
                        $virtualServer->host_server = $hostServer[$i];

                        if($status)
                            $status = $virtualServer->save() ? true : false;
                    }
                }

                if($category == "Dongle" || $category == "SIM")
                {
                    $dongleSim = new Dongle_SIM();
                    $dongleSim->inventory_code = $inventoryCode[$i];
                    $dongleSim->phone_no = $phoneNo[$i];
                    $dongleSim->service_provider = $serviceProvider[$i];
                    if($category == "Dongle")
                    {
                        $dongleSim->data_limit = $dataLimit[$i];
                        $dongleSim->monthly_rental = $monthlyRental[$i];
                    }
                    else
                    {
                        $dongleSim->location = $location[$i];
                    }
                    if($status)
                        $status = $dongleSim->save() ? true : false;
                }
                elseif($category == "Client-Device")
                {
                    $clientDevice = new Client_Device();
                    $clientDevice->inventory_code = $inventoryCode[$i];
                    $clientDevice->device_type = $deviceType[$i];
                    $clientDevice->client_name = $clientName[$i];

                    if($status)
                        $status = $clientDevice->save() ? true : false;
                }
            }

            if($status)
            {
                DB::commit();
            }
            else {
                DB::rollback();
                break;
            }
        }

        if($status)
            \Session::flash('flash_message','('.$count.')new Resource(s) added successfully!');
        else
            \Session::flash('flash_message_error','Resource(s) addition failed!');
        $types = Type::all();
        $id = "Office-Equipment";
        $key = Hardware::getInventoryCode($id);
        return view ('ManageResource.addHardware',compact('types','id','key'));

    }

    public function editAll()
    {
        $hardwares = Hardware::paginate(30);
        return view('ManageResource.editHardware',compact('hardwares'));
    }


}
