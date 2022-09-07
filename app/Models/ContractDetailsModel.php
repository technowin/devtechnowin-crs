<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContractDetailsModel extends Model
{
    protected $table = 'tblcontractdetails';

    protected $primaryKey = 'id';

    public $incrementing = false;

    public function customers(){
        return $this->belongsTo('App\Models\CustomersModel', 'customercode');
    }
    public function product(){
        return $this->belongsTo('App\Models\ProductServiceMasterModel', 'productservicecode');
    }
}
