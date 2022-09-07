<?php

namespace App\Http\Controllers;

use App\Models\ContractInvoiceandPaymentsModel;
use App\Models\EquipmentMasterModel;
use App\Models\ServiceLogModel;
use App\Models\ServiceManagementModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\StatusMasterModel;
use App\Models\TicketAssignedModel;
use App\Models\ComplaintLodgingModel;
use App\Models\ExistingUserComplaintLodging;
use App\Models\NonExistingUserComplaintLodging;
use Illuminate\Support\Facades\DB;
use App\Models\ContractPaymentTermModel;
use App\Models\AssigneeFilesModel;

class CustomerComplaintListController extends Controller
{
    //assignee manage function

    public function index()
    {
        return view('assignee.index',compact('complaints'));
    }

    public function show($id)
    {
        $user = auth()->user();

        $complaints = new TicketAssignedModel();

        $complaintsWithStatus = TicketAssignedModel::where('id', $id)->first();

        $complaints->ticketno = $complaintsWithStatus->ticketno;

        if($complaintsWithStatus->assigneestatus == 'RESOLVED'){
            $complaints->assigneestatus = $complaintsWithStatus->assigneestatus;
            $complaints->ticketresolvecomment = $complaintsWithStatus->ticketresolvecomment;
        }
        if($complaintsWithStatus->assigneestatus == 'NOT RESOLVED'){
            $complaints->assigneestatus = $complaintsWithStatus->assigneestatus;
            $complaints->ticketunresolvecomment = $complaintsWithStatus->ticketunresolvecomment;
        }
        if($complaintsWithStatus->assigneestatus == 'PENDING'){
            $complaints->assigneestatus = $complaintsWithStatus->assigneestatus;
            $complaints->ticketpendingreason = $complaintsWithStatus->ticketpendingreason;
            $complaints->ticketnextactionremark = $complaintsWithStatus->ticketnextactionremark;
        }

        $statusList = StatusMasterModel::where('statusfor', 'AS')->pluck('statusname','statuscode');

        return view('assignee.details',compact('complaints','statusList'));
    }

    public function edit($id)
    {
        $user = auth()->user();

        $complaints = new TicketAssignedModel();

        $complaintsWithStatus = TicketAssignedModel::where('id', $id)->first();

        $complaints->id = $complaintsWithStatus->id;
        $complaints->ticketno = $complaintsWithStatus->ticketno;

        if($complaintsWithStatus->assigneestatus == 'RESOLVED'){
            $complaints->assigneestatus = $complaintsWithStatus->assigneestatus;
            $complaints->ticketresolvecomment = $complaintsWithStatus->ticketresolvecomment;
        }
        if($complaints->assigneestatus == 'NOT RESOLVED'){
            $complaints->assigneestatus = $complaintsWithStatus->assigneestatus;
            $complaints->ticketunresolvecomment = $complaintsWithStatus->ticketunresolvecomment;
        }
        if($complaints->assigneestatus == 'PENDING'){
            $complaints->assigneestatus = $complaintsWithStatus->assigneestatus;
            $complaints->ticketpendingreason = $complaintsWithStatus->ticketpendingreason;
            $complaints->ticketnextactionremark = $complaintsWithStatus->ticketnextactionremark;
        }

        $statusList = StatusMasterModel::where('statusfor', 'AS')->pluck('statusname','statusname');

        return view('assignee.edit',compact('complaints','statusList'));
    }

