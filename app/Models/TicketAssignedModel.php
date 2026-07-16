<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class TicketAssignedModel extends Model
{
    protected $table = 'tblticketassigneedetails';
    public $incrementing = false;

    public function assignee(){
        return $this->belongsTo('App\Models\AssigneeMasterModel', 'assigneecode');
    }
}