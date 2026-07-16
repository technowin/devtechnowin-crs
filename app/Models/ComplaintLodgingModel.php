<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ComplaintLodgingModel extends Model
{
    protected $table = 'tblusercomplaintlodging';

    protected $primaryKey = 'ticketno';

    public $incrementing = false;

    public function customers(){
        return $this->belongsTo('App\Models\CustomersModel', 'customercode');
    }
    public function branch(){
        return $this->belongsTo('App\Models\BranchMasterModel', 'branchcode');
    }

}