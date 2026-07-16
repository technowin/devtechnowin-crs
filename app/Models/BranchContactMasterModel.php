<?php
/**
 * Created by PhpStorm.
 * User: technowin
 * Date: 21/08/2017
 * Time: 6:01 PM
 */

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BranchContactMasterModel extends Model
{
    protected $table = 'tblbranchcontactmaster';

    protected $primaryKey = 'branchcontactcode';

    public $incrementing = false;

    use SoftDeletes;

    protected $softDelete = true;

    protected $dates = ['deleted_at'];


    public function Branach(){
        return $this->belongsTo('App\Models\BranchMasterModel','branchcode');
    }


}