    public function update(Request $request,$id)
    {
        $user = auth()->user();

        $ticketAssigned = TicketAssignedModel::where('ticketno', $request->ticketnumber)
            ->where('assigneecode', $user->assigneecode)
            ->first();

        if($request->complaintstatus == "RESOLVED"){
            $ticketAssigned->assigneestatus = $request->complaintstatus;
            $ticketAssigned->ticketresolvecomment = $request->resolvecomment;
            $ticketAssigned->updated_by = \Auth::id();
            $ticketAssigned->updated_at = Carbon::now(new \DateTimeZone('Asia/Kolkata'));

            $ticketnumber = ExistingUserComplaintLodging::find($request->ticketnumber);
            if($ticketnumber == null){
                $ticketnumber = NonExistingUserComplaintLodging::find($request->ticketnumber);
            }
            $ticketnumber->callenddate = Carbon::now(new \DateTimeZone('Asia/Kolkata'));
            $ticketnumber->complaintstatus = StatusMasterModel::where('statuscode', 'CP0003')->first()->statusname;
            $ticketnumber->save();

        }
        if($request->complaintstatus == "NOT RESOLVED"){
            $ticketAssigned->assigneestatus = $request->complaintstatus;
            $ticketAssigned->ticketunresolvecomment = $request->unresolvecomment;
            $ticketAssigned->updated_by = \Auth::id();
            $ticketAssigned->updated_at = Carbon::now(new \DateTimeZone('Asia/Kolkata'));
        }
        if($request->complaintstatus == "PENDING"){
            $ticketAssigned->assigneestatus = $request->complaintstatus;
            $ticketAssigned->ticketpendingreason = $request->pendingreason;
            $ticketAssigned->ticketnextactionremark = $request->nextactionremark;
            $ticketAssigned->updated_by = \Auth::id();
            $ticketAssigned->updated_at = Carbon::now(new \DateTimeZone('Asia/Kolkata'));
        }
        $ticketAssigned->update();
        return redirect('assigneecomplaints')->with('success-message',$ticketAssigned->ticketnumber.' feedback updated');

    }

    public function closecomplaint($id)
    {
        $complaintDetail = ExistingUserComplaintLodging::selectraw('tblexistingcustomercomplaintlodging.*,tblticketassigneedetails.id as ticketassigneedetailsid,tblticketassigneedetails.assigneestatus,tblticketassigneedetails.assigneestartdate,tblticketassigneedetails.assigneeenddate')
            ->Join('tblticketassigneedetails','tblticketassigneedetails.ticketno','=','tblexistingcustomercomplaintlodging.ticketno')
            ->where('tblexistingcustomercomplaintlodging.ticketno',$id)->get()->first();
        $contractno = $complaintDetail->subcategory;
        $callclosuredate =  Carbon::now(new \DateTimeZone('Asia/Kolkata'));
        $resolveddate = date("Y-m-d", strtotime($complaintDetail->callenddate));
         if($complaintDetail == null){
            $complaintDetail = NonExistingUserComplaintLodging::where('id',$id)->first();
         }
         $filedetails = AssigneeFilesModel::where('ticketassigneedetailsid',$complaintDetail->ticketassigneedetailsid)->get();
        return view('complaint.closecomplaint',compact('complaintDetail','id','filedetails','contractno','callclosuredate','resolveddate'));
    }

