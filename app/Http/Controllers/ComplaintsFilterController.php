<?php

namespace App\Http\Controllers;

use App\Models\AssigneeFilesModel;
use App\Models\ContractMasterModel;
use App\Models\TicketAssignedHistoryModel;
use App\Models\TicketAssignedModel;
use App\User;
use Auth;
use Carbon\Carbon;
use DateTimeZone;
use DebugBar\DebugBar;
use Exception;
use Illuminate\Http\Request;
use App\Models\CustomersModel;
use App\Models\BranchMasterModel;
use App\Models\StatusMasterModel;
use App\Models\CategoryMasterModel;
use App\Models\ComplaintLodgingModel;
use App\Models\ExistingUserComplaintLodging;
use App\Models\NonExistingUserComplaintLodging;
use App\Models\ProductServiceMasterModel;
use App\Models\SubCategoryMasterModel;
use App\Models\EquipmentMasterModel;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Facades\DB;


class ComplaintsFilterController extends Controller
{
    public function index()
    {
        //$complaints = ComplaintLodgingModel::where('created_by', Auth::id())->get();
        $complaints = ComplaintLodgingModel::where('complaintstatus', 'OPEN')->get();
        return view('complaint.userlodgedcomplaints',compact('complaints'));
    }

    public function manageusersnewcomplaint($id)
    {
        $customercode = "";
        $complaint = ComplaintLodgingModel::where('ticketno', $id)->first();
        $customername = $complaint->customername;
        $branchname = $complaint->branchname;
        $userworkorderno = $complaint->workorderno;

        #region Customer list
        $customerlist = CustomersModel::select('customercode', 'customername')->get();
        $abcd = array();
        $abc = array();

        foreach ($customerlist as $customers) {
            if (mb_strtolower($customers->customername) == mb_strtolower($complaint->customername)) {
                $abcd[] = $customers;
            }
        }
        $newarray = array_unique($abcd);
        if (count($newarray) > 0) {
            if (count($newarray) == 1) {
                $customercode = $newarray[0]->customercode;
            }
        } else {
            foreach ($customerlist as $item) {
                $result = $item->where('customername', 'LIKE', '%' . mb_strtolower($complaint->customername) . '%')->select('customercode', 'customername')->get();
                if (count($result) > 0) {
                    $abc[] = $item->where('customername', 'LIKE', '%' . mb_strtolower($complaint->customername) . '%')->select('customercode', 'customername')->get();
                }
            }
            if (count($abc) > 0) {
                $customerlikelist = $abc[0];
                $customercode = $customerlikelist[0]['customercode'];
            } else {
                $customercode = null;
            }
        }
        $customerlike = $customerlist->pluck('customername', 'customercode');
        #endregion
        #region workorder no list
        $workorderlist = null;
        $workordercode = null;
        $workorderlikelist = null;
        $workordertp = array();
        if ($customercode != null) {
            $workorderlist = ContractMasterModel::where('customercode', $customercode)->get();
            foreach ($workorderlist as $item) {
                $result = $item->where('workorderno', 'LIKE', '%' . mb_strtolower($complaint->workorderno) . '%')->get();
                if (count($result)) {
                    $workordertp[] = $item->where('workorderno', 'LIKE', '%' . mb_strtolower($complaint->workorderno) . '%')->get();
                }
            }

            if ($workordertp != null) {
                $workorderlikelist = $workordertp[0];
                $workorderlike = $workorderlikelist[0];
                $workordercode = $workorderlike['workorderno'];
            }

            if ($workorderlist != null) {
                $workorderlist = $workorderlist->pluck('workorderno', 'workorderno');
            }
        } else {
            $workorderlist = array();
            $workordercode = '';
        }
        #endregion
        #region branch master
        $branchlist = null;
        $branchcode = null;
        $branchlikelist = null;
        $branchtp = array();
        if ($customercode != null) {
            $contract = ContractMasterModel::where('workorderno',$complaint->workorderno)->get()->first();
            if($contract !=null)
            {
                $contractno = $contract->contractno;
                $branchlist = BranchMasterModel::where('contractno', $contract->contractno)->get();
                foreach ($branchlist as $item) {
                    $result = $item->where('branchname', 'LIKE', '%' . mb_strtolower($complaint->branchname) . '%')->get();
                    if (count($result)) {
                        $branchtp[] = $item->where('branchname', 'LIKE', '%' . mb_strtolower($complaint->branchname) . '%')->get();
                    }
                }
                if ($branchtp != null) {
                    $branchlikelist = $branchtp[0];
                    $branchlike = $branchlikelist[0];
                    $branchcode = $branchlike['branchcode'];
                }
                if ($branchlist != null) {
                    $branchlist = $branchlist->pluck('branchname', 'branchcode');
                }
            }
            else
            {
                $branchlist = array();
                $branchcode = '';
            }

        } else {
            $branchlist = array();
            $branchcode = '';
        }
        #endregion
        #region Bind Product Service in the view
        $chkproductlist = EquipmentMasterModel::where('branchcode', $branchcode)->get()->first();
        if($chkproductlist == null)
        {
            $productservicelist = ProductServiceMasterModel::all();
        }
        else
        {
            $productlist = EquipmentMasterModel::where('branchcode', $branchcode)->get();
            $products = $productlist->pluck('productservicecode');
            $productservicelist = DB::table('tblproductservicemaster')->whereIn('productservicecode', $products)->get();

        }

        $productservicename = null;
        $productservicecode = null;
        foreach ($productservicelist as $p) {
            if ($p->productservicecode == $complaint->product_service) {
                $productservicename = $p->productservicename;
                $productservicecode = $p->productservicecode;
            }
        }

        $productservice = $productservicelist->pluck('productservicename', 'productservicecode')->all();

        #endregion
        #region category bind in view
        $chkcategory = EquipmentMasterModel::where('branchcode', $branchcode)->get();
        if($chkcategory == null)
        {
            $categorylist=CategoryMasterModel::all();
        }
        else
        {
            $categorycodelist = EquipmentMasterModel::where('branchcode', $branchcode)->get();
            $categorycode = $categorycodelist->pluck('categorycode');
            $categorylist = DB::table('tblcategorymaster')->whereIn('categorycode', $categorycode)->get();
        }

        $categoryname = null;
        $categorycode = null;
        foreach ($categorylist as $p) {
            if ($p->categorycode == $complaint->category) {
                $categoryname = $p->categoryname;
                $categorycode = $p->categorycode;
            }
        }

        $category = $categorylist->pluck('categoryname', 'categorycode')->all();
        #endregion
        #region Bind Sub Category in the view

        $subcategorylist = SubCategoryMasterModel::where('categorycode', $complaint->category)->get();
        $subcategoryname = null;
        $subcategorycode = null;
        foreach ($subcategorylist as $p) {
            if ($p->subcategorycode == $complaint->subcategory) {
                $subcategoryname = $p->subcategoryname;
                $subcategorycode = $p->subcategorycode;
            }
        }

        $subcategory = $subcategorylist->pluck('subcategoryname', 'subcategorycode')->all();
        #endregion
        #region Bind Product sr no in the view

        #region workorder no list
        $productsrnolist = null;
        $productsrnocode = null;
        $productsrnolikelist = null;
        $productsrnotp = array();
        if ($customercode != null) {
            $contract = ContractMasterModel::where('workorderno',$complaint->workorderno)->get()->first();
            if($contract !=null)
            {
                $productsrnolist = EquipmentMasterModel::where('contractno', $contract->contractno)->get();
                foreach ($productsrnolist as $item) {
                    $result = $item->where('equipmentsrno', 'LIKE', '%' . mb_strtolower($complaint->productsrno_accountno) . '%')->get();
                    if (count($result)) {
                        $productsrnotp[] = $item->where('equipmentsrno', 'LIKE', '%' . mb_strtolower($complaint->productsrno_accountno) . '%')->get();
                    }
                }

                if ($productsrnotp != null) {
                    $productsrnolikelist = $productsrnotp[0];
                    $productsrnolike = $productsrnolikelist[0];
                    $productsrnocode = $productsrnolike['equipmentsrno'];
                }

                if ($productsrnolist != null) {
                    $productsrnolist = $productsrnolist->pluck('equipmentsrno', 'equipmentsrno');
                }
            }
            else{
                $productsrnolist = array();
                $productsrnocode = '';
            }


        } else {
            $productsrnolist = array();
            $productsrnocode = '';
        }
        #endregion


//
//        $productsrnolist = EquipmentMasterModel::where('branchcode', $branchcode)->get();
//        $count = count($productsrnolist);
//        if($count == 0)
//        {
//            $productsrno = EquipmentMasterModel::pluck('equipmentsrno','equipmentsrno')->all();
//            $productsrcode = null;
//        }
//        else
//        {
//            $productsrnoname = null;
//            $productsrnocode = null;
//            foreach ($productsrnolist as $p) {
//                if ($p->equipmentsrno == $complaint->productsrno_accountno) {
//                    $productsrnoname = $p->equipmentsrno;
//                    $productsrcode = $p->equipmentsrno;
//                }
//                else
//                {
//                    $productsrcode =null;
//                }
//            }
//            $productsrno = $productsrnolist->pluck('equipmentsrno', 'equipmentsrno')->all();
//        }
//


        #endregion

        $productserialno = $complaint->productsrno_accountno;
        $complaintdescription = $complaint->complaintdescription;
        $callername = $complaint->callername;
        $mobileno = $complaint->mobilenumber;
        $emailid = $complaint->emailid;
        $ticketno = $complaint->ticketno;
        $customertype = $complaint->customertype;

        if ($customercode == null) {
            $customercode = '';
        }

        return view('complaint.adminnewcomplaintmanage', compact('customername','branchcode','userworkorderno','branchlist', 'customercode', 'customerlike', 'productservice', 'customername', 'branchname', 'productservicename', 'productservicecode', 'category', 'categorycode', 'categoryname', 'subcategorycode', 'subcategoryname', 'subcategory', 'complaintdescription', 'callername', 'mobileno', 'emailid', 'ticketno', 'subcategorycode', 'customertype','productserialno','workorderlist','workordercode','productsrnolist','productsrnocode','contract'));
    }

