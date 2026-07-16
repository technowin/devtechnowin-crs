<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomersModel extends Model
{
    protected $table = 'tblcustomermaster';

    protected $primaryKey = 'customercode';

    public $incrementing = false;

    public function customers()
    {
        return $this->belongsTo('App\Models\ContractDetailsModel')->withTimestamps();
    }
    public function contractcustomers()
    {
        return $this->belongsTo('App\Models\ContractMasterModel')->withTimestamps();
    }
    use SoftDeletes;

    protected $softDelete = true;

    protected $dates = ['deleted_at'];
}
