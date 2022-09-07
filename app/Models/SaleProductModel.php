<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleProductModel extends Model
{
    protected $table='tblsaleproduct';
    protected $primaryKey='id';
    public $incrementing=false;
}
