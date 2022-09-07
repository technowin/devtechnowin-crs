<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContractInvoiceandPaymentsModel extends Model
{
    protected $table = 'tblcontractinvoiceandpayments';

    protected $primaryKey = 'contractno';

    public $incrementing = false;
}
