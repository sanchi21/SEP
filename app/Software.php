<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Software extends Model {
    protected $table = 'Software';
    protected $primaryKey = 'inventory_code';
    public $timestamps = false;

    protected $fillable = [

        'name',
        'vendor',
        'no_of_license'
    ];

    protected function getInventoryCode()
    {
        $code = Software::max('inventory_code');
        $newCode='';
        if($code!=null)
        {
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
            $newCode = "CMB/SWR/0001" ;
        }
        return $newCode;
    }



}
