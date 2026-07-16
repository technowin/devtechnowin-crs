<?php
/**
 * Created by PhpStorm.
 * User: technowin
 * Date: 29/08/2017
 * Time: 10:19 AM
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class AssigneeMasterModel extends Model
{
    protected $table = 'tblassigneemaster';

    protected $primaryKey = 'assigneecode';

    public $incrementing = false;

    public function complaints(){
        return $this->belongsTo('App\Model\ExistingUserComplaintLodging');
    }

    public function department(){
        return $this->belongsTo('App\Models\DepartmentMasterModel','departmentcode');
    }
    public function employee(){
        return $this->belongsTo('App\Models\EmployeeMasterModel','employeeid');
    }

    public function assignee(){
        return $this->belongsTo('App\Models\ExistingUserComplaintLodging')->withTimestamps();
    }

    use SoftDeletes;

    protected $softDelete = true;

    protected $dates = ['deleted_at'];

}