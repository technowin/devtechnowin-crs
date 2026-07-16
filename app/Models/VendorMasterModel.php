<?php
/**
 * Created by PhpStorm.
 * User: technowin
 * Date: 21/09/2017
 * Time: 3:41 PM
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VendorMasterModel extends Model
{
    protected $table = 'tblvendormaster';

    protected $primaryKey = 'vendorcode';

    public $incrementing = false;

}