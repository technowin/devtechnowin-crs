<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Masters\SubCategoryMasterController;
use App\Models\AssigneeMasterModel;
use App\Models\BranchContactMasterModel;
use App\Models\BranchMasterModel;
use App\Models\CategoryMasterModel;
use App\Models\EquipmentMasterModel;
use App\Models\ExistingUserComplaintLodging;
use App\Models\SubCategoryMasterModel;
use App\Models\TicketAssignedModel;
use Auth;
use App\User;
use Carbon\Carbon;
use Hamcrest\Text\SubstringMatcher;
use Ramsey\Uuid\Uuid;
use Illuminate\Http\Request;
use App\Models\CustomersModel;
use App\Models\StatusMasterModel;
use App\Models\ComplaintLodgingModel;
use App\Models\ProductServiceMasterModel;
use App\Models\IncrementMasterModel;
use App\Models\EquipmentDetailsNewCustomerModel;
use App\Models\ComplaintTypeModel;
use App\Models\ContractMasterModel;


class UserComplaintController extends Controller
{

    public function dashboardUserComplaint(Request $request)
    {
        $request->user()->authorizeRoles(['user']);

        $user = Auth::user();

        return view('dashboard.userdashboard')->with(['user' => $user]);
    }

    public function indexUserComplaint(Request $request)
    {
        $request->user()->authorizeRoles(['user']);
        $currentUserId = auth()->user()->id;
        $currentUserCode = auth()->user()->customers->first()->customercode;
        $currentUserName = auth()->user()->customers->first()->customername;
//        $complaints = ComplaintLodgingModel::where('created_by', $currentUserId)->get();
        $complaints = ComplaintLodgingModel::selectraw('tblusercomplaintlodging.*,tblexistingcustomercomplaintlodging.chargedcomplaint')
            ->leftjoin('tblexistingcustomercomplaintlodging','tblexistingcustomercomplaintlodging.ticketno','=','tblusercomplaintlodging.ticketno')
            ->where('tblusercomplaintlodging.created_by',$currentUserId)
            ->get();
//     $complaints = ComplaintLodgingModel::where('customercode', $currentUserCode)->get();
//     $complaints = ComplaintLodgingModel::where('customername', $currentUserName)->get();
        return view('complaint.indexusercomplaint', compact('complaints'));
    }

    public function showUserComplaint(Request $request, $id = null)
    {
//        return $id;
        $request->user()->authorizeRoles(['user']);
        $assignee = TicketAssignedModel::where('ticketno',$id)->get()->first();
        if ($id !== null) {

            $complaints = ComplaintLodgingModel::where('ticketno', $id)->first();
            if($assignee != null)
            {
                $assigneedetails = AssigneeMasterModel::where('assigneecode',$assignee->assigneecode)->get()->first();
            }

        } else {

            return view('errors.404');
        }

        return view('complaint.detailusercomplaint', compact('complaints','assigneedetails','assignee'));
    }

    public function createUserComplaint(Request $request)
    {
        $request->user()->authorizeRoles(['user']);
        $currentUserName = auth()->user()->customers->customername;
        $productService = ProductServiceMasterModel::pluck('productservicename', 'productservicecode')->all();
        return view('complaint.createusernewcomplaint', compact('productService', 'customers','currentUserName'));
    }

