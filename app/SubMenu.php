<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubMenu extends Model
{
    protected $table = 'sub_menu';

    public function menu()
    {
        return $this->belongsTo('App\Menu');
    }
}