    public function lodgeusercomplaint(Request $request){

//        return $request->all();
        $model = new ExistingUserComplaintLodging;
        $model->id = Uuid::uuid1();
        $model->ticketno = $request->ticketno;
        $model->contractno = $request->contractno;
        $model->complaintdate = Carbon::now(new DateTimeZone('Asia/Kolkata'));
        $model->customercode = $request->customerlike;
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
        $model->chargedcomplaint = $request->chargedcomplaint;
        $model->created_at = Carbon::now(new DateTimeZone('Asia/Kolkata'));
        $model->created_by = Auth::id();
        $model->updated_at = Carbon::now(new DateTimeZone('Asia/Kolkata'));
        $model->save();
        $user = ComplaintLodgingModel::find($request->ticketno);
        $user->complaintstatus = $statusname;
        $user->save();
        return redirect('complaints');
    }

    public function LodgedUserComplaint(Request $request,$ticketno){

        $model = new ExistingUserComplaintLodging;
        $model->ticketno = $request->ticketno;
        $model->complaintdate = Carbon::now(new DateTimeZone('Asia/Kolkata'));
        $model->customercode = $request->customerlike;
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

        $user = ComplaintLodgingModel::find($request->ticketno);
        $user->complaintstatus = $statusname;
        $user->save();

        return redirect('useraccess/dashboard');
    }