    public function storeUserComplaint(Request $request)
    {
        $request->user()->authorizeRoles(['user']);
        $model = new ComplaintLodgingModel();
        $model->id = Uuid::uuid1();
        $model->ticketno = 'CP' . $request["complainttype"] . str_shuffle(strval(random_int(00000, 99999)) . strtoupper(str_random(3)));
        $model->customertype = "Existing";
        $model->workorderno = $request['workorderno'];
        $model->complaintdate = Carbon::now(new \DateTimeZone('Asia/Kolkata'));
        $model->customername = $request["customername"];
        $model->branchname = $request["branchname"];
        $model->product_service = $request["productservice"];
        $model->category = $request["category"];
        $model->subcategory = $request["subcategory"];
        $model->productsrno_accountno = $request["productsrno_accountno"];
        $model->complaintdescription = $request["complaintdescription"];
        $model->callername = $request["yourname"];
        $model->mobilenumber = $request["mobileno"];
        $model->emailid = $request["email"];
        $statusName = StatusMasterModel::where('statuscode', 'CP0001')->pluck('statusname')->first();
        $model->complaintstatus = $statusName;
        $model->created_at = Carbon::now(new \DateTimeZone('Asia/Kolkata'));
        $model->created_by = Auth::id();
        $model->save();
        return redirect('mycomplaints')->with('success-message', 'Your Complaint Successfully ! New Complaint created with Ticket No : ',$model->ticketno);
    }

    public function createGuestComplaint(Request $request)
    {
        try
        {
            $customers = CustomersModel::pluck('customername', 'customercode')->all();
            $productService = ProductServiceMasterModel::pluck('productservicename', 'productservicecode')->all();
            $complainttype = ComplaintTypeModel::all()->pluck('complaintname','complaintname');
            return view('complaint.createguestnewcomplaint', compact('productService', 'customers','complainttype'));
        }
        catch (\Exception $exception)
        {
            $error = new CommonController();
            $error->ErrorLogging($exception,'ComplaintController', 'storeNewAdminComplaint');
        }
    }

    public function newUserComplaint()
    {
        try {
            $customers = CustomersModel::pluck('customername', 'customercode')->all();
            $productService = ProductServiceMasterModel::pluck('productservicename', 'productservicecode')->all();
            $complainttype = ComplaintTypeModel::all()->pluck('complaintname', 'complaintname');
            return View('complaint.newusercomplaint', compact('customers','productService','complainttype'));
        }
        catch (\Exception $exception)
        {
            $error = new CommonController();
            $error->ErrorLogging($exception,'ComplaintController', 'storeNewAdminComplaint');
        }
    }

    public function storeNewUserComplaint(Request $request)
    {
        $user = auth()->user();
        $ticketno = 'CP' . str_shuffle(strval(random_int(00000, 99999)) . strtoupper(str_random(3)));
        $customer = $request["customers"];
        $typeOfCall = $request["typeofcall"];
        $productServiceCode = $request["eqipmentproductservice"];
        $category = $request["categorycode"];
        $subcategory = $request["subcategorycode"];
        $equipment = $request["textequipmentsrno"];
        $product = $request["productservicesrno"];
        $quantity = $request["quantity"];
        $callername = $request["callername"];
        $callermobile = $request["callermobile"];
        $calleremail = $request["calleremail"];
        $complaintdescription = $request["complaintdescription"];
        $priority = $request["priority"];
        $count = count($productServiceCode);

        for($i=0; $i < $count; $i++)
        {
            $model = new ExistingUserComplaintLodging();
            $model->id = Uuid::uuid1();
            $model->ticketno = $ticketno;
            $model->customercode = $customer;
            if($product[$i] == null && $equipment[$i] != null)
            {
                $model->productsrno_accountno = $equipment[$i];
            }
            else if($equipment[$i] == null && $product[$i] != null)
            {
                $model->productsrno_accountno = $product[$i];
            }
            $model->productservicecode = $productServiceCode[$i];
            $model->categorycode = $category[$i];
            $model->subcategorycode = $subcategory[$i];
            $model->callername = $callername;
            $model->mobilenumber = $callermobile;
            $model->emailid = $calleremail;
            $model->complaintdescription = $complaintdescription;
            $model->complaintdate = Carbon::now(new \DateTimeZone('Asia/Kolkata'));
            $model->priority = $priority;
            $model->complaintstatus = StatusMasterModel::where('statuscode', 'CP0004')->pluck('statusname')->first();
            $model->chargedcomplaint = 1;
            $model->typeofcall = $typeOfCall;
            $model->created_by = $user->name;
            $model->created_at = Carbon::now(new \DateTimeZone('Asia/Kolkata'));
            $model->typeofform = 'newusercomplaints';
            if($equipment[$i] == null || $product[$i] == null)
            {
                $model->quantity = $quantity[$i];
            }
            $model->save();
            if($model->save() == true)
            {
                $EquipmentDetailsNewCustomerModel = new EquipmentDetailsNewCustomerModel();
                if($product[$i] != null && $equipment[$i] == null) {
                    $EquipmentDetailsNewCustomerModel->equipmentsrno = $product[$i];
                }
                else if($equipment[$i] != null && $product[$i] == null){
                    $EquipmentDetailsNewCustomerModel->equipmentsrno = $equipment[$i];
                }
                $EquipmentDetailsNewCustomerModel->customercode = $customer;
                $EquipmentDetailsNewCustomerModel->productservicecode = $productServiceCode[$i];
                $EquipmentDetailsNewCustomerModel->categorycode = $category[$i];
                $EquipmentDetailsNewCustomerModel->specification = $subcategory[$i];
                $EquipmentDetailsNewCustomerModel->typeofcall = $typeOfCall;
                $EquipmentDetailsNewCustomerModel->ticketno = $ticketno;
                if($equipment[$i] == null || $product[$i] == null)
                {
                    $EquipmentDetailsNewCustomerModel->quantity = $quantity[$i];
                }
                $EquipmentDetailsNewCustomerModel->created_at = Carbon::now(new \DateTimeZone('Asia/Kolkata'));
                $EquipmentDetailsNewCustomerModel->created_by = $user->name;
                $EquipmentDetailsNewCustomerModel->save();
            }
        }

        return redirect('newusercomplaint')->with('success-message', 'Complaint Lodged Successfully ! New Complaint created with Ticket No :  "'.$ticketno.'"');
    }

