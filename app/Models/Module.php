<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    protected $table = 'module_user';

    protected $primaryKey = 'module_id';

    public $incrementing = false;
}