    public function rejectcomplaint(Request $request){

//        return $request->all();
        $complaint = ComplaintLodgingModel::findOrFail($request->ticketno);
        $complaint->complaintstatus = StatusMasterModel::where('statuscode', 'CP0009')->pluck('statusname')->first();
        $complaint->rejectionreason = $request->rejectionreason;
        $complaint->updated_at = Carbon::now(new DateTimeZone('Asia/Kolkata'));
        $complaint->updated_by = Auth::id();
        $complaint->save();
        return redirect('getallstatusshowpage');
//        return view('complaint.allcomplaintstatus');
    }

    public function nonexistingcustomercomplaintlist()
    {
        $nonexistingcustomercomplaints =  NonExistingUserComplaintLodging::all();
        return view('complaint.nonexistingcustomercomplaintlist', compact('nonexistingcustomercomplaints'));
    }

    public function closedcomplaintlist(){

        $existing = ExistingUserComplaintLodging::where('complaintstatus', 'CLOSED')->get();
        $nonExisting = NonExistingUserComplaintLodging::where('complaintstatus', 'CLOSED')->get();
        $closedcomplaints = $existing->merge($nonExisting)->sortByDesc('created_at');

        return view('complaint.closedcomplaints',compact('closedcomplaints'));
    }

    public function getallstatusshowpage()
    {
//        $complaints = ExistingUserComplaintLodging::all();
//        $complaints = \DB::select(\DB::raw('select DISTINCT ticketno,(SELECT customername FROM tblcustomermaster where customercode = t.customercode) as customername,(SELECT branchname from tblbranchmaster where branchcode = t.branchcode) as branchcode,complaintstatus,complaintdescription,complaintdate,closurecomment,complaintstatus from tblexistingcustomercomplaintlodging t  UNION select DISTINCT ticketno, null, null,complaintstatus,complaintdescription,complaintdate,closurecomment,complaintstatus from tblnonexistingcustomercomplaintlodging order by complaintdate desc'));
//        return view('complaint.allcomplaintstatus',compact('complaints'));
        return view('complaint.allcomplaintstatus');
    }

