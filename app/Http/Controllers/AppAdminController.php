<?php

namespace App\Http\Controllers;

use App\Models\BranchContactMasterModel;
use App\Models\CategoryMasterModel;
use App\Models\EquipmentMasterModel;
use App\Models\IncrementMasterModel;
use Illuminate\Support\Facades\DB;
use App\Role;
use App\User;
use App\Module;
use Carbon\Carbon;
use Ramsey\Uuid\Uuid;
use Illuminate\Http\Request;
use App\Models\UserRolesModel;
use App\Models\CustomersModel;
use Illuminate\Support\Facades\Validator;
use App\Models\ProductServiceMasterModel;
use App\Models\ExistingUserComplaintLodging;
use App\Models\NonExistingUserComplaintLodging;
use App\Models\StatusMasterModel;
use App\Models\ComplaintTypeModel;
use App\Models\SubCategoryMasterModel;
use Auth;


class AppAdminController extends Controller // control create new complaint,handle complaint filter
{
    public function dashboard()
    {
        $users = User::where('created_by', \Auth::id())->get();
        $userscount = $users->count();
        return view('dashboard.appadmindashboard', compact('users', 'userscount'));
    }

    public function createComplaint()
    {
        $customers = CustomersModel::pluck('customername', 'customercode')->all();
        $productservice = ProductServiceMasterModel::pluck('productservicename', 'productservicecode')->all();
        $chargedcomplaint = "1";
        $complainttype = ComplaintTypeModel::where('complaintname', '!=', 'Sale')->get()->pluck('complaintname', 'complaintname');
        return view('complaint.admincreatenewcomplaint', compact('customers', 'productservice', 'chargedcomplaint', 'complainttype'));
    }

    public function storeComplaint(Request $request)
    {
        $user = auth()->user();
        try {
            $ticketno = 'CP' . $request["complainttype"] . str_shuffle((string)(random_int(00000, 99999)) . strtoupper(str_random(3)));
            $model = new ExistingUserComplaintLodging;
            $model->id = Uuid::uuid1();
            $model->ticketno = $ticketno;
            $model->contractno = $request['contractno'];
            $model->workorderno = $request['workorderno'];
            $model->complaintdate = Carbon::now(new \DateTimeZone('Asia/Kolkata'));
            $model->customercode = $request->customers;
            $model->branchcode = $request->customersite;
            $model->productservicecode = $request->productservice;
            $model->categorycode = $request->category;
            $model->subcategorycode = $request->subcategory;
            if($request['productserialno'] == "" || $request['productsrno'] == ""){
                if($request['productserialno'] == ""){
                    $equipmentsrno = EquipmentMasterModel::where('productsrno','=',$request['productsrno'] )->pluck('equipmentsrno')->first();
                    $model->productsrno_accountno = $equipmentsrno;
                    $model->productsrno = $request['productsrno'];
                }
                else{
                    $productsrno = EquipmentMasterModel::where('equipmentsrno','=',$request['productserialno'] )->pluck('productsrno')->first();
                    $model->productsrno_accountno = $request['productserialno'];
                    $model->productsrno = $productsrno;
                }
            }
            else{
                $model->productsrno_accountno = $request['productserialno'];
                $model->productsrno = $request['productsrno'];
            }
            $model->complaintdescription = $request->complaintdescription;
            $model->typeofform = "complaintbyworkorder";
            $sitecontactcount = Count(BranchContactMasterModel::where('branchcontactcode', $request->callername)->pluck('contactpersonname')->first());
            if ($sitecontactcount != 0) {
                $model->callername = BranchContactMasterModel::where('branchcontactcode', $request->callername)->pluck('contactpersonname')->first();
            } else {
                $model->callername = $request->callername;
            }
            $model->mobilenumber = $request->callermobile;
            $model->emailid = $request->calleremail;
            $statusname = StatusMasterModel::where('statuscode', 'CP0004')->pluck('statusname')->first();
            $model->complaintstatus = $statusname;
            $model->priority = $request->priority;
            $model->chargedcomplaint = $request->chargedcomplaint;
            $model->typeofcall = $request['typeofcall'];
            $model->created_at = Carbon::now(new \DateTimeZone('Asia/Kolkata'));
            $model->created_by = Auth::id();
            $model->updated_at = Carbon::now(new \DateTimeZone('Asia/Kolkata'));
            $model->save();
            if ($model->save() == true) {
                $modelcount = count(BranchContactMasterModel::where('branchcontactcode', $request->callername)->get());
                if ($modelcount != 0) {
                    $model = BranchContactMasterModel::where('branchcontactcode', '=', $request->callername)->get()->first();
                    $model->branchcontactcode = $request->callername;
                    $model->branchcode = $request->customersite;
                    $model->phone = $request->callermobile;
                    $model->emailid = $request->calleremail;
                    $model->contractno = $request['contractno'];
                    $model->updated_by = $user->name;
                    $model->updated_at = Carbon::now(new \DateTimeZone('Asia/Kolkata'));;
                    $model->save();
                } else {
                    $common = new CommonController();
                    $model = new BranchContactMasterModel();
                    $model->contactpersonname = $request->callername;
                    $mystr = $request->callername;
                    $tablename = "BranchContactPerson";
                    $tempcode = $common->DynamicCode($mystr, $tablename);
                    $code = $tempcode['code'];
                    $model->branchcontactcode = $code;
                    $model->branchcode = $request->customersite;
                    $incrementid = $tempcode['incrementid'];
                    $model->phone = $request->callermobile;
                    $model->emailid = $request->calleremail;
                    $model->contractno = $request['contractno'];
                    $model->created_at = Carbon::now(new \DateTimeZone('Asia/Kolkata'));
                    $model->created_by = $user->name;
                    $model->updated_at = null;
                    $model->save();
                    if ($model->save() == true) {
                        $id = "BranchContactPerson";
                        $modelincrement = IncrementMasterModel::find(IncrementMasterModel::where('incrementfor', $id)->first()->incrementid);
                        $modelincrement->incrementvalue = $incrementid;
                        $modelincrement->save();
                    }
                }
            }
            return redirect()->back()->with('flash_message', 'New Complaint created with Ticket No : ' . $ticketno);
        } catch (\Exception $exception) {
            return $exception;
            $error = new CommonController();
            $error->ErrorLogging($exception, 'AppAdminController', 'storeComplaint');
        }
    }

