<?php


namespace App\Http\Controllers;


use App\Models\AdminCommentsModel;
use App\Models\AssigneeFilesModel;
use App\Models\ComplaintLodgingModel;
use App\Models\ComplaintTypeModel;
use App\Models\CustomersModel;
use App\Models\EquipmentMasterModel;
use App\Models\ExistingUserComplaintLodging;
use App\Models\IncrementMasterModel;
use App\Models\StatusMasterModel;
use App\Models\SubCategoryMasterModel;
use App\Models\TicketAssignedHistoryModel;
use App\Models\TicketAssignedModel;
use Carbon\Carbon;
use DateTimeZone;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class VendorController
{

    public function index() {
        $complaints = DB::select(DB::raw("SELECT t1.*,t2.assigneecode,t2.assigneestatus,t2.assigneestartdate,t3.assigneename,t4.customername FROM tblexistingcustomercomplaintlodging t1
                                            LEFT JOIN tblticketassigneedetails t2 ON t1.ticketno = t2.ticketno
                                            LEFT JOIN tblassigneemaster t3 ON t2.assigneecode = t3.assigneecode
                                            LEFT JOIN tblcustomermaster t4 ON t1.customercode = t4.customercode
                                            WHERE t1.complaintstatus = 'ASSIGNED' AND t3.employeeid IS NULL AND t3.isactive = '1' AND t1.complaintdescription != 'service'"));

        return View('vendor.index',compact('complaints'));
    }

    public function edit($id) {
        $data = ExistingUserComplaintLodging::where('id','=',$id)->get()->first();

        $equipmentdata =  EquipmentMasterModel::SelectRaw('tblequipmentdetails.*,tblbranchmaster.branchname,tblproductservicemaster.productservicename,tblcategorymaster.categoryname')
            ->join('tblbranchmaster','tblbranchmaster.branchcode','=','tblequipmentdetails.branchcode')
            ->join('tblproductservicemaster','tblproductservicemaster.productservicecode','=','tblequipmentdetails.productservicecode')
            ->join('tblcategorymaster','tblcategorymaster.categorycode','=','tblequipmentdetails.categorycode')
            ->where('tblequipmentdetails.customercode',$data->customercode)->where('status','Active')
            ->get();

        $equipmentcode = $data->productsrno_accountno;
        $workordercode = $data->workorderno;
        $customercode = CustomersModel::where('customercode','=',$data->customercode)->get()->first();
        $customersitecode =  $equipmentdata->where('branchcode','=',$data->branchcode)->pluck('branchname')->first();
        $productservicecode = $equipmentdata->where('productservicecode','=',$data->productservicecode)->pluck('productservicename')->first();
        $categorycode = $equipmentdata->where('categorycode','=',$data->categorycode)->pluck('categoryname')->first();
        $subcategorycode = SubCategoryMasterModel::where('subcategorycode','=',$data->subcategorycode)->pluck('subcategoryname')->first();
        $complainttype= ComplaintTypeModel::where('complaintname','!=','Sale')->get()->pluck('complaintname','complaintname');
        $complainttypecode = $data->typeofcall;
        $chargedcomplaint = ($data->chargedcomplaint != "0" ?  true  : false);

        return View('vendor.editvendorcomplaints',compact('data','equipmentdata','equipmentcode','workordercode','customercode',
            'customersitecode','productservicecode','categorycode','subcategorycode','complainttype','complainttypecode','chargedcomplaint'));
    }

    public function update(Request $request) {
        $model = ExistingUserComplaintLodging::where('id',$request->id)->get()->first();
        $model->complaintdescription = $request["complaintdescription"];
        $model->updated_at = Carbon::now(new DateTimeZone('Asia/Kolkata'));
        $model->updated_by = Auth::id();
        $model->update();
        return redirect('vendorindex')->with('success-message', 'Complaint edited successfully.');
    }

    public function addComments($ticketno) {
        return view('vendor.addcommentvendor',compact('ticketno'));
    }

    public function postComments(Request $request) {
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
            $commenttable->commentdate = Carbon::now(new DateTimeZone('Asia/Kolkata'));
        }

        $commenttable->created_by = $user->name;
        $commenttable->created_at = Carbon::now(new DateTimeZone('Asia/Kolkata'));
        $commenttable->save();

        return redirect('vendorindex')->with('flash_message', 'Comments Succesfully Added for'.$ticketno);
    }

     public function closeVendorComplaint($ticketno) {
        $complaints = ExistingUserComplaintLodging::where('ticketno','=',$ticketno)->get()->first();
        $assignee = TicketAssignedModel::where('ticketno','=',$ticketno)->get()->first();
        $assigneestartdate = isset($assignee->assigneestartdate) ? date("Y-m-d", strtotime($assignee->assigneestartdate)) : '';
        $assigneeenddate = isset($assignee->assigneeenddate) ? date("Y-m-d", strtotime($assignee->assigneeenddate)) : '';
         $statusList = StatusMasterModel::where('statusfor', 'AS')->pluck('statusname', 'statusname');
        return View('vendor.closevendorcomplaint',compact('complaints','assignee','assigneestartdate','assigneeenddate','statusList'));
     }

     public function submitVendorComplaint(Request $request,$ticketno) {
         $user = auth()->user();

         $ticketAssigned = TicketAssignedModel::where('ticketno', $ticketno)->get()->first();

         if ($request->complaintstatus == "RESOLVED") {
             $ticketAssigned->assigneestatus = $request->complaintstatus;
             $ticketAssigned->ticketresolvecomment = $request->resolvecomment;
             $ticketAssigned->assigneestartdate = $request->assigneestartdate;
             $ticketAssigned->assigneeenddate = $request->assigneeenddate;
             $ticketAssigned->assigneeenddate = $request->assigneeenddate;
             $ticketAssigned->updated_by = \Auth::id();
             $ticketAssigned->updated_at = Carbon::now(new DateTimeZone('Asia/Kolkata'));
         }
         if ($request->complaintstatus == "NOT RESOLVED") {
             $ticketAssigned->assigneestatus = $request->complaintstatus;
             $ticketAssigned->ticketunresolvecomment = $request->unresolvecomment;
             $ticketAssigned->assigneestartdate = $request->assigneestartdate;
             $ticketAssigned->assigneeenddate = $request->assigneeenddate;
//            $ticketAssigned->unresolvestatusddate = Carbon::now(new \DateTimeZone('Asia/Kolkata'));
             $ticketAssigned->updated_by = \Auth::id();
             $ticketAssigned->updated_at = Carbon::now(new DateTimeZone('Asia/Kolkata'));
         }
         if ($request->complaintstatus == "PENDING") {
             $ticketAssigned->assigneestatus = $request->complaintstatus;
             $ticketAssigned->ticketpendingreason = $request->pendingreason;
             $ticketAssigned->ticketnextactionremark = $request->nextactionremark;
             $ticketAssigned->assigneestartdate = $request->assigneestartdate;
             $ticketAssigned->assigneeenddate = $request->assigneeenddate;
             //           $ticketAssigned->pendingstatusdate = Carbon::now(new \DateTimeZone('Asia/Kolkata'));
             $ticketAssigned->updated_by = \Auth::id();
             $ticketAssigned->updated_at = Carbon::now(new DateTimeZone('Asia/Kolkata'));
         }
         $ticketAssigned->update();

         if($ticketAssigned->update() == true){
             $TicketAssignedHistoryModel = new TicketAssignedHistoryModel();
//            $TicketAssignedHistoryModel->id = Uuid::uuid1();
             $dynamiccode= $this->DynamicCode('HistoryID');
             $TicketAssignedHistoryModel->id =$dynamiccode['code'];
             $incrementid= $dynamiccode['incrementid'];

             $TicketAssignedHistoryModel->ticketno = $ticketAssigned->ticketno;
             $TicketAssignedHistoryModel->assigneecode = $ticketAssigned->assigneecode;
             $TicketAssignedHistoryModel->assigneestartdate = $request->assigneestartdate;
             $TicketAssignedHistoryModel->assigneeenddate = $request->assigneeenddate;
             $TicketAssignedHistoryModel->assigneestatus = $request->complaintstatus;
             $TicketAssignedHistoryModel->ticketpendingreason = $request->pendingreason;
             $TicketAssignedHistoryModel->ticketnextactionremark = $request->nextactionremark;
             $TicketAssignedHistoryModel->ticketresolvecomment = $request->resolvecomment;
             $TicketAssignedHistoryModel->ticketunresolvecomment = $request->unresolvecomment;
             $TicketAssignedHistoryModel->calldetails = $request->vendorTicketNo;
             $TicketAssignedHistoryModel->created_at = Carbon::now(new DateTimeZone('Asia/Kolkata'));
             $TicketAssignedHistoryModel->created_by = \Auth::id();
             $TicketAssignedHistoryModel->save();
             if ($TicketAssignedHistoryModel->save()== true)
             {
                 $id="HistoryID";
                 $modelincrement = IncrementMasterModel::find(IncrementMasterModel::where('incrementfor',$id)->first()->incrementid);
                 $modelincrement->incrementvalue = $incrementid;
                 $modelincrement->save();
             }
         }
         $collection = TicketAssignedModel::where('ticketno',$request['ticketnumber'])->get();
         $filtered = $collection->whereNotIn('assigneestatus', ['UnresolvedReassigned','RESOLVED','REASSIGNED','ReassignedResolved','ClosedByAdmin']);
         $count = count($filtered);
         if($count == 0){
             $id = ExistingUserComplaintLodging::where('ticketno',$request['ticketnumber'])->get()->pluck('id');
             $count = count($id);
             for ($i=0;$i < $count; $i++){
                 $ticketnumber = ExistingUserComplaintLodging::where('id',$id[$i])->get()->first();
                 $ticketnumber->callenddate = Carbon::now(new DateTimeZone('Asia/Kolkata'));
                 $ticketnumber->complaintstatus = StatusMasterModel::where('statuscode', 'CP0003')->first()->statusname;
                 $ticketnumber->save();
             }
         }
         $user = ComplaintLodgingModel::find($request['ticketnumber']);
         if($user != null)
         {
             $user->complaintstatus = $request->complaintstatus;
             $user->save();
         }
         $files = $request->file('file');
         if($request->hasFile('file'))
         {
             $count = count($files);
             for($i=0; $i < $count ; $i++)
             {
                 $product = new AssigneeFilesModel();
                 $product->ticketassigneedetailsid = $ticketAssigned->id;
                 $file = $request->file('file')[$i];
                 $string = $file->getClientOriginalName();
                 $fileName = str_replace(' ', '-', $string);
                 $fileExtension = $file->getClientMimeType();
                 $filesize = $file->getClientSize();
                 $product->filename = $fileName;
                 $product->fileextesion = $fileExtension;
                 $product->filesize = $filesize;
                 $folderpath  = 'uploads'.'/';
                 $file->move($folderpath , $fileName);
                 $product->fileurl = $folderpath;
                 $product->save();
             }
         }
        return redirect('vendorindex')->with('success-message', $ticketAssigned->ticketnumber . ' feedback updated');
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