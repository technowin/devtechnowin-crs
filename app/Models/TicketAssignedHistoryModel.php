<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class TicketAssignedHistoryModel extends Model
{
    protected $table = 'tblticketassigneedetailshistory';
    public $incrementing = false;

    public function assignee(){
        return $this->belongsTo('App\Models\AssigneeMasterModel', 'assigneecode');
    }
    public $timestamps = false;
}
