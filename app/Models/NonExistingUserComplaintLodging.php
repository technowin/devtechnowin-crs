<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NonExistingUserComplaintLodging extends Model
{
    protected $table = 'tblnonexistingcustomercomplaintlodging';

    protected $primaryKey = 'ticketno';

    public $incrementing = false;

    public function customers(){
        return $this->belongsTo('App\Models\CustomersModel', 'customercode');
    }
}
