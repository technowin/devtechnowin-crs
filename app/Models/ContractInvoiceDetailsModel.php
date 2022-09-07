<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContractInvoiceDetailsModel extends Model
{
    protected $table='tblcontractinvoicedetails';
//    protected $primaryKey='contractno';
    protected $primaryKey='id';
    public $incrementing=false;
}
