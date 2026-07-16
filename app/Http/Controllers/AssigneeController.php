<?php

namespace App\Http\Controllers;

use App\Models\AssigneeMasterModel;
use App\Models\BranchMasterModel;
use App\Models\CategoryMasterModel;
use App\Models\CustomersModel;
use App\Models\EquipmentMasterModel;
use App\Models\IncrementMasterModel;
use App\Models\ProductServiceMasterModel;
use App\Models\SectorMasterModel;
use Auth;
use Carbon\Carbon;
use DateTimeZone;
use Exception;
use Illuminate\Http\Request;
use App\Models\StatusMasterModel;
use App\Models\TicketAssignedModel;
use App\Models\ExistingUserComplaintLodging;
use App\Models\ComplaintLodgingModel;
use App\Models\AssigneeFilesModel;
use App\Models\TicketAssignedHistoryModel;
use Ramsey\Uuid\Uuid;

class AssigneeController extends Controller
{
    public function dashboard()
    {
        $user = auth()->user();
        $complaints = TicketAssignedModel::where('assigneecode', $user->assigneecode)->get();
        $newassignedcomplaints = $complaints->where('assigneestatus', null)->count();
        $pendingcomplaints = $complaints->where('assigneestatus', 'PENDING')->count();
        $resolvedcomplaints = $complaints->where('assigneestatus', 'RESOLVED')->count();
        $notresolvedcomplaints = $complaints->where('assigneestatus', 'NOT RESOLVED')->count();
        return view('dashboard.assigneedashboard', compact('newassignedcomplaints', 'pendingcomplaints', 'resolvedcomplaints', 'notresolvedcomplaints'));
    }

    public function index()
    {
        try {
            $user = auth()->user();
            $assigneecode = trim($user->assigneecode);

            $assigneenewcomplaints = TicketAssignedModel::selectRaw('tblticketassigneedetails.*,tblexistingcustomercomplaintlodging.productsrno_accountno,tblexistingcustomercomplaintlodging.productsrno')
                ->Join('tblexistingcustomercomplaintlodging', 'tblexistingcustomercomplaintlodging.ticketno', '=', 'tblticketassigneedetails.ticketno')
                ->where('tblticketassigneedetails.assigneecode', $assigneecode)
                ->whereIn('assigneestatus',array('ASSIGNED','REASSIGNED'))
                ->get();

            $pendingsstatus = TicketAssignedModel::selectRaw('tblticketassigneedetails.*,tblexistingcustomercomplaintlodging.productsrno_accountno,tblexistingcustomercomplaintlodging.productsrno')
                ->leftJoin('tblexistingcustomercomplaintlodging', 'tblexistingcustomercomplaintlodging.ticketno', '=', 'tblticketassigneedetails.ticketno')
                ->where('assigneecode', $assigneecode)->where('assigneestatus','PENDING')
                ->get();

            $notresolvedcomplaints = TicketAssignedModel::selectRaw('tblticketassigneedetails.*,tblexistingcustomercomplaintlodging.productsrno_accountno,tblexistingcustomercomplaintlodging.productsrno')
                ->leftJoin('tblexistingcustomercomplaintlodging', 'tblexistingcustomercomplaintlodging.ticketno', '=', 'tblticketassigneedetails.ticketno')
                ->where('assigneecode', $assigneecode)
                ->where('assigneestatus','NOT RESOLVED')
                ->get();

            $resolvedcomplaints = TicketAssignedModel::selectRaw('tblticketassigneedetails.*,tblexistingcustomercomplaintlodging.productsrno_accountno,tblexistingcustomercomplaintlodging.productsrno,tblexistingcustomercomplaintlodging.complaintstatus')
                ->leftJoin('tblexistingcustomercomplaintlodging', 'tblexistingcustomercomplaintlodging.ticketno', '=', 'tblticketassigneedetails.ticketno')
                ->where('assigneecode', $assigneecode)
                ->whereIn('assigneestatus',array('ReassignedResolved','RESOLVED'))
                ->where('complaintstatus','!=','CLOSED')
                ->get();

            $closedComplaints = TicketAssignedModel::selectRaw('tblticketassigneedetails.*,tblexistingcustomercomplaintlodging.productsrno_accountno,tblexistingcustomercomplaintlodging.productsrno,tblexistingcustomercomplaintlodging.complaintstatus')
                ->join('tblexistingcustomercomplaintlodging', 'tblexistingcustomercomplaintlodging.ticketno', '=', 'tblticketassigneedetails.ticketno')
                ->where('assigneecode', $assigneecode)
                ->where('complaintstatus','=','CLOSED')
                ->get();

            return view('assignee.index', compact('assigneenewcomplaints', 'pendingsstatus', 'notresolvedcomplaints', 'resolvedcomplaints','closedComplaints'));
        } catch (Exception $ex) {

        }
    }

