<?php


namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class AdminCommentsModel extends model
{
    protected $table = 'tbladmincomments';
    protected $primaryKey = 'id';
    public $incrementing = false;
}