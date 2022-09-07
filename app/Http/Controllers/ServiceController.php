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
use App\Models\ServiceLogModel;
use App\Models\SubCategoryMasterModel;
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

class ServiceController extends Controller
{

    //Index of Service Management-> Pending Service
    public function serviceindex()
    {
        // Query to get the upcoming services
        $manageservice=\DB::select(\DB::raw('SELECT service.*,contract.workorderno,customer.customername,contract.servicefrequency 
                                                FROM tblservicemanagement service 
                                                INNER JOIN (SELECT tbl.contractno, tbl.servicereminderdate AS MaxDateTime
                                                FROM tblservicemanagement as tbl
                                                WHERE serviceStatus = \'ASSIGNED\'
                                                UNION
                                                SELECT TABLE1.contractno, MAX(TABLE1.servicereminderdate) AS dates
                                                FROM tblservicemanagement as TABLE1
                                                WHERE TABLE1.servicereminderdate <= NOW() AND TABLE1.contractno NOT IN (SELECT tbl.contractno
                                                FROM tblservicemanagement as tbl
                                                WHERE serviceStatus = \'ASSIGNED\' AND tbl.contractno = TABLE1.contractno
                                                GROUP BY tbl.contractno) 
                                                GROUP BY TABLE1.contractno) groupedtt ON service.contractno=groupedtt.contractno 
                                                AND service.servicereminderdate = groupedtt.MaxDateTime 
                                                LEFT JOIN tblcontractmaster AS contract ON contract.contractno = service.contractno 
                                                LEFT JOIN tblcustomermaster AS customer ON customer.customercode = service.customercode 
                                                WHERE service.flagkey = 0
                                                ORDER BY service.servicereminderdate DESC'));

        // Query to get the managed services which needs to be assigned
        $assignservices=\DB::select(\DB::raw('SELECT service.*,contract.workorderno,customer.customername,contract.servicefrequency 
                                                FROM tblservicemanagement service 
                                                INNER JOIN (SELECT tbl.contractno, tbl.servicereminderdate AS MaxDateTime
                                                FROM tblservicemanagement as tbl
                                                WHERE serviceStatus = \'ASSIGNED\'
                                                UNION
                                                SELECT TABLE1.contractno, MAX(TABLE1.servicereminderdate) AS dates
                                                FROM tblservicemanagement as TABLE1
                                                WHERE TABLE1.servicereminderdate <= NOW() AND TABLE1.contractno NOT IN (SELECT tbl.contractno
                                                FROM tblservicemanagement as tbl
                                                WHERE serviceStatus = \'ASSIGNED\' AND tbl.contractno = TABLE1.contractno
                                                GROUP BY tbl.contractno) 
                                                GROUP BY TABLE1.contractno) groupedtt ON service.contractno=groupedtt.contractno 
                                                AND service.servicereminderdate = groupedtt.MaxDateTime 
                                                LEFT JOIN tblcontractmaster AS contract ON contract.contractno = service.contractno 
                                                LEFT JOIN tblcustomermaster AS customer ON customer.customercode = service.customercode 
                                                WHERE service.flagkey = 1
                                                ORDER BY service.servicereminderdate DESC'));

        // Query to get status and ticketNo of the assigned services
        $servicestatus = \DB::select(\DB::raw('SELECT distinct t1.ticketno, t1.contractno, t3.customername, t4.branchname,  t2.serviceadate AS servicedate
                                            FROM tblexistingcustomercomplaintlodging t1
                                            INNER JOIN (SELECT contractno,ticketno
                                            FROM tblexistingcustomercomplaintlodging
                                            WHERE complaintdescription = \'service\'
                                            	AND subcategorycode = \'service\'
                                            	AND ticketno != \'Temp\'
                                            GROUP BY ticketno,contractno) tbl ON t1.contractno = tbl.contractno AND t1.ticketno = tbl.ticketno
                                            LEFT JOIN tblservicemanagement t2 ON t1.contractno = t2.contractno AND tbl.contractno = t2.contractno
                                            LEFT JOIN tblcustomermaster t3 ON t1.customercode = t3.customercode
                                            LEFT JOIN tblbranchmaster t4 ON t1.branchcode = t4.branchcode
                                            WHERE DATE(t2.updated_at) = DATE(t1.created_at)
                                            AND t2.flagkey = \'1\'
                                            ORDER BY servicedate desc'));

        return view('service.service', compact('manageservice','assignservices','servicestatus'));
    }

    //Manage service
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
        return view('service.index', compact('equipmentnull', 'equipment','id','equipementid'));
    }

    // Stores all the equipment of the particular contract into ExistingCustomerComplaint table with ticket no as 'Temp' and service date into complaint date;
    // Sets the flag key of table Service Management to 1;
    // Sets flag key of all equipments in Equipment master table to 0;
    public function storeequipment()
    {
        $user = User::where('id', '=', Auth::id())->get()->first();
        $equipmentsvalue = EquipmentMasterModel::where('contractno', '=', $_GET['contractcode'])->get()->pluck('equipmentsrno');
        $servicemanagement = ServiceManagementModel::find($_GET['equipmentsrno']);
        $count = count($equipmentsvalue);
        for ($i = 0; $i < $count; $i++) {
            $equipmentdetails = EquipmentMasterModel::where('equipmentsrno', '=', $equipmentsvalue[$i])->where('contractno','=',$_GET['contractcode'])->get()->first();
            $model = new ExistingUserComplaintLodging();
            $model->id = Uuid::uuid1();
            $model->ticketno = "Temp";
            $model->customercode = $equipmentdetails->customercode;
            $model->branchcode = $equipmentdetails->branchcode;
            $model->productservicecode = $equipmentdetails->productservicecode;
            $model->categorycode = $equipmentdetails->categorycode;
            $model->subcategorycode = "service";
            //$model->subcategorycode = SubCategoryMasterModel::where('subcategorycode', $equipmentdetails->categorycode)->first()->subcategoryname;
            $model->callername = $user->name;
            $model->emailid = $user->email;
            $model->complaintdescription = "service";
            $model->priority = "Medium";
            $model->complaintstatus = "ACKNOWLEDGED";
            $model->contractno = $equipmentdetails->contractno;
            $model->productsrno_accountno = $equipmentdetails->equipmentsrno;
//            $model->flag_key = '0';
            $model->complaintdate = $servicemanagement->serviceadate;
            $model->created_at = Carbon::now(new \DateTimeZone('Asia/Kolkata'));
            $model->created_by = Auth::id();
            $model->save();
            if($model->save() ==true){
                $servicemanagement->flagkey = "1";
                $status = StatusMasterModel::where('statuscode','=','CP0016')->get()->pluck('statusname')->first();
                $servicemanagement->serviceStatus = $status;
                $servicemanagement->save();
            }
            if($model->save() == true){
                $equipmentModel = EquipmentMasterModel::where('equipmentsrno', '=', $equipmentsvalue[$i])->where('contractno','=',$_GET['contractcode'])->get()->first();
                $equipmentModel->flagkey = "0";
                $equipmentModel->save();
            }
        }
            return json_encode($model);
    }

    //View the equipments
    public function show($id)
    {
        $equipmentnull = EquipmentMasterModel::where('contractno', '=', $id)->get()->first();
        if($equipmentnull == null)
        {
            $message = "There are no equipment to view";
        }
        else
        {
            $equipment = EquipmentMasterModel::where('contractno','=', $id)->get();
            $count=count($equipment);
//            $equipment = EquipmentMasterModel::selectRaw('tblequipmentdetails.*,tblbranchmaster.branchname')
//                ->leftjoin('tblbranchmaster','tblbranchmaster.branchcode','=','tblequipmentdetails.branchcode')
//                ->where('tblequipmentdetails.contractno', '=', $id)
//                ->get();

        }
        return view('service.show', compact('equipment','equipmentnull','count'));
    }

    // Assign Service to Engineer
    public function assignee($id,$serviceId)
    {
//        $workorder = EquipmentMasterModel::where('contractno', $id)->get()->first();
        $equipmentnull = EquipmentMasterModel::where('contractno', $id)->where('flagkey', '0')->get()->first();
        if ($equipmentnull == null) {
            $message = "There Is No Equipment To Assignee";
            return view('Service.assignee', compact('equipmentnull'));
        } else {
            $equipment = EquipmentMasterModel::where('contractno', $id)->where('flagkey', '0')->get();
            $branchcodes = array();
            foreach ($equipment as $codes)
                array_push($branchcodes, $codes->branchcode);
            $branches = BranchMasterModel::whereIn('branchcode', $branchcodes)->where('contractno',$id)->get();
            $productservicecodes = array();
            foreach ($equipment as $code)
                array_push($productservicecodes, $code->productservicecode);
            $productnames = ProductServiceMasterModel::whereIn('productservicecode', $productservicecodes)->get();
            $equipmentforlooping = EquipmentMasterModel::where('contractno', $id)->select('productservicecode', 'branchcode')->distinct()->get();
        }
        return view('Service.assignee', compact('equipmentnull',     'serviceId','equipment','branches','productnames','equipmentforlooping'));
    }

    public function getchkvalues()
    {
        $ticketno = 'CP' . str_shuffle((string)(random_int(00000, 99999)) . strtoupper(str_random(3)));
        $checkvalues = $_GET['checkvalues'];
        $contractno = $_GET['contractno'];
        $count = count($checkvalues);
        for ($i = 0; $i < $count; $i++) {
            $existingcomplaintid = ExistingUserComplaintLodging::where('productsrno_accountno', $checkvalues[$i])->where('ticketno','Temp')->get()->first()->id;
            $existingcomplaint = ExistingUserComplaintLodging::findorfail($existingcomplaintid);
            $existingcomplaint->ticketno = $ticketno;
            $statusname = StatusMasterModel::where('statuscode', 'CP0004')->pluck('statusname')->first();
            $existingcomplaint->complaintstatus = $statusname;
//            $existingcomplaint->complaintdate = Carbon::now(new \DateTimeZone('Asia/Kolkata'));
            $existingcomplaint->flag_key = '0';
            $existingcomplaint->save();
            $model = EquipmentMasterModel::where('contractno','=',$contractno)->where('equipmentsrno',$checkvalues[$i])->get()->first();
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
        return redirect('servicemanagement')->with('flash_message', 'record successfully update for contract no.' . $servicemanagementmodel->contractno);
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

    public function servicehome(){
        $service = \DB::select(\DB::raw('SELECT DISTINCT t1.contractno,t3.customername,t4.branchname,t1.ticketno,t2.servicedate 
                                    FROM tblexistingcustomercomplaintlodging t1
                                    INNER JOIN (select contractno, MAX(servicereminderdate) AS servicedate 
                                    from tblservicemanagement GROUP BY contractno ) AS t2 ON t1.contractno = t2.contractno
                                    LEFT JOIN tblcustomermaster t3 ON t1.customercode = t3.customercode
                                    LEFT JOIN tblbranchmaster t4 ON t1.contractno = t4.contractno AND t1.customercode = t4.customercode AND t1.branchcode = t4.branchcode
                                    WHERE t1.complaintdescription = \'service\' AND t1.subcategorycode = \'service\' AND t1.ticketno != \'Temp\'
                                    ORDER BY t2.servicedate desc'));
        return View('service.servicehome',compact('service'));
    }

    public function serviceview($ticketno){
        $products = ExistingUserComplaintLodging::selectRaw('tblexistingcustomercomplaintlodging.*,tblticketassigneedetails.assigneestatus')
                    ->leftjoin('tblticketassigneedetails','tblticketassigneedetails.ticketno','=','tblexistingcustomercomplaintlodging.ticketno')
                    ->where('tblexistingcustomercomplaintlodging.ticketno',$ticketno)->get();
        $count = count($products);
        $complaintstatuslist = StatusMasterModel::whereIn('statuscode',array('CP0010','CP0003','CP0002','CP0012'))->pluck('statusname','statusname');
        return View('service.serviceview',compact('products','count','complaintstatuslist'));
    }

}