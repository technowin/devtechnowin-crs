<?php


namespace App\Http\Controllers;

use App\Models\AssigneeMasterModel;
use App\Models\IncrementMasterModel;
use App\Models\InwardOutwardModel;
use App\Models\BranchMasterModel;
use App\Models\ExistingUserComplaintLodging;
use App\Models\TicketAssignedModel;
use Carbon\Carbon;
use DateTimeZone;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;

class InwardOutwardController
{
    public function inwardindex()
    {
        $inward = InwardOutwardModel::where('status','=','INWARD')->get();
        return View('inwardoutward.inwardindex',compact('inward'));
    }

    public function addinward()
    {
        $tickets = ExistingUserComplaintLodging::selectRaw('tblexistingcustomercomplaintlodging.*,tblticketassigneedetails.*')
                    ->leftjoin('tblticketassigneedetails','tblexistingcustomercomplaintlodging.ticketno','=','tblticketassigneedetails.ticketno')
                    ->where('tblexistingcustomercomplaintlodging.complaintstatus','=','ASSIGNED')
                    ->where('tblticketassigneedetails.assigneestatus','=','PENDING')
                    ->pluck('ticketno','ticketno');
        return View('inwardoutward.addinward',compact('tickets'));
    }

    public function saveinward(Request $request)
    {
        $user = auth()->user();
        $d = Carbon::now(new DateTimeZone('Asia/Kolkata'));
        $date = explode(" ",$d);
        $date1 = explode("-",$date[0]);
        $Year = $date1[0];
        $Month = $date1[1];
        $day = $date1[2];
        $dynamiccode= $this->DynamicCode('InwardId');
        $id =$dynamiccode['code'];
        $incrementid= $dynamiccode['incrementid'];
        $inwardno = "IN/".$day.$Month.$Year.'/'.$id;
        $inward = new InwardOutwardModel();
        $inward->ticketno = $request->ticketno;
        $inward->customercode = $request->customercode;
        $inward->branchcode = $request->branchcode;
        $inward->callerName = $request->callername;
        $inward->equipmentsrno = $request->equipmentsrno;
        $inward->productsrno = $request->productsrno;
        $inward->inwardProductDetails = $request->details;
        $inward->assigneecode = $request->assigneecode;
        $inward->status = 'INWARD';
        $inward->inwardno = $inwardno;
        $inward->inwardDate = Carbon::now(new DateTimeZone('Asia/Kolkata'));
        $inward->inwardComment = $request->comment;
        $inward->created_at = Carbon::now(new DateTimeZone('Asia/Kolkata'));
        $inward->created_by = $user->name;
        $inward->save();
        if($inward->save() == true)
        {
            $id="InwardId";
            $modelincrement = IncrementMasterModel::find(IncrementMasterModel::where('incrementfor',$id)->first()->incrementid);
            $modelincrement->incrementvalue = $incrementid;
            $modelincrement->save();
        }
        return redirect('inwardindex')->with('flash_message', 'Inward details Successfully Added. Inward No. = '.$inwardno);
    }

    public function editinward($ticketno,$id)
    {
        $editinward = InwardOutwardModel::where('id','=',$id)->where('ticketno','=',$ticketno)->get()->first();
        return View('inwardoutward.editinward',compact('editinward'));
    }

    public function updateinward(Request $request)
    {
        $user = auth()->user();
        $updateinward = InwardOutwardModel::where('ticketno','=',$request->ticketno)
                            ->where('inwardno','=',$request->inwardno)->get()->first();
        $updateinward->callerName = $request->callername;
        $updateinward->inwardProductDetails = $request->details;
        $updateinward->inwardComment = $request->comment;
        $updateinward->updated_at = Carbon::now(new DateTimeZone('Asia/Kolkata'));
        $updateinward->updated_by = $user->name;
        $updateinward->save();
        return redirect('inwardindex')->with('flash_message', $request->inwardno.' Edited succesfully.');
    }

    public function outwardindex()
    {
        $outward = InwardOutwardModel::where('inwardno','!=',null)->get();
        return View('inwardoutward.outwardindex',compact('outward'));
    }

    public function addoutward($ticketno,$id)
    {
        $outward = InwardOutwardModel::where('id','=',$id)->where('ticketno','=',$ticketno)->get()->first();
        $assigneelist = AssigneeMasterModel::where('isactive',1)->pluck('assigneename', 'assigneecode');
        return View('inwardoutward.addoutward',compact('outward','assigneelist'));
    }

