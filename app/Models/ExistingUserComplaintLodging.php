<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExistingUserComplaintLodging extends Model
{
    protected $table = 'tblexistingcustomercomplaintlodging';

//    protected $primaryKey = 'ticketno';

    public $incrementing = false;

    public function customers(){
        return $this->belongsTo('App\Models\CustomersModel', 'customercode');
    }
    public function branch(){
        return $this->belongsTo('App\Models\BranchMasterModel', 'branchcode');
    }
    public function assignee(){
        return $this->belongsTo('App\Models\AssigneeMasterModel', 'assigneecode');
    }
    public function product(){
        return $this->belongsTo('App\Models\ProductServiceMasterModel', 'productservicecode');
    }
    public function category(){
        return $this->belongsTo('App\Models\CategoryMasterModel', 'categorycode');
    }
    public function subcategory(){
        return $this->belongsTo('App\Models\SubCategoryMasterModel', 'subcategorycode');
    }
}