    public function show($id)
    {
        $complaints = new TicketAssignedModel();
        $complaintsWithStatus = TicketAssignedModel::where('id', $id)->first();
        $complaints->ticketno = $complaintsWithStatus->ticketno;
        $customer = ExistingUserComplaintLodging::where('ticketno', $complaintsWithStatus->ticketno)->get()->first();
        $customerdetails = CustomersModel::where('customercode', $customer->customercode)->get()->first();
        $product = ProductServiceMasterModel::where('productservicecode', $customer->productservicecode)->get()->first();
        $equipment = EquipmentMasterModel::where('equipmentsrno', $customer->productsrno_accountno)->get()->first();
        $branch = BranchMasterModel::where('branchcode', $customer->branchcode)->get()->first();
        if($branch !=null)
        {
            $branch = $branch->branchname;
         }else
        {
            $branch = "NA";
        }

//       return $customeralldetails =collect($customerdetails,$product,$equipment,$branch);

        if ($complaintsWithStatus->assigneestatus == 'RESOLVED') {
            $complaints->assigneestatus = $complaintsWithStatus->assigneestatus;
            $complaints->ticketresolvecomment = $complaintsWithStatus->ticketresolvecomment;
        }
        if ($complaintsWithStatus->assigneestatus == 'NOT RESOLVED') {
            $complaints->assigneestatus = $complaintsWithStatus->assigneestatus;
            $complaints->ticketunresolvecomment = $complaintsWithStatus->ticketunresolvecomment;
        }
        if ($complaintsWithStatus->assigneestatus == 'PENDING') {
            $complaints->assigneestatus = $complaintsWithStatus->assigneestatus;
            $complaints->ticketpendingreason = $complaintsWithStatus->ticketpendingreason;
            $complaints->ticketnextactionremark = $complaintsWithStatus->ticketnextactionremark;
        }
        if($complaintsWithStatus->assigneestatus == 'ASSIGNED') {
            $complaints->assigneestatus = $complaintsWithStatus->assigneestatus;
            $complaints->ticketresolvecomment = $complaintsWithStatus->ticketresolvecomment;
        }

        $statusList = StatusMasterModel::where('statusfor', 'AS')->pluck('statusname', 'statuscode');
        $complaintDetail = ExistingUserComplaintLodging::selectraw('tblticketassigneedetails.id,tblticketassigneedetails.assigneestatus,tblticketassigneedetails.assigneestartdate,tblticketassigneedetails.assigneeenddate')
            ->Join('tblticketassigneedetails','tblticketassigneedetails.ticketno','=','tblexistingcustomercomplaintlodging.ticketno')
            ->where('tblticketassigneedetails.ticketno',$complaintsWithStatus->ticketno)->get()->first();
        $filedetails = AssigneeFilesModel::where('ticketassigneedetailsid',$complaintDetail->id)->get();


        return view('assignee.details', compact('complaints', 'statusList', 'customerdetails', 'product', 'equipment', 'branch','filedetails','customer'));
    }

    public function showFile($id)
    {
        $filedetails = AssigneeFilesModel::where('id', $id)->get()->first();
        return view('complaint.fileView',compact('filedetails'));
    }

