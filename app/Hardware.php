<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Hardware extends Model {

    protected $table = 'Hardware';

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

}