    public function allcomplaints(Request $request){

        $columns = array(
            0 =>'id',
            1 =>'ticketno',
            2=> 'customercode',
            3=> 'branchcode',
            4=> 'complaintdescription',
            5 => 'complaintdate',
            6 => 'closurecomment',
            7 => 'complaintstatus',
            8 => 'action'
        );
        $totalData = ExistingUserComplaintLodging::where('complaintdate','>=','2018-04-01')->count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if(empty($request->input('search.value')))
        {
            $posts =  ExistingUserComplaintLodging::selectraw('tblexistingcustomercomplaintlodging.*,tblcustomermaster.customername,tblbranchmaster.branchname')
                ->leftJoin('tblcustomermaster', 'tblcustomermaster.customercode', '=', 'tblexistingcustomercomplaintlodging.customercode')
                ->leftJoin('tblbranchmaster', 'tblbranchmaster.branchcode', '=', 'tblexistingcustomercomplaintlodging.branchcode')
                ->where('complaintdate','>=','2018-04-01')
//            $posts = ExistingUserComplaintLodging::offset($start)
                ->offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
//                ->orderBy('tblexistingcustomercomplaintlodging.complaintdate','desc')
                ->get();
        }
        else {
            $search = $request->input('search.value');
            $posts =  ExistingUserComplaintLodging::selectraw('tblexistingcustomercomplaintlodging.*,tblcustomermaster.customername,tblbranchmaster.branchname')
                ->leftJoin('tblcustomermaster', 'tblcustomermaster.customercode', '=', 'tblexistingcustomercomplaintlodging.customercode')
                ->leftJoin('tblbranchmaster', 'tblbranchmaster.branchcode', '=', 'tblexistingcustomercomplaintlodging.branchcode')
//            $posts = ExistingUserComplaintLodging::where('ticketno','LIKE',"%{$search}%")
                ->where('ticketno','LIKE',"%{$search}%")
                ->orWhere('complaintdate', 'LIKE',"%{$search}%")
                ->orWhere('complaintstatus', 'LIKE',"%{$search}%")
                ->orWhere('complaintdescription', 'LIKE',"%{$search}%")
                ->orWhere('customername', 'LIKE',"%{$search}%")
                ->orWhere('branchname', 'LIKE',"%{$search}%")
                ->where('complaintdate','>=','2018-04-01')
                ->offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get();

            $totalFiltered =  ExistingUserComplaintLodging::selectraw('tblexistingcustomercomplaintlodging.*,tblcustomermaster.customername,tblbranchmaster.branchname')
                ->Join('tblcustomermaster', 'tblcustomermaster.customercode', '=', 'tblexistingcustomercomplaintlodging.customercode')
                ->Join('tblbranchmaster', 'tblbranchmaster.branchcode', '=', 'tblexistingcustomercomplaintlodging.branchcode')
                ->where('ticketno','LIKE',"%{$search}%")
//               $totalFiltered = ExistingUserComplaintLodging::where('ticketno','LIKE',"%{$search}%")
                ->orWhere('complaintdate', 'LIKE',"%{$search}%")
                ->orWhere('complaintstatus', 'LIKE',"%{$search}%")
                ->orWhere('complaintdescription', 'LIKE',"%{$search}%")
                ->orWhere('customername', 'LIKE',"%{$search}%")
                ->orWhere('branchname', 'LIKE',"%{$search}%")
                ->where('complaintdate','>=','2018-04-01')
                ->count();
        }

        $url = "/getallstatusshowpage/view/";
        //$url = "/technowin-crs/public/index.php/getallstatusshowpage/view/";            //Live code url
        //$url = "/technowin-crs/public/index.php/getallstatusshowpage/view/";            //Live code url

        $data = array();
        if(!empty($posts))
        {
            $count = 1;
            foreach ($posts as $post)
            {
                $nestedData['id'] = $count++;
                $nestedData['ticketno'] = $post->ticketno;
                $nestedData['customercode'] = $post->customername;
                $nestedData['branchcode'] = $post->branchname;
                $nestedData['complaintdescription'] = $post->complaintdescription;
                $nestedData['complaintdate'] = $post->complaintdate;
                $nestedData['closurecomment'] = $post->closurecomment;
                $nestedData['complaintstatus'] = $post->complaintstatus;
                $nestedData['viewurl'] = $url.$post->ticketno;
                $data[] = $nestedData;
            }
        }

        $json_data = array(
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $data,
        );

        echo json_encode($json_data);
    }

