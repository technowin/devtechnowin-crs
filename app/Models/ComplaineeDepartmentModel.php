<?php
/**
 * Created by PhpStorm.
 * User: technowin
 * Date: 31/08/2017
 * Time: 12:33 PM
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class ComplaineeDepartmentModel extends Model
{
    protected $table = 'tblcomplaineedepartmentmaster';

    protected $primaryKey = 'complaineedepartmentmastercode';

    public $incrementing = false;
}