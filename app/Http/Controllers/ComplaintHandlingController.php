<?php

namespace App\Http\Controllers;

use App\Models\AdminCommentsModel;
use App\Models\AssigneeFilesModel;
use App\Models\BranchMasterModel;
use App\Models\CategoryMasterModel;
use App\Models\ComplaintTypeModel;
use App\Models\ContractMasterModel;
use App\Models\CustomersModel;
use App\Models\EquipmentMasterModel;
use App\Models\ExistingUserComplaintLodgingHistory;
use App\Models\IncrementMasterModel;
use App\Models\ProductServiceMasterModel;
use App\Models\ServiceLogModel;
use App\Models\ServiceManagementModel;
use App\Models\SubCategoryMasterModel;
use Carbon\Carbon;
use phpDocumentor\Reflection\Types\This;
use Illuminate\Support\Facades\Auth;
use Ramsey\Uuid\Uuid;
use Illuminate\Http\Request;
use App\Models\StatusMasterModel;
use App\Models\AssigneeMasterModel;
use App\Models\TicketAssignedModel;
use App\Models\NonExistingUserComplaintLodging;
use App\Models\ExistingUserComplaintLodging;
use App\Models\ComplaintLodgingModel;
use App\Models\TicketAssignedHistoryModel;
use Illuminate\Support\Facades\Validator;

class ComplaintHandlingController extends Controller
{
    public function index()
    {
        try {
            $complaints = ExistingUserComplaintLodging::all();
            return view('complaint.existingcustomercomplaintlist', compact('complaints'));
        } catch (\Exception $ex) {
            $common = new CommonController;
            $common->ErrorLogging($ex, 'UserComplaint', 'newcomplaintregister');
            return 'Some error occurred while processing your request';
        }
    }

    public function show($id)
    {
        try {
            $model = TicketAssignedModel::where('ticketno', $id)->get()->first();
            if ($model == null) {
                return redirect()->back()->with('error-message', 'for view please assign complaint.');
            } else {
                $id = $model->id;
                $ticketnumber = $model->ticketno;
                $startdate = isset($model->assigneestartdate) ? date("Y-m-d", strtotime($model->assigneestartdate)) : null;
                $enddate = isset($model->assigneeenddate) ? date("Y-m-d", strtotime($model->assigneeenddate)) : null;
                $pendingreason = isset($model->ticketpendingreason) ? $model->ticketpendingreason : null;
                $nextactionremark = isset($model->ticketnextactionremark) ? $model->ticketnextactionremark : null;
                $resolvecomment = isset($model->ticketresolvecomment) ? $model->ticketresolvecomment : null;
                $assigneestatusvalue = isset($model->assigneestatus) ? $model->assigneestatus : null;
                $assigneesvalue = isset($model->assigneecode) ? $model->assigneecode : null;
                return view('complaint.existingcustomercomplaintview', compact('id', 'ticketnumber', 'assigneestatusvalue', 'assigneesvalue', 'resolvecomment', 'startdate', 'enddate', 'pendingreason', 'nextactionremark'));
            }
        } catch (\Exception $ex) {
            $common = new CommonController;
            $common->ErrorLogging($ex, 'UserComplaint', 'newcomplaintregister');
            return 'Some error occurred while processing your request';
        }
    }

    public function create($id,$serviceId)
    {
        try {
            $ticketnumber = ExistingUserComplaintLodging::where('ticketno', $id)->value('ticketno');
            $checkStatus = ExistingUserComplaintLodging::where('ticketno', $id)->value('complaintstatus');
            if ($ticketnumber == null) {
                $ticketnumber = NonExistingUserComplaintLodging::where('id', $id)->value('ticketno');
            }
            if($checkStatus == 'ACKNOWLEDGED')
            {
                $assignees = AssigneeMasterModel::where('isactive',1)->pluck('assigneename', 'assigneecode');
                $assigneestatus = array('Resolved' => 'Resolved', 'Not Resolved' => 'Not Resolved', 'Pending' => 'Pending');
                $assigneestartdate = Carbon::now(new \DateTimeZone('Asia/Kolkata'));
//            $increment = IncrementMasterModel::selectRaw('tblincrementmaster.*')->where('incrementid','=','20')->get();
//            $test = $increment->incrementvalue;
//            return $test;

                return view('complaint.assigncomplaint', compact('ticketnumber', 'assigneestatus', 'assignees','assigneestartdate','serviceId'));
            }
            else{
                return redirect('complaints')->with('success-message', 'Ticket No. '.$id.' already assigned.');
            }

        } catch (\Exception $ex) {
            $common = new CommonController;
            $common->ErrorLogging($ex, 'UserComplaint', 'newcomplaintregister');
            return 'Some error occurred while processing your request';
        }
    }

