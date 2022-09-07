<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentdetailsModel extends Model
{
    public $table='tblpaymentdetails';
    protected $primaryKey='invoicebillno';
    public $incrementing=false;
}
