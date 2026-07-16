<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SectorMasterModel extends Model
{
    protected $table = 'tblsectormaster';

    protected $primaryKey = 'sectorcode';

    public $incrementing = false;

    public function product(){
        return $this->belongsTo('App\Models\ProductServiceMasterModel')->withTimestamps();
    }

}
