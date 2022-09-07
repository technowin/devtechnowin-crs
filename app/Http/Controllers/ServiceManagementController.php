<?php
/**
 * Created by PhpStorm.
 * User: technowin
 * Date: 15/12/2017
 * Time: 1:26 PM
 */

namespace App\Http\Controllers;

use App\Models\BranchMasterModel;
use App\Models\EquipmentMasterModel;
use App\Models\ExistingUserComplaintLodging;
use App\User;
use Carbon\Carbon;
use App\Models\ProductServiceMasterModel;
use App\Models\ServiceParametersModel;
use Illuminate\Http\Request;
use App\Models\StatusMasterModel;
use App\Models\ServiceManagementModel;
use Psy\Test\Exception\RuntimeExceptionTest;
use Ramsey\Uuid\Uuid;
use Auth;
use Illuminate\Support\Facades\DB;




class ServiceManagementController extends Controller
{
    public function serviceindex()
    {

        $pendingservice = ServiceManagementModel::selectRaw('tblservicemanagement.*,tblcontractmaster.workorderno,tblcustomermaster.customername')
            ->leftJoin('tblcontractmaster', 'tblservicemanagement.contractno', '=', 'tblcontractmaster.contractno')
            ->leftJoin('tblcustomermaster', 'tblservicemanagement.customercode', '=', 'tblcustomermaster.customercode')
            ->where('servicecertificatedate','=',null)
            ->whereDate('servicereminderdate', '<=', Carbon::now())->orderBy('servicereminderdate', 'desc')
            ->get();
        return view('service.service', compact('pendingservice'));
    }

    public function index($equipementid)
    {
        $contract = ServiceManagementModel::where('id',$equipementid)->get()->first();
        $id = $contract->contractno;
        $equipmentnull = EquipmentMasterModel::where('contractno', '=', $contract->contractno)->get()->first();
        if($equipmentnull == null)
        {
            $message = "There are no equipment to view";
        }
        else
        {
            $equipment = EquipmentMasterModel::where('contractno', '=', $contract->contractno)->get();
        }
        return view('service.index', compact('equipmentnull','equipment', 'id','equipementid'));
    }
    public function storeequipment()
    {
//        return json_encode($_GET['equipmentsrno']);
        $user = User::where('id', '=', Auth::id())->get()->first();

        $equipmentsvalue = EquipmentMasterModel::where('contractno', '=', $_GET['contractcode'])->get()->pluck('equipmentsrno');
        $count = count($equipmentsvalue);
        for ($i = 0; $i < $count; $i++) {
            $equipmentdetails = EquipmentMasterModel::where('equipmentsrno', '=', $equipmentsvalue[$i])->get()->first();
            $model = new ExistingUserComplaintLodging();
            $model->id = Uuid::uuid1();
            $model->customercode = $equipmentdetails->customercode;
            $model->branchcode = $equipmentdetails->branchcode;
            $model->productservicecode = $equipmentdetails->productservicecode;
            $model->categorycode = $equipmentdetails->categorycode;
            $model->subcategorycode = "service";
            $model->callername = $user->name;
            $model->emailid = $user->email;
            $model->complaintdescription = "service";
            $model->priority = "Medium";
            $model->contractno = $equipmentdetails->contractno;
            $model->productsrno_accountno = $equipmentdetails->equipmentsrno;
            $model->complaintdate = Carbon::now(new \DateTimeZone('Asia/Kolkata'));
            $model->created_at = Carbon::now(new \DateTimeZone('Asia/Kolkata'));
            $model->created_by = Auth::id();
            $model->save();
            if($model->save() == true){
                $servicemanagement = ServiceManagementModel::find($_GET['equipmentsrno']);
                $servicemanagement->flagkey = "1";
                $servicemanagement->save();
            }
        }



        return json_encode($model);
    }
    public function show($id)
    {
        $equipmentnull = EquipmentMasterModel::where('contractno', '=', $id)->get()->first();
        if($equipmentnull == null)
        {
            $message = "There are no equipment to view";
        }
        else
        {
            $equipment = EquipmentMasterModel::where('contractno', '=', $id)->get();
        }
        return view('service.show', compact('equipment','equipmentnull'));
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
            $equipment = EquipmentMasterModel::where('contractno', $id)->where('flagkey','0')->get();
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


        return view('service.assignee', compact('equipmentnull','message','workorder', 'equipment', 'productnames', 'branches', 'equipmentforlooping'));
    }
    public function getchkvalues()
    {
        $ticketno = 'CP' . str_shuffle((string)(random_int(00000, 99999)) . strtoupper(str_random(3)));
        $checkvalues = $_GET['checkvalues'];
        $count = count($checkvalues);
        for ($i = 0; $i < $count; $i++) {
            $existingcomplaintid = ExistingUserComplaintLodging::where('productsrno_accountno', $checkvalues[$i])->where('ticketno',null)->get()->first()->id;
            $existingcomplaint = ExistingUserComplaintLodging::findorfail($existingcomplaintid);
            $existingcomplaint->ticketno = $ticketno;
            $statusname = StatusMasterModel::where('statuscode', 'CP0004')->pluck('statusname')->first();
            $existingcomplaint->complaintstatus = $statusname;
            $existingcomplaint->complaintdate = Carbon::now(new \DateTimeZone('Asia/Kolkata'));
            $existingcomplaint->save();
            $model = EquipmentMasterModel::where('equipmentsrno',$checkvalues[$i])->get()->first();
            $model->flagkey = '1';
            $model->save();
        }
        return json_encode($ticketno);
    }

