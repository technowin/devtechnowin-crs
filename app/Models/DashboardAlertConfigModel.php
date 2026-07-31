<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DashboardAlertConfigModel extends Model
{
    protected $table = 'tbldashboardalertconfig';
    public $timestamps = false;
    protected $guarded = [];

    public static function getAll()
    {
        return self::pluck('alertdays', 'alertkey'); // ['expiring_soon_days' => 30, 'critical_days' => 5, ...]
    }
}