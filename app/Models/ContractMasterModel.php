<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContractMasterModel extends Model
{
        protected $table = 'tblcontractmaster';

        protected $primaryKey = 'contractno';

        public $incrementing = false;

        public function customers(){
            return $this->belongsTo('App\Models\CustomersModel', 'customercode');
        }

}
