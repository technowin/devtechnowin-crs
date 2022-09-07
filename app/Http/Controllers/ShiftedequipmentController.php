<?php

namespace App\Http\Controllers;

use App\Models\ContractMasterModel;
use App\Models\EquipmentMasterModel;
use Illuminate\Http\Request;
use App\Models\ShiftedequipmentModel;
use App\Models\CustomersModel;
use App\Models\BranchMasterModel;
use App\Models\ProductServiceMasterModel;
use Ramsey\Uuid\Uuid;

class ShiftedequipmentController extends Controller
{
    public function index()
    {
        $model = ShiftedequipmentModel::all();
        return view('shifted.index',compact('model'));
    }

    public function create()
    {
        $customerlist = CustomersModel::All()->pluck('customername','customercode');
        $branchlist = BranchMasterModel::All()->pluck('branchname','branchcode');
        $productlist = ProductServiceMasterModel::All()->pluck('productservicename','productservicecode');
        $contractnolist = ContractMasterModel::all()->pluck('contractno','contractno');
        return view('shifted.shiftedequipment',compact('customerlist','branchlist','productlist','productsrnolist','contractnolist'));
    }

    public function getproductwiseequipment()
    {
        $customersite = $_GET['customersite'];
//        $equipmentlist  = EquipmentMasterModel::where('branchcode',$customersite)->get();
        $equipmentlist  = EquipmentMasterModel::selectraw('tblequipmentdetails.*,tblbranchmaster.branchname,tblproductservicemaster.productservicename,tblcategorymaster.categoryname')
            ->Join('tblbranchmaster','tblbranchmaster.branchcode','=','tblequipmentdetails.branchcode')
            ->Join('tblproductservicemaster','tblproductservicemaster.productservicecode','=','tblequipmentdetails.productservicecode')
            ->Join('tblcategorymaster','tblcategorymaster.categorycode','=','tblequipmentdetails.categorycode')
            ->where('tblequipmentdetails.branchcode',$customersite)->where('tblequipmentdetails.status','Active')
            ->get();

        return json_encode( $equipmentlist);
//        return view();
    }

    public function storeshiftequipment(Request $request)
    {
//        return $request->alL();
        $equipmentsrno = $request['equipmentsrno'];
        $product =  $request['productservicecode'];
        $category =  $request['categorycode'];
//        $exitexitspecification=  $request['exitspecification'];
        $count = count($request['equipmentsrno']);

        for ($i=0;$i<$count;$i++){
            $updateequipment =  EquipmentMasterModel::where('equipmentsrno',$equipmentsrno[$i])->where('status','Active')->get()->first();
            $updateequipment->status  = "InActive";
            $updateequipment->save();

            if($updateequipment->save() == true){
                $insertequipment = new EquipmentMasterModel();
                $insertequipment->status  = "Active";
                $insertequipment->customercode  = $request['customercode'];
                $insertequipment->contractno = $request['contractno'];
                $insertequipment->equipmentsrno = $equipmentsrno[$i];
                $insertequipment->productservicecode = $updateequipment->productservicecode;
                $insertequipment->categorycode = $updateequipment->categorycode;
                $insertequipment->branchcode = $request['newcustomersite'];
                $insertequipment->specification = $updateequipment->specification;
                $insertequipment->contracttype = $updateequipment->contracttype;
                $insertequipment->workorderno = $updateequipment->workorderno;
                $insertequipment->save();
            }
            if($updateequipment->save() == true)
            {
                $model = new ShiftedequipmentModel();
                $model->id = Uuid::uuid1();
                $model->contractno = $request['contractno'];
                $model->oldbranchcode = $request['customersite'];
                $model->customercode = $request['customercode'];
                $model->productservicecode = $product[$i];
                $model->equipmentsrno = $equipmentsrno[$i];
                $model->categorycode = $category[$i];
                $model->specification = $request['specification'];
                $model->installationdate = $request['installationdate'];
                $model->warrantyamc = $request['warrantyamc'];
                $model->warrantyamcenddate = $request['warrantyamcenddate'];
                $model->amcamount = $request['amcamount'];
                $model->newbranchcode = $request['newcustomersite'];
                $model->shiftremarks = $request['shiftremarks'];
                $model->shiftdate = $request['shiftdate'];
                $model->save();
            }
        }
        return redirect('shiftedequipmentindex');
    }

    public function getcontractdetails($id)
    {
        $contractdetails = ContractMasterModel::where('contractno',$id)->get()->first();
        return json_encode($contractdetails);
    }
}
