<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\AppUser;
use Carbon\Carbon;
use DateTimeZone;
use Exception;
use Illuminate\Http\Response;
use Ramsey\Uuid\Uuid;
use Illuminate\Http\Request;
use App\Models\CustomersModel;
use App\Models\StatusMasterModel;
use App\Models\ProductServiceMasterModel;
use App\Models\ExistingUserComplaintLodging;
use App\Models\NonExistingUserComplaintLodging;


class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $users = User::all();

        $userscount = User::count();

        return view('dashboard.admindashboard', compact('users', 'userscount'));
    }

    public function appuserlist()
    {
        $users = AppUser::all();

        return view('appuser.index',compact('users',$users));
    }

    public function createnewcomplaint()
    {
        $customers = CustomersModel::pluck('customername', 'customercode')->all();

        $productservice = ProductServiceMasterModel::pluck('productservicename', 'productservicecode')->all();

        return view('complaint.admincreatenewcomplaint', compact('customers', 'productservice'));
    }

    public function storenewcomplaint(Request $request)
    {

        try
        {
            $customerName = $request->customers;
            $customerSite = $request->customersite;
            $productSerialNumber = $request->productsrno_accountno;

            if ($customerName == null && $customerSite == null && $productSerialNumber == null){
                //insert into non exiting
                $model = new NonExistingUserComplaintLodging;
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
                $statusname = StatusMasterModel::where('statuscode', 'CP0004')->pluck('statusname')->first();
                $model->complaintstatus = $statusname;
                $model->priority = $request->priority;
                $model->created_at = Carbon::now(new DateTimeZone('Asia/Kolkata'));
                $model->created_by = Auth::id();
                $model->updated_at = Carbon::now(new DateTimeZone('Asia/Kolkata'));
                $model->save();
                return redirect()->back()->with('success-message', 'new complaint created');
            }else{
                //insert into exiting
                $model = new ExistingUserComplaintLodging;
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
                $statusname = StatusMasterModel::where('statuscode', 'CP0004')->pluck('statusname')->first();
                $model->complaintstatus = $statusname;
                $model->priority = $request->priority;
                $model->created_at = Carbon::now(new DateTimeZone('Asia/Kolkata'));
                $model->created_by = Auth::id();
                $model->updated_at = Carbon::now(new DateTimeZone('Asia/Kolkata'));
                $model->save();
                return redirect()->back()->with('success-message', 'new complaint created for');
            }
        }
        catch (Exception $exception)
        {
            $error = new CommonController();
            $error->ErrorLogging($exception,'AdminController', 'storenewcomplaint');
        }
    }

}
