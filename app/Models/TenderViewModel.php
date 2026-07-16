<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TenderViewModel extends Model
{
    protected $table = 'tbltenderdetails';

    protected $primaryKey = 'tenderno';

    public $incrementing = false;
}