    public function getequipmentdate($id)
    {
        $product = EquipmentMasterModel::where('branchcode', $id)->get();
        $productservicecode = $product->pluck('productservicecode');
        $categorycode = $product->pluck('categorycode');
        $productservicelist = DB::table('tblproductservicemaster')->whereIn('productservicecode', $productservicecode)->get();
        $categorylist = DB::table('tblcategorymaster')->whereIn('categorycode', $categorycode)->get();
        $equipmentsnolist = DB::table('tblequipmentdetails')->where('branchcode', $id)->get();
        $branchcontactmaster = BranchContactMasterModel::where('branchcode', '=', $id)->get();
        return json_encode(array('equipmentsnolist' => $equipmentsnolist, 'productservicelist' => $productservicelist, 'categorylist' => $categorylist, 'branchcontactmaster' => $branchcontactmaster));
    }

    public function getcategory($productservicecode,$customersite)
    {
        $product = EquipmentMasterModel::where('branchcode', $customersite)->where('productservicecode',$productservicecode)->get();
        $categorycode = $product->pluck('categorycode')->first();
        $categorylist = DB::table('tblcategorymaster')->where('categorycode', $categorycode)->get();
        return json_encode(array('categorylist' => $categorylist));
    }

    public function getequipmentproductsrnodate()
    {
//        return json_encode($_GET['categorycode']);
        $subcategorylist = SubCategoryMasterModel::where('categorycode', $_GET['categorycode'])->get();
        $productsrnolist = EquipmentMasterModel::where('customercode', $_GET['customerscode'])->where('contractno', $_GET['contractnoid'])->where('productservicecode', $_GET['productservice'])->where('branchcode', $_GET['branchcode'])->where('categorycode', $_GET['categorycode'])->get();
        return json_encode(array('subcategorylist' => $subcategorylist, 'productsrnolist' => $productsrnolist));
//        return json_encode(array('categorylist'=>$categorylist));
    }

    public function newcomplaintbyequipment()
    {
        $customers = CustomersModel::pluck('customername', 'customercode')->all();
        $complainttype = ComplaintTypeModel::where('complaintname', '!=', 'Sale')->get()->pluck('complaintname', 'complaintname');
        return view('complaint.newcomplaintbyequipment', compact('customers', 'complainttype'));
    }