    public function saveoutward(Request $request)
    {
        $user = auth()->user();
        $d = Carbon::now(new DateTimeZone('Asia/Kolkata'));
        $date = explode(" ",$d);
        $date1 = explode("-",$date[0]);
        $Year = $date1[0];
        $Month = $date1[1];
        $day = $date1[2];
        $dynamiccode= $this->DynamicCode('OutwardId');
        $id =$dynamiccode['code'];
        $incrementid= $dynamiccode['incrementid'];
        $outwardNo = "OUT/".$day.$Month.$Year.'/'.$id;
        $outward = InwardOutwardModel::where('id','=',$request->id)->where('ticketno','=',$request->ticketno)->get()->first();
        $outward->outwardno = $outwardNo;
        $outward->outwardProductDetails = $request->details;
        $outward->outwardQuantity = $request->quantity;
        $outward->outwardComment = $request->comment;
        $outward->outwardAssigneeCode = $request->assignee;
        $outward->status = "OUTWARD";
        $outward->outwardDate = Carbon::now(new DateTimeZone('Asia/Kolkata'));
        $outward->updated_at = Carbon::now(new DateTimeZone('Asia/Kolkata'));
        $outward->updated_by = $user->name;
        $outward->save();
        if($outward->save() == true)
        {
            $id="OutwardId";
            $modelincrement = IncrementMasterModel::find(IncrementMasterModel::where('incrementfor',$id)->first()->incrementid);
            $modelincrement->incrementvalue = $incrementid;
            $modelincrement->save();
        }
        return redirect('outwardindex')->with('flash_message', 'Outward Details Succesfully Added. Outward No. = '.$outwardNo);
    }

    public function generatechallan($ticketno,$id)
    {
        $user = auth()->user();
        $d = Carbon::now(new DateTimeZone('Asia/Kolkata'));
        $date = explode(" ",$d);
        $date1 = explode("-",$date[0]);
        $Year = $date1[0];
        $Month = $date1[1];
        $day = $date1[2];
        $dynamiccode= $this->DynamicCode('ChallanId');
        $id1 =$dynamiccode['code'];
        $incrementid= $dynamiccode['incrementid'];
        $challanNo = "CHLN/".$day.$Month.$Year.'/'.$id1;
        $challan = InwardOutwardModel::where('id','=',$id)->where('ticketno','=',$ticketno)->get()->first();
        $challan->status = "CHALLAN GENERATED";
        $challan->challanNo = $challanNo;
        $challan->challanDate = Carbon::now(new DateTimeZone('Asia/Kolkata'));
        $challan->updated_at = Carbon::now(new DateTimeZone('Asia/Kolkata'));
        $challan->updated_by = $user->name;
        $challan->save();
        $challanId = $id;
        if($challan->save() == true)
        {
            $id="ChallanId";
            $modelincrement = IncrementMasterModel::find(IncrementMasterModel::where('incrementfor',$id)->first()->incrementid);
            $modelincrement->incrementvalue = $incrementid;
            $modelincrement->save();
        }

        $challanData = InwardOutwardModel::where('id','=',$challanId)->where('ticketno','=',$ticketno)->get()->first();
        $date = Carbon::parse($challanData->challanDate);
        return View('inwardoutward.generatechallan',compact('challanData','date'));
    }

    public function downloadChallan(Request $request)
    {
        $challanData = InwardOutwardModel::where('id','=', $request->id)->where('ticketno','=',$request->ticketno)->get()->first();
        $date = Carbon::parse($challanData->challanDate);
        $pdf = PDF::loadView('inwardoutward.challanpdf',compact('challanData','date'));
        return $pdf->download($challanData->challanNo.'.pdf');
        return redirect('outwardindex');
    }

    public function challandetails($ticketno,$id)
    {
        $challanData = InwardOutwardModel::where('id','=',$id)->where('ticketno','=',$ticketno)->get()->first();
        $date = Carbon::parse($challanData->challanDate);
        return View('inwardoutward.generatechallan',compact('challanData','date'));
    }

    public function viewdetails($ticketno,$id)
    {
        $details = InwardOutwardModel::where('id','=',$id)->where('ticketno','=',$ticketno)->get()->first();
        return View('inwardoutward.viewdetails',compact('details'));
    }

    public function getticketdetails($ticket)
    {
        $ticketno = ExistingUserComplaintLodging::where('ticketno','=',$ticket)->get()->first();
        $assigneecode = TicketAssignedModel::where('ticketno','=',$ticket)->get()->first();
        $assignee = $assigneecode->assignee->assigneename;
        $customername = $ticketno->customers->customername;
        if($ticketno->branchcode != null)
        {
            $branchname = $ticketno->branch->branchname;
        }
        else{
            $branchname = BranchMasterModel::where('customercode','=',$ticketno->customercode)->pluck('branchnname');
        }

        return json_encode(array('ticketno' => $ticketno,'customername' => $customername,'branchname' => $branchname,'assignee'=>$assignee,'assigneecode'=>$assigneecode));
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