<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Hardware extends Model {

    protected $table = 'Hardware';
    protected $primaryKey = 'inventory_code';
    public $timestamps = false;

	protected $fillable = [

        'description',
        'serial_no',
        'ip_address',
        'make',
        'model',
        'purchase_date',
        'warranty_exp',
        'insurance'
    ];

    protected function getTableColumns()
    {
        return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
    }

    protected function getInventoryCode($type)
    {
        $code = Hardware::where('type',$type)->max('inventory_code');
        $newCode='';
        if($code!=null) {
            $newNumber = substr($code, 8);

            $newCode = substr($code, 0, 8);
            $newNumber = $newNumber + 1;
            $count = strlen($newNumber);

            if ($count == 1)
                $newCode = $newCode . "000" . $newNumber;
            elseif ($count == 2)
                $newCode = $newCode . "00" . $newNumber;
            elseif ($count == 3)
                $newCode = $newCode . "0" . $newNumber;
        }
        else
        {
            switch($type)
            {
                case "Office-Equipment" : $newCode = "CMB/OEQ/0001" ; break;
                case "Communication-Equipment" : $newCode = "CMB/COM/0001" ; break;
                case "Development-Device" : $newCode = "CMB/DEV/0001" ; break;
                case "Network-Equipment" : $newCode = "CMB/NTE/0001" ; break;
                case "Desktop" : $newCode = "CMB/DSK/0001" ; break;
                case "Monitor" : $newCode = "CMB/MON/0001" ; break;
                case "Laptop" : $newCode = "CMB/LAP/0001" ; break;
                case "Server" : $newCode = "CMB/SVR/0001" ; break;
                case "Virtual-Server" : $newCode = "CMB/VIR/0001" ; break;
                case "Power-Equipment" : $newCode = "CMB/PWR/0001" ; break;
                case "Dongle" : $newCode = "CMB/DON/0001" ; break;
                case "Sim" : $newCode = "CMB/SIM/0001" ; break;
                case "Client-Device" : $newCode = "CMB/CDV/0001" ; break;
            }
        }
        return $newCode;
    }

}