    public function EditGuestComplaint($id){
        $data = ExistingUserComplaintLodging::where('id','=',$id)->get()->first();
        $typeofform = $data->typeofform;
        if($typeofform =="complaintbyequipment"){
             $equipmentdata =  EquipmentMasterModel::SelectRaw('tblequipmentdetails.*,tblbranchmaster.branchname,tblproductservicemaster.productservicename,tblcategorymaster.categoryname')
                ->join('tblbranchmaster','tblbranchmaster.branchcode','=','tblequipmentdetails.branchcode')
                ->join('tblproductservicemaster','tblproductservicemaster.productservicecode','=','tblequipmentdetails.productservicecode')
                ->join('tblcategorymaster','tblcategorymaster.categorycode','=','tblequipmentdetails.categorycode')
                ->where('tblequipmentdetails.customercode',$data->customercode)->where('status','Active')
                ->get();
            $equipmentlist = $equipmentdata->pluck('equipmentsrno','equipmentsrno');
            $equipmentcode = $data->productsrno_accountno;

            $productsrno = $equipmentdata->pluck('productsrno','productsrno');
            $productcode = $data->productsrno;

//            $workorderlist = $equipmentlist->pluck('workorderno','workorderno');
            $workordercode = $data->workorderno;

//            $customerslist = CustomersModel::pluck('customername', 'customercode')->all();
            $customercode = CustomersModel::where('customercode','=',$data->customercode)->get()->first();

//            $customersitelist = $equipmentdata->pluck('branchname','branchcode');
            $customersitecode = $equipmentdata->where('branchcode','=',$data->branchcode)->pluck('branchname')->first();


//            $productservicelist = $equipmentdata->pluck('productservicename','productservicecode');
            $productservicecode = $equipmentdata->where('productservicecode','=',$data->productservicecode)->pluck('productservicename')->first();

//            $categorylist = $equipmentdata->pluck('categoryname','categorycode');
            $categorycode = $equipmentdata->where('categorycode','=',$data->categorycode)->pluck('categoryname')->first();

//            $subcategorylist = SubCategoryMasterModel::where('categorycode','=',$data->categorycode)->get()->pluck('subcategoryname','subcategorycode');
//            $subcategorycode = $data->subcategorycode;
            $subcategorycode = SubCategoryMasterModel::where('subcategorycode','=',$data->subcategorycode)->pluck('subcategoryname')->first();


            $complainttype= ComplaintTypeModel::where('complaintname','!=','Sale')->get()->pluck('complaintname','complaintname');
            $complainttypecode = $data->typeofcall;
            $chargedcomplaint = ($data->chargedcomplaint != "0" ?  true  : false);
//            $callernamelist = ExistingUserComplaintLodging::where('id','=',$id)->get()->pluck('callername','callername');


//            changes done by MAAVIYA on 19/11/2020

            return view('complaint.editnewcomplaintbyequipment',compact('data','customerslist','customercode' ,'equipmentlist','equipmentcode','workorderlist',
                'workordercode','customersitelist','customersitecode','productservicelist','productservicecode','categorylist','categorycode','subcategorylist',
                'subcategorycode','chargedcomplaint','complainttype','complainttypecode','callernamelist','productsrno','productcode'));
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
//            $categorylist = CategoryMasterModel::where('productservicecode','=',$data->productservicecode)->get()->pluck('categoryname','categorycode');
             $categorylist = CategoryMasterModel::selectRaw('tblcategorymaster.*,tblequipmentdetails.categorycode')
            ->leftjoin('tblequipmentdetails','tblequipmentdetails.categorycode','=','tblcategorymaster.categorycode')
            ->where('tblcategorymaster.productservicecode','=',$data->productservicecode)
                ->where('tblequipmentdetails.branchcode','=',$data->branchcode)
                ->get()->pluck('categoryname','categorycode');
            $categorycode = $data->categorycode;
            $subcategorylist = SubCategoryMasterModel::where('categorycode','=',$data->categorycode)->get()->pluck('subcategoryname','subcategorycode');
            $subcategorycode = $data->subcategorycode;
            $equipmentlist = EquipmentMasterModel::where('contractno','=',$data->contractno)->where('customercode','=',$data->customercode)
                ->where('productservicecode','=',$data->productservicecode)
                ->where('categorycode','=',$data->categorycode)
                ->where('categorycode','=',$data->categorycode)->get()->pluck('equipmentsrno','equipmentsrno');
            $productsrnolist = EquipmentMasterModel::where('contractno','=',$data->contractno)->where('customercode','=',$data->customercode)
                ->where('productservicecode','=',$data->productservicecode)
                ->where('categorycode','=',$data->categorycode)
                ->where('categorycode','=',$data->categorycode)->get()->pluck('productsrnno','productsrnno');
            $equipmentcode = $data->productsrno_accountno;
            $equipmentcode = $data->productsrno;
            $complainttype= ComplaintTypeModel::where('complaintname','!=','Sale')->get()->pluck('complaintname','complaintname');
            $complainttypecode = $data->typeofcall;
            $callernamelist = ExistingUserComplaintLodging::where('id','=',$id)->get()->pluck('callername','callername');
            return view('complaint.editcomplaintsbyworkorder',compact('data','customerslist','customercode' ,'equipmentlist','equipmentcode','productsrnolist','equipmentcode','workorderlist',
                'workordercode','customersitelist','customersitecode','productservicelist','productservicecode','categorylist','categorycode','subcategorylist',
                'subcategorycode','chargedcomplaint','complainttype','complainttypecode','callernamelist'));
        }
        else {
//            $customers = CustomersModel::pluck('customername', 'customercode')->all();
            $customercode = CustomersModel::where('customercode','=',$data->customercode)->pluck('customername')->first();
            $productServicecode = ProductServiceMasterModel::where('productservicecode','=',$data->productservicecode)->pluck('productservicename')->first();
//            $productServicecode = $data->productservicecode;
            $complainttype = ComplaintTypeModel::all()->pluck('complaintname','complaintname');
            $complainttypecode = $data->typeofcall;
//            $categorylist = CategoryMasterModel::where('productservicecode','=',$data->productservicecode)->get()->pluck('categoryname','categorycode');
            $categorycode = CategoryMasterModel::where('categorycode','=',$data->categorycode)->pluck('categoryname')->first();
//            $subcategorylist = SubCategoryMasterModel::where('categorycode','=',$data->categorycode)->get()->pluck('subcategoryname','subcategorycode');
            $subcategorycode = SubCategoryMasterModel::where('subcategorycode','=',$data->subcategorycode)->pluck('subcategoryname')->first();
            $chargedcomplaint = ($data->chargedcomplaint != "0" ?  true  : false);
//            $callernamelist = ExistingUserComplaintLodging::where('id','=',$id)->get()->pluck('callername','callername');

//            changed by MAAVIYA on 19/11/2020

            return view('complaint.editguestnewcomplaint',compact('data','productServicecode' ,'customercode','complainttype',
                'complainttypecode','categorycode','subcategorycode','chargedcomplaint'));
        }
    }

