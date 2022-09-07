<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductServiceMasterModel extends Model
{
    protected $table = 'tblproductservicemaster';

    protected $primaryKey = 'productservicecode';

    public $incrementing = false;

    use SoftDeletes;

    protected $softDelete = true;

    protected $dates = ['deleted_at'];

    public function Sector(){
        return $this->belongsTo('App\Models\SectorMasterModel','sectorcode');
    }

    public function category(){
        return $this->belongsTo('App\Models\CategoryMasterModel')->withTimestamps();
    }


}