    public function servicecompletionindex ()
    {
        $servicemanagementmodel=ServiceManagementModel::selectraw('tblservicemanagement.id,tblservicemanagement.contractno,tblservicemanagement.customercode,
         tblcustomermaster.customername,tblservicemanagement.serviceadate,tblservicemanagement.servicereminderdate,tblservicemanagement.srmdate,
        tblservicemanagement.actualcontractcompletiondate')
            ->leftjoin('tblcustomermaster','tblservicemanagement.customercode','=','tblcustomermaster.customercode')->get();
//        $servicemanagementmodel=servicemanagementmodel::orderby('serviceadate','desc')->get();
        return view('servicemanagement.servicemanagement', compact('servicemanagementmodel'));

    }

    public function servicecompletionupdated(Request $request, $id)
    {
        $model = ServiceManagementModel::selectraw('tblservicemanagement.contractno,tblcontractmaster.servicefrequency,tblcontractmaster.contracttodate')
            ->leftjoin('tblcontractmaster','tblservicemanagement.contractno','=','tblcontractmaster.contractno')
            ->where('tblservicemanagement.contractno',$request->contractno)
            ->get()->first();

        $serviceparameter = ServiceParametersModel::selectraw('servicedays,leadlogdays')->where('name',$model->servicefrequency)->get()->first();

        $servicemanagementmodel = ServiceManagementModel::where('contractno', $request->contractno)->where('id', $id)->get()->first();
        $customercode = $servicemanagementmodel->customercode;
        //  ------------Update servicemanagement--------------------
        $servicemanagementmodel->contractno ;
        $servicemanagementmodel->customercode;
        $servicemanagementmodel->serviceadate = $request->serviceadate;
        $servicemanagementmodel->servicereminderdate = $request->servicereminderdate;
        $servicemanagementmodel->srmdate = $request->srmdate;
        $servicemanagementmodel->actualcontractcompletiondate = $request->actualcontractcompletiondate;
        $servicemanagementmodel->save();

        if($servicemanagementmodel->save() == true)
        {
            $equipmentflagupdatelist = EquipmentMasterModel::where('contractno',$request->contractno)->get()->pluck('equipmentsrno');
            $equipmentflagupdatecount = count($equipmentflagupdatelist);
            for($i=0; $i < $equipmentflagupdatecount; $i++)
            {
                $equipmentflagupdate = EquipmentMasterModel::where('equipmentsrno',$equipmentflagupdatelist[$i])->where('contractno',$request->contractno)->get()->first();
                $equipmentflagupdate->flagkey='0';
                $equipmentflagupdate->save();
            }
        }
//        if($servicemanagementmodel->save() == true)
//        {
//            $equipmet = EquipmentMasterModel::where('contractno',$request->contractno)->get()->pluck('equipmentsrno');
//            $count = count($equipmet);
//            for($i=0; $i < $count; $i++)
//            {
//                $updateequipment =  EquipmentMasterModel::find($equipmet[$i]);
//                $updateequipment->flagkey = '0';
//                $updateequipment->save();
//            }
//        }

//      $splitfrequency = explode(",",  $model->servicefrequency);
//        $serviceadate = Carbon::createFromFormat('Y-m-d',$request->serviceadate);
//        $contracttodate= Carbon::createFromFormat('Y-m-d',$model->contracttodate)->format('y-m-d');
//        $newservicedate = $serviceadate->addDays($serviceparameter->servicedays)->format('y-m-d');

        //----------New row create -------------
//        if($request->srmdate !=null && $request->actualcontractcompletiondate==null)
//        {
//            if($newservicedate <= $contracttodate) {
//
//                $servicemanagementmodel = new ServiceManagementModel();
//                $servicemanagementmodel->id = Uuid::uuid1();
//                $servicemanagementmodel->contractno = $request->contractno;
//                $servicemanagementmodel->customercode =$customercode;
//                $servicemanagementmodel->serviceadate=$newservicedate;
//                $servicemanagementmodel->servicereminderdate=$serviceadate->subDays($serviceparameter->leadlogdays)->format('y-m-d');
//                $servicemanagementmodel->flagkey = '0';
//                $servicemanagementmodel->save();
//            }
//        }


        return redirect('servicemanagement')->with('flash_message', 'record successfully update for contract no.' . $request->contractno);
    }

    public function view($id)
    {
        $servicemanagementmodel=ServiceManagementModel::selectraw('tblservicemanagement.id,tblservicemanagement.contractno,tblservicemanagement.customercode,
         tblcustomermaster.customername,tblservicemanagement.serviceadate,tblservicemanagement.servicereminderdate,tblservicemanagement.srmdate,
        tblservicemanagement.actualcontractcompletiondate')
            ->leftjoin('tblcustomermaster','tblservicemanagement.customercode','=','tblcustomermaster.customercode')
            ->where ('id',$id)->get()->first();


//        $servicemanagementmodel=servicemanagementmodel::where('id',$id)->get()->first() ;
        return redirect('servicemanagement')->with('flash_message', 'record successfully update for contract no.' . $request->contractno);
    }

    public function servicecompletionview($id)
    {
        $servicemanagementmodel=ServiceManagementModel::selectraw('tblservicemanagement.id,tblservicemanagement.contractno,tblservicemanagement.customercode,
         tblcustomermaster.customername,tblservicemanagement.serviceadate,tblservicemanagement.servicereminderdate,tblservicemanagement.srmdate,
        tblservicemanagement.actualcontractcompletiondate')
            ->leftjoin('tblcustomermaster','tblservicemanagement.customercode','=','tblcustomermaster.customercode')
            ->where ('id',$id)->get()->first();


//        $servicemanagementmodel=servicemanagementmodel::where('id',$id)->get()->first() ;
        return view('servicemanagement.servicemanagementview', compact('servicemanagementmodel'));
    }

    public function servicecompletionedit($id)
    {

        $servicemanagementmodel=ServiceManagementModel::selectraw('tblservicemanagement.id,tblservicemanagement.contractno,tblservicemanagement.customercode,
         tblcustomermaster.customername,tblservicemanagement.serviceadate,tblservicemanagement.servicereminderdate,tblservicemanagement.srmdate,tblcontractmaster.contracttodate,
        tblservicemanagement.actualcontractcompletiondate')
            ->leftjoin('tblcustomermaster','tblservicemanagement.customercode','=','tblcustomermaster.customercode')
            ->leftjoin('tblcontractmaster','tblservicemanagement.contractno','=','tblcontractmaster.contractno')
            ->where ('tblservicemanagement.id',$id)->get()->first();

//        $servicemanagementmodel = servicemanagementmodel::where('id',$id)->get()->first();
//         $contracts = ContractMasterDetailsModel::where('contractno',$servicemanagementmodel->contractno)->get()->first();
        $contracttodate = $servicemanagementmodel->contracttodate;

        return view('servicemanagement.servicemanagementedit',compact('servicemanagementmodel','contracttodate'));
    }

}