    public function UpdateGuestComplaint(Request $request){
        $model = ExistingUserComplaintLodging::where('id',$request->id)->get()->first();
        $model->complaintdescription = $request["complaintdescription"];
        $model->updated_at = Carbon::now(new \DateTimeZone('Asia/Kolkata'));
        $model->updated_by = Auth::id();
        $model->update();

//        $model->customercode = $request["customerscode"];
//        $model->typeofcall = $request["typeofcall"];
//        $model->productservicecode = $request["productservicecode"];
//        $model->categorycode = $request["categorycode"];
//        $model->subcategorycode = $request["subcategorycode"];
//        $model->productsrno_accountno = $request["textproductservicesrno"];
//        $model->callername = $request["callername"];
//        $model->mobilenumber = $request["callermobile"];
//        $model->emailid = $request["calleremail"];
//        $model->priority = $request["priority"];
////        $model->complaintstatus = StatusMasterModel::where('statuscode', 'CP0004')->pluck('statusname')->first();


//        Changed by Maaviya on 19/11/2020

        return redirect('complaints')->with('success-message', 'complaint successfully lodged.');
    }

    public function updatenewcomplaintbyequipment(Request $request){
//        return $request->all();
         $model = ExistingUserComplaintLodging::where('id',$request->id)->get()->first();
        $model->complaintdescription = $request["complaintdescription"];
//        $model->customercode = $request["customers"];
//        $model->workorderno = $request["workorderno"];
//        $model->productsrno_accountno = $request["productserialno"];
//        $model->productsrno = $request["productsrno"];
//        $model->branchcode = $request["customersite"];
//        $model->productservicecode = $request["productservice"];
//        $model->categorycode = $request["category"];
//        $model->subcategorycode = $request["subcategory"];
//        $model->callername = $request["callername"];
//        $model->mobilenumber = $request["callermobile"];
//        $model->emailid = $request["calleremail"];
//        $model->priority = $request["priority"];
//        $model->typeofcall = $request["typeofcall"];
//        $model->complaintstatus = StatusMasterModel::where('statuscode', 'CP0004')->pluck('statusname')->first();


        $model->created_at = Carbon::now(new \DateTimeZone('Asia/Kolkata'));
        $model->created_by = Auth::id();
        $model->update();
        return redirect('complaints')->with('success-message', 'complaint successfully lodged.');

        //            changes done by MAAVIYA on 19/11/2020
    }

