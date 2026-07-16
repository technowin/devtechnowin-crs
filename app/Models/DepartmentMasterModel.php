<?php
/**
 * Created by PhpStorm.
 * User: technowin
 * Date: 28/08/2017
 * Time: 5:01 PM
 */

namespace App\Models;
use Illuminate\Database\Eloquent\Model;


class DepartmentMasterModel extends Model
{
    protected $table = 'tbldepartmentmaster';

    protected $primaryKey = 'departmentcode';

    public $incrementing = false;


}