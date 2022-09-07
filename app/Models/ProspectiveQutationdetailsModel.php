<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProspectiveQutationdetailsModel extends Model
{
    protected $table = 'tblprospectivequotationdetails';

    public function products(){
        return $this->belongsTo('App\Models\ProductServiceMasterModel','productservicecode');
    }
    public function category(){
        return $this->belongsTo('App\Models\CategoryMasterModel','categorycode');
    }
}