    public function storecomplaintbyequipment(Request $request)
    {
        try {
            $user = auth()->user();
            $common = new CommonController();
            $ticketno = 'CP' . $request["complainttype"] . str_shuffle((string)(random_int(00000, 99999)) . strtoupper(str_random(3)));
            $model = new ExistingUserComplaintLodging;
            $model->id = Uuid::uuid1();
            $model->ticketno = $ticketno;
            $model->contractno = $this->checkifdataisempty($request['contractno']);
            $model->workorderno = $this->checkifdataisempty($request['workorderno']);
            $model->complaintdate = Carbon::now(new \DateTimeZone('Asia/Kolkata'));
            $model->customercode = $request->customers;
            $model->branchcode = $request->customersite;
            $model->productservicecode = $request->productservice;
            $model->categorycode = $request->category;
            $model->subcategorycode = $request->subcategory;
            if($request['productserialno'] == "" || $request['productsrno'] == ""){
                if($request['productserialno'] == ""){
                    $equipmentsrno = EquipmentMasterModel::where('productsrno','=',$request['productsrno'] )->pluck('equipmentsrno')->first();
                    $model->productsrno_accountno = $equipmentsrno;
                    $model->productsrno = $request['productsrno'];
                }
                else{
                    $productsrno = EquipmentMasterModel::where('equipmentsrno','=',$request['productserialno'] )->pluck('productsrno')->first();
                    $model->productsrno_accountno = $request['productserialno'];
                    $model->productsrno = $productsrno;
                }
            }
            else{
                $model->productsrno_accountno = $request['productserialno'];
                $model->productsrno = $request['productsrno'];
            }
            $model->complaintdescription = $request->complaintdescription;
            $model->typeofform = "complaintbyequipment";
            $sitecontactcount = Count(BranchContactMasterModel::where('branchcontactcode', $request->callername)->pluck('contactpersonname')->first());
            if ($sitecontactcount != 0) {
                $model->callername = BranchContactMasterModel::where('branchcontactcode', $request->callername)->pluck('contactpersonname')->first();
            } else {
                $model->callername = $request->callername;
            }
            $model->mobilenumber = $request->callermobile;
            $model->emailid = $request->calleremail;
            $statusname = StatusMasterModel::where('statuscode', 'CP0004')->pluck('statusname')->first();
            $model->complaintstatus = $statusname;
            $model->priority = $request->priority;
            $model->chargedcomplaint = $request->chargedcomplaint;
            $model->typeofcall = $request['typeofcall'];
            $model->created_at = Carbon::now(new \DateTimeZone('Asia/Kolkata'));
            $model->created_by = Auth::id();
            $model->updated_at = Carbon::now(new \DateTimeZone('Asia/Kolkata'));
//            $count = $common->chkDuplicaterecord($request->customers, $request->customersite, $request->productservice, $request->category, $request->subcategory, $request['productserialno']);
//            if ($count == 0) {
                $model->save();
//            }
            if ($model->save() == true) {
                if ($request['contractno'] != null || $request['contractno'] != "") {
                    $modelcount = count(BranchContactMasterModel::where('branchcontactcode', $request->callername)->get());
                    if ($modelcount != 0) {
                        $model = BranchContactMasterModel::where('branchcontactcode', '=', $request->callername)->get()->first();
                        $model->branchcontactcode = $request->callername;
                        $model->branchcode = $request->customersite;
                        $model->phone = $request->callermobile;
                        $model->emailid = $request->calleremail;
                        $model->contractno = $request['contractno'];
                        $model->updated_by = $user->name;
                        $model->updated_at = Carbon::now(new \DateTimeZone('Asia/Kolkata'));;
                        $model->save();
                    } else {
                        $common = new CommonController();
                        $model = new BranchContactMasterModel();
                        $model->contactpersonname = $request->callername;
                        $mystr = $request->callername;
                        $tablename = "BranchContactPerson";
                        $tempcode = $common->DynamicCode($mystr, $tablename);
                        $code = $tempcode['code'];
                        $model->branchcontactcode = $code;
                        $model->branchcode = $request->customersite;
                        $incrementid = $tempcode['incrementid'];
                        $model->phone = $request->callermobile;
                        $model->emailid = $request->calleremail;
                        $model->contractno = $request['contractno'];
                        $model->created_at = Carbon::now(new \DateTimeZone('Asia/Kolkata'));
                        $model->created_by = $user->name;
                        $model->updated_at = null;
                        $model->save();
                        if ($model->save() == true) {
                            $id = "BranchContactPerson";
                            $modelincrement = IncrementMasterModel::find(IncrementMasterModel::where('incrementfor', $id)->first()->incrementid);
                            $modelincrement->incrementvalue = $incrementid;
                            $modelincrement->save();
                        }
                    }
                }
                return redirect()->back()->with('flash_message', 'New complaint created And Ticket No is : ' . $ticketno);
            } else {
                return redirect()->back()->with('flash_message', 'New complaint created');
            }
        } catch (\Exception $exception) {
            return $exception;
            $error = new CommonController();
            $error->ErrorLogging($exception, 'AppAdminController', 'storeComplaint');
        }
    }

