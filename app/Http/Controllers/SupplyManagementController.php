<?php

namespace App\Http\Controllers;

use App\Models\BranchMasterModel;
use App\Models\EquipmentMasterModel;
use App\Models\ExistingUserComplaintLodging;
use App\User;
use Carbon\Carbon;
use App\Models\ProductServiceMasterModel;
use App\Models\SupplyManagementModel;
use App\Models\ServiceParametersModel;
use Ramsey\Uuid\Uuid;
use Illuminate\Http\Request;
use App\Models\SubCategoryMasterModel;
use Auth;

class SupplyManagementController extends Controller
{
    public function index()
    {
        $pendingsupply = SupplyManagementModel::selectRaw('tblsupplymanagement.*,tblcontractmaster.workorderno,tblcustomermaster.customername')
            ->leftJoin('tblcontractmaster', 'tblsupplymanagement.contractno', '=', 'tblcontractmaster.contractno')
            ->leftJoin('tblcustomermaster', 'tblsupplymanagement.customercode', '=', 'tblcustomermaster.customercode')
            ->where('installationdate','!=',null)
            ->where('preventivemaintenancecertificatedate','=',null)
            ->whereDate('preventivemaintenancereminderdate', '<=', Carbon::now())->orderBy('preventivemaintenancereminderdate', 'desc')
            ->get();
        return view('supplymanagement.index', compact('pendingsupply'));
    }

    public function show($id)
    {
        $show = EquipmentMasterModel::where('contractno',$id)->get()->first();
        if($show == null)
        {
            $message = 'There is no equipment';
        }
        else
        {
            $show = EquipmentMasterModel::where('contractno',$id)->get();
        }
        return view('supplymanagement.show',compact('show'));
    }

    public function manage($id)
    {
        $manage = EquipmentMasterModel::where('contractno',$id)->get()->first();
        if($manage == null)
        {
            $message = 'There is no equipment';
        }
        else
        {
            $manage = EquipmentMasterModel::where('contractno',$id)->get();
        }
        return view('supplymanagement.manage',compact('manage','id'));
    }

    public function storemanage()
    {
        $model = "";
        $user = User::where('id', '=', Auth::id())->get()->first();
        $equipmentsvalue = EquipmentMasterModel::where('contractno', '=', $_GET['contractcode'])->get()->pluck('equipmentsrno');
        $count = count($equipmentsvalue);
        for ($i = 0; $i < $count; $i++) {
            $equipmentdetails = EquipmentMasterModel::where('equipmentsrno', '=', $equipmentsvalue[$i])->get()->first();
            $model = new ExistingUserComplaintLodging();
            $model->id = Uuid::uuid1();
            $model->ticketno = "Temp";
            $model->customercode = $equipmentdetails->customercode;
            $model->branchcode = $equipmentdetails->branchcode;
            $model->productservicecode = $equipmentdetails->productservicecode;
            $model->categorycode = $equipmentdetails->categorycode;
            $model->subcategorycode = "service";
            $model->callername = $user->name;
            $model->emailid = $user->email;
            $model->complaintdescription = "service";
            $model->priority = "Medium";
            $model->contractno = $_GET['contractcode'];
            $model->productsrno_accountno = $equipmentdetails->equipmentsrno;
            $model->complaintdate = Carbon::now(new \DateTimeZone('Asia/Kolkata'));
            $model->created_at = Carbon::now(new \DateTimeZone('Asia/Kolkata'));
            $model->created_by = Auth::id();
            $model->save();
        }
        if ($model->save() == true) {
            $servicemanagement = SupplyManagementModel::where('contractno', $_GET['contractcode'])->where('flagkey',null)->get();
            for ($i=0; $i < count($servicemanagement);$i++)
            {
                if($servicemanagement[$i]->flagkey == null)
                {
                    $updateservicemanagement = SupplyManagementModel::where('id', $servicemanagement[$i]->id)->where('flagkey',null)->get()->first();
                    $updateservicemanagement->flagkey = "1";
                    $updateservicemanagement->save();
                }
            }
        }
        return json_encode($model);
    }

    public function assignee($id)
    {
//        $workorder = EquipmentMasterModel::where('contractno', $id)->get()->first();
        $equipmentnull = EquipmentMasterModel::where('contractno', $id)->where('flagkey','0')->get()->first();
        if($equipmentnull == null)
        {
            $message = "There Is No Equipment To Assignee";
        }
        else
        {
            $equipment = EquipmentMasterModel::where('contractno',$id)->where('flagkey','0')->get();
            $branchcodes = array();
            foreach ($equipment as $codes)
                array_push($branchcodes, $codes->branchcode);
            $branches = BranchMasterModel::whereIn('branchcode', $branchcodes)->get();
            $productservicecodes = array();
            foreach ($equipment as $code)
                array_push($productservicecodes, $code->productservicecode);
            $productnames = ProductServiceMasterModel::whereIn('productservicecode', $productservicecodes)->get();
            $equipmentforlooping = EquipmentMasterModel::where('contractno', $id)->select('productservicecode', 'branchcode')->distinct()->get();
        }

        return view('supplymanagement.assignee', compact('equipmentnull','message','workorder', 'equipment', 'productnames', 'branches', 'equipmentforlooping'));
    }

