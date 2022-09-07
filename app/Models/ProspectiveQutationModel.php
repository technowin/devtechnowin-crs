<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProspectiveQutationModel extends Model
{
    protected $table = 'tblprospectivequotation';
    protected $primaryKey = 'id';
    public  $incrementing = false;

    public function customers()
    {
        return $this->belongsTo('App\Models\CustomersModel','customercode');
    }
}
