<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class InwardOutwardModel extends Model
{
    protected $table = 'tblinwardoutward';

    public function customers(){
        return $this->belongsTo('App\Models\CustomersModel', 'customercode');
    }
    public function branch(){
        return $this->belongsTo('App\Models\BranchMasterModel', 'branchcode');
    }
    public function assignee(){
        return $this->belongsTo('App\Models\AssigneeMasterModel', 'assigneecode');
    }
}