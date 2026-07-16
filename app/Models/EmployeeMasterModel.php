<?php
/**
 * Created by PhpStorm.
 * User: technowin
 * Date: 11/09/2017
 * Time: 4:16 PM
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeMasterModel extends Model
{

    protected $table = 'tblemployeemaster';

    protected $primaryKey ='employeeid';

    public  $incrementing = false;


}