    public function edit($id)
    {
        $user = auth()->user()->id;
        $complaints = new TicketAssignedModel();
        $complaintsWithStatus = TicketAssignedModel::where('id', $id)->first();

        $complaints->id = $complaintsWithStatus->id;
        $complaints->ticketno = $complaintsWithStatus->ticketno;
        $status = $complaintsWithStatus->assigneestatus;
        $assigneestartdate = isset($complaintsWithStatus->assigneestartdate) ? date("Y-m-d", strtotime($complaintsWithStatus->assigneestartdate)) : '';
        $assigneeenddate = isset($complaintsWithStatus->assigneeenddate) ? date("Y-m-d", strtotime($complaintsWithStatus->assigneeenddate)) : '';

        if ($complaintsWithStatus->assigneestatus == 'RESOLVED') {
            $complaints->assigneestatus = $complaintsWithStatus->assigneestatus;
            $complaints->ticketresolvecomment = $complaintsWithStatus->ticketresolvecomment;
            $complaints->assigneestartdate = $complaintsWithStatus->assigneestartdate;
            $complaints->assigneeenddate = $complaintsWithStatus->assigneeenddate;

        }
        if ($complaintsWithStatus->assigneestatus == 'NOT RESOLVED') {
            $complaints->assigneestatus = $complaintsWithStatus->assigneestatus;
            $complaints->ticketunresolvecomment = $complaintsWithStatus->ticketunresolvecomment;
            $complaints->assigneestartdate = $complaintsWithStatus->assigneestartdate;
            $complaints->assigneeenddate = $complaintsWithStatus->assigneeenddate;
        }
        if ($complaintsWithStatus->assigneestatus == 'PENDING') {
            $complaints->assigneestatus = $complaintsWithStatus->assigneestatus;
            $complaints->ticketpendingreason = $complaintsWithStatus->ticketpendingreason;
            $complaints->ticketnextactionremark = $complaintsWithStatus->ticketnextactionremark;
            $complaints->assigneestartdate = $complaintsWithStatus->assigneestartdate;
            $complaints->assigneeenddate = $complaintsWithStatus->assigneeenddate;
        }

        if($complaintsWithStatus->assigneestatus == "REASSIGNED")
        {
            $statusList = StatusMasterModel::where('statusfor', 'AS')->pluck('statusname', 'statusname');
        }
        else
        {
            $statusList = StatusMasterModel::where('statusfor', 'AS')->pluck('statusname', 'statusname');
        }

        $complaintType = ExistingUserComplaintLodging::where('ticketno',$complaintsWithStatus->ticketno)->get();
        if(count($complaintType) > 1)
        {
            $description = ExistingUserComplaintLodging::where('ticketno',$complaintsWithStatus->ticketno)
                ->distinct()->pluck('complaintdescription')->first();
        }
        else{
            $description = $complaintType->first()->complaintdescription;
        }
        $equipment = ExistingUserComplaintLodging::where('ticketno',$complaintsWithStatus->ticketno)
            ->where('flag_key',0)
            ->get();

        return view('assignee.edit', compact('complaints', 'statusList', 'assigneestartdate', 'assigneeenddate','status','user','description','equipment','complaintType'));
    }

