<?php

namespace App\Http\Controllers;

use App\User;
use Auth;
use Carbon\Carbon;
use DateTimeZone;
use Exception;
use Ramsey\Uuid\Uuid;
use Illuminate\Http\Request;
use App\Models\CustomersModel;
use App\Models\StatusMasterModel;
use App\Models\ComplaintLodgingModel;
use App\Models\ProductServiceMasterModel;
use App\Models\ExistingUserComplaintLodging;
use App\Models\NonExistingUserComplaintLodging;

class ComplaintController extends Controller
{
    public function complaints(Request $request)//user complaint index.
    {
//        $request->user()->authorizeRoles(['user']);
//
//        $currentUserId = auth()->user()->id;
//
//        return $roles = User::find(Auth::id())->roles;
//
//        $complaints = ComplaintLodgingModel::where('created_by', Auth::id())->get();

//        return view('complaint.indexUserComplaint', compact('complaints'));
        return view('complaint.indexUserComplaint');
    }

    public function showComplaints(Request $request,$id)
    {
        $request->user()->authorizeRoles(['admin','user']);

        $complaints = ComplaintLodgingModel::where('id', $id)->first();

        return view('complaint.detailUserComplaint', compact('complaints'));
    }

    public function createNewComplaint(Request $request)
    {
        if (Auth::guest()){

            $productService = ProductServiceMasterModel::pluck('productservicename', 'productservicecode')->all();

            return view('complaint.createGuestNewComplaint', compact('productService'));

        }else{

            $request->user()->authorizeRoles(['admin','user']);

            if(auth()->user()->hasRole('admin')){

                $customers = CustomersModel::pluck('customername', 'customercode')->all();

                $productService = ProductServiceMasterModel::pluck('productservicename', 'productservicecode')->all();

                return view('complaint.createAdminNewComplaint', compact('productService','customers'));
            }
            if(auth()->user()->hasRole('user')){

                $customers = CustomersModel::pluck('customername', 'customercode')->all();

                $productService = ProductServiceMasterModel::pluck('productservicename', 'productservicecode')->all();

                return view('complaint.createUserNewComplaint', compact('productService','customers'));
            }
        }
    }

    public function storeNewComplaint(Request $request)
    {
        $request->user()->authorizeRoles(['admin','user']);

        if(auth()->user()->hasRole('admin')){
            return $this->storeNewAdminComplaint($request);
        }
        if(auth()->user()->hasRole('user')){
            return $this->storeNewUserComplaint($request);
        }
        if (Auth::guest()){
            return $this->storeNewGuestComplaint($request);
        }
    }

    public function storeNewAdminComplaint(Request $request)
    {

        try
        {
            $customerName = $request->customers;
            $customerSite = $request->customersite;
            $productSerialNumber = $request->productsrno_accountno;

            if ($customerName === null && $customerSite === null && $productSerialNumber === null){
                //insert into non exiting
                $model = new NonExistingUserComplaintLodging();
                $model->id = Uuid::uuid1();
                $model->ticketno = 'CP'.$request["complainttype"].str_shuffle((string)(random_int(00000,99999)).strtoupper(str_random(3)));
                $model->complaintdate = Carbon::now(new DateTimeZone('Asia/Kolkata'));
                $model->productservicecode = $request->productservice;
                $model->categorycode = $request->category;
                $model->subcategorycode = $request->subcategory;
                $model->complaintdescription = $request->complaintdescription;
                $model->callername = $request->callername;
                $model->mobilenumber = $request->callermobile;
                $model->emailid = $request->calleremail;
                $statuSname = StatusMasterModel::where('statuscode', 'CP0004')->pluck('statusname')->first();
                $model->complaintstatus = $statuSname;
                $model->priority = $request->priority;
                $model->created_at = Carbon::now(new DateTimeZone('Asia/Kolkata'));
                $model->created_by = Auth::id();
                $model->save();
                return redirect()->back()->with('success-message', 'complaint successfully lodged.');
            }else{
                //insert into exiting
                $model = new ExistingUserComplaintLodging();
                $model->id = Uuid::uuid1();
                $model->ticketno = 'CP'.$request["complainttype"].str_shuffle((string)(random_int(00000,99999)).strtoupper(str_random(3)));
                $model->complaintdate = Carbon::now(new DateTimeZone('Asia/Kolkata'));
                $model->customercode = $request->customers;
                $model->branchcode = $request->customersite;
                $model->productservicecode = $request->productservice;
                $model->categorycode = $request->category;
                $model->subcategorycode = $request->subcategory;
                $model->productsrno_accountno = $request->productserialno;
                $model->complaintdescription = $request->complaintdescription;
                $model->callername = $request->callername;
                $model->mobilenumber = $request->callermobile;
                $model->emailid = $request->calleremail;
                $statuSname = StatusMasterModel::where('statuscode', 'CP0004')->pluck('statusname')->first();
                $model->complaintstatus = $statuSname;
                $model->priority = $request->priority;
                $model->created_at = Carbon::now(new DateTimeZone('Asia/Kolkata'));
                $model->created_by = Auth::id();
                $model->save();
                return redirect()->back()->with('success-message', 'complaint successfully lodged.');
            }
        }
        catch (Exception $exception)
        {
            $error = new CommonController();
            $error->ErrorLogging($exception,'ComplaintController', 'storeNewAdminComplaint');
        }
    }

    public function storeNewUserComplaint(Request $request)
    {
        $customers = CustomersModel::pluck('customername','customercode');
        $productService  = ProductServiceMasterModel::pluck('productservicename','productservicecode');
        return view('complaint.createguestnewcomplaint',compact('customers','productService'));
    }

