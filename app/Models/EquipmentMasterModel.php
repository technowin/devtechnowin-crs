<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EquipmentMasterModel extends Model
{
    protected $table = 'tblequipmentdetails';

    protected $primaryKey = 'equipmentsrno';

    public $incrementing = false;
    protected $fillable =   ['status'];

    public  function customer()
    {
        return $this->belongsTo('App\Model\ExistingUserComplaintLodging');
    }
    public function products(){
        return $this->belongsTo('App\Models\ProductServiceMasterModel','productservicecode');
    }

    public function category(){
        return $this->belongsTo('App\Models\CategoryMasterModel','categorycode');
    }
    public  function branch()
    {
        return $this->belongsTo('App\Models\BranchMasterModel','branchcode');
    }

}