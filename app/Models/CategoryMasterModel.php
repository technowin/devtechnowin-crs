<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategoryMasterModel extends Model
{
    protected $table = 'tblcategorymaster';

    protected $primaryKey = 'categorycode';

    public $incrementing = false;

    public function products(){
        return $this->belongsTo('App\Models\ProductServiceMasterModel','productservicecode');
    }

    public function subcategory(){
        return $this->belongsTo('App\Models\SubCategoryMasterModel')->withTimestamps();
    }

    use SoftDeletes;

    protected $softDelete = true;

    protected $dates = ['deleted_at'];

}