    public function store(Request $request)
    {
//        try {
            $validator = Validator::make($request->all(), [
                'assignees' => 'required',
                'startdate' => 'required',
                'enddate' => 'required'
            ]);
            if ($validator->fails()) {
                return redirect()->back()->withErrors()->withInput();
            } else {
                $model = new TicketAssignedModel();
                $model->id = Uuid::uuid1();
                $model->ticketno = $request['ticketnumber'];
                $model->assigneecode = $request['assignees'];
                $model->assigneestartdate = $request['startdate'];
                $model->assigneeenddate = $request['enddate'];
                $model->assigneestatus = StatusMasterModel::where('statuscode', 'CP0010')->first()->statusname;
                $model->created_at = Carbon::now(new \DateTimeZone('Asia/Kolkata'));
                $model->created_by = \Auth::id();
                $model->save();

                $historymodel = new TicketAssignedHistoryModel();
                $dynamiccode= $this->DynamicCode('HistoryID');
                $historymodel->id =$dynamiccode['code'];
                $incrementid= $dynamiccode['incrementid'];
                $historymodel->ticketno = $request['ticketnumber'];
                $historymodel->assigneecode = $request['assignees'];
                $historymodel->assigneestartdate = $request['startdate'];
                $historymodel->assigneeenddate = $request['enddate'];
                $historymodel->assigneestatus = StatusMasterModel::where('statuscode', 'CP0010')->first()->statusname;
                $historymodel->created_at  = Carbon::now(new \DateTimeZone('Asia/Kolkata'));
                $historymodel->created_by = \Auth::id();
                $historymodel->save();
                if ($historymodel->save()== true)
                {
                    $id="HistoryID";
                    $modelincrement = IncrementMasterModel::find(IncrementMasterModel::where('incrementfor',$id)->first()->incrementid);
                    $modelincrement->incrementvalue = $incrementid;
                    $modelincrement->save();
                }

                $ticketno = ExistingUserComplaintLodging::where('ticketno', $request->ticketnumber)->select('ticketno','id')->get();
                $count = count($ticketno);
                for ($i = 0; $i < $count; $i++) {
                    $ticketnumber = ExistingUserComplaintLodging::where('ticketno', $ticketno[$i]->ticketno)->where('id',$ticketno[$i]->id)->get()->first();
                    $ticketnumber->complaintstatus = StatusMasterModel::where('statuscode', 'CP0010')->first()->statusname;
                    $ticketnumber->callstartdate = $request['startdate'];
                    $ticketnumber->callenddate = $request['enddate'];
                    $ticketnumber->save();
                }
//                $mobile = AssigneeMasterModel::select('mobileno')
//                    ->where('assigneecode','=',$request['assignees'])
//                    ->value('mobileno');
//                $ticket = $request['ticketnumber'];
//
//                $productserialno = ExistingUserComplaintLodging::select('productsrno_accountno')
//                ->where('ticketno','=',$request['ticketnumber'])
//                ->value('productsrno_accountno');
//
//                $customername = ExistingUserComplaintLodging::SelectRaw('tblexistingcustomercomplaintlodging.*,tblcustomermaster.customername')
//                    ->leftjoin('tblcustomermaster','tblcustomermaster.customercode','=','tblexistingcustomercomplaintlodging.customercode')
//                    ->where('ticketno','=',$request['ticketnumber'])
//                    ->value('customername');
//
//                $branch = ExistingUserComplaintLodging::SelectRaw('tblexistingcustomercomplaintlodging.*,tblbranchmaster.branchname')
//                    ->leftjoin('tblbranchmaster','tblbranchmaster.branchcode','=','tblexistingcustomercomplaintlodging.branchcode')
//                    ->where('ticketno','=',$request['ticketnumber'])
//                    ->value('branchname');
//
//
//                $callername = ExistingUserComplaintLodging::select('callername')
//                    ->where('ticketno','=',$request['ticketnumber'])
//                    ->value('callername');
//
//                $callerphone = ExistingUserComplaintLodging::select('mobilenumber')
//                    ->where('ticketno','=',$request['ticketnumber'])
//                    ->value('mobilenumber');
//
//
//
//                $result = LaravelMsg91::message($mobile, "Ticket No.:$ticket\nEquipment SR No.:$productserialno\nCustomer Name:$customername\nLocation:$branch\nCaller Name:$callername\nCaller Mobile No:$callerphone");

                $user = ComplaintLodgingModel::find($request['ticketnumber']);
                if($user != null)
                {
                    $user->complaintstatus = StatusMasterModel::where('statuscode', 'CP0010')->first()->statusname;
                    $user->save();
                }

                if($request['serviceId'] != "null")
                {
                    $serviceManagement = ServiceManagementModel::where('id','=',$request['serviceId'])->get()->first();
                    if($serviceManagement->serviceStatus == "MANAGED") {
                        $serviceManagement->serviceStatus = "ASSIGNED";
                        $serviceManagement->save();
                    }
                    $ticket = ExistingUserComplaintLodging::where('ticketno','=',$request['ticketnumber'])->get()->first();
                    $serviceLog = new ServiceLogModel();
                    $serviceLog->serviceManagementId = $request['serviceId'];
                    $serviceLog->contractno = $ticket->contractno;
                    $serviceLog->servicedate = $serviceManagement->serviceadate;
                    $serviceLog->ticketno = $request['ticketnumber'];
                    $serviceLog->ticketStatus = "ASSIGNED";
                    $serviceLog->servicingDate = Carbon::now(new \DateTimeZone('Asia/Kolkata'));
                    $serviceLog->created_at = Carbon::now(new \DateTimeZone('Asia/Kolkata'));
                    $serviceLog->created_by = \Auth::id();
                    $serviceLog->save();
                }

                return redirect('complaints')->with('flash_message', $request->ticketnumber . ' complaint assigned successfully to ' . $model->assigneecode);
            }
//        } catch (\Exception $ex) {
////            $common = new CommonController;
////            $common->ErrorLogging($ex, 'UserComplaint', 'newcomplaintregister');
////            return 'Some error occurred while processing your request';
//            return $ex;
//        }

    }

