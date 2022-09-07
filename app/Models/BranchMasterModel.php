<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BranchMasterModel extends Model
{
    protected $table = 'tblbranchmaster';

    protected $primaryKey = 'branchcode';

    public $incrementing = false;

    use SoftDeletes;

    protected $softDelete = true;

    protected $dates = ['deleted_at'];

    public function branch(){
        return $this->belongsTo('App\Models\ExistingUserComplaintLodging')->withTimestamps();
    }

}
