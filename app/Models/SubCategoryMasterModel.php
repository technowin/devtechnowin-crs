<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubCategoryMasterModel extends Model
{
    protected $table = 'tblsubcategorymaster';

    protected $primaryKey = 'subcategorycode';

    public $incrementing = false;

    public function products(){
        return $this->belongsTo('App\Models\ProductServiceMasterModel','productservicecode');
    }

    public function category(){
        return $this->belongsTo('App\Models\CategoryMasterModel','categorycode');
    }

    use SoftDeletes;

    protected $softDelete = true;

    protected $dates = ['deleted_at'];

}