    public function edit($id, $ticketno)
    {
        try
        {
             $complaintdetails = ExistingUserComplaintLodging::selectRaw('tblexistingcustomercomplaintlodging.*,tblcustomermaster.customername,tblproductservicemaster.productservicename,tblcategorymaster.categoryname,tblsubcategorymaster.subcategoryname,tblbranchmaster.branchname')  //Add column name for branch name
            ->leftjoin('tblcustomermaster','tblcustomermaster.customercode','tblexistingcustomercomplaintlodging.customercode')
                ->leftjoin('tblproductservicemaster','tblproductservicemaster.productservicecode','tblexistingcustomercomplaintlodging.productservicecode')
                ->leftjoin('tblcategorymaster','tblcategorymaster.categorycode','tblexistingcustomercomplaintlodging.categorycode')
                ->leftjoin('tblsubcategorymaster','tblsubcategorymaster.subcategorycode','tblexistingcustomercomplaintlodging.subcategorycode')
                 ->leftjoin('tblbranchmaster','tblbranchmaster.branchcode','tblexistingcustomercomplaintlodging.branchcode')
                ->where('tblexistingcustomercomplaintlodging.ticketno',$ticketno)
                ->get()->first();

            $previouslyassignedto = TicketAssignedModel::where('assigneecode',$id)->where('ticketno',$ticketno)->get();
            $historyDetails = TicketAssignedHistoryModel::where('ticketno',$ticketno)->orderBy('id','desc')->get();
            $comments = AdminCommentsModel::where('ticketno',$ticketno)->orderBy('commentdate','desc')->get();
            $userid = $complaintdetails->created_by;
            $user =  \App\User::where('id',$userid)->get()->first();
            if ($previouslyassignedto == null) {
                return redirect()->back()->with('error-message', ' to edit the complaint please assign the complaint first.');
            } else {
                $status = $previouslyassignedto->first()->assigneestatus;
                $ticketnumber = $previouslyassignedto->first()->ticketno;
                $assignees = AssigneeMasterModel::pluck('assigneename', 'assigneecode')->all();
                if($status != 'ACKNOWLEDGED') {
                    $filedetails = AssigneeFilesModel::where('ticketassigneedetailsid', $previouslyassignedto->first()->id)->get();
                }
                return view('complaint.updateassignee',compact('complaintdetails','ticketno', 'id','ticketnumber','assignees','status','previouslyassignedto','user','filedetails','historyDetails','comments'));
            }
        } catch (\Exception $ex) {
            $common = new CommonController;
            $common->ErrorLogging($ex, 'UserComplaint', 'newcomplaintregister');
            return 'Some error occurred while processing your request';
        }
    }

