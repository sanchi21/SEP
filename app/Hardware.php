<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Type;

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
        'insurance',
        'screen_size',
        'device_type',
        'client_name',
        'CPU',
        'RAM',
        'hard_disk',
        'OS',
        'previous_user',
        'phone_no',
        'service_provider',
        'data_limit',
        'monthly_rental',
        'location',
        'classification',
        'no_of_cpu',
        'no_of_cores',
        'host_server'
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
            $firstKey = Type::find($type);
            $n_code = $firstKey->key;
            $newCode = $n_code."/0001";
        }
        return $newCode;
    }

}