    public function updateeditcomplaintsbyworkorder(Request $request){
//        return $request->all();
        $model = ExistingUserComplaintLodging::where('id',$request->id)->get()->first();
        $model->customercode = $request["customercode"];
        $model->workorderno = $request["workorderno"];
        $model->productsrno_accountno = $request["productserialno"];
        $model->productsrno = $request["productsrno"];
        $model->branchcode = $request["customersite"];
        $model->productservicecode = $request["productservice"];
        $model->categorycode = $request["category"];
        $model->subcategorycode = $request["subcategory"];
        $model->complaintdescription = $request["complaintdescription"];
        $model->callername = $request["callername"];
        $model->mobilenumber = $request["callermobile"];
        $model->emailid = $request["calleremail"];
        $model->priority = $request["priority"];
        $model->typeofcall = $request["typeofcall"];
        $model->complaintstatus = StatusMasterModel::where('statuscode', 'CP0004')->pluck('statusname')->first();
        $model->created_at = Carbon::now(new \DateTimeZone('Asia/Kolkata'));
        $model->created_by = Auth::id();
        $model->save();
        return redirect('complaints')->with('success-message', 'complaint successfully lodged.');
    }

    public function storeGuestComplaint(Request $request)
    {
        //return $request->all();
        $model = new ExistingUserComplaintLodging();
        $model->id = Uuid::uuid1();
        $ticketno = 'CP' . str_shuffle(strval(random_int(00000, 99999)) . strtoupper(str_random(3)));
        $model->ticketno = $ticketno;
        $model->complaintdate = Carbon::now(new \DateTimeZone('Asia/Kolkata'));
        $model->customercode = $request["customerscode"];
        $model->branchcode = null;
        $model->productservicecode = $request["productservicecode"];
        $model->categorycode = $request["categorycode"];
        $model->subcategorycode = $request["subcategorycode"];
        $model->typeofform = "newusercomplaints";
        if($request['productservicesrno'] !=null){
            $model->productsrno_accountno = $request["productservicesrno"];
        }
        else{
            $model->productsrno_accountno = $request["textproductservicesrno"];
        }
        $model->complaintdescription = $request["complaintdescription"];
        $model->callername = $request["callername"];
        $model->mobilenumber = $request["callermobile"];
        $model->emailid = $request["calleremail"];
        $statusName = StatusMasterModel::where('statuscode', 'CP0004')->pluck('statusname')->first();
        $model->complaintstatus = $statusName;
        $model->typeofcall = $request["typeofcall"];
//        if($request["chargedcomplaint"] !=0)
//        {
//            $model->chargedcomplaint =  $request["chargedcomplaint"];
//        }
//        else
//        {
//            $model->chargedcomplaint =  null;
//        }
        $model->chargedcomplaint =  1;                                                      //Changed by Maaviya
        $model->created_at = Carbon::now(new \DateTimeZone('Asia/Kolkata'));
        $model->created_by = Auth::id();
        $model->save();
        if($model->save() == true)
        {
            $newmodel = null;

            $count = $request['productservicesrno'] == null ? 0:count($request['productservicesrno']);
            if($count == 0)
            {
                $EquipmentDetailsNewCustomerModel = new EquipmentDetailsNewCustomerModel();
                if($request['productservicesrno'] !=null) {
                    $EquipmentDetailsNewCustomerModel->equipmentsrno = $request["productservicesrno"];
                }
                else{
                    $EquipmentDetailsNewCustomerModel->equipmentsrno = $request["textproductservicesrno"];
                }
//              $EquipmentDetailsNewCustomerModel->equipmentsrno = $request["productservicesrno"];

                $EquipmentDetailsNewCustomerModel->customercode = $request["customerscode"];
                $EquipmentDetailsNewCustomerModel->productservicecode = $request["productservicecode"];
                $EquipmentDetailsNewCustomerModel->categorycode = $request["categorycode"];
                $EquipmentDetailsNewCustomerModel->specification = $request["specefication"];
                $EquipmentDetailsNewCustomerModel->typeofcall = $request["typeofcall"];
                $EquipmentDetailsNewCustomerModel->ticketno = $ticketno;
                $EquipmentDetailsNewCustomerModel->save();

                if($EquipmentDetailsNewCustomerModel->save() == true)
                {
                    $id="EstimateNo";
                    $incrementid = $this->DynamicCode();
                    $modelincrement = IncrementMasterModel::find(IncrementMasterModel::where('incrementfor',$id)->first()->incrementid);
                    $modelincrement->incrementvalue = $incrementid;
                    $modelincrement->save();
                }
            }
        }
        return redirect()->back()->with('success-message', 'Complaint Lodged Successfully ! New Complaint created with Ticket No :  "' . $model->ticketno . '"');
    }

