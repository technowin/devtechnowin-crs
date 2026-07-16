<?php
/**
 * Created by PhpStorm.
 * User: technowin
 * Date: 22/09/2017
 * Time: 10:10 AM
 */

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class VendorTransactionModel extends Model
{
    protected $table = 'tblvendortransaction';

    protected $primaryKey = 'id';

    public $incrementing = false;

}