    public function Getequipmentbyworkorderdata()
    {
        $id = $_GET['id'];
        $data = \DB::select(\DB::raw("select t1.contractno, t1.equipmentsrno,t1.productsrno,t5.workorderno,t1.branchcode,t2.branchname,t1.categorycode,t3.categoryname,t1.productservicecode,t4.productservicename from tblequipmentdetails t1
                join tblbranchmaster t2 on t1.branchcode=t2.branchcode
                join tblcategorymaster t3 on t1.categorycode=t3.categorycode
                join tblproductservicemaster t4 on t1.productservicecode=t4.productservicecode
                join tblcontractmaster t5 on t1.contractno = t5.contractno
                where t1.equipmentsrno='$id'"));
        if ($data == "" || $data == null) {
            $data = \DB::select(\DB::raw("select ticketno,callername,emailid,mobilenumber from tblexistingcustomercomplaintlodging where productsrno_accountno='$id'"));
            return json_encode(array('data' => $data));
        } else {
            $contractdetails = EquipmentMasterModel::where('equipmentsrno', '=', $id)->get()->first();
            if ($contractdetails->branchcode != "" || $contractdetails->branchcode != null) {
                $branchcontactlist = BranchContactMasterModel::where('branchcode', '=', $contractdetails->branchcode)->get();
            }
            return json_encode(array('data' => $data, 'branchcontactlist' => $branchcontactlist));
        }


    }

    public function Getproductbyworkorderdata()
    {
        $id = $_GET['id'];
        $data = \DB::select(\DB::raw("select t1.contractno, t1.equipmentsrno,t1.productsrno,t5.workorderno,t1.branchcode,t2.branchname,t1.categorycode,t3.categoryname,t1.productservicecode,t4.productservicename from tblequipmentdetails t1
                join tblbranchmaster t2 on t1.branchcode=t2.branchcode
                join tblcategorymaster t3 on t1.categorycode=t3.categorycode
                join tblproductservicemaster t4 on t1.productservicecode=t4.productservicecode
                join tblcontractmaster t5 on t1.contractno = t5.contractno
                where t1.productsrno='$id'"));
        if ($data == "" || $data == null) {
            $data = \DB::select(\DB::raw("select ticketno,callername,emailid,mobilenumber from tblexistingcustomercomplaintlodging where productsrno='$id'"));
            return json_encode(array('data' => $data));
        } else {
            $contractdetails = EquipmentMasterModel::where('productsrno', '=', $id)->get()->first();
            if ($contractdetails->branchcode != "" || $contractdetails->branchcode != null) {
                $branchcontactlist = BranchContactMasterModel::where('branchcode', '=', $contractdetails->branchcode)->get();
            }
            return json_encode(array('data' => $data, 'branchcontactlist' => $branchcontactlist));
        }
    }

    public function getcallerdetails($id)
    {
        $contractbranchcontactdetails = BranchContactMasterModel::where('branchcontactcode', '=', $id)->get()->first();
        $email = $contractbranchcontactdetails->emailid;
        $phone = $contractbranchcontactdetails->phone;
        return json_encode(array('email' => $email, 'phone' => $phone));
    }

    public function checkifdataisempty($date)
    {
        if ($date == '')
            $date = null;

        return $date;
    }

    public function checkProductSrNo(Request $request){
        $product = $request->product;
        $ticketno = ExistingUserComplaintLodging::where('productsrno_accountno','=',$product)
            ->where('complaintstatus','=','ACKNOWLEDGED')->where('complaintdescription','!=','service')
            ->where('subcategorycode','!=','service')
            ->get()->pluck('ticketno');

        return json_encode(array('ticketno' => $ticketno));
    }

    public function checkEquipmentSrNo(Request $request){
        $equipment = $request->equipment;
        $ticketno = ExistingUserComplaintLodging::where('productsrno','=',$equipment)
            ->where('complaintstatus','=','ACKNOWLEDGED')->where('complaintdescription','!=','service')
            ->where('subcategorycode','!=','service')
            ->get()->pluck('ticketno');

        return json_encode(array('ticketno' => $ticketno));
    }

}

