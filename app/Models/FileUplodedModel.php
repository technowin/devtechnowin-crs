<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FileUplodedModel extends Model
{
    protected $table = 'tblfileuploded';
    protected $primaryKey = 'id';
    public $incrementing = false;
}
