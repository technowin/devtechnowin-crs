<?php
/**
 * Created by PhpStorm.
 * User: technowin
 * Date: 15/12/2017
 * Time: 1:22 PM
 */

namespace App\Http\Controllers\Masters;
use App\Http\Controllers\Controller;
use App\Models\EquipmentMasterModel;

class ServiceController extends Controller
{
    public  function serviceindex()
    {
        return $equipment = EquipmentMasterModel::where('servicedate','<',Carbon::now(new \DateTimeZone('Asia/Kolkata')))->get();
    }
}