    public function shownewcomplaints()
    {
        try {

             $newcomplaints = \DB::select(\DB::raw('select id ,productsrno_accountno, ticketno,(SELECT customername FROM tblcustomermaster where customercode = t.customercode) as customername,(SELECT branchname from tblbranchmaster where branchcode = t.branchcode AND contractno = t.contractno ) as branchcode,complaintstatus,complaintdescription,complaintdate,contractno,workorderno,callername,complaintdate as tcomplaintdate from tblexistingcustomercomplaintlodging t WHERE complaintstatus = \'ACKNOWLEDGED\' order by complaintdate DESC'));

             $assignedcomplaints = \DB::select(\DB::raw('select t2.id ,t1.ticketno,(SELECT customername FROM tblcustomermaster where customercode = t2.customercode) as customername,(SELECT branchname from tblbranchmaster where branchcode = t2.branchcode  AND contractno = t2.contractno) as branchcode,t1.created_at as assigneedate,
                            (SELECT assigneename from tblassigneemaster where assigneecode = t1.assigneecode) as assigneename,t2.callername,t2.productsrno_accountno,t2.complaintdescription,t1.assigneestatus, complaintdate,
                            t1.assigneecode,t2.complaintstatus ,DATE_FORMAT(t1.assigneestartdate, \'%d-%m-%Y\') as assigneestartdate,t1.assigneestartdate as tassigneestartdate,t3.order_by as order_by,t2.New_Reopen
                                from tblticketassigneedetails  t1 left join tblexistingcustomercomplaintlodging t2 on  t2.ticketno = t1.ticketno LEFT JOIN tblassigneemaster t4 ON t1.assigneecode = t4.assigneecode left join tblstatusmaster t3 on  t3.statusname = t1.assigneestatus
                            WHERE t2.New_Reopen IS NOT NULL AND t2.complaintstatus=\'ASSIGNED\' And t1.assigneestatus <> \'UnresolvedReassigned\' AND t4.employeeid IS NOT NULL
                            UNION
                            select t2.id ,t1.ticketno,(SELECT customername FROM tblcustomermaster where customercode = t2.customercode) as customername,(SELECT branchname from tblbranchmaster where branchcode = t2.branchcode  AND contractno = t2.contractno) as branchcode,t1.created_at as assigneedate,
                            (SELECT assigneename from tblassigneemaster where assigneecode = t1.assigneecode) as assigneename,t2.callername,t2.productsrno_accountno,t2.complaintdescription,t1.assigneestatus, complaintdate,
                            t1.assigneecode,t2.complaintstatus ,DATE_FORMAT(t1.assigneestartdate, \'%d-%m-%Y\') as assigneestartdate,t1.assigneestartdate as tassigneestartdate,t3.order_by as order_by,t2.New_Reopen
                            from tblticketassigneedetails  t1 left join tblexistingcustomercomplaintlodging t2 on  t2.ticketno = t1.ticketno LEFT JOIN tblassigneemaster t4 ON t1.assigneecode = t4.assigneecode left join tblstatusmaster t3 on  t3.statusname = t1.assigneestatus
                            WHERE t2.New_Reopen IS null and t2.complaintstatus=\'ASSIGNED\' And t1.assigneestatus <> \'UnresolvedReassigned\' AND t4.employeeid IS NOT NULL order by New_Reopen desc,order_by ASC,tassigneestartdate '));


            $resolvedcomplaints = \DB::select(\DB::raw('select id ,productsrno_accountno, ticketno,t1.customername,(SELECT branchname from tblbranchmaster where branchcode = t.branchcode AND contractno = t.contractno) as branchcode,complaintstatus,complaintdescription,complaintdate,contractno,workorderno, DATE_FORMAT(callenddate, \'%d-%m-%Y\') as callenddate,callenddate as tcallenddate  from tblexistingcustomercomplaintlodging t  join tblcustomermaster t1 on t.customercode=t1.customercode WHERE complaintstatus = \'RESOLVED\' order by callenddate desc'));
            $closedcomplaints = \DB::select(\DB::raw('select id ,productsrno_accountno, ticketno,t1.customername,(SELECT branchname from tblbranchmaster where branchcode = t.branchcode AND contractno = t.contractno) as branchcode,complaintstatus,complaintdescription,complaintdate,contractno,workorderno, DATE_FORMAT(callclosuredate, \'%d-%m-%Y\') as callclosuredate,callenddate as tcallenddate  from tblexistingcustomercomplaintlodging t  join tblcustomermaster t1 on t.customercode=t1.customercode WHERE complaintstatus = \'CLOSED\' and t.callclosuredate >= "2018-04-01" order by t.callclosuredate desc'));

            return view('complaint.complaints', compact('newcomplaints', 'assignedcomplaints', 'resolvedcomplaints','closedcomplaints'));
        } catch (\Exception $ex) {
            return $ex;
            $common = new CommonController;
            $common->ErrorLogging($ex, 'UserComplaint', 'newcomplaintregister');
            return 'Some error occurred while processing your request';
        }
    }

    public function viewcustomercomplaint($id)
    {
        try {
            $ticketnumber = ExistingUserComplaintLodging::SelectRaw('tblexistingcustomercomplaintlodging.*,tblcustomermaster.customername,tblbranchmaster.branchname,tblproductservicemaster.productservicename,tblcategorymaster.categoryname,tblsubcategorymaster.subcategoryname')
                ->leftjoin('tblcustomermaster','tblcustomermaster.customercode','=','tblexistingcustomercomplaintlodging.customercode')
                ->leftjoin('tblbranchmaster','tblbranchmaster.branchcode','=','tblexistingcustomercomplaintlodging.branchcode')
                ->leftjoin('tblproductservicemaster','tblproductservicemaster.productservicecode','=','tblexistingcustomercomplaintlodging.productservicecode')
                ->leftjoin('tblcategorymaster','tblcategorymaster.categorycode','=','tblexistingcustomercomplaintlodging.categorycode')
                ->leftjoin('tblsubcategorymaster','tblsubcategorymaster.subcategorycode','=','tblexistingcustomercomplaintlodging.subcategorycode')
                ->where('tblexistingcustomercomplaintlodging.id', '=', $id)->get()->first();
            $userid = $ticketnumber->created_by;
            $user =  \App\User::where('id',$userid)->get()->first();
            $userupdate = $ticketnumber->updated_by;
            $userupdated = \App\User::where('id',$userupdate)->get()->first();
            $previouslyassignedto = TicketAssignedHistoryModel::where('ticketno',$ticketnumber->ticketno)->orderBy('id','desc')->get();
            $ticketdetails = TicketAssignedModel::where('ticketno',$ticketnumber->ticketno)->get();

            if(count($previouslyassignedto) > 0) {
                $status = $previouslyassignedto->first()->assigneestatus;
            }
            else{
                $status =$ticketnumber->complaintstatus;
            }
            if($status != 'ACKNOWLEDGED' && count($previouslyassignedto) > 0) {
                $filedetails = AssigneeFilesModel::where('ticketassigneedetailsid', $ticketdetails->first()->id)->get();
            }

            return view('complaint.viewcustomercomplaint', compact('ticketnumber',    'user', 'previouslyassignedto','status','userupdated','filedetails'));

        }
 catch (\Exception $ex) {
            $common = new CommonController;
            $common->ErrorLogging($ex, 'UserComplaint', 'newcomplaintregister');
            return 'Some error occurred while processing your request';             //'Some error occurred while processing your request'
        }
    }

    public function closecomplaints(Request $request)
    {
        $updatexistingstaus =  null;
        $historyModel = new TicketAssignedHistoryModel();
        $existingstaus = ExistingUserComplaintLodging::where('ticketno',$request['ticketnumber'])->get()->pluck('id');
        $updateesistingstauscount = count($existingstaus);
        for ($j=0; $j < $updateesistingstauscount; $j++)
        {
            $updatexistingstaus = ExistingUserComplaintLodging::where('id',$existingstaus[$j])->get()->first();
            $updatexistingstaus->complaintstatus = "CLOSED";
            $updatexistingstaus->closurecomment = $request['reasonclosecomplaint'];
            $updatexistingstaus->callclosuredate = Carbon::now(new \DateTimeZone('Asia/Kolkata'));
            $updatexistingstaus->save();
        }

        if($updatexistingstaus->save() == true)
        {
            $ticketassignee  = TicketAssignedModel::where('ticketno',$request['ticketnumber'])->get()->pluck('id');
            $count = count($ticketassignee);
            if($count >0)
            {
                for ($i=0; $i < $count; $i++)
                {
                    $updaeticketassignee = TicketAssignedModel::where('id',$ticketassignee[$i])->get()->first();
                    $updaeticketassignee->assigneestatus = "ClosedByAdmin";
                    $updaeticketassignee->save();

                    $dynamiccode= $this->DynamicCode('HistoryID');
                    $historyModel->id =$dynamiccode['code'];
                    $incrementid= $dynamiccode['incrementid'];

                    $historyModel->ticketno = $request['ticketnumber'];
                    $historyModel->assigneestatus = "ClosedByAdmin";
                    $historyModel->assigneecode =  TicketAssignedModel::where('ticketno',$request['ticketnumber'])->value('assigneecode');
                    $historyModel->created_at = Carbon::now(new \DateTimeZone('Asia/Kolkata'));
                    $historyModel->created_by = \Auth::id();
                    $historyModel->save();
                    if ($historyModel->save()== true)
                    {
                        $id="HistoryID";
                        $modelincrement = IncrementMasterModel::find(IncrementMasterModel::where('incrementfor',$id)->first()->incrementid);
                        $modelincrement->incrementvalue = $incrementid;
                        $modelincrement->save();
                    }
                }
            }

        }
        return redirect('complaints');
    }

    public function GetProductsrno($id)
    {
        $data = ExistingUserComplaintLodging::where('id','=',$id)->get()->first();
        $typeofform = $data->typeofform;
        if($typeofform =="complaintbyequipment"){
            $equipmentdata =  EquipmentMasterModel::SelectRaw('tblequipmentdetails.*,tblbranchmaster.branchname,tblproductservicemaster.productservicename,tblcategorymaster.categoryname')
                ->join('tblbranchmaster','tblbranchmaster.branchcode','=','tblequipmentdetails.branchcode')
                ->join('tblproductservicemaster','tblproductservicemaster.productservicecode','=','tblequipmentdetails.productservicecode')
                ->join('tblcategorymaster','tblcategorymaster.categorycode','=','tblequipmentdetails.categorycode')
                ->where('tblequipmentdetails.customercode',$data->customercode)->where('status','Active')
                ->get();

//            $equipmentlist = $equipmentdata->pluck('equipmentsrno','equipmentsrno');
            $equipmentcode = $data->productsrno_accountno;

//            $workorderlist = $equipmentlist->pluck('workorderno','workorderno');
            $workordercode = $data->workorderno;

//            $customerslist = CustomersModel::pluck('customername', 'customercode')->all();
            $customercode = CustomersModel::where('customercode','=',$data->customercode)->get()->first();

//            $customersitelist = $equipmentdata->pluck('branchname','branchcode');
            $customersitecode =  $equipmentdata->where('branchcode','=',$data->branchcode)->pluck('branchname')->first();

//            $productservicelist = $equipmentdata->pluck('productservicename','productservicecode');
            $productservicecode = $equipmentdata->where('productservicecode','=',$data->productservicecode)->pluck('productservicename')->first();

//            $categorylist = $equipmentdata->pluck('categoryname','categorycode');
            $categorycode = $equipmentdata->where('categorycode','=',$data->categorycode)->pluck('categoryname')->first();

//            $subcategorylist = SubCategoryMasterModel::where('categorycode','=',$data->categorycode)->get()->pluck('subcategoryname','subcategorycode');
            $subcategorycode = SubCategoryMasterModel::where('subcategorycode','=',$data->subcategorycode)->pluck('subcategoryname')->first();

            $complainttype= ComplaintTypeModel::where('complaintname','!=','Sale')->get()->pluck('complaintname','complaintname');
            $complainttypecode = $data->typeofcall;
            $chargedcomplaint = ($data->chargedcomplaint != "0" ?  true  : false);
//            $callernamelist = ExistingUserComplaintLodging::where('id','=',$id)->get()->pluck('callername','callername');
            return view('complaint.updateproductsrno',compact('data','customerslist','customercode' ,'equipmentlist','equipmentcode','workorderlist',
                'workordercode','customersitelist','customersitecode','productservicelist','productservicecode','categorylist','categorycode','subcategorylist',
                'subcategorycode','chargedcomplaint','complainttype','complainttypecode','callernamelist'));
        }
        elseif ($typeofform =="complaintbyworkorder"){
            $customerslist = CustomersModel::pluck('customername', 'customercode')->all();
            $customercode = $data->customercode;
            $workorderlist  = ContractMasterModel::where('customercode',$data->customercode)->where('closuredate',null)->get()->pluck('workorderno','workorderno');
            $workordercode = $data->workorderno;
            $customersitelist = $contractno = BranchMasterModel::where('contractno','=',$data->contractno)->get()->pluck('branchname','branchcode');
            $customersitecode =  $data->branchcode;
            $productservicelist = EquipmentMasterModel::selectraw('tblequipmentdetails.productservicecode,tblproductservicemaster.productservicename')
                ->join('tblproductservicemaster','tblproductservicemaster.productservicecode','=','tblequipmentdetails.productservicecode')
                ->where('tblequipmentdetails.branchcode','=',$data->branchcode)
                ->get()->pluck('productservicename','productservicecode');
            $productservicecode = $data->productservicecode;
            $categorylist = CategoryMasterModel::where('productservicecode','=',$data->productservicecode)->get()->pluck('categoryname','categorycode');
            $categorycode = $data->categorycode;
            $subcategorylist = SubCategoryMasterModel::where('categorycode','=',$data->categorycode)->get()->pluck('subcategoryname','subcategorycode');
            $subcategorycode = $data->subcategorycode;
            $equipmentlist = EquipmentMasterModel::where('contractno','=',$data->contractno)->where('customercode','=',$data->customercode)
                ->where('productservicecode','=',$data->productservicecode)
                ->where('categorycode','=',$data->categorycode)
                ->where('categorycode','=',$data->categorycode)->get()->pluck('equipmentsrno','equipmentsrno');
            $equipmentcode = $data->equipmentsrno;
            $complainttype= ComplaintTypeModel::where('complaintname','!=','Sale')->get()->pluck('complaintname','complaintname');
            $complainttypecode = $data->typeofcall;
            $callernamelist = ExistingUserComplaintLodging::where('id','=',$id)->get()->pluck('callername','callername');
            return view('complaint.updateproductsrno',compact('data','customerslist','customercode' ,'equipmentlist','equipmentcode','workorderlist',
                'workordercode','customersitelist','customersitecode','productservicelist','productservicecode','categorylist','categorycode','subcategorylist',
                'subcategorycode','chargedcomplaint','complainttype','complainttypecode','callernamelist'));
        }
        else {
//            $customers = CustomersModel::pluck('customername', 'customercode')->all();
            $customercode = CustomersModel::where('customercode','=',$data->customercode)->pluck('customername')->first();
//            $productService = ProductServiceMasterModel::pluck('productservicename', 'productservicecode')->all();
            $productServicecode = ProductServiceMasterModel::where('productservicecode','=',$data->productservicecode)->pluck('productservicename')->first();
            $complainttype = ComplaintTypeModel::all()->pluck('complaintname','complaintname');
            $complainttypecode = $data->typeofcall;
//            $categorylist = CategoryMasterModel::where('productservicecode','=',$data->productservicecode)->get()->pluck('categoryname','categorycode');
            $categorycode = CategoryMasterModel::where('categorycode','=',$data->categorycode)->pluck('categoryname')->first();
//            $subcategorylist = SubCategoryMasterModel::where('categorycode','=',$data->categorycode)->get()->pluck('subcategoryname','subcategorycode');
            $subcategorycode = SubCategoryMasterModel::where('subcategorycode','=',$data->subcategorycode)->pluck('subcategoryname')->first();
            $chargedcomplaint = ($data->chargedcomplaint != "0" ?  true  : false);
//            $callernamelist = ExistingUserComplaintLodging::where('id','=',$id)->get()->pluck('callername','callername');

//            Changed By Maaviya on 19/11/2020

            return view('complaint.editguestnewcomplaint',compact('data','productServicecode' ,'customercode','complainttype',
                'complainttypecode','categorycode','subcategorycode','chargedcomplaint'));
        }
    }

    public function updateproductsrnocomplaint(Request $request)
    {
        $model = ExistingUserComplaintLodging::where('id',$request->id)->get()->first();
        $model->complaintdescription = $request["complaintdescription"];
        $model->updated_at = Carbon::now(new \DateTimeZone('Asia/Kolkata'));
        $model->updated_by = Auth::id();
        $model->update();
//        $model->customercode = $request["customers"];
//        $model->typeofcall = $request["typeofcall"];
//        $model->productservicecode = $request["productservice"];
//        $model->workorderno = $request["workorderno"];
//        $model->categorycode = $request["category"];
//        $model->subcategorycode = $request["subcategory"];
//        $model->productsrno_accountno = $request["productserialno"];

//        $model->callername = $request["callername"];
//        $model->mobilenumber = $request["callermobile"];
//        $model->emailid = $request["calleremail"];
//        $model->priority = $request["priority"];
//        $model->complaintstatus = StatusMasterModel::where('statuscode', 'CP0010')->pluck('statusname')->first();

//        Changed by Maaviya on 19/11/2020

        return redirect('complaints')->with('success-message', 'Complaint edited successfully.');
    }

    public function registercomplaintclose($id, $ticketno)
    {
        $previouslyassignedto = TicketAssignedModel::where('assigneecode',$id)->where('ticketno',$ticketno)->get()->first();
        $assigneename = AssigneeMasterModel::all()->where('assigneecode', $previouslyassignedto->assigneecode)->first()->assigneename;
        return view('complaint.registercomplaintclose',compact('id','ticketno','previouslyassignedto','assigneename'));
    }

    public function registerassignecomplaint($id, $ticketno)
    {
        $assignees = AssigneeMasterModel::where('isactive','1')
            ->where('assigneecode','!=',$id)
            ->get()->pluck('assigneename','assigneecode');


        $assigneestartdate = Carbon::now(new \DateTimeZone('Asia/Kolkata'));
        return view('complaint.reassigncomplaint',compact('ticketno','id','assignees','assigneestartdate'));
    }

    public function update(Request $request, $id)
    {
          try{
              $validator = \Validator::make($request->all(), [
                  'assignees' => 'required',
                  'startdate' => 'required',
                  'enddate' => 'required'
              ]);
              $user = auth()->user();
              $model = TicketAssignedModel::where('ticketno', $id)->where('assigneecode',$request->id)->get()->first();
              $historyModel = new TicketAssignedHistoryModel();
              $model->ticketno = $request['ticketnumber'];
              $model->assigneecode = $request['assignees'];
              $model->assigneestartdate = $request['startdate'];
              $model->assigneeenddate = $request['enddate'];
              if($request['employeeid'] == '')
              {
                  $model->calldetails = $request['vendorTicketNo'];
                  $commenttable = new AdminCommentsModel();
                  $commenttable->ticketno = $request['ticketnumber'];
                  $commenttable->comment = $request['vendorComment'];
                  $commenttable->commentdate = Carbon::now(new \DateTimeZone('Asia/Kolkata'));
                  $commenttable->created_by = $user->name;
                  $commenttable->created_at = Carbon::now(new \DateTimeZone('Asia/Kolkata'));
                  $commenttable->save();
              }
              $model->assigneestatus = StatusMasterModel::where('statuscode', 'CP0010')->first()->statusname;
              $model->updated_at = Carbon::now(new \DateTimeZone('Asia/Kolkata'));
              $model->updated_by = \Auth::id();
              $model->update();

              $dynamiccode= $this->DynamicCode('HistoryID');
              $historyModel->id =$dynamiccode['code'];
              $incrementid= $dynamiccode['incrementid'];

              $historyModel->ticketno = $request['ticketnumber'];
              $historyModel->assigneecode = $request['assignees'];
              $historyModel->assigneestartdate = $request['startdate'];
              $historyModel->assigneeenddate = $request['enddate'];
              if($request['employeeid'] == '') {
                  $model->calldetails = $request['vendorTicketNo'];
              }
              $historyModel->assigneestatus = StatusMasterModel::where('statuscode', 'CP0010')->first()->statusname;
              $historyModel->created_at = Carbon::now(new \DateTimeZone('Asia/Kolkata'));
              $historyModel->created_by = \Auth::id();
              $historyModel->save();
              if ($historyModel->save()== true)
              {
                  $id="HistoryID";
                  $modelincrement = IncrementMasterModel::find(IncrementMasterModel::where('incrementfor',$id)->first()->incrementid);
                  $modelincrement->incrementvalue = $incrementid;
                  $modelincrement->save();
              }


              return redirect('complaints')->with('flash_message', $model->ticketnumber . ' complaint assigned successfully to ' . $request['assignees']);
          }
            catch (\Exception $ex) {
                return $ex;
                $common = new CommonController;
                $common->ErrorLogging($ex, 'UserComplaint', 'newcomplaintregister');
                return 'Some error occurred while processing your request';
            }
//        try {
//            $reassignedticketno = TicketAssignedModel::where('ticketno', $id)->where('assigneecode',$request->id)->get()->first();
//            if($reassignedticketno->assigneecode == $request->id && $reassignedticketno->assigneestatus = "NOT RESOLVED")
//            {
//                $model = new TicketAssignedModel;
//                $rowid = Uuid::uuid1();
//                $model->id = $rowid;
//                $model->ticketno = $request['ticketnumber'];
//                $model->assigneecode = $request['assignees'];
//                $model->assigneestartdate = $request['startdate'];
//                $model->assigneeenddate = $request['enddate'];
//                $model->assigneestatus = StatusMasterModel::where('statuscode', 'CP0008')->first()->statusname;
//                $model->updated_at = Carbon::now(new \DateTimeZone('Asia/Kolkata'));
//                $model->updated_by = \Auth::id();
//                $model->save();
//            }
//            $reassignedticketno->assigneestatus = StatusMasterModel::where('statuscode', 'CP0014')->first()->statusname;
//            $reassignedticketno->save();
//
//
//
//            return redirect('complaints')->with('flash_message', $request->ticketnumber.'complaint assigned successfully to'.$model->assigneecode);
//
//        } catch (\Exception $ex) {
//            return $ex;
//            $common = new CommonController;
//            $common->ErrorLogging($ex, 'UserComplaint', 'newcomplaintregister');
//            return 'Some error occurred while processing your request';
//        }
    }

    public function closecomplint($id)
    {
        $ticketexitclosecomplaints = ExistingUserComplaintLodging::where('ticketno',$id)->get()->first();
        $ticketno = $ticketexitclosecomplaints->ticketno;
        $assigneename = null;
        return view('complaint.registercomplaintclose',compact('id','ticketno','assigneename'));
    }

    public function reopenComplaint($ticketno){

        $assigneemodel =  TicketAssignedModel::where('ticketno','=',$ticketno)->get()->first();
        if($assigneemodel != "") {
            $assigneemaster = AssigneeMasterModel::selectRaw('tblassigneemaster.assigneename,tblassigneemaster.assigneecode,tblticketassigneedetails.assigneecode')
                ->leftjoin('tblticketassigneedetails', 'tblticketassigneedetails.assigneecode', '=', 'tblassigneemaster.assigneecode')
                ->where('tblticketassigneedetails.ticketno', '=', $ticketno)
                ->where('tblassigneemaster.isactive', 1)
                ->where('tblassigneemaster.assigneecode', '=', $assigneemodel->assigneecode)
                ->get()->first();
            $assigneelist = AssigneeMasterModel::where('isactive', 1)->pluck('assigneename', 'assigneecode');
            $assigneename = $assigneemaster->assigneecode;
            $assigneestartdate = Carbon::now(new \DateTimeZone('Asia/Kolkata'));
        }
        else{
             $assigneelist = AssigneeMasterModel::where('isactive', 1)->pluck('assigneename', 'assigneecode');
            $assigneename = '';
            $assigneestartdate = Carbon::now(new \DateTimeZone('Asia/Kolkata'));
        }
        return view('complaint.reopenComplaint',compact('ticketno','assigneemodel','assigneelist','assigneename','assigneestartdate'));
    }

    public function storeReopenComplaint(Request $request){
//        try {
            $validator = Validator::make($request->all(), [
                'assignees' => 'required',
                'startdate' => 'required',
                'enddate' => 'required',
                'reopendescription' => 'required'
            ]);
            if ($validator->fails()) {
                return redirect()->back()->withErrors()->withInput();
            } else {
                $existingmodel = ExistingUserComplaintLodging::where('ticketno',$request['ticketnumber'])->get()->first();
                $existingHistoryModel = new ExistingUserComplaintLodgingHistory();
                $dynamiccode= $this->DynamicCode('ExistingHistoryId');
                $existingHistoryModel->id =$dynamiccode['code'];
                $incrementid= $dynamiccode['incrementid'];

                $existingHistoryModel->ticketno = $request['ticketnumber'];
                $existingHistoryModel->contractno = $existingmodel->contractno;
                $existingHistoryModel->workorderno = $existingmodel->workorderno;
                $existingHistoryModel->customercode = $existingmodel->customercode;
                $existingHistoryModel->branchcode = $existingmodel->branchcode;
                $existingHistoryModel->productsrno_accountno = $existingmodel->productsrno_accountno;
                $existingHistoryModel->productsrno = $existingmodel->productsrno;
                $existingHistoryModel->productservicecode = $existingmodel->productservicecode;
                $existingHistoryModel->categorycode = $existingmodel->categorycode;
                $existingHistoryModel->subcategorycode = $existingmodel->subcategorycode;
                $existingHistoryModel->callername = $existingmodel->callername;
                $existingHistoryModel->mobilenumber = $existingmodel->mobilenumber;
                $existingHistoryModel->emailid = $existingmodel->emailid;
                $existingHistoryModel->complaintdescription = $existingmodel->complaintdescription;
                $existingHistoryModel->complaintdate = $existingmodel->complaintdate;
                $existingHistoryModel->priority = $existingmodel->priority;
                $existingHistoryModel->comprehensive = $existingmodel->comprehensive;
                $existingHistoryModel->complaintstatus = $existingmodel->complaintstatus;
                $existingHistoryModel->certificatedate = $existingmodel->certificatedate;
                $existingHistoryModel->callstartdate = $existingmodel->callstartdate;
                $existingHistoryModel->callenddate = $existingmodel->callenddate;
                $existingHistoryModel->callclosuredate = $existingmodel->callclosuredate;
                $existingHistoryModel->closurecomment = $existingmodel->closurecomment;
                $existingHistoryModel->chargedcomplaint = $existingmodel->chargedcomplaint;
                $existingHistoryModel->typeofcall = $existingmodel->typeofcall;
                $existingHistoryModel->New_Reopen = $existingmodel->New_Reopen;
                $existingHistoryModel->Reopen_description = $existingmodel->Reopen_description;
                $existingHistoryModel->Reopen_date = $existingmodel->Reopen_date;
                $existingHistoryModel->created_by = $existingmodel->created_by;
                $existingHistoryModel->created_at = $existingmodel->created_at;
                $existingHistoryModel->updated_by = $existingmodel->updated_by;
                $existingHistoryModel->updated_at = $existingmodel->updated_at;
                $existingHistoryModel->save();
                if ($existingHistoryModel->save()== true)
                {
                    $id="ExistingHistoryId";
                    $modelincrement = IncrementMasterModel::find(IncrementMasterModel::where('incrementfor',$id)->first()->incrementid);
                    $modelincrement->incrementvalue = $incrementid;
                    $modelincrement->save();


                    $model = ExistingUserComplaintLodging::where('ticketno',$request['ticketnumber'])->get()->first();
                    $model->complaintstatus = StatusMasterModel::where('statuscode', 'CP0010')->pluck('statusname')->first();
                    $model->New_Reopen = StatusMasterModel::where('statuscode', 'CP0015')->pluck('statusname')->first();
                    $model->Reopen_description = $request['reopendescription'];
                    $model->Reopen_date = Carbon::now(new \DateTimeZone('Asia/Kolkata'));
                    $model->callstartdate = $request['startdate'];
                    $model->callenddate = $request['enddate'];
                    $model->updated_at = Carbon::now(new \DateTimeZone('Asia/Kolkata'));
                    $model->updated_by =  Auth::id();
                    $model->update();
                }

                $assigneemodel = TicketAssignedModel::where('ticketno',$request['ticketnumber'])->get()->first();
                $assigneemodel->assigneecode = $request['assignees'];
                $assigneemodel->assigneestatus = StatusMasterModel::where('statuscode', 'CP0010')->pluck('statusname')->first();
                $assigneemodel->assigneestartdate = $request['startdate'];
                $assigneemodel->assigneeenddate = $request['enddate'];
                $assigneemodel->updated_at = Carbon::now(new \DateTimeZone('Asia/Kolkata'));
                $assigneemodel->updated_by = Auth::id();
                $assigneemodel->update();


                $historymodel = new TicketAssignedHistoryModel();
                $dynamiccode= $this->DynamicCode('HistoryID');
                $historymodel->id =$dynamiccode['code'];
                $incrementid= $dynamiccode['incrementid'];

                $historymodel->ticketno = $request['ticketnumber'];
                $historymodel->assigneecode = $request['assignees'];
                $historymodel->assigneestatus = StatusMasterModel::where('statuscode', 'CP0010')->pluck('statusname')->first();
                $historymodel->assigneestartdate = $request['startdate'];
                $historymodel->assigneeenddate = $request['enddate'];
                $historymodel->created_at = Carbon::now(new \DateTimeZone('Asia/Kolkata'));
                $historymodel->created_by = Auth::id();
                $historymodel->save();

                if ($historymodel->save()== true)
                {

                    $id="HistoryID";
                    $modelincrement = IncrementMasterModel::find(IncrementMasterModel::where('incrementfor',$id)->first()->incrementid);
                    $modelincrement->incrementvalue = $incrementid;
                    $modelincrement->save();
                }

            }
            return redirect('complaints')->with('flash_message', ' Complaint Reopened Successfully.');
        }
//        catch (\Exception $ex) {
//            $common = new CommonController;
//            $common->ErrorLogging($ex, 'UserComplaint', 'newcomplaintregister');
//            return 'Some error occurred while processing your request';
//            return $ex;
//        }

//    }

//    public function Duplicatedata($ticketno,$assigneecode,$assigneestatus){
//        $count = 0;
//        $data = TicketAssignedModel::where('ticketno','=',$ticketno,'And','assigneecode','=',$assigneecode,'And','assigneestatus','=',$assigneestatus)->get()->first();
//        if(count($data) == 0){
//            $count = 1;
//        }
//        return $count;
//    }

    public function addcomments($ticketno)
    {
        return view('complaint.addcomments',compact('ticketno'));
    }

    public function commentspost(Request $request)
    {
        $user = auth()->user();
        $ticketno = $request['ticketno'];
        $comments = $request['comments'];
        $commentdate = $request['commentdate'];

        $commenttable = new AdminCommentsModel();
        $commenttable->ticketno = $ticketno;
        $commenttable->comment = $comments;
        if($commentdate != ''){
            $commenttable->commentdate = $commentdate;
        }
        else{
            $commenttable->commentdate = Carbon::now(new \DateTimeZone('Asia/Kolkata'));
        }

        $commenttable->created_by = $user->name;
        $commenttable->created_at = Carbon::now(new \DateTimeZone('Asia/Kolkata'));
        $commenttable->save();

       return redirect('complaints')->with('flash_message', 'Comments Succesfully Added for'.$ticketno);
    }

    public function getassigneeassigneddata($id){
        $assigneecode = trim($id);
        $data = ExistingUserComplaintLodging::selectRaw('tblexistingcustomercomplaintlodging.*,tblcustomermaster.customername,tblbranchmaster.branchname,tblticketassigneedetails.assigneestartdate,tblassigneemaster.employeeid')
            ->Join('tblcustomermaster', 'tblcustomermaster.customercode', '=', 'tblexistingcustomercomplaintlodging.customercode')
            ->Join('tblbranchmaster', 'tblbranchmaster.branchcode', '=', 'tblexistingcustomercomplaintlodging.branchcode')
            ->Join('tblticketassigneedetails', 'tblticketassigneedetails.ticketno', '=', 'tblexistingcustomercomplaintlodging.ticketno')
            ->leftjoin('tblassigneemaster','tblassigneemaster.assigneecode','=','tblticketassigneedetails.assigneecode')
            ->where('tblticketassigneedetails.assigneecode', $assigneecode)
            ->whereIn('tblexistingcustomercomplaintlodging.complaintstatus',array('ASSIGNED','REASSIGNED'))
            ->get();

//        $data = \DB::select(\DB::raw('select DISTINCT  t.ticketno,t.complaintstatus,t.complaintdescription,t.complaintdate as tcomplaintdate ,t1.branchname,t2.customername,t3.assigneestartdate from tblexistingcustomercomplaintlodging t join tblbranchmaster t1 on t1.branchcode=t.branchcode join tblcustomermaster t2 on t2.customercode = t.customercode join tblticketassigneedetails t3 on t3.ticketno = t.ticketno and t3.assigneestartdate=t.callstartdate where t3.assigneecode=\''+$id+'\' and t.complaintstatus=\'ASSIGNED\' order by complaintdate desc'));
        return json_encode($data);
    }

    public function DynamicCode($tablename)
    {
        $lastincrementid = IncrementMasterModel::all()->where('incrementfor',$tablename)->first()->incrementvalue;
        $incrementid= $lastincrementid + 1;
        $code = $lastincrementid;
        $itemarray=array('code'=>$code,'incrementid'=>$incrementid);
        return $itemarray ;
    }

}