    public function storeNewGuestComplaint(Request $request)
    {
//        return $request->all();
        try{
            $model = new ComplaintLodgingModel();
            $model->id = Uuid::uuid1();
            $model->ticketno = 'CP'.str_shuffle((string)(random_int(00000,99999)).strtoupper(str_random(3)));
            $model->customertype = $request["customertype"];
            $model->complaintdate = Carbon::now(new DateTimeZone('Asia/Kolkata'));
            $model->customername = $request["customername"];
            $model->branchname = $request["branchname"];
            $model->product_service = $request["productservicecode"];
            $model->category = $request["categorycode"];
            $model->subcategory = $request["subcategorycode"];
            $model->productsrno_accountno = $request["productservicesrno"];
            $model->complaintdescription = $request["complaintdescription"];
            $model->callername = $request["callername"];
            $model->mobilenumber = $request["callermobile"];
            $model->emailid = $request["calleremail"];
            $statusName = StatusMasterModel::where('statuscode', 'CP0001')->pluck('statusname')->first();
            $model->complaintstatus = $statusName;
            $model->created_at = Carbon::now(new DateTimeZone('Asia/Kolkata'));
            $model->save();
            return redirect()->back()->with('success-message', 'complaint successfully for TICKET NO : '.$model->ticketno);
        }
        catch (Exception $ex) {
            return $ex;

//            $this->ErrorLogging($ex,'ComplaintController', 'storeNewGuestComplaint');
            return 'Some error occurred while processing your request';
        }
    }

    public function getUserLoggedUserWiseComplaints(Request $request){

        $complaints = ComplaintLodgingModel::where('created_by', Auth::id())->get();

        $columns = array(
            0 =>'id',
            1 =>'ticketno',
            2=> 'complaintdescription',
            3=> 'complaintdate',
            4=> 'complaintstatus',
            5=> 'options'
        );

        $totalData = $complaints->count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if(empty($request->input('search.value')))
        {
            $assignedcomplaints = ComplaintLodgingModel::where('created_by', Auth::id())
                ->offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get();

            $posts = $assignedcomplaints->where('created_by', Auth::id());
        }
        else {
            $search = $request->input('search.value');

            $assignedcomplaints = ComplaintLodgingModel::where('created_by', Auth::id())
                ->where('ticketno','LIKE',"%{$search}%")
                ->orWhere('complaintdescription', 'LIKE',"%{$search}%")
                ->orWhere('complaintdate', 'LIKE',"%{$search}%")
                ->orWhere('complaintstatus', 'LIKE',"%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get();

            $assignedcomplaints = $assignedcomplaints->where('created_by', Auth::id());
            $posts = $assignedcomplaints;
        }

        $data = array();
        if(!empty($posts))
        {
            $count = 1;
            foreach ($posts as $post)
            {
                $nestedData['id'] = $count++;
                $nestedData['ticketno'] = $post->ticketno;
                $nestedData['complaintdescription'] = $post->complaintdescription;
                $nestedData['complaintdate'] = isset($post->complaintdate) ? date("d-m-Y", strtotime($post->complaintdate)) : '';
                $nestedData['complaintstatus'] = $post->complaintstatus;
                $nestedData['options'] = " <a href=\"user/viewcomplaints/$post->id\" style=\"margin-right: 3px;\">view</a>";
                $data[] = $nestedData;
            }
        }

        $json_data = array(
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $data
        );

        echo json_encode($json_data);
    }

    public function getUserLoggedComplaints(Request $request){

        $complaints = ComplaintLodgingModel::where('complaintstatus', 'OPEN')->get();

        $columns = array(
            0 =>'id',
            1 =>'ticketno',
            2=> 'complaintdescription',
            3=> 'complaintdate',
            4=> 'complaintstatus',
            5=> 'options'
        );

        $totalData = $complaints->count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if(empty($request->input('search.value')))
        {
            $assignedcomplaints = ComplaintLodgingModel::where('complaintstatus', 'OPEN')
                ->offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get();

            $posts = $assignedcomplaints->where('complaintstatus', 'OPEN');
        }
        else {
            $search = $request->input('search.value');

            $assignedcomplaints = ComplaintLodgingModel::where('complaintstatus', 'OPEN')
                ->where('ticketno','LIKE',"%{$search}%")
                ->orWhere('complaintdescription', 'LIKE',"%{$search}%")
                ->orWhere('complaintdate', 'LIKE',"%{$search}%")
                ->orWhere('complaintstatus', 'LIKE',"%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get();

            $assignedcomplaints = $assignedcomplaints->where('complaintstatus', 'OPEN');
            $posts = $assignedcomplaints;
        }

        $data = array();
        if(!empty($posts))
        {
            $count = 1;
            foreach ($posts as $post)
            {
                $nestedData['id'] = $count++;
                $nestedData['ticketno'] = $post->ticketno;
                $nestedData['complaintdescription'] = $post->complaintdescription;
                $nestedData['complaintdate'] = isset($post->complaintdate) ? date("d-m-Y", strtotime($post->complaintdate)) : '';
                $nestedData['complaintstatus'] = $post->complaintstatus;
                $nestedData['options'] = " <a href=\"registration/manageusernewcomplaint/$post->ticketno\" style=\"margin-right: 3px;\">manage</a>";
                $data[] = $nestedData;
            }
        }

        $json_data = array(
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $data
        );

        echo json_encode($json_data);
    }
}
