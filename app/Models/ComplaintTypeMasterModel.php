<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ComplaintTypeMasterModel extends Model
{
    protected $table = 'tblcomplainttypemaster';

    protected $primaryKey = 'complaintcode';

    public $incrementing = false;
}
