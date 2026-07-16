<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContractDocumentsModel extends Model
{
    protected $table = 'contract_documents';
    
    protected $primaryKey = 'id';
    
    public $incrementing = true;
    
    protected $fillable = [
        'contractno',
        'type',
        'subtype',
        'doc1',
        'doc2',
        'doc3',
        'created_by',
        'updated_by'
    ];
    
    protected $dates = [
        'created_at',
        'updated_at'
    ];
}