    public function update(Request $request, $id)
    {
        $user = auth()->user();

            $ticketAssigned = TicketAssignedModel::where('id', $id)->first();
        if($request->description == 'service')
        {
            if($request->complaintstatus1 == "PENDING" || $request->complaintstatus1 == "RESOLVED")
            {
                $explode = $request->checkvalues;
                $checkvalues = explode(',',$explode[0]);
                $count = count($checkvalues);
                for ($i = 0; $i < $count; $i++) {
                    $existingcomplaintid = ExistingUserComplaintLodging::where('productsrno_accountno', $checkvalues[$i])->where('ticketno',$ticketAssigned->ticketno)->get()->first();
                    $existingcomplaintid->flag_key = '1';
                    $existingcomplaintid->save();
                }
                if ($request->complaintstatus1 == "PENDING") {
                    $ticketAssigned->assigneestatus = $request->complaintstatus1;
                    $ticketAssigned->ticketpendingreason = $request->pendingreason;
                    $ticketAssigned->ticketnextactionremark = $request->nextactionremark;
                    $ticketAssigned->assigneestartdate = $request->assigneestartdate;
                    $ticketAssigned->assigneeenddate = $request->assigneeenddate;
                    //           $ticketAssigned->pendingstatusdate = Carbon::now(new \DateTimeZone('Asia/Kolkata'));
                    $ticketAssigned->updated_by = Auth::id();
                    $ticketAssigned->updated_at = Carbon::now(new DateTimeZone('Asia/Kolkata'));
                }
                if ($request->complaintstatus1 == "RESOLVED") {
                    $ticketAssigned->assigneestatus = $request->complaintstatus1;
                    $ticketAssigned->ticketresolvecomment = $request->resolvecomment;
                    $ticketAssigned->assigneestartdate = $request->assigneestartdate;
                    $ticketAssigned->assigneeenddate = $request->assigneeenddate;
                    $ticketAssigned->assigneeenddate = $request->assigneeenddate;
                    $ticketAssigned->updated_by = Auth::id();
                    $ticketAssigned->updated_at = Carbon::now(new DateTimeZone('Asia/Kolkata'));
                }
            }
        }
            if ($request->complaintstatus == "ReassignedResolved") {
                $ticketAssigned->assigneestatus = $request->complaintstatus;
                $ticketAssigned->ticketresolvecomment = $request->resolvecomment;
                $ticketAssigned->assigneestartdate = $request->assigneestartdate;
                $ticketAssigned->assigneeenddate = $request->assigneeenddate;
                $ticketAssigned->updated_by = Auth::id();
                $ticketAssigned->updated_at = Carbon::now(new DateTimeZone('Asia/Kolkata'));
            }
            if ($request->complaintstatus == "RESOLVED" && $request->description != 'service') {
                $ticketAssigned->assigneestatus = $request->complaintstatus;
                $ticketAssigned->ticketresolvecomment = $request->resolvecomment;
                $ticketAssigned->assigneestartdate = $request->assigneestartdate;
                $ticketAssigned->assigneeenddate = $request->assigneeenddate;
                $ticketAssigned->assigneeenddate = $request->assigneeenddate;
                $ticketAssigned->updated_by = Auth::id();
                $ticketAssigned->updated_at = Carbon::now(new DateTimeZone('Asia/Kolkata'));
            }
            if ($request->complaintstatus == "NOT RESOLVED") {
                $ticketAssigned->assigneestatus = $request->complaintstatus;
                $ticketAssigned->ticketunresolvecomment = $request->unresolvecomment;
                $ticketAssigned->assigneestartdate = $request->assigneestartdate;
                $ticketAssigned->assigneeenddate = $request->assigneeenddate;
//            $ticketAssigned->unresolvestatusddate = Carbon::now(new \DateTimeZone('Asia/Kolkata'));
                $ticketAssigned->updated_by = Auth::id();
                $ticketAssigned->updated_at = Carbon::now(new DateTimeZone('Asia/Kolkata'));
            }
            if ($request->complaintstatus == "PENDING" && $request->description != 'service') {
                $ticketAssigned->assigneestatus = $request->complaintstatus;
                $ticketAssigned->ticketpendingreason = $request->pendingreason;
                $ticketAssigned->ticketnextactionremark = $request->nextactionremark;
                $ticketAssigned->assigneestartdate = $request->assigneestartdate;
                $ticketAssigned->assigneeenddate = $request->assigneeenddate;
                //           $ticketAssigned->pendingstatusdate = Carbon::now(new \DateTimeZone('Asia/Kolkata'));
                $ticketAssigned->updated_by = Auth::id();
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
            if($request->description == 'service')
            {
                $TicketAssignedHistoryModel->assigneestatus = $request->complaintstatus1;
            }
            else{
                $TicketAssignedHistoryModel->assigneestatus = $request->complaintstatus;
            }
            $TicketAssignedHistoryModel->ticketpendingreason = $request->pendingreason;
            $TicketAssignedHistoryModel->ticketnextactionremark = $request->nextactionremark;
            $TicketAssignedHistoryModel->ticketresolvecomment = $request->resolvecomment;
            $TicketAssignedHistoryModel->ticketunresolvecomment = $request->unresolvecomment;
            $TicketAssignedHistoryModel->created_at = Carbon::now(new DateTimeZone('Asia/Kolkata'));
            $TicketAssignedHistoryModel->created_by = Auth::id();
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
        return redirect('assigneecomplaints')->with('success-message', $ticketAssigned->ticketnumber . ' feedback updated');
    }

    public function getassigneenewcomplaints(Request $request)
    {
        $user = auth()->user();
        $complaints = TicketAssignedModel::where('assigneecode', $user->assigneecode)
            ->where('assigneestatus', null)
            ->get();

        $columns = array(
            0 => 'id',
            1 => 'ticketno',
            2 => 'status',
            3 => 'startdate',
            4 => 'enddate',
            5 => 'options'
        );

        $totalData = $complaints->count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $assignedcomplaints = TicketAssignedModel::where('assigneecode', $user->assigneecode)
                ->where('assigneestatus', null)
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $posts = $assignedcomplaints;
//                ->where('assigneecode', $user->assigneecode)->where('assigneestatus', null);
        } else {
            $search = $request->input('search.value');

            $assignedcomplaints = TicketAssignedModel::where('assigneecode', $user->assigneecode)
                ->where('assigneestatus', null)
                ->where('ticketno', 'LIKE', "%{$search}%")
                ->orWhere('assigneestatus', 'LIKE', "%{$search}%")
                ->orWhere('assigneestartdate', 'LIKE', "%{$search}%")
                ->orWhere('assigneeenddate', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $assignedcomplaints = $assignedcomplaints->where('assigneecode', $user->assigneecode)->where('assigneestatus', null);
            $posts = $assignedcomplaints;
        }

        $data = array();
        if (!empty($posts)) {
            $count = 1;
            foreach ($posts as $post) {
                $nestedData['id'] = $count++;
                $nestedData['ticketno'] = $post->ticketno;
                $nestedData['status'] = $post->assigneestatus;
                $nestedData['startdate'] = isset($post->assigneestartdate) ? date("d-m-Y", strtotime($post->assigneestartdate)) : '';
                $nestedData['enddate'] = isset($post->assigneeenddate) ? date("d-m-Y", strtotime($post->assigneeenddate)) : '';
                $nestedData['options'] = " <a href=\"assigneecomplaintsview/$post->id\" style=\"margin-right: 3px;\">view</a> |
                                <a href=\"manageassigneecomplaint/$post->id\" style=\"margin-right: 3px;\">edit</a>";
                $data[] = $nestedData;
            }
        }

        $json_data = array(
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );

        echo json_encode($json_data);
    }

    public function getassigneenotresolvedcomplaints(Request $request)
    {
        $user = auth()->user();
        $complaints = TicketAssignedModel::where('assigneecode', $user->assigneecode)
            ->where('assigneestatus', 'NOT RESOLVED')
            ->get();

        $columns = array(
            0 => 'id',
            1 => 'ticketno',
            2 => 'status',
            3 => 'startdate',
            4 => 'enddate',
            5 => 'options'
        );

        $totalData = $complaints->count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $assignedcomplaints = TicketAssignedModel::where('assigneecode', $user->assigneecode)
                ->where('assigneestatus', 'NOT RESOLVED')
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $posts = $assignedcomplaints;
        } else {
            $search = $request->input('search.value');

            $assignedcomplaints = TicketAssignedModel::where('assigneecode', $user->assigneecode)
                ->where('assigneestatus', 'NOT RESOLVED')
                ->where('ticketno', 'LIKE', "%{$search}%")
                ->orWhere('assigneestatus', 'LIKE', "%{$search}%")
                ->orWhere('assigneestartdate', 'LIKE', "%{$search}%")
                ->orWhere('assigneeenddate', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $assignedcomplaints = $assignedcomplaints->where('assigneecode', $user->assigneecode)->where('assigneestatus', 'NOT RESOLVED');
            $posts = $assignedcomplaints;
        }

        $data = array();
        if (!empty($posts)) {
            $count = 1;
            foreach ($posts as $post) {
                $nestedData['id'] = $count++;
                $nestedData['ticketno'] = $post->ticketno;
                $nestedData['status'] = $post->assigneestatus;
                $nestedData['startdate'] = isset($post->assigneestartdate) ? date("d-m-Y", strtotime($post->assigneestartdate)) : '';
                $nestedData['enddate'] = isset($post->assigneeenddate) ? date("d-m-Y", strtotime($post->assigneeenddate)) : '';
//                $nestedData['options'] = " <a href=\"assigneecomplaintsview/$post->id\" style=\"margin-right: 3px;\">view</a> |
//                                <a href=\"manageassigneecomplaint/$post->id\" style=\"margin-right: 3px;\">edit</a>";
                $nestedData['options'] = " <a href=\"assigneecomplaintsview/$post->id\" style=\"margin-right: 3px;\">view</a>";
//                                <a href=\"manageassigneecomplaint/$post->id\" style=\"margin-right: 3px;\">edit</a>";
                $data[] = $nestedData;
            }
        }

        $json_data = array(
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );

        echo json_encode($json_data);
    }

    public function getassigneeresolvedcomplaints(Request $request)
    {
        $user = auth()->user();
        $complaints = TicketAssignedModel::where('assigneecode', $user->assigneecode)
            ->where('assigneestatus', 'RESOLVED')
            ->get();

        $columns = array(
            0 => 'id',
            1 => 'ticketno',
            2 => 'status',
            3 => 'startdate',
            4 => 'enddate',
            5 => 'options'
        );

        $totalData = $complaints->count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $assignedcomplaints = TicketAssignedModel::where('assigneecode', $user->assigneecode)
                ->where('assigneestatus', 'RESOLVED')
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $assignedcomplaints = $assignedcomplaints->where('assigneecode', $user->assigneecode)->where('assigneestatus', 'RESOLVED');
            $posts = $assignedcomplaints;
        } else {
            $search = $request->input('search.value');

            $assignedcomplaints = TicketAssignedModel::where('assigneecode', $user->assigneecode)
                ->where('assigneestatus', 'RESOLVED')
                ->where('ticketno', 'LIKE', "%{$search}%")
                ->orWhere('assigneestatus', 'LIKE', "%{$search}%")
                ->orWhere('assigneestartdate', 'LIKE', "%{$search}%")
                ->orWhere('assigneeenddate', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $assignedcomplaints = $assignedcomplaints->where('assigneecode', $user->assigneecode)->where('assigneestatus', 'RESOLVED');
            $posts = $assignedcomplaints;
        }

        $data = array();
        if (!empty($posts)) {
            $count = 1;
            foreach ($posts as $post) {
                $nestedData['id'] = $count++;
                $nestedData['ticketno'] = $post->ticketno;
                $nestedData['status'] = $post->assigneestatus;
                $nestedData['startdate'] = isset($post->assigneestartdate) ? date("d-m-Y", strtotime($post->assigneestartdate)) : '';
                $nestedData['enddate'] = isset($post->assigneeenddate) ? date("d-m-Y", strtotime($post->assigneeenddate)) : '';
                $nestedData['options'] = " <a href=\"assigneecomplaintsview/$post->id\" style=\"margin-right: 3px;\">view</a>";
//                                <a href=\"manageassigneecomplaint/$post->id\" style=\"margin-right: 3px;\">edit</a>";
                $data[] = $nestedData;
            }
        }

        $json_data = array(
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );

        echo json_encode($json_data);
    }

    public function getpendingcomplaints(Request $request)
    {
        $user = auth()->user();
        $complaints = TicketAssignedModel::where('assigneecode', $user->assigneecode)
            ->where('assigneestatus', 'PENDING')
            ->get();

        $columns = array(
            0 => 'id',
            1 => 'ticketno',
            2 => 'status',
            3 => 'startdate',
            4 => 'enddate',
            5 => 'options'
        );

        $totalData = $complaints->count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $assignedcomplaints = TicketAssignedModel::where('assigneecode', $user->assigneecode)
                ->where('assigneestatus', 'PENDING')
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $assignedcomplaints = $assignedcomplaints->where('assigneecode', $user->assigneecode)->where('assigneestatus', 'PENDING');
            $posts = $assignedcomplaints;
        } else {
            $search = $request->input('search.value');

            $assignedcomplaints = TicketAssignedModel::where('assigneecode', $user->assigneecode)
                ->where('assigneestatus', 'PENDING')
                ->where('ticketno', 'LIKE', "%{$search}%")
                ->orWhere('assigneestatus', 'LIKE', "%{$search}%")
                ->orWhere('assigneestartdate', 'LIKE', "%{$search}%")
                ->orWhere('assigneeenddate', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $assignedcomplaints = $assignedcomplaints->where('assigneecode', $user->assigneecode)->where('assigneestatus', 'PENDING');
            $posts = $assignedcomplaints;
        }

        $data = array();
        if (!empty($posts)) {
            $count = 1;
            foreach ($posts as $post) {
                $nestedData['id'] = $count++;
                $nestedData['ticketno'] = $post->ticketno;
                $nestedData['status'] = $post->assigneestatus;
                $nestedData['startdate'] = isset($post->assigneestartdate) ? date("d-m-Y", strtotime($post->assigneestartdate)) : '';
                $nestedData['enddate'] = isset($post->assigneeenddate) ? date("d-m-Y", strtotime($post->assigneeenddate)) : '';
                $nestedData['options'] = " <a href=\"assigneecomplaintsview/$post->id\" style=\"margin-right: 3px;\">view</a> |
                                <a href=\"manageassigneecomplaint/$post->id\" style=\"margin-right: 3px;\">edit</a>";
                $data[] = $nestedData;
            }
        }

        $json_data = array(
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );

        echo json_encode($json_data);
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
