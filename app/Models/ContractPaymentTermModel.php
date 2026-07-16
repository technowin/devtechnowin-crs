<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContractPaymentTermModel extends Model
{
    protected $table = 'tblcontractpaymentterms';
    protected $primaryKey = 'contractno';
    public $incrementing= false;
}
