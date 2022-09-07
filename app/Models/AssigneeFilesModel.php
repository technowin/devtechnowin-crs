<?php
/**
 * Created by PhpStorm.
 * User: technowin
 * Date: 05/08/2019
 * Time: 1:06 PM
 */

namespace App\Models;
use Illuminate\Database\Eloquent\Model;


class AssigneeFilesModel extends Model
{
    protected $table = 'tblticketassigneefiles';
    protected $primaryKey = 'id';
    public $incrementing = false;
}