    // GET: Show Compliant Status
    public function showComplaintStatus(Request $request, $ticket)
    {
        if (Auth::guest()) {
            return view('complaint.viewcomplaintstatus', compact(''));
        } else {
            $request->user()->authorizeRoles(['user', 'admin']);
            return view('complaint.viewcomplaintstatus', compact(''));
        }
    }

    public function settingindex(Request $request)
    {
        $request->user()->authorizeRoles(['user']);

        $user = Auth::user();

        return view('registereduser.profile')->with(['user' => $user]);
    }

    public function getComplaintStatus(Request $request)
    {
        $clientIP = \Request::getClientIp(true);

        $complaint = ComplaintLodgingModel::find($request->ticketnumber);

        if ($complaint) {
            return view('complaint._partialcomplaintstatus')->with('complaint', $complaint)->renderSections()['content1'];
        } else {
            return 'please check the ticket number you have enter';
        }
    }

    public function settingupdate(Request $request, $id)
    {

        $request->user()->authorizeRoles(['user']);

        $user = User::findOrFail($id);

        $validator = \Validator::make($request->all(), [
            'name' => 'required|max:120',
            'email' => 'required|email|unique:users,email,' . $id,
            'mobile' => 'required|numeric|digits:10'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        } else {
            $input = $request->only(['name', 'email', 'mobile']);

            $user->fill($input)->save();

            return redirect()->back()->with('success-message', 'settings successfully edited.');
        }
    }

    public function multiplerow(Request $request)
    {
        $model = EquipmentMasterModel::all();

        return view('multirow', compact('model'));
    }

    public function multiplerowupdate(EquipmentMasterModel $EquipmentMaster, Request $request)
    {
        $input = $request->all();
        $condition = $input['contractno'];
        $student = new EquipmentMasterModel;

        foreach ($condition as $key => $condition) {
            $student->contractno = $input['contractno'][$key];
        }
        return $student;
    }

    public function chkcustomername($id)
    {
        $customer = CustomersModel::where('customername',$id)->get()->first();
        return json_encode($customer);
    }

    public function addaddequipmentdetailsnewcustomer()
    {
        $lastincrementid = IncrementMasterModel::all()->where('incrementfor', 'EstimateNo')->first()->incrementvalue;
        $code = str_pad($lastincrementid+1, 4, "0", STR_PAD_LEFT);
        $currryear = trim(date('Y'));
        $nxtyear = date('Y') + 1;
        $substringval = substr($nxtyear, 2,2);
        $estimateno = "TEC/EST/$currryear-$substringval-$code";

        $id="EstimateNo";
        $incrementid = $this->DynamicCode();
        $modelincrement = IncrementMasterModel::find(IncrementMasterModel::where('incrementfor',$id)->first()->incrementid);
        $modelincrement->incrementvalue = $incrementid;
        $modelincrement->save();
        return json_encode($estimateno);
    }

    public function DynamicCode()
    {
        $lastincrementid = IncrementMasterModel::all()->where('incrementfor', 'EstimateNo')->first()->incrementvalue;
        $itemarray = $lastincrementid + 1;
        return  $itemarray ;
    }

    public function getequipmentdetailsnewcustomer($id){
        $newequipmentlist = EquipmentDetailsNewCustomerModel::where('customercode',$id)->get();
        return json_encode(array('newequipmentlist'=>$newequipmentlist));
    }



}