    public function pendinginstalletionindex()
    {
        $pendinginstallationsupply = SupplyManagementModel::selectRaw('tblsupplymanagement.*,tblcontractmaster.workorderno,tblcustomermaster.customername')
            ->leftJoin('tblcontractmaster', 'tblsupplymanagement.contractno', '=', 'tblcontractmaster.contractno')
            ->leftJoin('tblcustomermaster', 'tblsupplymanagement.customercode', '=', 'tblcustomermaster.customercode')
            ->where('installationdate',null)
            ->get();
        return view('supplymanagement.pendinginstallationindex', compact('pendinginstallationsupply'));
    }

    public  function supplycompletionindex()
    {
//        $SupplymanagementModel= SupplymanagementModel::all();
        $supplymanagementModel = SupplymanagementModel::selectraw('tblsupplymanagement.id,tblsupplymanagement.contractno,tblcustomermaster.customername,tblsupplymanagement.installationdate,tblsupplymanagement.inspectiondate,
               tblsupplymanagement.preventivemaintenancedate,tblsupplymanagement.preventivemaintenancereminderdate,tblsupplymanagement.preventivemaintenancecertificatedate,
               tblsupplymanagement.actualcontractcompletiondate')
            ->leftjoin('tblcustomermaster','tblsupplymanagement.customercode','=','tblcustomermaster.customercode')->get();

//           $supplymanagementModel=SupplymanagementModel::orderby('inspectiondate','desc')->get();
        return view('supplymanagement.supplymanagement', compact('supplymanagementModel'));
    }

    public function view($id)
    {
        $supplymanagementModel = SupplymanagementModel::selectraw('tblsupplymanagement.id,tblsupplymanagement.contractno,tblcustomermaster.customername,tblsupplymanagement.installationdate,tblsupplymanagement.inspectiondate,
               tblsupplymanagement.preventivemaintenancedate,tblsupplymanagement.preventivemaintenancereminderdate,tblsupplymanagement.preventivemaintenancecertificatedate,
               tblsupplymanagement.actualcontractcompletiondate')
            ->leftjoin('tblcustomermaster','tblsupplymanagement.customercode','=','tblcustomermaster.customercode')
            ->where ('id',$id)->get()->first();
//         return $supplymanagementModel=SupplymanagementModel::where('id',$id)->get()->first();
        return view('supplymanagement.supplymanagementview',compact('supplymanagementModel'));

    }

    public function edit($id)
    {
        $supplymanagementModel = SupplyManagementModel::selectraw('tblsupplymanagement.id,tblsupplymanagement.contractno,tblsupplymanagement.customercode,tblcustomermaster.customername,tblsupplymanagement.installationdate,tblsupplymanagement.inspectiondate,
               tblsupplymanagement.preventivemaintenancedate,tblsupplymanagement.preventivemaintenancereminderdate,tblsupplymanagement.preventivemaintenancecertificatedate,tblcontractmaster.contracttodate,
               tblsupplymanagement.actualcontractcompletiondate')
            ->leftjoin('tblcustomermaster','tblsupplymanagement.customercode','=','tblcustomermaster.customercode')
            ->leftjoin('tblcontractmaster','tblsupplymanagement.contractno','=','tblcontractmaster.contractno')
            ->where ('tblsupplymanagement.id',$id)->get()->first();

//        $supplymanagementModel=SupplymanagementModel::where('id',$id)->get()->first();
        return view('supplymanagement.supplymanagementedit',compact('supplymanagementModel'));
    }

    public function update(Request $request,$id)
    {
//        return $request->all();

        $model = SupplymanagementModel::selectraw('tblsupplymanagement.contractno,tblcontractmaster.servicefrequency,tblcontractmaster.contracttodate')
            ->leftjoin('tblcontractmaster','tblsupplymanagement.contractno','=','tblcontractmaster.contractno')
            ->where('tblsupplymanagement.contractno',$request->contractno)
            ->get()->first();

        $serviceparameter=ServiceParametersModel::selectraw('servicedays,leadlogdays')->where('name',$model->servicefrequency)->get()->first();

        $customercode = SupplymanagementModel::where('contractno', $request->contractno)->where('id', $id)->get()->first();
        $supplymanagementModel = SupplymanagementModel::where('contractno', $request->contractno)->where('id', $id)->get()->first();
        $installationdateindatabase= $supplymanagementModel->installationdate;

        $supplymanagementModel->contractno;
        $supplymanagementModel->customercode;
        $supplymanagementModel->installationdate=$request->installationdate;
        $supplymanagementModel->inspectiondate=$request->inspectiondate;
        $supplymanagementModel->preventivemaintenancedate=$request->preventivemaintenancedate;
        $supplymanagementModel->preventivemaintenancereminderdate=$request->preventivemaintenancereminderdate;
        $supplymanagementModel->preventivemaintenancecertificatedate=$request->preventivemaintenancecertificatedate;
        $supplymanagementModel->actualcontractcompletiondate=$request->actualcontractcompletiondate;
        $supplymanagementModel->flagkey= '1';
        $supplymanagementModel->save();


        //------------New row create---------------------------------
        if($installationdateindatabase != null) {

//           $splitfrequency = explode(",", $model->servicefrequency);
            $preventivemaintenancedate = Carbon::createFromFormat('Y-m-d', $request->preventivemaintenancedate);
            $contracttodate = Carbon::createFromFormat('Y-m-d', $model->contracttodate)->format('y-m-d');
//           $newpreventivemaintenancedate = $preventivemaintenancedate->addDays($splitfrequency[0])->format('y-m-d');
            $newpreventivemaintenancedate = $preventivemaintenancedate->addDays($serviceparameter->servicedays)->format('y-m-d');
            if($request->preventivemaintenancecertificatedate != null) {
                if ($newpreventivemaintenancedate <= $contracttodate) {
                    $supplymanagementModel = new SupplymanagementModel();
                    $supplymanagementModel->id = Uuid::uuid1();
                    $supplymanagementModel->contractno = $request->contractno;
                    $supplymanagementModel->customercode = $customercode->customercode;
                    $supplymanagementModel->installationdate = $request->installationdate;
                    $supplymanagementModel->inspectiondate = $request->inspectiondate;
                    $supplymanagementModel->preventivemaintenancedate = $newpreventivemaintenancedate;
//                  $supplymanagementModel->preventivemaintenancereminderdate = $preventivemaintenancedate->subDays($splitfrequency[1])->format('y-m-d');
                    $supplymanagementModel->preventivemaintenancereminderdate = $preventivemaintenancedate->subDays($serviceparameter->leadlogdays)->format('y-m-d');
                    $supplymanagementModel->save();
                    $updateflagkeysupplylist = EquipmentMasterModel::where('contractno',$request->contractno)->get()->pluck('equipmentsrno');
                    $count = count($updateflagkeysupplylist);
                    for($i=0; $i < $count; $i++)
                    {
                        $updateflagkeysupply = EquipmentMasterModel::where('equipmentsrno',$updateflagkeysupplylist[$i])->where('contractno',$request->contractno)->get()->first();
                        $updateflagkeysupply->flagkey= '0';
                        $updateflagkeysupply->save();

                    }
                    $supply = SupplyManagementModel::where('contractno',$request->contractno)->get()->first();
                    $supply->flagkey ='0';
                    $supply->save();
                }
            }
        }
        if($request->installationdate != null)
        {
            if($customercode->installationdate == null) {
                $updateflagkeysupplylist = EquipmentMasterModel::where('contractno',$request->contractno)->get()->pluck('equipmentsrno');
                $count = count($updateflagkeysupplylist);
                for($i=0; $i < $count; $i++)
                {
                    $updateflagkeysupply = EquipmentMasterModel::where('equipmentsrno',$updateflagkeysupplylist[$i])->where('contractno',$request->contractno)->get()->first();
                    $updateflagkeysupply->flagkey= '0';
                    $updateflagkeysupply->save();

                }
                $supply = SupplyManagementModel::where('contractno',$request->contractno)->get()->first();
                $supply->flagkey ='0';
                $supply->save();
            }
        }

        $equipmentflagupdatelist = EquipmentMasterModel::where('contractno',$request->contractno)->get()->pluck('equipmentsrno');
        $equipmentflagupdatecount = count($equipmentflagupdatelist);
        for($i=0; $i < $equipmentflagupdatecount; $i++)
        {
            $equipmentflagupdate = EquipmentMasterModel::where('equipmentsrno',$equipmentflagupdatelist[$i])->where('contractno',$request->contractno)->get()->first();
            $equipmentflagupdate->flagkey='0';
            $equipmentflagupdate->save();
        }

        return redirect('supplymanagement')->with('flash_message', 'record successfully update for contract no.' . $request->contractno);
//
    }

}