    public function allStatusView($ticketno){
        try {
            $ticketnumber = ExistingUserComplaintLodging::SelectRaw('tblexistingcustomercomplaintlodging.*,tblcustomermaster.customername,tblbranchmaster.branchname,tblproductservicemaster.productservicename,tblcategorymaster.categoryname,tblsubcategorymaster.subcategoryname')
                ->leftjoin('tblcustomermaster','tblcustomermaster.customercode','=','tblexistingcustomercomplaintlodging.customercode')
                ->leftjoin('tblbranchmaster','tblbranchmaster.branchcode','=','tblexistingcustomercomplaintlodging.branchcode')
                ->leftjoin('tblproductservicemaster','tblproductservicemaster.productservicecode','=','tblexistingcustomercomplaintlodging.productservicecode')
                ->leftjoin('tblcategorymaster','tblcategorymaster.categorycode','=','tblexistingcustomercomplaintlodging.categorycode')
                ->leftjoin('tblsubcategorymaster','tblsubcategorymaster.subcategorycode','=','tblexistingcustomercomplaintlodging.subcategorycode')
                ->where('tblexistingcustomercomplaintlodging.ticketno', '=', $ticketno)->get()->first();
            $userid = Auth::id();
            $user =  User::where('id',$userid)->get()->first();
            $previouslyassignedto = TicketAssignedHistoryModel::where('ticketno',$ticketnumber->ticketno)->orderBy('id','desc')->get();
            $ticketdetails = TicketAssignedModel::where('ticketno',$ticketnumber->ticketno)->get();

            if(count($previouslyassignedto) > 0) {
                $status = $previouslyassignedto->first()->assigneestatus;
            }
            else{
                $status =$ticketnumber->complaintstatus;
            }
            if($status != 'ACKNOWLEDGED' && count($previouslyassignedto) > 0){
                $filedetails = AssigneeFilesModel::where('ticketassigneedetailsid', $ticketdetails->first()->id)->get();
            }
            return view('complaint.allcomplaintstatusview', compact('ticketnumber',  'filedetails', 'user', 'previouslyassignedto','status'));

        }
        catch (Exception $ex) {
            $common = new CommonController;
            $common->ErrorLogging($ex, 'UserComplaint', 'newcomplaintregister');
            return 'Some error occurred while processing your request';
        }

    }

    public function showFile($id)
    {
        $filedetails = AssigneeFilesModel::where('id', $id)->get()->first();
        return view('complaint.fileView',compact('filedetails'));
    }


}