    public function closecomplaintupdate(Request $request, $id)
    {
        $complaintDetail = ExistingUserComplaintLodging::where('ticketno',$id)->get()->first();
        if($complaintDetail === null){
            $complaintDetail = NonExistingUserComplaintLodging::where('ticketno',$id)->first();
        }
        if ($complaintDetail !== null){
            $complaintDetail->certificatedate = $request->certificatedate;
            //$complaintDetail->callstartdate = $request->callstartdate;
//            $complaintDetail->callenddate = $request->callenddate;
            $complaintDetail->callclosuredate = $request->callclosuredate;
            $complaintDetail->closurecomment = $request->closurecomment;
            $complaintDetail->complaintstatus = StatusMasterModel::where('statuscode', 'CP0002')->first()->statusname;
            $complaintDetail->updated_by = \Auth::id();
            $complaintDetail->updated_at = Carbon::now(new \DateTimeZone('Asia/Kolkata'));
//            $complaintDetail->resolveddate = Carbon::now(new \DateTimeZone('Asia/Kolkata'));
            $complaintDetail->update();

            if($complaintDetail->update() == true)
            {
                $equipment = ServiceManagementModel::where('contractno',$complaintDetail->contractno)->get()->first();
                if($equipment !=null)
                {

                    $contractpaymentterms = ContractPaymentTermModel::where('contractno',$complaintDetail->contractno)->get()->first();
                    if($contractpaymentterms !=null)
                    {
                        if($contractpaymentterms->customeriniatedbilling == 'NO')
                        {
//                            $servicemanagementlist = ServiceManagementModel::where('contractno',$complaintDetail->contractno)->get();
//                            $count = count($servicemanagementlist);
//                            for($i=0; $i < $count; $i++)
//                            {
                            $servicemanagement = ServiceManagementModel::where('flagkey','1')->where('srmdate',null)->where('servicecertificatedate','=',null)->get()->first();
                            if($servicemanagement->serviceadate == $servicemanagement->paymentduedate)
                            {
                                $servicemanagement->srmdate = $request->certificatedate;
                                $servicemanagement->servicecertificatedate = $request->certificatedate;
                                $servicemanagement->save();
                            }
                            else
                            {
                                $servicemanagement->servicecertificatedate = $request->certificatedate;
                                $servicemanagement->save();
                            }
//                            }
                            $equipmentflagupdatelist = EquipmentMasterModel::where('contractno',$complaintDetail->contractno)->where('status','active')->get()->pluck('equipmentsrno');
                            $equipmentflagupdatecount = count($equipmentflagupdatelist);
                            for($i=0; $i < $equipmentflagupdatecount; $i++)
                            {
                                $equipmentflagupdate = EquipmentMasterModel::where('equipmentsrno',$equipmentflagupdatelist[$i])->where('contractno',$complaintDetail->contractno)->where('status','active')->get()->first();
                                $equipmentflagupdate->flagkey='0';
                                $equipmentflagupdate->save();
                            }
                        }
                    }
                }
            }
            $ticketno = ExistingUserComplaintLodging::where('ticketno',$id)->get()->pluck('id');
            $count = count($ticketno);
            for($i=0; $i < $count; $i++)
            {
                $ticketnumber = ExistingUserComplaintLodging::where('id',$ticketno[$i])->get()->first();
                $ticketnumber->certificatedate = $request->certificatedate;
                $ticketnumber->callclosuredate = $request->callclosuredate;
                $ticketnumber->closurecomment = $request->closurecomment;
                $ticketnumber->complaintstatus = StatusMasterModel::where('statuscode', 'CP0002')->first()->statusname;
                //$ticketnumber->callstartdate = Carbon::now(new \DateTimeZone('Asia/Kolkata'));
                $ticketnumber->save();
            }
            $user = ComplaintLodgingModel::find($request['ticketnumber']);
            if($user != null)
            {
                $user->complaintstatus = StatusMasterModel::where('statuscode', 'CP0010')->first()->statusname;
                $user->save();
            }

            $serviceLog = ServiceLogModel::where('ticketno','=',$id)->get()->first();
            if($serviceLog != null)
            {
                $serviceLog->ticketStatus = StatusMasterModel::where('statuscode', 'CP0002')->first()->statusname;
                $serviceLog->updated_at = Carbon::now(new \DateTimeZone('Asia/Kolkata'));
                $serviceLog->updated_by = \Auth::id();
                $serviceLog->save();

                $allTicketInServiceLog = ServiceLogModel::where('serviceManagementId','=',$serviceLog->serviceManagementId)->get();
                $serviceLogCount = count($allTicketInServiceLog);
                $isClosed = true;
                for($i=0; $i < $serviceLogCount; $i++) {
                    if($allTicketInServiceLog[$i]->ticketStatus != 'CLOSED')
                    {
                        $isClosed = false;
                    }
                }
                if($isClosed == true)
                {
                    $allTicketInExistingTable = ExistingUserComplaintLodging::where('complaintdate','=',$serviceLog->servicedate)
                        ->where('contractno','=',$serviceLog->contractno)
                        ->get();
                    $existingCount = count($allTicketInExistingTable);
                    $isClosedExisting = true;
                    for($j = 0; $j < $existingCount; $j++) {
                        if($allTicketInExistingTable[$j]->complaintstatus != 'CLOSED')
                        {
                            $isClosedExisting = false;
                        }
                    }
                    if($isClosedExisting == true) {
                        $service = ServiceManagementModel::where('id','=',$serviceLog->serviceManagementId)->get()->first();
                        $service->serviceStatus = StatusMasterModel::where('statuscode', 'CP0002')->first()->statusname;
                        $service->updated_at = Carbon::now(new \DateTimeZone('Asia/Kolkata'));
                        $service->updated_by = \Auth::id();
                        $service->save();
                    }
                }
            }
        }
        return redirect('getallstatusshowpage')->with('success-message',$complaintDetail->ticketno. ' complaint successfully closed.');

    }

}
