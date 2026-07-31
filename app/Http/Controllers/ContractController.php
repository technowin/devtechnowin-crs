<?php

namespace App\Http\Controllers;

use App\Imports\ExcelImport;
use App\Models\BranchMasterModel;
use App\Models\CategoryMasterModel;
use App\Models\ContractDetailsModel;
use App\Models\ContractMasterModel;
use App\Models\CustomersModel;
use App\Models\ExcelTestModel;
use App\Models\ProductServiceMasterModel;
use App\Models\TenderViewModel;
use Auth;
use Carbon\Carbon;
use DateTimeZone;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
//use Maatwebsite\Excel\Excel;
use Maatwebsite\Excel\Facades\Excel;
use PhpParser\JsonDecoder;
use Ramsey\Uuid\Uuid;
use App\Models\ServiceParametersModel;
use App\Models\EquipmentMasterModel;
use Illuminate\Support\Facades\DB;
use App\Models\IncrementMasterModel;
use App\Models\BranchContactMasterModel;
use App\Models\ServiceManagementModel;
use App\Models\SupplyManagementModel;
use App\Models\ContractPaymentTermModel;
use App\Models\ContractPaymentschedulesModel;
use function count;

use App\Models\ContractDocumentsModel;
use App\Models\ContractBillingModel;
use App\Models\BillingPaymentCyclesModel;

use Illuminate\Support\Facades\Storage;


use App\Models\PaymentDetailsNewModel;
use App\Models\DashboardAlertConfigModel; 

class ContractController extends Controller
{
    public function index()
    {

         //$contracts = ContractMasterModel::all();
          $contracts = ContractMasterModel::selectRaw('tblcontractmaster.*,tblcustomermaster.customername')
            ->leftjoin('tblcustomermaster', 'tblcustomermaster.customercode', '=', 'tblcontractmaster.customercode')
            ->orderByRaw("-closuredate",'asc')
            ->orderBy('updated_at', 'desc')
            ->get();
        return view('contract.indexContracts', compact('contracts'));
    }

    public function create()
    {
        $contractsaved = 'false';
        $customers = CustomersModel::pluck('customername', 'customercode');
//        $tenders = TenderViewModel::where('technicalbidstatus', 'Selected')->where('commercialbidstatus', 'Selected')->pluck('tenderno', 'tenderno');
        $tenders = TenderViewModel::pluck('tenderno', 'tenderno');
        $productservice = ProductServiceMasterModel::where('isactive','=',1)->pluck('productservicename', 'productservicecode')->all();

        $workorder = CustomersModel::all();
        $work = $workorder->pluck('workorderno', 'customercode')->all();
        $branchmastercode = BranchMasterModel::pluck('branchname', 'branchcode');
        $serviceParameterscode = ServiceParametersModel::all()->pluck('name', 'name');
//        $serviceParameterscode = ServiceParametersModel::pluck('name', 'name');
        $categorycode = CategoryMasterModel::pluck('categoryname', 'categorycode');
        $eqipmentproductservice = ProductServiceMasterModel::pluck('productservicename', 'productservicecode');
        return view('contract.createNewContract', compact('customers', 'tenders', 'productservice', 'contractsaved', 'work', 'serviceParameterscode', 'branchmastercode', 'categorycode', 'eqipmentproductservice'));
    }

    public function addNewContract()
    {
        $user = auth()->user();
        try {
            if ($_GET['contractsaved'] != '0') {
                $contract = ContractMasterModel::find($_GET['contractsaved']);
                $contract->customercode = $this->checkifdataisempty($_GET['customers']);
                $contract->tenderno = $this->checkifdataisempty($_GET['tenderno']);
                $contract->tenderopendate = $this->checkifdataisempty($_GET['tenderopendate']);
                $contract->workordertype = $this->checkifdataisempty($_GET['workordertype']);
                $contract->workorderno = $this->checkifdataisempty($_GET['workorderno']);
                $contract->workorderdescription = $this->checkifdataisempty($_GET['workorderdescription']);
                $contract->workorderdate = $this->checkifdataisempty($_GET['workorderdate']);
                $contract->contractfromdate = $this->checkifdataisempty($_GET['contractfromdate']);
                $contract->contracttodate = $this->checkifdataisempty($_GET['contracttodate']);
                $contract->purchaseorderno = $this->checkifdataisempty($_GET['purchaseorderno']);
                $contract->purchaseorderdate = $this->checkifdataisempty($_GET['purchaseorderdate']);
                $contract->amendmentno = $this->checkifdataisempty($_GET['amendmentno']);
                $contract->amendmentdescription = $this->checkifdataisempty($_GET['amendmentdescription']);
                $contract->renewalperiod = $this->checkifdataisempty($_GET['renewalperiod']);
                $contract->totalcost = $this->checkifdataisempty($_GET['totalcost']);
                $contract->contractperiod = $this->checkifdataisempty($_GET['contractperiod']);
                $contract->closuredate = $this->checkifdataisempty($_GET['closerdate']);


                $contract->projectownername = $this->checkifdataisempty($_GET['projectownername']);
                $contract->billingownername = $this->checkifdataisempty($_GET['billingownername']);



                if($_GET['serviceParameterscode'] != null){
                    $contract->servicefrequency = $this->checkifdataisempty($_GET['serviceParameterscode']);
                }
                else{
                    $contract->servicefrequency = null;
                }

                $contract->contractno = $_GET['contractsaved'];
                $code = $_GET['contractsaved'];
                $contract->updated_at = Carbon::now(new DateTimeZone('Asia/Kolkata'));
                $contract->updated_by = $user->name;
                $contract->comprehensivetype = $this->checkifdataisempty($_GET['comprehensivetype']);
                $contract->save();
            } else {

                $code = null;
                $contract = new ContractMasterModel;
                $contract->customercode = $this->checkifdataisempty($_GET['customers']);
                
                $contract->tenderno = $this->checkifdataisempty($_GET['tenderno']);
                $contract->tenderopendate = $this->checkifdataisempty($_GET['tenderopendate']);
                $contract->workordertype = $this->checkifdataisempty($_GET['workordertype']);
                $contract->workorderno = $this->checkifdataisempty($_GET['workorderno']);
                $contract->workorderdescription = $this->checkifdataisempty($_GET['workorderdescription']);
                $contract->workorderdate = $this->checkifdataisempty($_GET['workorderdate']);
                $contract->contractfromdate = $this->checkifdataisempty($_GET['contractfromdate']);
                $contract->contracttodate = $this->checkifdataisempty($_GET['contracttodate']);
                $contract->purchaseorderno = $this->checkifdataisempty($_GET['purchaseorderno']);
                $contract->purchaseorderdate = $this->checkifdataisempty($_GET['purchaseorderdate']);
                $contract->amendmentno = $this->checkifdataisempty($_GET['amendmentno']);
                $contract->amendmentdescription = $this->checkifdataisempty($_GET['amendmentdescription']);
                $contract->renewalperiod = $this->checkifdataisempty($_GET['renewalperiod']);
                $contract->totalcost = $this->checkifdataisempty($_GET['totalcost']);
                $contract->contractperiod = $this->checkifdataisempty($_GET['contractperiod']);
                $contract->closuredate = $this->checkifdataisempty($_GET['closerdate']);


                $contract->projectownername = $this->checkifdataisempty($_GET['projectownername']);
                $contract->billingownername = $this->checkifdataisempty($_GET['billingownername']);


                $contract->servicefrequency = $this->checkifdataisempty($_GET['serviceParameterscode']);
                $contract->comprehensivetype = $this->checkifdataisempty($_GET['comprehensivetype']);
                $contract->created_at = Carbon::now(new DateTimeZone('Asia/Kolkata'));
                $contract->created_by = $user->name;
                $contract->updated_at = Carbon::now(new DateTimeZone('Asia/Kolkata'));
                $tablename = 'Contractno';
                $tempcode = $this->contractno($contract->contractfromdate, $contract->contracttodate, $contract->workordertype, $tablename);
                $code = $tempcode['code'];
                $contract->contractno = $code;
                $incrementid = $tempcode['incrementid'];
                $contract->save();

                if ($_GET['workordertype'] == "Hardware AMC") {
                    $serviceparameter = ServiceParametersModel::where('name', $_GET['serviceParameterscode'])->get();
                    $fromdate = $_GET['contracttodate'];
                    $todate = $_GET['contractfromdate'];
                    $to = Carbon::createFromFormat('Y-m-d', $fromdate);
                    $from = Carbon::createFromFormat('Y-m-d', $todate);
                    $months = $to->diffInMonths($from);
                    $countmonths = $months / $serviceparameter[0]->id;
                    $getdate = $_GET['contractfromdate'];
                    for ($i = 1; $i <= $countmonths; $i++) {
                        $service = new ServiceManagementModel();
                        $id = Uuid::uuid1();
                        $service->id = $id;
                        $service->contractno = $code;
                        $service->customercode = $this->checkifdataisempty($_GET['customers']);
                        if ($i == 1) {
                            $service->serviceadate = date('Y-m-d', strtotime($getdate . '+' . $serviceparameter[0]->id . 'months -1 days'));
                            $getdate = $service->serviceadate;
                        } else {
                            $service->serviceadate = $getdate;
                        }
                        $service->servicereminderdate = date('Y-m-d', strtotime($getdate . '-' . $serviceparameter[0]->leadlogdays . 'days'));
                        $service->flagkey = '0';
                        $service->created_at = Carbon::now(new DateTimeZone('Asia/Kolkata'));
                        $service->save();
                        $getdate = date('Y-m-d', strtotime($getdate . '+' . $serviceparameter[0]->id . 'months'));
                    }
                }
//                if ($_GET['workordertype'] == "Hardware Warranty" || $_GET['workordertype'] == "Software development" || $_GET['workordertype'] == "Hardware Supply")
                if ($_GET['workordertype'] == "Hardware Warranty") {
                    $supply = new SupplyManagementModel();
                    $id = Uuid::uuid1();
                    $supply->id = $id;
                    $supply->contractno = $code;
                    $supply->customercode = $this->checkifdataisempty($_GET['customers']);
                    $supply->preventivemaintenancedate = $_GET['servicedate'];
                    $supply->preventivemaintenancereminderdate = $_GET['servicereminderdate'];
                    $supply->created_at = Carbon::now(new DateTimeZone('Asia/Kolkata'));
                    $supply->created_by = Auth::id();
                    $supply->save();
                }


                if ($contract->save() == true) {
                    $incrementcontractid = "Contractno";
                    $modelincrement = IncrementMasterModel::find(IncrementMasterModel::where('incrementfor', $incrementcontractid)->first()->incrementid);
                    $modelincrement->incrementvalue = $incrementid;
                    $modelincrement->save();
                }
            }

            $customerlist = ContractMasterModel::where('contractno', '=', $code)->get()->first();
            $customercode = $customerlist->customercode;
            $contractperiod = $customerlist->contractperiod;
            if($_GET['serviceParameterscode'] != null){
                $serviceparameterid = ServiceParametersModel::where('name', $_GET['serviceParameterscode'])->get()->pluck('id');
                $serviceparameter = ServiceParametersModel::where('id', '>=', $serviceparameterid)->get();
            }
            else{
                $serviceparameter = '';
            }

            return json_encode(array('code' => $code, 'customercode' => $customercode, 'contractperiod' => $contractperiod, 'serviceparameter' => $serviceparameter));


        } catch (Exception $exception) {
            return response()->json([
                'error' => true,
                'message' => $exception->getMessage(),
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
            ], 500);
        }
    }

    public function addnewcontractsitemaster()
    {
        try {
            $user = auth()->user();
//            return json_encode($_GET["contractsitemaster"]);
            $branch = $_GET["branchname"];
            $phone = $_GET["phone"];
            $fax = $_GET["fax"];
            $email = $_GET["email"];
            $count = count($branch);
            $contractcode = $_GET['contractno'];
            for ($i = 0; $i < $count; $i++) {
                if ($_GET['contractsitemaster'][$i] != '0') {
                    $model = BranchMasterModel::where('branchcode', '=', $_GET['contractsitemaster'][$i])->where('contractno', '=', $contractcode)->get()->first();
//                    $model = BranchMasterModel::find($_GET['contractsitemaster'][$i]);
                    $model->branchname = $_GET["branchname"][$i];
                    $model->branchcode = $_GET['contractsitemaster'][$i];
                    $model->phone = $phone[$i];
                    $model->fax = $fax[$i];
                    $model->email = $email[$i];
                    $model->contractno = $contractcode;
                    $model->updated_at = Carbon::now(new DateTimeZone('Asia/Kolkata'));
                    $model->updated_by = $user->name;
                    $model->save();
                } else {
//                    return json_encode('Else');
                    $common = new CommonController();
                    $model = new BranchMasterModel();
                    $model->branchname = $_GET["branchname"][$i];
                    $mystr = $_GET['branchname'][$i];
                    $tablename = "Branchname";
                    $tempcode = $common->DynamicCode($mystr, $tablename);
                    $code = $tempcode['code'];
                    $incrementid = $tempcode['incrementid'];
                    $model->branchcode = $code;
                    $model->phone = $phone[$i];
                    $model->fax = $fax[$i];
                    $model->email = $email[$i];
                    $model->customercode = $_GET["customercode"];
                    $model->contractno = $_GET['contractno'];
                    $contractcode = $_GET['contractno'];
                    $model->created_at = Carbon::now(new DateTimeZone('Asia/Kolkata'));
                    $model->created_by = $user->name;
                    $model->updated_at = null;
                    $model->save();
                    if ($model->save() == true) {
                        $id = "Branchname";
                        $modelincrement = IncrementMasterModel::find(IncrementMasterModel::where('incrementfor', $id)->first()->incrementid);
                        $modelincrement->incrementvalue = $incrementid;
                        $modelincrement->save();
                    }
                }
            }
            $branchlist = BranchMasterModel::where('contractno', '=', $contractcode)->get();
            return json_encode(array('branchlist' => $branchlist, 'contractcode' => $contractcode));
        } catch (Exception $exception) {
            return json_encode($exception);
        }
    }

    public function addnewcontractsitecontactmaster()
    {
        try {
            $user = auth()->user();
//            return json_encode($_GET['contractsitecontact']);
            $branch = $_GET["branchcode"];
            $phone = $_GET["phone"];
            $fax = $_GET["fax"];
            $emailid = $_GET["emailid"];
            $contractcode = $_GET['contractno'];
            $count = count($branch);
            for ($i = 0; $i < $count; $i++) {
                if ($_GET['contractsitecontact'][$i] != '0') {
                    $model = BranchContactMasterModel::where('branchcontactcode', '=', $_GET['contractsitecontact'][$i])->where('contractno', '=', $contractcode)->get()->first();
//                    $model = BranchContactMasterModel::find($_GET['contractsitecontact'][$i]);
                    $model->branchcontactcode = $_GET["contractsitecontact"][$i];
                    $model->branchcode = $_GET["branchcode"][$i];
                    $model->phone = $phone[$i];
                    $model->fax = $fax[$i];
                    $model->emailid = $emailid[$i];
                    $model->contractno = $contractcode;
                    $model->updated_by = $user->name;
                    $model->updated_at = Carbon::now(new DateTimeZone('Asia/Kolkata'));
                    $model->save();

                } else {
                    $common = new CommonController();
                    $model = new BranchContactMasterModel();
                    $model->contactpersonname = $_GET["contactpersonname"][$i];
                    $mystr = $_GET['contactpersonname'][$i];
                    $tablename = "BranchContactPerson";
                    $tempcode = $common->DynamicCode($mystr, $tablename);
                    $code = $tempcode['code'];
                    $model->branchcontactcode = $code;
                    $model->branchcode = $_GET["branchcode"][$i];
                    $incrementid = $tempcode['incrementid'];
                    $model->phone = $phone[$i];
                    $model->fax = $fax[$i];
                    $model->emailid = $emailid[$i];
                    $model->contractno = $contractcode;
                    $model->created_at = Carbon::now(new DateTimeZone('Asia/Kolkata'));
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
                $contactbranchlist = BranchContactMasterModel::where('contractno', $contractcode)->get();
            }
            return json_encode(array('contractcode' => $contractcode, 'contactbranchlist' => $contactbranchlist));
        } catch (Exception $exception) {
            return json_encode($exception);
        }
    }

    public function addContractDetails()
    {
        try {
            $user = auth()->user();
//           return json_encode($_GET['contractdetailssaveid']);
            $contractno = $_GET['contractno'];
            $products = $_GET['productservice'];
            $rate = $_GET['rate'];
            $quantity = $_GET['quantity'];
            $warranty_amc_period = $_GET['warranty_amc_period'];
            $sgstrate = $_GET['sgstrate'];
            $sgstamt = $_GET['sgstamt'];
            $cgstrate = $_GET['cgstrate'];
            $cgstamt = $_GET['cgstamt'];
            $taxrate = $_GET['taxrate'];
            $tax = $_GET['taxamt'];
            $totaltax = $_GET['taxtotalamt'];
            $totalcontractcost = $_GET['totalcontractcost'];
            $hsncode = $_GET['hsncode'];

     //       $grossrate = (int)$rate * (int)$quantity;

            $count = count($products);
            for ($i = 0; $i < $count; $i++) {

                if ($_GET['contractdetailssaveid'][$i] != '0') {
                    $contractdetails = ContractDetailsModel::where('contractno', $_GET['contractdetailssaveid'][$i])->get()->first();
                    $contractdetails->updated_at = Carbon::now(new DateTimeZone('Asia/Kolkata'));
                    $contractdetails->updated_by = $user->name;
                } else {
                    $contractdetails = new ContractDetailsModel();
                    $id = Uuid::uuid1();
                    $contractdetails->id = $id;
                    $contractdetails->created_at = Carbon::now(new DateTimeZone('Asia/Kolkata'));
                    $contractdetails->created_by = $user->name;
                    $contractdetails->updated_at = null;
                }
                $contractdetails->contractno = $contractno;
                $contractdetails->productservicecode = $products[$i];
                $contractdetails->quantity = $quantity[$i];
                $contractdetails->rate = $rate[$i];
                $contractdetails->taxamt = $tax[$i];
                $contractdetails->warranty_amcperiod = $warranty_amc_period[$i];
                $grossrate = $rate[$i] * $quantity[$i];
                $contractdetails->grossrate = $grossrate;

                $contractdetails->sgstrate = $sgstrate[$i];
                $contractdetails->sgstamt = $sgstamt[$i];
                $contractdetails->cgstrate = $cgstrate[$i];
                $contractdetails->cgstamt = $cgstamt[$i];
                $contractdetails->taxrate = $taxrate[$i];
                $contractdetails->totaltax = $totaltax[$i];
                $contractdetails->totalcontractcost = $totalcontractcost[$i];
                $contractdetails->hsncode = $hsncode[$i];

                $taxtotalamt = $sgstamt[$i] + $cgstamt[$i] + $tax[$i];
                $contractdetails->taxtotalamt = $taxtotalamt;

                $contractdetails->save();
            }

            $branchlist = BranchMasterModel::where('contractno', '=', $contractno)->get();
            $equipment = ContractDetailsModel::where('contractno', '=', $contractno)->pluck('productservicecode');
            $equipmentlist = ProductServiceMasterModel::whereIn('productservicecode', $equipment)->get();
            $contractlist = ContractDetailsModel::where('contractno', '=', $contractno)->get();
            $contracttype = ContractMasterModel::where('contractno', '=', $contractno)->get()->first();
            return json_encode(array('contracttype' => $contracttype, 'branchlist' => $branchlist, 'contractcode' => $contractno, 'equipment' => $equipmentlist, 'contractlist' => $contractlist));
        } catch (Exception $exception) {
            return json_encode($exception);
        }
    }

    public function addequipmentDetails()
    {
        try {
            $user = auth()->user();
//            $test = $_GET['equipmentdetailssavedid'];
//            return json_encode($test);
            $customercode = $_GET['equipmentcustomercode'];
            $product = $_GET['eqipmentproductservice'];
            $category = $_GET['categorycode'];
            $equipmentsrno = $_GET['equipmentsrno'];
            $productsrno = $_GET['productsrno'];
            $specification = $_GET['specification'];
            $contractcode = $_GET['contractno'];
            $branch = $_GET['branchcode'];
            $count = count($product);
            if($_GET['equipmentsrno'][0] != "") {
            for ($i = 0; $i < $count; $i++) {
                if ($_GET['equipmentdetailssavedid'][$i] != '0') {
                    $model = EquipmentMasterModel::where('equipmentsrno', $equipmentsrno[$i])->where('contractno', $contractcode)->where('status', 'Active')->get()->first();
                    $model->updated_at = Carbon::now(new DateTimeZone('Asia/Kolkata'));
                    $model->updated_by = $user->name;
                } else {
                    $model = new EquipmentMasterModel;
                    $model->created_at = Carbon::now(new DateTimeZone('Asia/Kolkata'));
                    $model->created_by = $user->name;
                    $model->updated_at = null;
                    $model->status = "Active";
                }
                $contractcode = $_GET['contractno'];
                $model->customercode = $customercode;
                $model->contractno = $contractcode;
                $model->contracttype = $_GET['contracttype'];
                $model->branchcode = $branch[$i];
                $model->productservicecode = $product[$i];
                $model->categorycode = $category[$i];
                $model->equipmentsrno = $equipmentsrno[$i];
                $model->productsrno = $productsrno[$i];
                $model->specification = $specification[$i];
                $model->flagkey = '0';
                $model->save();
            }
            }
            $equipmentslist = EquipmentMasterModel::where('contractno', '=', $_GET['contractno'])->get();

            return json_encode(array('equipmentslist' => $equipmentslist, 'contractcode' => $contractcode));

        } catch (Exception $exception) {
            return json_encode($exception);
        }

        return redirect('contracts');
    }

    public function addPaymentTerms()
    {

        try {
            $model = new ContractPaymentTermModel();
            $model->id = Uuid::uuid1();
            $model->contractno = $_GET['contractno'];
            $model->securitydeposit = $this->checkifdataisempty($_GET['securitydeposit']);
            $model->sbpaymentperiod = $this->checkifdataisempty($_GET['sbpaymentperiod']);
            $model->admincharges = $this->checkifdataisempty($_GET['admincharges']);
            $model->facilitycharges = $this->checkifdataisempty($_GET['facilitycharges']);
            $model->paymentintervalforamc = $this->checkifdataisempty($_GET['paymentintervalforamc']);
            $model->leaddaysforpayment = $this->checkifdataisempty($_GET['leaddaysforpayment']);
            $model->customeriniatedbilling = $this->checkifdataisempty($_GET['customeriniatedbilling']);
//               ------supply----
            $model->firstpaymentpercent = $this->checkifdataisempty($_GET['firstpaymentpercent']);
            $model->firstpaymentcriteria = $this->checkifdataisempty($_GET['firstpaymentcriteria']);
            $model->secondpaymentpercent = $this->checkifdataisempty($_GET['secondpaymentpercent']);
            $model->secondpaymentcriteria = $this->checkifdataisempty($_GET['secondpaymentcriteria']);
            $model->thirdpaymentpercent = $this->checkifdataisempty($_GET['thirdpaymentpercent']);
            $model->thirdpaymentcriteria = $this->checkifdataisempty($_GET['thirdpaymentcriteria']);
            $model->fourthpaymentpercent = $this->checkifdataisempty($_GET['fourthpaymentpercent']);
            $model->fourthpaymentcriteria = $this->checkifdataisempty($_GET['fourthpaymentcriteria']);
            $model->fifthpaymentpercent = $this->checkifdataisempty($_GET['fifthpaymentpercent']);
            $model->fifthpaymentcriteria = $this->checkifdataisempty($_GET['fifthpaymentcriteria']);
            $model->created_at = Carbon::now(new DateTimeZone('Asia/Kolkata'));
            $model->created_by = Auth::id();
            $model->updated_at = null;

            $model->save();
//
            if ($_GET['paymentworkorder'] == "Software Maintenance" || $_GET['paymentworkorder'] == "Hardware AMC") {

                $service = ServiceManagementModel::where('contractno', $_GET['contractno'])->orderby('serviceadate', 'ASC')->get();
                $contractdate = ContractMasterModel::where('contractno', $_GET['contractno'])->get()->first();
                $fromdate = $contractdate->contractfromdate;
                $todate = $contractdate->contracttodate;
                $from = Carbon::createFromFormat('Y-m-d', $fromdate);
                $to = Carbon::createFromFormat('Y-m-d', $todate);
                $months = $to->diffInMonths($from);

                $serviceparameter = ServiceParametersModel::where('name', $_GET['paymentintervalforamc'])->get()->first();
                $countmonths = $months / $serviceparameter->id;
                $getdate = $from;
                $preservicedate = $from;
                for ($i = 1; $i <= $countmonths; $i++) {

                    $paymentschedule = new ContractPaymentschedulesModel();
                    $paymentschedule->id = Uuid::uuid1();
                    $paymentschedule->contractno = $_GET['contractno'];
                    $paymentschedule->paymentcycleno = $i;
                    $paymentschedule->created_at = Carbon::now(new DateTimeZone('Asia/Kolkata'));
                    $paymentschedule->created_by = Auth::id();
                    $paymentschedule->updated_at = null;
                    if ($i == 1) {
                        $service->paymentduedate = date('Y-m-d', strtotime($getdate . '+' . $serviceparameter->id . 'months -1 days '));
                        $getdate = $service->paymentduedate;
                        $preservicedate = $getdate;
//                         -----paymentschedule----
                        $paymentschedule->paymentcyclestartdate = $from;
                        $paymentschedule->paymentcycleenddate = $getdate;
                        $paymentschedule->paymentduedate = $getdate;
                        $paymentschedule->save();

                        $servicedate = ServiceManagementModel::where('serviceadate', '<=', $getdate)->where('contractno', $_GET['contractno'])->get();
                        for ($n = 0; $n < count($servicedate); $n++) {
                            $model = ServiceManagementModel::find($servicedate[$n]->id);
                            $model->paymentduedate = $getdate;
                            $model->save();
                        }
                    } else {
                        $paymentschedule->paymentcyclestartdate = $preservicedate;
                        $paymentschedule->paymentcycleenddate = $getdate;
                        $paymentschedule->paymentduedate = $getdate;
                        $paymentschedule->save();
//                        $service->paymentduedate = $getdate;
                        $servicedate = ServiceManagementModel::whereBetween('serviceadate', [$preservicedate, $getdate])->where('serviceadate', '>', $preservicedate)->where('contractno', $_GET['contractno'])->get();
                        for ($n = 0; $n < count($servicedate); $n++) {
                            $model = ServiceManagementModel::find($servicedate[$n]->id);
                            $model->paymentduedate = $getdate;
                            $model->save();
                        }
                        $preservicedate = $getdate;
                    }
                    $getdate = date('Y-m-d', strtotime($getdate . '+' . $serviceparameter->id . 'months'));
                }

            } elseif ($_GET['paymentworkorder'] == "Hardware Warranty" || $_GET['paymentworkorder'] == "Software development") {
                $paymentcycleno = 0;
                if ($_GET['firstpaymentpercent'] != null) {
                    $contractpaymentschdule = new ContractPaymentschedulesModel();
//                    $paymentcycleno++;
                    $contractpaymentschdule->id = Uuid::uuid1();
                    $contractpaymentschdule->contractno = $_GET['contractno'];
                    $contractpaymentschdule->paymentcycleno = ++$paymentcycleno;
                    $contractpaymentschdule->paymentype = $_GET['firstpaymentcriteria'];
                    $contractpaymentschdule->save();
                    if ($_GET['secondpaymentpercent'] != null) {
                        $contractpaymentschdule = new ContractPaymentschedulesModel();
//                        $paymentcycleno++;
                        $contractpaymentschdule->id = Uuid::uuid1();
                        $contractpaymentschdule->contractno = $_GET['contractno'];
                        $contractpaymentschdule->paymentcycleno = ++$paymentcycleno;
                        $contractpaymentschdule->paymentype = $_GET['secondpaymentcriteria'];

                        $contractpaymentschdule->save();
                        if ($_GET['thirdpaymentpercent'] != null) {
                            $contractpaymentschdule = new ContractPaymentschedulesModel();
//                            $paymentcycleno++;
                            $contractpaymentschdule->id = Uuid::uuid1();
                            $contractpaymentschdule->contractno = $_GET['contractno'];
                            $contractpaymentschdule->paymentcycleno = ++$paymentcycleno;
                            $contractpaymentschdule->paymentype = $_GET['thirdpaymentcriteria'];
                            $contractpaymentschdule->save();
                            if ($_GET['fourthpaymentpercent'] != null) {
                                $contractpaymentschdule = new ContractPaymentschedulesModel();
//                                $paymentcycleno++;
                                $contractpaymentschdule->id = Uuid::uuid1();
                                $contractpaymentschdule->contractno = $_GET['contractno'];
                                $contractpaymentschdule->paymentcycleno = ++$paymentcycleno;
                                $contractpaymentschdule->paymentype = $_GET['fourthpaymentcriteria'];
                                $contractpaymentschdule->save();
                                if ($_GET['fifthpaymentpercent'] != null) {
                                    $contractpaymentschdule = new ContractPaymentschedulesModel();
//                                    $paymentcycleno++;
                                    $contractpaymentschdule->id = Uuid::uuid1();
                                    $contractpaymentschdule->contractno = $_GET['contractno'];
                                    $contractpaymentschdule->paymentcycleno = ++$paymentcycleno;
                                    $contractpaymentschdule->paymentype = $_GET['fifthpaymentcriteria'];
                                    $contractpaymentschdule->save();

                                }
                            }

                        }
                    }
                }

            }

            return json_encode('Done');
        } catch (Exception $exception) {
            return json_encode($exception);
        }

    }

    public function addPayables(Request $request)
    {
        $payables = new ContractPayablesModel();
        $payables->id = Uuid::uuid1();
        $payables->contractno = $request->contractno;
        $payables->sdpaymentdate = $request->sdpaymentdate;
        $payables->totalsecuritydepositpaid = $request->totalsecuritydepositpaid;
        $payables->sdpaymentmode = $request->sdpaymentmode;
        $payables->adminchargespaymentdate = $request->adminchargespaymentdate;
        $payables->adminchargespaid = $request->adminchargespaid;
        $payables->facilitychargespaymentdate = $request->facilitychargespaymentdate;
        $payables->facilitychargespaid = $request->facilitychargespaid;
        $payables->save();

        return redirect('appadmin/contracts');
    }

    public function uploadExcel()
    {
        $branchlist = BranchMasterModel::where('contractno', '=', '2020-21-HAR-0600')->get();
        $equipment = ContractDetailsModel::where('contractno', '=', '2020-21-HAR-0600')->get();
        return view('contract.uploadExcel');
    }

    public function uploadExcelPost(Request $request)
    {
        $equipments ='';
        try {
            $contractNo = $request['contractnoupload'];
            $customerCode = $request['customerupload'];
            $contractType = $request['contracttypeupload'];
            $workOrderNo = $request['workorderupload'];
            $branchCode = $request['branchcodeupload'];
            $productserviceCode = $request['eqipmentproductserviceupload'];
            $categoryCode = $request['categorycodeupload'];
            $flagKey = 0;
            $status = "Active";
            $createdAt = Carbon::now(new DateTimeZone('Asia/Kolkata'));
            $createdBy = "Upload";
            $this->validate($request, [
                'file' => 'required|mimes:xls,xlsx'
            ]);

            $data = Excel::toArray(new ExcelImport, $request->file('file'));
            //dd($data);
            if ($data != "") {
                foreach ($data as $key => $value) {
                    foreach ($value as $row) {
                        if ($row['equipmentsrno'] != "") {
                            $insert_data[] = array(
                                'equipmentsrno' => $row['equipmentsrno'],
                                'contractno' => $contractNo,
                                'productsrno' => $row['productsrno'],
                                'customercode' => $customerCode,
                                'contracttype' => $contractType,
                                'workorderno' => $workOrderNo,
                                'branchcode' => $branchCode,
                                'productservicecode' => $productserviceCode,
                                'categorycode' => $categoryCode,
                                'specification' => $row['specification'],
                                'flagkey' => $flagKey,
                                'status' => $status,
                                'created_at' => $createdAt,
                                'created_by' => $createdBy,
                            );
                        }
                    }
                }


                if (!empty($insert_data)) {
                    EquipmentMasterModel::insert($insert_data);
                }
            }

            $equipments = EquipmentMasterModel::where('contractno', $contractNo)->get();
            foreach ($equipments as $equipment) {
                $branchname[] = $equipment->branch->branchname;
                $productname[] = $equipment->products->productservicename;
                $category[] = $equipment->category->categoryname;
            }

            return json_encode(array('equipments' => $equipments, 'branchname' => $branchname, 'productname' => $productname, 'category' => $category));
        }
        catch (Exception $exception) {
            return json_encode(array('exception' => $exception,'equipments' => $equipments));
        }
    }

    public function editUploadExcel(Request $request)
    {
        $equipments ='';
        try {
            $contractNo = $request['contractnoupload'];
            $customerCode = $request['customerupload'];
            $contractType = $request['contracttypeupload'];
            $workOrderNo = $request['workorderupload'];
            $branchCode = $request['branchcodeupload'];
            $productserviceCode = $request['eqipmentproductserviceupload'];
            $categoryCode = $request['categorycodeupload'];
            $flagKey = 0;
            $status = "Active";
            $createdAt = Carbon::now(new DateTimeZone('Asia/Kolkata'));
            $createdBy = "Upload";
            $this->validate($request, [
                'file' => 'required|mimes:xls,xlsx'
            ]);

            $data = Excel::toArray(new ExcelImport, $request->file('file'));
            //dd($data);
            if ($data != "") {
                foreach ($data as $key => $value) {
                    foreach ($value as $row) {
                        if ($row['equipmentsrno'] != "") {
                            $insert_data[] = array(
                                'equipmentsrno' => $row['equipmentsrno'],
                                'contractno' => $contractNo,
                                'productsrno' => $row['productsrno'],
                                'customercode' => $customerCode,
                                'contracttype' => $contractType,
                                'workorderno' => $workOrderNo,
                                'branchcode' => $branchCode,
                                'productservicecode' => $productserviceCode,
                                'categorycode' => $categoryCode,
                                'specification' => $row['specification'],
                                'flagkey' => $flagKey,
                                'status' => $status,
                                'created_at' => $createdAt,
                                'created_by' => $createdBy,
                            );
                        }
                    }
                }


                if (!empty($insert_data)) {
                    EquipmentMasterModel::insert($insert_data);
                }
            }
            $today = Carbon::today(new DateTimeZone('Asia/Kolkata'));
            $equipments = EquipmentMasterModel::where('contractno', $contractNo)
                                    ->where('created_by','Upload')
                                    ->where('created_at','>',$today)
                                    ->get();
            foreach ($equipments as $equipment) {
                $branchname[] = $equipment->branch->branchname;
                $productname[] = $equipment->products->productservicename;
                $category[] = $equipment->category->categoryname;
            }

            return json_encode(array('equipments' => $equipments, 'branchname' => $branchname, 'productname' => $productname, 'category' => $category));
        }
        catch (Exception $exception) {
            return json_encode(array('exception' => $exception,'equipments' => $equipments));
        }
    }

    public function edit($id)
    {
        $contract = ContractMasterModel::where('contractno', $id)->get()->first();
        $contractno = $contract->contractno;
        $editconract = ContractMasterModel::where('contractno', $contractno)->get()->first();
//        $totalcostdecimal = $editconract->totalcost;
        $totalcost = $editconract->totalcost;
        $contractperioddecimal = $editconract->contractperiod;
        $contractperiod = preg_replace("/\.?0*$/", '', $contractperioddecimal);
        $customers = CustomersModel::pluck('customername', 'customercode');
        $customerscode = $contract->customercode;
        // $tenders = TenderViewModel::pluck('tenderno', 'tenderno');
        // $tenderscode = $contract->tenderno;

        $tenders = TenderViewModel::pluck('tenderno', 'tenderno');

        if ($contract->tenderno && !$tenders->has($contract->tenderno)) {
            $tenders->put($contract->tenderno, $contract->tenderno);
        }

        $tenderscode = $contract->tenderno;

        $customername = CustomersModel::where('customercode', $contract->customercode)->get()->first()->customername;


        $editequipmenthead = EquipmentMasterModel::where('contractno', $contractno)->where('status', 'Active')->get()->first();
        $serviceParameterscode = ServiceParametersModel::pluck('name', 'name');
        $editcontractsitemaster = BranchMasterModel::where('contractno', $contractno)->orderby('created_at', 'asc')->get();

        $editcontractsitecontactmaster = BranchContactMasterModel::where('contractno', $contractno)->orderby('created_at', 'asc')->get();

        $editcontractdetails = ContractDetailsModel::where('contractno', $contractno)->orderby('created_at', 'asc')->get();
        $editcontractequipment = EquipmentMasterModel::where('contractno', $contractno)->where('status', 'Active')->orderby('created_at', 'asc')->get();
        $eqipmentbranch = BranchMasterModel::where('contractno', '=', $contractno)->get()->pluck('branchname', 'branchcode');

        $equipment = ContractDetailsModel::where('contractno', '=', $contractno)->pluck('productservicecode');
        $eqipmentproductservice = ProductServiceMasterModel::whereIn('productservicecode', $equipment)->get()->pluck('productservicename', 'productservicecode');
        $eqipmentcategory = CategoryMasterModel::pluck('categoryname', 'categorycode');
        $eqipment = ProductServiceMasterModel::where('isactive','=',1)->pluck('productservicename', 'productservicecode');
        $customercode = BranchMasterModel::where('contractno', $contractno)->pluck('customercode')->first();

        $paymentterms = ContractPaymentTermModel::where('contractno', $contractno)->get()->first();
        $serviceparameterid = ServiceParametersModel::where('name', $contract->servicefrequency)->get()->first();
        if($serviceparameterid == ""){
            $paymentintervalamc = '';
        }
        else{
            $paymentintervalamc = ServiceParametersModel::where('id', '>=', $serviceparameterid->id)->pluck('name', 'name');
        }

        $serviceChangeId = '';
        // $is_amendment = !empty($editconract->amendmentno) ? true : false;
        $is_amendment = ($editconract->amendmentno !== null && $editconract->amendmentno !== '' && $editconract->amendmentno !== '0') ? true : false;
        return view('contract.editContract', compact('customername', 'editconract', 'contractperiod', 'totalcost', 'customers', 'customerscode', 'tenders', 'tenderscode', 'editequipmenthead', 'serviceParameterscode', 'eqipment', 'editcontractsitemaster', 'editcontractsitecontactmaster', 'editcontractdetails', 'editcontractequipment', 'eqipmentbranch', 'eqipmentproductservice', 'eqipmentcategory', 'customercode', 'paymentterms', 'paymentintervalamc','serviceChangeId','is_amendment'));
//        return view('contract.editContract', compact('customername', 'editconract', 'contractperiod', 'totalcost', 'customers', 'customerscode', 'tenders', 'tenderscode', 'editequipmenthead', 'serviceParameterscode', 'eqipment', 'editcontractsitemaster', 'editcontractsitecontactmaster', 'editcontractdetails', 'editcontractequipment', 'eqipmentbranch', 'eqipmentproductservice', 'eqipmentcategory', 'customercode','paymentterms'));

    }

    public function showContract($id)
    {
        $contract = ContractMasterModel::where('contractno', $id)->get()->first();
        $contractno = $contract->contractno;
        $editconract = ContractMasterModel::where('contractno', $contractno)->get()->first();
        $totalcostdecimal = $editconract->totalcost;
        $totalcost = preg_replace("/\.?0*$/", '', $totalcostdecimal);
        $contractperioddecimal = $editconract->contractperiod;
        $contractperiod = preg_replace("/\.?0*$/", '', $contractperioddecimal);
        $customers = CustomersModel::pluck('customername', 'customercode');
        $customerscode = $contract->customercode;
        $tenders = TenderViewModel::pluck('tenderno', 'tenderno');
        $tenderscode = $contract->tenderno;
        $editequipmenthead = EquipmentMasterModel::where('contractno', $contractno)->where('status', 'Active')->get()->first();
        $serviceParameterscode = ServiceParametersModel::pluck('name', 'name');
        $editcontractsitemaster = BranchMasterModel::where('contractno', $contractno)->get();

        $editcontractsitecontactmaster = BranchContactMasterModel::where('contractno', $contractno)->get();

        $editcontractdetails = ContractDetailsModel::where('contractno', $contractno)->get();
        $editcontractequipment = EquipmentMasterModel::where('contractno', $contractno)->get();
        $eqipmentbranch = BranchMasterModel::where('contractno', '=', $contractno)->get()->pluck('branchname', 'branchcode');

        $equipment = ContractDetailsModel::where('contractno', '=', $contractno)->pluck('productservicecode');
        $eqipmentproductservice = ProductServiceMasterModel::whereIn('productservicecode', $equipment)->get()->pluck('productservicename', 'productservicecode');

        $eqipmentcategory = CategoryMasterModel::pluck('categoryname', 'categorycode');
        $eqipment = ProductServiceMasterModel::pluck('productservicename', 'productservicecode');
        $customercode = BranchMasterModel::where('contractno', $contractno)->pluck('customercode')->first();
        $paymentterms = ContractPaymentTermModel::where('contractno', $contractno)->get()->first();
        $serviceparameterid = ServiceParametersModel::where('name', $contract->servicefrequency)->get()->first();
        if($serviceparameterid != '')
        {
            $paymentintervalamc = ServiceParametersModel::where('id', '>=', $serviceparameterid->id)->pluck('name', 'name');
        }
        else{
            $paymentintervalamc = '';
        }

        return view('contract.viewContract', compact('editconract', 'contractperiod', 'totalcost', 'customers', 'customerscode', 'tenders', 'tenderscode', 'editequipmenthead', 'serviceParameterscode', 'eqipment', 'editcontractsitemaster', 'editcontractsitecontactmaster', 'editcontractdetails', 'editcontractequipment', 'eqipmentbranch', 'eqipmentproductservice', 'eqipmentcategory', 'customercode', 'paymentterms', 'paymentintervalamc'));
    }

    public function updateContract()
    {
//        return json_encode('hi');
        try {
            $user = Auth()->user();
//            return $test = json_encode($_GET['comprehensivetype']);
            $customercode = $_GET['customers'];
            $contractno = $_GET['contractsavedid'];
            $contract = ContractMasterModel::where('contractno', '=', $contractno)->get()->first();
            $serviceValue = $contract->servicefrequency;
            $contract->customercode = $this->checkifdataisempty($_GET['customers']);
//            $contract->branchcode = $this->checkifdataisempty($_GET['customersite']);
            $contract->tenderno = $this->checkifdataisempty($_GET['tenders']);
            $contract->tenderopendate = $this->checkifdataisempty($_GET['tenderopendate']);
            $contract->workordertype = $this->checkifdataisempty($_GET['workordertype']);
            $contract->workorderno = $this->checkifdataisempty($_GET['workorderno']);
            $contract->workorderdescription = $this->checkifdataisempty($_GET['workorderdescription']);
            $contract->workorderdate = $this->checkifdataisempty($_GET['workorderdate']);
            $contract->contractfromdate = $this->checkifdataisempty($_GET['contractfromdate']);
            $contract->contracttodate = $this->checkifdataisempty($_GET['contracttodate']);
            $contract->purchaseorderno = $this->checkifdataisempty($_GET['purchaseorderno']);
            $contract->purchaseorderdate = $this->checkifdataisempty($_GET['purchaseorderdate']);
            $contract->amendmentno = $this->checkifdataisempty($_GET['amendmentno']);
            $contract->amendmentdescription = $this->checkifdataisempty($_GET['amendmentdescription']);
            $contract->renewalperiod = $this->checkifdataisempty($_GET['renewalperiod']);
            $contract->totalcost = $this->checkifdataisempty($_GET['totalcost']);
            $contract->contractperiod = $this->checkifdataisempty($_GET['contractperiod']);
            $contract->servicefrequency = $this->checkifdataisempty($_GET['serviceParameterscode']);
            $contract->closuredate = $this->checkifdataisempty($_GET['closerdate']);

            $contract->projectownername = $this->checkifdataisempty($_GET['projectownername']);
            $contract->billingownername = $this->checkifdataisempty($_GET['billingownername']);


            $contract->updated_at = Carbon::now(new DateTimeZone('Asia/Kolkata'));
            $contract->comprehensivetype = $this->checkifdataisempty($_GET['comprehensivetype']);
            $contract->updated_by = $user->name;
            $contract->save();

            $serviceChangeId = $this->checkifdataisempty($_GET['serviceChangeId']);


            if ($serviceChangeId != '' && $serviceValue != $serviceChangeId) {
                    DB::table('tblservicemanagement')->where('contractno','=',$contractno)->delete();

                    $serviceparameter = ServiceParametersModel::where('name', $_GET['serviceChangeId'])->get();
                    $fromdate = $_GET['contracttodate'];
                    $todate = $_GET['contractfromdate'];
                    $to = Carbon::createFromFormat('Y-m-d', $fromdate);
                    $from = Carbon::createFromFormat('Y-m-d', $todate);
                    $months = $to->diffInMonths($from);
                    $countmonths = $months / $serviceparameter[0]->id;
                    $getdate = $_GET['contractfromdate'];
                    for ($i = 1; $i <= $countmonths; $i++) {
                        $service = new ServiceManagementModel();
                        $id = Uuid::uuid1();
                        $service->id = $id;
                        $service->contractno = $contractno;
                        $service->customercode = $this->checkifdataisempty($_GET['customers']);
                        if ($i == 1) {
                            $service->serviceadate = date('Y-m-d', strtotime($getdate . '+' . $serviceparameter[0]->id . 'months -1 days'));
                            $getdate = $service->serviceadate;
                        } else {
                            $service->serviceadate = $getdate;
                        }
                        $service->servicereminderdate = date('Y-m-d', strtotime($getdate . '-' . $serviceparameter[0]->leadlogdays . 'days'));
                        $service->flagkey = '0';
                        $service->created_at = Carbon::now(new DateTimeZone('Asia/Kolkata'));
                        $service->save();
                        $getdate = date('Y-m-d', strtotime($getdate . '+' . $serviceparameter[0]->id . 'months'));
                    }
            }
            return json_encode(array('customercode' => $customercode, 'contractno' => $contractno));

        } catch (Exception $exception) {
            return json_encode($exception);
        }
    }

    public function updatecontractsitemaster()
    {
//        return json_encode($_GET['contractsitemasterid']);
        try {
            $user = Auth()->user();
            $contractcode = $_GET['contractno'];
            $branch = $_GET["branchname"];
            $fax = $_GET["fax"];
            $email = $_GET["email"];
            $phone = $_GET["phone"];
            $count = count($branch);
            for ($i = 0; $i < $count; $i++) {
                if ($_GET['contractsitemasterid'][$i] != '0') {
                    $model = BranchMasterModel::where('branchcode', '=', $_GET["contractsitemasterid"][$i])->where('contractno', '=', $contractcode)->get()->first();
//                    $model = BranchMasterModel::find($_GET["contractsitemasterid"][$i]);
                    $model->contractno = $contractcode;
                    $model->branchname = $branch[$i];
                    $model->phone = $phone[$i];
                    $model->fax = $fax[$i];
                    $model->email = $email[$i];
                    $model->customercode = $_GET["customercode"];
                    $model->updated_at = Carbon::now(new DateTimeZone('Asia/Kolkata'));
                    $model->updated_by = $user->name;
                    $model->save();
                } else {
                    $common = new CommonController();
                    $model = new BranchMasterModel();
                    $mystr = $branch[$i];
                    $tablename = "Branchname";
                    $tempcode = $common->DynamicCode($mystr, $tablename);
                    $code = $tempcode['code'];
                    $incrementid = $tempcode['incrementid'];
                    $model->branchcode = $code;
                    $model->branchname = $branch[$i];
                    $model->phone = $phone[$i];
                    $model->fax = $fax[$i];
                    $model->email = $email[$i];
                    $model->contractno = $contractcode;
                    $model->customercode = $_GET["customercode"];
                    $model->created_at = Carbon::now(new DateTimeZone('Asia/Kolkata'));
                    $model->created_by = $user->name;
                    $model->save();
                    if ($model->save() == true) {
                        $modelincrement = IncrementMasterModel::find(IncrementMasterModel::where('incrementfor', $tablename)->first()->incrementid);
                        $modelincrement->incrementvalue = $incrementid;
                        $modelincrement->save();
                    }
                }
            }
            $branchlist = BranchMasterModel::where('contractno', '=', $contractcode)->get();
            return json_encode(array('branchlist' => $branchlist, 'contractcode' => $contractcode));
        } catch (Exception $exception) {
            return json_encode($exception);
        }
    }

    public function updatecontractsitecontactmaster()

    {
        try {

            $user = Auth()->user();
            $contractcode = $_GET['contractno'];
            $contactpersonname = $_GET["contactpersonname"];
            $phone = $_GET["phone"];
            $fax = $_GET["fax"];
            $emailid = $_GET["emailid"];
            $branch = $_GET['branchcode'];
            $count = count($branch);
            for ($i = 0; $i < $count; $i++) {
                if ($_GET['contractsitecontactsaveid'][$i] != '0') {
                    $model = BranchContactMasterModel::where('branchcontactcode', '=', $_GET['contractsitecontactsaveid'][$i])->where('contractno', '=', $contractcode)->get()->first();
//                    $model = BranchContactMasterModel::find($_GET['contractsitecontactsaveid'][$i]);
                    $model->contactpersonname = $contactpersonname[$i];
                    $model->branchcontactcode = $_GET['contractsitecontactsaveid'][$i];
                    $model->contractno = $_GET['contractno'];
                    $model->branchcode = $_GET['branchcode'][$i];
                    $model->phone = $phone[$i];
                    $model->fax = $fax[$i];
                    $model->emailid = $emailid[$i];
                    $model->updated_at = Carbon::now(new DateTimeZone('Asia/Kolkata'));
                    $model->updated_by = $user->name;
                    $contractcode = $_GET['contractno'];
                    $model->save();
                } else {
                    $common = new CommonController();
                    $model = new BranchContactMasterModel();
                    $mystr = $contactpersonname[$i];
                    $tablename = "BranchContactPerson";
                    $tempcode = $common->DynamicCode($mystr, $tablename);
                    $code = $tempcode['code'];
                    $incrementid = $tempcode['incrementid'];
                    $model->branchcontactcode = $code;
                    $model->contactpersonname = $contactpersonname[$i];
                    $model->phone = $phone[$i];
                    $model->fax = $fax[$i];
                    $model->emailid = $emailid[$i];
                    $model->contractno = $_GET['contractno'];
                    $model->branchcode = $branch[$i];
                    $contractcode = $_GET['contractno'];
                    $model->created_at = Carbon::now(new DateTimeZone('Asia/Kolkata'));
                    $model->created_by = $user->name;
                    $model->save();
                    if ($model->save() == true) {
                        $modelincrement = IncrementMasterModel::find(IncrementMasterModel::where('incrementfor', $tablename)->first()->incrementid);
                        $modelincrement->incrementvalue = $incrementid;
                        $modelincrement->save();
                    }
                }
            }
            $brachcontactlist = BranchContactMasterModel::where('contractno', $contractcode)->get();


            return json_encode(array('brachcontactlist' => $brachcontactlist, 'contractcode' => $contractcode));

        } catch (Exception $exception) {
            return json_encode($exception);
        }
    }

    public function updateContractDetails()

    {
        try {
            $user = Auth()->user();
//           return $id = json_encode(($_GET['totaltax']));
            $contractno = $_GET['contractno'];
            $products = $_GET['eqipment'];
            $rate = $_GET['rate'];
            $quantity = $_GET['quantity'];
            $warranty_amc_period = $_GET['warranty_amc_period'];
            $sgstrate = $_GET['sgstrate'];
            $sgstamt = $_GET['sgstamt'];
            $cgstrate = $_GET['cgstrate'];
            $cgstamt = $_GET['cgstamt'];
            $taxrate = $_GET['taxrate'];
            $tax = $_GET['taxamt'];
            $totalcontractcost = $_GET['totalcontractcost'];
            $totaltax = $_GET['totaltax'];
            $hsncode = $_GET['hsncode'];
            $count = count($_GET['eqipment']);
            $productCode ='';

            $returndata = array();
            for ($i = 0; $i < $count; $i++) {
                $contractdetails = null;
                if ($_GET['contractdetailsaveid'][$i] != '0') {
                    $contractdetails = ContractDetailsModel::where('id', '=', $_GET['contractdetailsaveid'][$i])->get()->first();
                    $contractdetails->updated_at = Carbon::now(new DateTimeZone('Asia/Kolkata'));
                    $contractdetails->updated_by = $user->name;
                } else {
                    $contractdetails = new ContractDetailsModel();
                    $id = Uuid::uuid1();
                    $contractdetails->id = $id;
                    $contractdetails->created_at = Carbon::now(new DateTimeZone('Asia/Kolkata'));
                    $contractdetails->created_by = $user->name;
                }
                $productCode = ProductServiceMasterModel::where('productservicecode','=',$products[$i])->value('productservicecode');
                $contractdetails->contractno = $contractno;
                $contractdetails->productservicecode = $productCode;
                $contractdetails->quantity = $quantity[$i];
                $contractdetails->rate = $rate[$i];
                $contractdetails->taxamt = $tax[$i];
                $contractdetails->warranty_amcperiod = $warranty_amc_period[$i];
                $contractdetails->sgstrate = $sgstrate[$i];
                $contractdetails->sgstamt = $sgstamt[$i];
                $contractdetails->cgstrate = $cgstrate[$i];
                $contractdetails->cgstamt = $cgstamt[$i];
                $contractdetails->taxrate = $taxrate[$i];
                $contractdetails->totalcontractcost = $totalcontractcost[$i];
                $contractdetails->totaltax = $totaltax[$i];
                $contractdetails->hsncode = $hsncode[$i];

                $contractdetails->save();
                array_push($returndata, $contractdetails);
            }
            $contractdetailsid = ContractDetailsModel::where('contractno', '=', $contractno)->get();
            $branchlist = BranchMasterModel::where('contractno', '=', $contractno)->get();
            $equipment = ContractDetailsModel::where('contractno', '=', $contractno)->pluck('productservicecode');
            $equipmentlist = ProductServiceMasterModel::whereIn('productservicecode', $equipment)->get();

            return json_encode(array('contractdetailsid' => $contractdetailsid, 'branchlist' => $branchlist, 'equipmentlist' => $equipmentlist, 'contractno' => $contractno));

        } catch (Exception $exception) {
            return json_encode($exception);
        }
    }

    public function updateequipmentDetails()
    {
        try {
            $user = Auth()->user();
            $product = $_POST['eqipmentproductservice'];
            $branch = $_POST['eqipmentbranch'];
            $category = $_POST['categorycode'];
            $eqipmentsrno = $_POST['equipmentsrno'];
            $productsrno = $_POST['productsrno'];
            $spcification = $_POST['specification'];
            $id = $_POST['contractquipmentid'];
            $count = count($product);
            $equipmentdetails = '';
            for ($i = 0; $i < $count; $i++) {
                if ($id[$i] != '0') {
                    $equipmentdetails = EquipmentMasterModel::where('equipmentsrno', '=', $eqipmentsrno[$i])->where('contractno', '=', $_POST['contractno'])->where('status','=', 'Active')->get()->first();
                    $equipmentdetails->updated_at = Carbon::now(new DateTimeZone('Asia/Kolkata'));
                    $equipmentdetails->updated_by = $user->name;
                } else {
                    $equipmentdetails = new EquipmentMasterModel();
                    $equipmentdetails->created_at = Carbon::now(new DateTimeZone('Asia/Kolkata'));
                    $equipmentdetails->created_by = $user->name;
                }
                $equipmentdetails->contractno = $_POST['contractno'];
                $equipmentdetails->contracttype = $_POST['contracttype'];
                $equipmentdetails->customercode = $_POST['equipmentcustomercodeid'];
                $equipmentdetails->productservicecode = $product[$i];
                $equipmentdetails->branchcode = $branch[$i];
                $equipmentdetails->categorycode = $category[$i];
                $equipmentdetails->equipmentsrno = $eqipmentsrno[$i];
                $equipmentdetails->productsrno = $productsrno[$i];
                $equipmentdetails->specification = $spcification[$i];
                $equipmentdetails->status = "Active";
                $equipmentdetails->flagkey = '0';
                $equipmentdetails->save();
            }
            $equipmentsrnolist = EquipmentMasterModel::where('contractno', '=', $_POST['contractno'])->where('status', 'Active')->get();
//            $success = 'true';
            return json_encode(array('equipmentsrnolist' => $equipmentsrnolist));
        } catch (Exception $exception) {
//            $success = 'false';
            return json_encode($exception);
//            return Response::json(['exception' => $exception, 'success' => $success],201);
        }
    }

    public function updatepaymenterms()
    {

        try {
            $model = ContractPaymentTermModel::where('contractno', '=', $_GET['contractno'])->get()->first();

            if ($model == null) {
                $model = new ContractPaymentTermModel();
                $model->id = Uuid::uuid1();
                $model->created_at = Carbon::now(new DateTimeZone('Asia/Kolkata'));
                $model->created_by = Auth::id();
            } else {
                $model->id;
                $model->updated_at = Carbon::now(newDateTimeZone('Asia/Kolkata'));
                $model->updated_by = Auth::id();
            }
            $model->contractno = $_GET['contractno'];
            $model->securitydeposit = $this->checkifdataisempty($_GET['securitydeposit']);
            $model->sbpaymentperiod = $this->checkifdataisempty($_GET['sbpaymentperiod']);
            $model->admincharges = $this->checkifdataisempty($_GET['admincharges']);
            $model->facilitycharges = $this->checkifdataisempty($_GET['facilitycharges']);
            $model->paymentintervalforamc = $this->checkifdataisempty($_GET['paymentintervalforamc']);
            $model->leaddaysforpayment = $this->checkifdataisempty($_GET['leaddaysforpayment']);
            $model->customeriniatedbilling = $this->checkifdataisempty($_GET['customeriniatedbilling']);
//               ------supply----
            if ($_GET['workordertype'] == "Hardware Warranty" || $_GET['workordertype'] == "Software development") {
                $model->firstpaymentpercent = $this->checkifdataisempty($_GET['firstpaymentpercent']);
                $model->firstpaymentcriteria = $this->checkifdataisempty($_GET['firstpaymentcriteria']);
                $model->secondpaymentpercent = $this->checkifdataisempty($_GET['secondpaymentpercent']);
                $model->secondpaymentcriteria = $this->checkifdataisempty($_GET['secondpaymentcriteria']);
                $model->thirdpaymentpercent = $this->checkifdataisempty($_GET['thirdpaymentpercent']);
                $model->thirdpaymentcriteria = $this->checkifdataisempty($_GET['thirdpaymentcriteria']);
                $model->fourthpaymentpercent = $this->checkifdataisempty($_GET['fourthpaymentpercent']);
                $model->fourthpaymentcriteria = $this->checkifdataisempty($_GET['fourthpaymentcriteria']);
                $model->fifthpaymentpercent = $this->checkifdataisempty($_GET['fifthpaymentpercent']);
                $model->fifthpaymentcriteria = $this->checkifdataisempty($_GET['fifthpaymentcriteria']);
            }
            $model->save();
            if ($_GET['workordertype'] == "Software Maintenance" || $_GET['workordertype'] == "Hardware AMC") {
                $service = ServiceManagementModel::where('contractno', $_GET['contractno'])->orderby('serviceadate', 'ASC')->get();
                $countservice = count($service);
                for ($j = 0; $j < $countservice; $j++) {
                    $model = ServiceManagementModel::find($service[$j]->id);
                    $model->paymentduedate = null;
                    $model->save();
                }
                $paymentschedule = ContractPaymentschedulesModel::where('contractno', $_GET['contractno'])->get();
                for ($p = 0; $p < count($paymentschedule); $p++) {
                    $paymentdelete = ContractPaymentschedulesModel::find($paymentschedule[$p]->id);
                    $paymentdelete->Delete();
                }
                $contractdate = ContractMasterModel::where('contractno', $_GET['contractno'])->get()->first();
                $fromdate = $contractdate->contractfromdate;
                $todate = $contractdate->contracttodate;
                $from = Carbon::createFromFormat('Y-m-d', $fromdate);
                $to = Carbon::createFromFormat('Y-m-d', $todate);
                $months = $to->diffInMonths($from);
                $serviceparameter = ServiceParametersModel::where('name', $_GET['paymentintervalforamc'])->get()->first();
                $countmonths = $months / $serviceparameter->id;
                $getdate = $from;
                $preservicedate = $from;
                for ($i = 1; $i <= $countmonths; $i++) {
                    $paymentschedule = new ContractPaymentschedulesModel();
                    $paymentschedule->id = Uuid::uuid1();
                    $paymentschedule->contractno = $_GET['contractno'];
                    $paymentschedule->paymentcycleno = $i;
                    $paymentschedule->updated_at = Carbon::now(new DateTimeZone('Asia/Kolkata'));
                    $paymentschedule->updated_by = Auth::id();
                    $paymentschedule->created_at = null;
                    if ($i == 1) {
                        $service->paymentduedate = date('Y-m-d', strtotime($getdate . '+' . $serviceparameter->id . 'months -1 days '));
                        $getdate = $service->paymentduedate;
                        $preservicedate = $getdate;
                        $servicedate = ServiceManagementModel::where('serviceadate', '<=', $getdate)->where('contractno', $_GET['contractno'])->get();
                        $paymentschedule->paymentcyclestartdate = $from;
                        $paymentschedule->paymentcycleenddate = $getdate;
                        $paymentschedule->paymentduedate = $getdate;
                        $paymentschedule->save();
                        for ($n = 0; $n < count($servicedate); $n++) {
                            $model = ServiceManagementModel::find($servicedate[$n]->id);
                            $model->paymentduedate = $getdate;
                            $model->save();
                        }
                    } else {
//                        $service->paymentduedate = $getdate;
                        $paymentschedule->paymentcyclestartdate = $preservicedate;
                        $paymentschedule->paymentcycleenddate = $getdate;
                        $paymentschedule->paymentduedate = $getdate;
                        $paymentschedule->save();
                        $servicedate = ServiceManagementModel::whereBetween('serviceadate', [$preservicedate, $getdate])->where('serviceadate', '>', $preservicedate)->where('contractno', $_GET['contractno'])->get();
                        for ($n = 0; $n < count($servicedate); $n++) {
                            $model = ServiceManagementModel::find($servicedate[$n]->id);
                            $model->paymentduedate = $getdate;
                            $model->save();
                        }
                        $preservicedate = $getdate;
                    }
                    $getdate = date('Y-m-d', strtotime($getdate . '+' . $serviceparameter->id . 'months'));
                }
            }
//            --supply-----
            if ($_GET['workordertype'] == "Hardware Warranty" || $_GET['workordertype'] == "Software development") {
                $contractpaymentschedules = ContractPaymentschedulesModel::where('contractno', $_GET['contractno'])->get();

                if (count($contractpaymentschedules) > 0) {
                    for ($i = 0; $i < count($contractpaymentschedules); $i++) {
                        $paymentschdelete = ContractPaymentschedulesModel::find($contractpaymentschedules[$i]->id);
                        $paymentschdelete->Delete();
                    }
                }
                $paymentcycleno = 0;
                if ($_GET['firstpaymentpercent'] != null) {
                    $contractpaymentschdule = new ContractPaymentschedulesModel();
//                    $paymentcycleno++;
                    $contractpaymentschdule->id = Uuid::uuid1();
                    $contractpaymentschdule->contractno = $_GET['contractno'];
                    $contractpaymentschdule->paymentcycleno = ++$paymentcycleno;
                    $contractpaymentschdule->paymentype = $_GET['firstpaymentcriteria'];
                    $contractpaymentschdule->save();
                    if ($_GET['secondpaymentpercent'] != null) {
                        $contractpaymentschdule = new ContractPaymentschedulesModel();
//                        $paymentcycleno++;
                        $contractpaymentschdule->id = Uuid::uuid1();
                        $contractpaymentschdule->contractno = $_GET['contractno'];
                        $contractpaymentschdule->paymentcycleno = ++$paymentcycleno;
                        $contractpaymentschdule->paymentype = $_GET['secondpaymentcriteria'];

                        $contractpaymentschdule->save();
                        if ($_GET['thirdpaymentpercent'] != null) {
                            $contractpaymentschdule = new ContractPaymentschedulesModel();
//                            $paymentcycleno++;
                            $contractpaymentschdule->id = Uuid::uuid1();
                            $contractpaymentschdule->contractno = $_GET['contractno'];
                            $contractpaymentschdule->paymentcycleno = ++$paymentcycleno;
                            $contractpaymentschdule->paymentype = $_GET['thirdpaymentcriteria'];
                            $contractpaymentschdule->save();
                            if ($_GET['fourthpaymentpercent'] != null) {
                                $contractpaymentschdule = new ContractPaymentschedulesModel();
//                                $paymentcycleno++;
                                $contractpaymentschdule->id = Uuid::uuid1();
                                $contractpaymentschdule->contractno = $_GET['contractno'];
                                $contractpaymentschdule->paymentcycleno = ++$paymentcycleno;
                                $contractpaymentschdule->paymentype = $_GET['fourthpaymentcriteria'];
                                $contractpaymentschdule->save();
                                if ($_GET['fifthpaymentpercent'] != null) {
                                    $contractpaymentschdule = new ContractPaymentschedulesModel();
//                                    $paymentcycleno++;
                                    $contractpaymentschdule->id = Uuid::uuid1();
                                    $contractpaymentschdule->contractno = $_GET['contractno'];
                                    $contractpaymentschdule->paymentcycleno = ++$paymentcycleno;
                                    $contractpaymentschdule->paymentype = $_GET['fifthpaymentcriteria'];
                                    $contractpaymentschdule->save();

                                }
                            }

                        }
                    }
                }
            }
            return json_encode('Done');
        } catch (Exception $exception) {
            return json_encode($exception);
        }
    }

    public function addPaymentSchedule($contractno, $paymentintervalforamc, $leaddays)
    {
        $data = ContractMasterModel::where('contractno', $contractno)->get()->first();
        $totalcost = $data->totalcost;
        $contractperiod = $data->contractperiod;
        $contractfromdate = $data->contractfromdate;
        $count = 1;
        $costeverytime = $totalcost / (12 / $paymentintervalforamc * $contractperiod);

        $lastenddate = null;
        for ($i = 0; $i < ((12 / $paymentintervalforamc) * $contractperiod); $i++) {
            $paymentschedule = new ContractPaymentSchedules();
            $id = Uuid::uuid1();
            $paymentschedule->id = $id;
            $paymentschedule->contractno = $contractno;
            $paymentschedule->paymentcycleno = $count;
            $count++;
            $startdate = $lastenddate == null ? $contractfromdate : $lastenddate;
            $paymentschedule->paymentcyclestartdate = $startdate;
            $paymentschedule->paymentcycleenddate = Carbon::parse($startdate)->addMonth($paymentintervalforamc)->addDay(-1);
            $lastenddate = Carbon::parse($startdate)->addMonth($paymentintervalforamc);
            $paymentschedule->paymentduedate = Carbon::parse($lastenddate)->addDay($leaddays);
            $paymentschedule->paymentdueamount = $costeverytime;
            $paymentschedule->invoicegenerationduedate = Carbon::parse($startdate)->addDay(-5);
            $paymentschedule->created_at = Carbon::now(new DateTimeZone('Asia/Kolkata'));
            $paymentschedule->created_by = Auth::id();
            $paymentschedule->save();
        }
    }

    public function addPaymentScheduleForWarranty($paymentpercent, $cycleno, $totalcost, $contractno)
    {
        $paymentschedule = new ContractPaymentSchedule();
        $id = Uuid::uuid1();

        $paymentschedule->id = $id;
        $paymentschedule->contractno = $contractno;
        $paymentschedule->paymentcycleno = $cycleno;
        $paymentschedule->paymentdueamount = $totalcost * $paymentpercent / 100;
        $paymentschedule->created_at = Carbon::now(new DateTimeZone('Asia/Kolkata'));
        $paymentschedule->created_by = Auth::id();
        $paymentschedule->save();
    }

//    Data Table populate for the index page
    public function getAllContractsDT(Request $request)
    {

        $columns = array(
            0 => 'id',
            1 => 'contractno',
            2 => 'customercode',
            3 => 'tenderno',
            4 => 'workorderno',
            5 => 'purchaseorderno',
            6 => 'options'
        );

        $totalData = ContractMasterModel::count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $posts = ContractMasterModel::limit($limit)
                ->offset($start)
                ->orderBy($order, $dir)
                ->get();

        } else {

            $search = $request->input('search.value');
            $posts = ContractMasterModel::where('contractno', 'LIKE', "%{$search}%")
                ->orWhere('customercode', 'LIKE', "%{$search}%")
                ->orWhere('tenderno', 'LIKE', "%{$search}%")
                ->orWhere('workorderno', 'LIKE', "%{$search}%")
                ->orWhere('purchaseorderno', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered = ContractMasterModel::where('contractno', 'LIKE', "%{$search}%")
                ->orWhere('customercode', 'LIKE', "%{$search}%")
                ->orWhere('tenderno', 'LIKE', "%{$search}%")
                ->orWhere('workorderno', 'LIKE', "%{$search}%")
                ->orWhere('purchaseorderno', 'LIKE', "%{$search}%")
                ->count();
        }

        $data = array();
        if (!empty($posts)) {
            $count = 1;
            foreach ($posts as $post) {
                $nestedData['id'] = $count++;
                $nestedData['contractno'] = $post->contractno;
                $nestedData['customercode'] = $post->customercode;
                $nestedData['tenderno'] = $post->tenderno;
                $nestedData['workorderno'] = $post->workorderno;
                $nestedData['purchaseorderno'] = $post->purchaseorderno;
                $nestedData['options'] = "&emsp;<a href=\"showcontract/$post->id\" style=\"margin-right: 3px;\">view</a>
                                          | <a href=\"editcontract/$post->id\" style=\"margin - right: 3px;\">edit</a>";
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

    public function getWorkOrders($id)
    {
        try {
            $workorderno = CustomersModel::where('customercode', $id)->get();
            return json_encode($workorderno);
        } catch (Exception $ex) {
            $common = new CommonController;
            $common->ErrorLogging($ex, 'UserComplaint', 'newcomplaintregister');
            return 'Some error occurred while processing your request';
        }
    }

    public function getPaymentSchedules($id)
    {
        $data = ContractPaymentSchedule::where('contractno', $id)->get();
        return view('contract._contractpartials._paymentschedules', compact('data'));
    }

    public function getservicedate()
    {
        $contractfromdate = $_GET['contractfromdate'];
        if($_GET['servicefrequency'] != null){
            $servicefrequency = $_GET['servicefrequency'];
        }
        else{
            $servicefrequency = 'Yearly';
        }

        $serviceparameter = ServiceParametersModel::where('name', $servicefrequency)->get()->first();

        $servicedate = DB::select(DB::raw("SELECT DATE_ADD('$contractfromdate', INTERVAL $serviceparameter->servicedays - $serviceparameter->leadlogdays day) as servicereminderdate ,DATE_ADD('$contractfromdate', INTERVAL $serviceparameter->servicedays  day) as servicedate"));
        return json_encode($servicedate);
    }

    public function checkifdataisempty($date)
    {
        if ($date == '')
            $date = null;

        return $date;
    }

    public function contractno($fromdate, $todate, $contracttype, $tablename)
    {
        $lastincrementid = IncrementMasterModel::all()->where('incrementfor', $tablename)->first()->incrementvalue;
        $code = str_pad($lastincrementid + 1, 4, "0", STR_PAD_LEFT);
        $contfromdate = strtoupper(mb_substr($fromdate, 0, 4));
        $conttype = strtoupper(mb_substr($contracttype, 0, 3));
        $conttodate = strtoupper(mb_substr($todate, 0, 4));
        $finaltodate = strtoupper(mb_substr($conttodate, 2, 2));
        $newgenratedcode = $contfromdate . "-" . $finaltodate . "-" . $conttype . "-" . $code;
        $itemarray = array('code' => $newgenratedcode, 'incrementid' => $lastincrementid + 1);
        return $itemarray;
    }

    public function getYears()
    {
        $fromdate = $_GET['fromdate'];
        $todate = $_GET['todate'];
        $to = Carbon::createFromFormat('Y-m-d', $fromdate);
        $from = Carbon::createFromFormat('Y-m-d', $todate);
        $months = $to->diffInMonths($from);

        $year = $to->diffInYears($from);
        if ($year == 0) {
            $date = $to->diffInMonths($from);
            $date = '0.' . $date;
        } else {
//            $date = $to->diffInYears($from);

            $remaingmonths = $months - $year * 12;
            $date = $year . '.' . $remaingmonths;
        }
        return json_encode($date); // Output: 1
    }

    public function getbranch($id)
    {
        $branchlist = BranchMasterModel::where('contractno', '=', $id)->get();
        return json_encode(array('branchlist' => $branchlist));
    }

    public function getbranchandequipmen($id)
    {
        $branchlist = BranchMasterModel::where('contractno', '=', $id)->get();
        $equipment = ContractDetailsModel::where('contractno', '=', $id)->pluck('productservicecode');
        $equipmentlist = ProductServiceMasterModel::whereIn('productservicecode', $equipment)->get();
        return json_encode(array('branchlist' => $branchlist, 'equipmentlist' => $equipmentlist));
    }

    public function getequipmentexcelupload($id,$contractno,$branchcode)
    {
        $equipment = EquipmentMasterModel::where('contractno','=', $contractno)
                        ->where('branchcode','=',$branchcode)
                        ->groupBy('categorycode')
                        ->pluck('categorycode');
        $category = CategoryMasterModel::where('productservicecode',$id)
                        ->whereNotIn('categorycode',$equipment)
                        ->get();
        $contractmaster = ContractMasterModel::where('contractno','=', $contractno)
                        ->get();
        return json_encode(array('category' => $category, 'contractmaster' => $contractmaster));
    }

    public function gettenderdate()
    {
        $id = $_GET['tenderno'];
        $tendersopendate = TenderViewModel::where('tenderno', '=', $id)->get()->first();
        if($tendersopendate != ''){
            $prebidmeetingdate = date("Y-m-d", strtotime($tendersopendate->tenderdate));
        }
        else{
            //$now = Carbon::today(new \DateTimeZone('Asia/Kolkata'));
            $prebidmeetingdate = date("");
        }

        return json_encode($prebidmeetingdate);
    }

    public function delete()
    {
        $equipmentsrid = $_GET['equipmentsrid'];
        $contractno = $_GET['contractno'];
        $euipmentdelete = EquipmentMasterModel::where('equipmentsrno', $equipmentsrid)->where('contractno', $contractno)->get()->first();
        $euipmentdelete->forceDelete();
        return json_encode($contractno);

    }

    public function amendcontract($id, $customername)
    {
        return view('contract.amendcontract', compact('id', 'customername'));
    }


    public function amendcontractcreatenewcontract(Request $request, $contractno)
{
    $newcontractno = null;

    $common = new CommonController();
    $user = auth()->user();

    #region Add Contract Master Data
    $oldcontract = ContractMasterModel::findorfail($request->contractno);

    $contract = new ContractMasterModel;
    $contract->customercode = $this->checkifdataisempty($oldcontract->customercode);
    $contract->tenderno = $this->checkifdataisempty($oldcontract->tenderno);
    $contract->tenderopendate = $this->checkifdataisempty($oldcontract->tenderopendate);
    $contract->workordertype = $this->checkifdataisempty($oldcontract->workordertype);
    $contract->workorderno = $this->checkifdataisempty($oldcontract->workorderno);
    $contract->workorderdescription = $this->checkifdataisempty($oldcontract->workorderdescription);
    $contract->workorderdate = $this->checkifdataisempty($oldcontract->workorderdate);
    $contract->contractfromdate = $this->checkifdataisempty($request->contractfromdate);
    $contract->contracttodate = $this->checkifdataisempty($request->contracttodate);

    $to = Carbon::createFromFormat('Y-m-d', $request->contractfromdate);
    $from = Carbon::createFromFormat('Y-m-d', $request->contracttodate);
    $months = $to->diffInMonths($from);

    //Get difference between fromdate and todate
    $year = $to->diffInYears($from);
    if ($year == 0) {
        $date = $to->diffInMonths($from);
        $date = '0.' . $date;
    } else {
        $remaingmonths = $months - $year * 12;
        $date = $year . '.' . $remaingmonths;
    }

    $contract->purchaseorderno = $this->checkifdataisempty($oldcontract->purchaseorderno);
    $contract->purchaseorderdate = $this->checkifdataisempty($oldcontract->purchaseorderdate);
    $contract->amendmentno = $request->amendmentno;
    $contract->amendmentdescription = $request->amendmentdescription;
    $contract->renewalperiod = $this->checkifdataisempty($date);
    $contract->totalcost = $this->checkifdataisempty($oldcontract->totalcost);
    $contract->contractperiod = $this->checkifdataisempty($date);
    $contract->closuredate = $this->checkifdataisempty($oldcontract->closuredate);


    $contract->servicefrequency = $this->checkifdataisempty($oldcontract->servicefrequency);
    $contract->comprehensivetype = $this->checkifdataisempty($oldcontract->comprehensivetype);
    $contract->created_at = Carbon::now(new DateTimeZone('Asia/Kolkata'));
    $contract->created_by = $user->name;
    $contract->updated_at = Carbon::now(new DateTimeZone('Asia/Kolkata'));
    $incrementfor = 'Contractno';
    $tempcode = $this->contractno($contract->contractfromdate, $contract->contracttodate, $contract->workordertype, $incrementfor);
    $contract->contractno = $tempcode['code'];
    $newcontractno = $tempcode['code'];
    $incrementid = $tempcode['incrementid'];
    $contract->save();

    if($oldcontract->closuredate == null){
        $oldcontract->closuredate = Carbon::now(new DateTimeZone('Asia/Kolkata'));
        $oldcontract->save();
    }


    $serviceparameter = ServiceParametersModel::where('name', $oldcontract->servicefrequency)->get()->first();

    if ($contract->save() == true) {
        $incrementcontractid = "Contractno";
        $modelincrement = IncrementMasterModel::find(IncrementMasterModel::where('incrementfor', $incrementcontractid)->first()->incrementid);
        $modelincrement->incrementvalue = $incrementid;
        $modelincrement->save();
    }

    if ($oldcontract->workordertype == "Software Maintenance") {
        $fromdate = $request->contractfromdate;
        $todate = $request->contracttodate;
        $to = Carbon::createFromFormat('Y-m-d', $todate);
        $from = Carbon::createFromFormat('Y-m-d', $fromdate);
        $months = $to->diffInMonths($from);
        $countmonths = $months / $serviceparameter->id;
        $getdate = $request->contractfromdate;
        for ($i = 0; $i < $countmonths; $i++) {
            $service = new ServiceManagementModel();
            $id = Uuid::uuid1();
            $service->id = $id;
            $service->contractno = $tempcode['code'];
            $service->customercode = $this->checkifdataisempty($oldcontract->customercode);
            if ($i == 0) {
                $service->serviceadate = date('Y-m-d', strtotime($getdate . '+' . $serviceparameter->id . 'months -1 days'));
                $getdate = $service->serviceadate;
            } else {
                $service->serviceadate = $getdate;
            }
            $service->servicereminderdate = date('Y-m-d', strtotime($getdate . '-' . $serviceparameter->leadlogdays . 'days'));
            $service->created_at = Carbon::now(new DateTimeZone('Asia/Kolkata'));
            $service->created_by = $user->name;
            $service->save();
            $getdate = date('Y-m-d', strtotime($getdate . '+' . $serviceparameter->id . 'months'));
        }
    }

    if ($oldcontract->workordertype == "Hardware Warranty") {
        $servicedate = DB::select(DB::raw("SELECT DATE_ADD('$request->contractfromdate', INTERVAL $serviceparameter->servicedays - $serviceparameter->leadlogdays day) as servicereminderdate ,DATE_ADD('$request->contractfromdate', INTERVAL $serviceparameter->servicedays  day) as servicedate"));

        $supply = new SupplyManagementModel();
        $id = Uuid::uuid1();
        $supply->id = $id;
        $supply->contractno = $newcontractno;
        $supply->customercode = $this->checkifdataisempty($oldcontract->customercode);
        $supply->preventivemaintenancedate = $servicedate['servicedate'];
        $supply->preventivemaintenancereminderdate = $servicedate['servicereminderdate'];
        $supply->created_at = Carbon::now(new DateTimeZone('Asia/Kolkata'));
        $supply->created_by = $user->name;
        $supply->save();
    }
    #endregion

    #region Add Contract Details
    $oldcontractdetails = ContractDetailsModel::where('contractno', $request->contractno)->get();
    if ($oldcontractdetails != null) {
        for ($i = 0; $i < count($oldcontractdetails); $i++) {
            $contractdetailsinsert = new ContractDetailsModel();
            $contractdetailsinsert->id = Uuid::uuid1();
            $contractdetailsinsert->contractno = $newcontractno;
            $contractdetailsinsert->productservicecode = $oldcontractdetails[$i]->productservicecode;
            $contractdetailsinsert->quantity = $oldcontractdetails[$i]->quantity;
            $contractdetailsinsert->rate = $oldcontractdetails[$i]->rate;
            $contractdetailsinsert->taxamt = $oldcontractdetails[$i]->taxamt;
            $contractdetailsinsert->warranty_amcperiod = $oldcontractdetails[$i]->warranty_amcperiod;
            $contractdetailsinsert->sgstrate = $oldcontractdetails[$i]->sgstrate;
            $contractdetailsinsert->sgstamt = $oldcontractdetails[$i]->sgstamt;
            $contractdetailsinsert->cgstrate = $oldcontractdetails[$i]->cgstrate;
            $contractdetailsinsert->cgstamt = $oldcontractdetails[$i]->cgstamt;
            $contractdetailsinsert->taxrate = $oldcontractdetails[$i]->taxrate;
            $contractdetailsinsert->totaltax = $oldcontractdetails[$i]->totaltax;
            $contractdetailsinsert->totalcontractcost = $oldcontractdetails[$i]->totalcontractcost;
            $contractdetailsinsert->hsncode = $oldcontractdetails[$i]->hsncode;
            $contractdetailsinsert->save();
        }
    }

    #endregion

    #region Add Contract Site Master

    $oldbranchdetails = BranchMasterModel::where('contractno', $request->contractno)->get();
    if ($oldbranchdetails != null) {
        for ($i = 0; $i < count($oldbranchdetails); $i++) {
            $branchmaster = new BranchMasterModel();
            $branchmaster->branchname = $oldbranchdetails[$i]->branchname;
            $branchmaster->branchcode = $oldbranchdetails[$i]->branchcode;
            $branchmaster->phone = $oldbranchdetails[$i]->phone;
            $branchmaster->fax = $oldbranchdetails[$i]->fax;
            $branchmaster->email = $oldbranchdetails[$i]->email;
            $branchmaster->customercode = $oldbranchdetails[$i]->customercode;
            $branchmaster->contractno = $newcontractno;
            $branchmaster->created_at = Carbon::now(new DateTimeZone('Asia/Kolkata'));
            $branchmaster->created_by = $user->name;
            $branchmaster->updated_at = null;
            $branchmaster->save();
        }
    }

    #endregion

    #region Add Contract Site Contact Master

    $oldbranchcontactdetails = BranchContactMasterModel::where('contractno', $request->contractno)->get();

    if ($oldbranchcontactdetails != null) {
        for ($i = 0; $i < count($oldbranchcontactdetails); $i++) {
            $branchcontactmaster = new BranchContactMasterModel();
            $branchcontactmaster->contactpersonname = $oldbranchcontactdetails[$i]->contactpersonname;
            $branchcontactmaster->branchcontactcode = $oldbranchcontactdetails[$i]->branchcontactcode;
            $branchcontactmaster->branchcode = $oldbranchcontactdetails[$i]->branchcode;
            $branchcontactmaster->phone = $oldbranchcontactdetails[$i]->phone;
            $branchcontactmaster->fax = $oldbranchcontactdetails[$i]->fax;
            $branchcontactmaster->emailid = $oldbranchcontactdetails[$i]->emailid;
            $branchcontactmaster->contractno = $newcontractno;
            $branchcontactmaster->created_at = Carbon::now(new DateTimeZone('Asia/Kolkata'));
            $branchcontactmaster->created_by = $user->name;
            $branchcontactmaster->updated_at = null;
            $branchcontactmaster->save();
        }
    }
    #endregion

    #region Add Equipment

    $oldequipmentdetails = EquipmentMasterModel::where('contractno', $request->contractno)->get();
    $count = count($oldequipmentdetails);
    $status = 'InActive';
    for($i = 0; $i < $count; $i++)
    {
        $data = EquipmentMasterModel::where('contractno',$oldequipmentdetails[$i]->contractno)
            ->where('equipmentsrno',$oldequipmentdetails[$i]->equipmentsrno)
            ->get()->first();
        $data->status = $status;
        $data->updated_at = Carbon::now(new DateTimeZone('Asia/Kolkata'));
        $data->update();
    }

    if ($oldequipmentdetails != null) {
        $status = 'Active';
        for ($i = 0; $i < $count; $i++) {
            $equipmentmaster = new EquipmentMasterModel;
            $equipmentmaster->customercode = $oldequipmentdetails[$i]->customercode;
            $equipmentmaster->contractno = $newcontractno;
            $equipmentmaster->contracttype = $oldequipmentdetails[$i]->contracttype;
            $equipmentmaster->branchcode = $oldequipmentdetails[$i]->branchcode;
            $equipmentmaster->productservicecode = $oldequipmentdetails[$i]->productservicecode;
            $equipmentmaster->categorycode = $oldequipmentdetails[$i]->categorycode;
            $equipmentmaster->equipmentsrno = $oldequipmentdetails[$i]->equipmentsrno;
            $equipmentmaster->productsrno = $oldequipmentdetails[$i]->productsrno;
            $equipmentmaster->specification = $oldequipmentdetails[$i]->specification;
            $equipmentmaster->status = $status;
            $equipmentmaster->flagkey = '0';
            $equipmentmaster->created_at = Carbon::now(new DateTimeZone('Asia/Kolkata'));
            $equipmentmaster->created_by = $user->name;
            $equipmentmaster->updated_at = null;
            $equipmentmaster->save();

        }
    }

    
    return redirect('contracts')->with('flash_message', 'Amendment Successfully Added. New Contract No is ' . $newcontractno);
}



public function uploadMultipleDocuments(Request $request)
{
    try {
        $contractno = $request->contractno;
        $docField = $request->doc_field;
        $subtype = $request->subtype; // NEW: 'new_contract' or 'amend'

        
        $contractDoc = ContractDocumentsModel::where('contractno', $contractno)
                        ->where('subtype', $subtype)
                        ->first();

        if (!$contractDoc) {
            $contractDoc = new ContractDocumentsModel();
            $contractDoc->contractno = $contractno;
            $contractDoc->type = 'contract';
            $contractDoc->subtype = $subtype; // Set subtype
            $contractDoc->created_by = auth()->user()->name;
            $contractDoc->created_at = Carbon::now();
        }

        $files = $request->file('documents');

        foreach ($files as $index => $file) {
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('contracts/' . $contractno . '/' . $subtype, $filename, 'public');

            if ($docField) {
                if ($contractDoc->$docField && Storage::disk('public')->exists($contractDoc->$docField)) {
                    Storage::disk('public')->delete($contractDoc->$docField);
                }
                $contractDoc->$docField = $path;
            } else {
                if (!$contractDoc->doc1) {
                    $contractDoc->doc1 = $path;
                } elseif (!$contractDoc->doc2) {
                    $contractDoc->doc2 = $path;
                } elseif (!$contractDoc->doc3) {
                    $contractDoc->doc3 = $path;
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'Max 3 files already uploaded. Please delete one first.'
                    ]);
                }
            }
        }

        $contractDoc->updated_by = auth()->user()->name;
        $contractDoc->updated_at = Carbon::now();
        $contractDoc->save();
        $contractDoc->refresh();

        return response()->json([
            'success'   => true,
            'message'   => 'Documents uploaded successfully',
            'documents' => $contractDoc
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => $e->getMessage()
        ]);
    }
}


public function viewContractDocument($contractno, $docField)
{
    $contractDoc = ContractDocumentsModel::where('contractno', $contractno)->first();
    
    if ($contractDoc && $contractDoc->$docField) {
        $filePath = storage_path('app/public/' . $contractDoc->$docField);
        
        // Debug - Log the file path
        \Log::info('Looking for file at: ' . $filePath);
        
        if (file_exists($filePath)) {
            $extension = pathinfo($filePath, PATHINFO_EXTENSION);
            
            if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                return response()->file($filePath);
            }
            
            if ($extension == 'pdf') {
                return response()->file($filePath, [
                    'Content-Type' => 'application/pdf',
                    'Content-Disposition' => 'inline; filename="' . basename($filePath) . '"'
                ]);
            }
            
            return response()->download($filePath);
        } else {
            \Log::error('File not found: ' . $filePath);
            return redirect()->back()->with('error', 'File not found at: ' . $filePath);
        }
    }
    
    return redirect()->back()->with('error', 'Document not found in database');
}

/**
 * Download document
 */
public function downloadContractDocument($contractno, $docField)
{
    $contractDoc = ContractDocumentsModel::where('contractno', $contractno)->first();
    
    if ($contractDoc && $contractDoc->$docField) {
        $filePath = storage_path('app/public/' . $contractDoc->$docField);
        if (file_exists($filePath)) {
            return response()->download($filePath);
        }
    }
    
    return redirect()->back()->with('error', 'File not found');
}


public function getContractDocuments($contractno)
{
    // Get both new contract and amendment documents
    $documents = [
        'new_contract' => ContractDocumentsModel::where('contractno', $contractno)
                            ->where('subtype', 'new_contract')
                            ->first(),
        'amend' => ContractDocumentsModel::where('contractno', $contractno)
                    ->where('subtype', 'amend')
                    ->first()
    ];
    
    return response()->json([
        'success' => true,
        'documents' => $documents
    ]);
}


public function deleteContractDocument(Request $request) 
{
    try {
        $contractno = $request->contractno;
        $docField = $request->doc_field;

        $contractDoc = ContractDocumentsModel::where('contractno', $contractno)->first();

        if ($contractDoc) {

            if ($contractDoc->$docField && Storage::disk('public')->exists($contractDoc->$docField)) {
                Storage::disk('public')->delete($contractDoc->$docField);
            }

            $contractDoc->$docField = null;
            $contractDoc->save();

            return response()->json([
                'success' => true,
                'message' => 'Document deleted successfully'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Document not found'
        ], 404);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => $e->getMessage()
        ], 500);
    }
}

public function uploadEquipmentDocument(Request $request)
{
    try {
        $contractno = $request->contractno;
        $file = $request->file('document');
        $subtype = $request->subtype; // NEW: 'equipment' or 'amend_equipment'

        // Find or create record with specific subtype
        $contractDoc = ContractDocumentsModel::where('contractno', $contractno)
                        ->where('subtype', $subtype)
                        ->first();

        if (!$contractDoc) {
            $contractDoc = new ContractDocumentsModel();
            $contractDoc->contractno = $contractno;
            $contractDoc->type = 'contract';
            $contractDoc->subtype = $subtype;
            $contractDoc->created_by = auth()->user()->name;
            $contractDoc->created_at = Carbon::now();
        }

        // Delete old file if exists
        if ($contractDoc->doc1 && Storage::disk('public')->exists($contractDoc->doc1)) {
            Storage::disk('public')->delete($contractDoc->doc1);
        }

        $filename = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('contracts/' . $contractno . '/' . $subtype, $filename, 'public');

        $contractDoc->doc1 = $path;
        $contractDoc->updated_by = auth()->user()->name;
        $contractDoc->updated_at = Carbon::now();
        $contractDoc->save();

        return response()->json([
            'success'  => true,
            'message'  => 'Equipment document uploaded successfully.',
            'document' => $contractDoc
        ]);

    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => $e->getMessage()]);
    }
}



public function getEquipmentDocument($contractno)
{
    $documents = [
        'equipment' => ContractDocumentsModel::where('contractno', $contractno)
                        ->where('subtype', 'equipment')
                        ->first(),
        'amend_equipment' => ContractDocumentsModel::where('contractno', $contractno)
                            ->where('subtype', 'amend_equipment')
                            ->first()
    ];

    return response()->json(['success' => true, 'document' => $documents])
        ->header('Cache-Control', 'no-cache, no-store, must-revalidate');
}


public function viewEquipmentDocument($contractno)
{
    // First try to get equipment document
    $doc = ContractDocumentsModel::where('contractno', $contractno)
               ->where('subtype', 'equipment')
               ->first();
    
    // If not found, try amend_equipment
    if (!$doc) {
        $doc = ContractDocumentsModel::where('contractno', $contractno)
                   ->where('subtype', 'amend_equipment')
                   ->first();
    }

    if ($doc && $doc->doc1) {
        $filePath = storage_path('app/public/' . $doc->doc1);
        if (file_exists($filePath)) {
            $extension = pathinfo($filePath, PATHINFO_EXTENSION);
            if (in_array($extension, ['jpg','jpeg','png'])) {
                return response()->file($filePath);
            }
            if ($extension === 'pdf') {
                return response()->file($filePath, [
                    'Content-Type' => 'application/pdf',
                    'Content-Disposition' => 'inline; filename="' . basename($filePath) . '"'
                ]);
            }
            return response()->download($filePath);
        }
    }
    return redirect()->back()->with('error', 'File not found.');
}


public function downloadEquipmentDocument($contractno)
{
    // First try to get equipment document
    $doc = ContractDocumentsModel::where('contractno', $contractno)
               ->where('subtype', 'equipment')
               ->first();
    
    // If not found, try amend_equipment
    if (!$doc) {
        $doc = ContractDocumentsModel::where('contractno', $contractno)
                   ->where('subtype', 'amend_equipment')
                   ->first();
    }

    if ($doc && $doc->doc1) {
        $filePath = storage_path('app/public/' . $doc->doc1);
        if (file_exists($filePath)) {
            return response()->download($filePath);
        }
    }
    return redirect()->back()->with('error', 'File not found.');
}


public function deleteEquipmentDocument(Request $request)
{
    try {
        $contractno = $request->contractno;
        
        // Try to delete from equipment first, then amend_equipment
        $doc = ContractDocumentsModel::where('contractno', $contractno)
                   ->where('subtype', 'equipment')
                   ->first();
        
        if (!$doc) {
            $doc = ContractDocumentsModel::where('contractno', $contractno)
                       ->where('subtype', 'amend_equipment')
                       ->first();
        }

        if ($doc && $doc->doc1) {
            if (Storage::disk('public')->exists($doc->doc1)) {
                Storage::disk('public')->delete($doc->doc1);
            }
            $doc->doc1 = null;
            $doc->updated_at = Carbon::now();
            $doc->save();

            return response()->json(['success' => true, 'message' => 'Document deleted.']);
        }

        return response()->json(['success' => false, 'message' => 'Document not found.'], 404);

    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
    }
}


public function addBillingDetails()
{
    try {
        $user = auth()->user();
        $contractno = $_GET['contractno'];

        $estimatedbillingdate = isset($_GET['estimatedbillingdate']) ? $_GET['estimatedbillingdate'] : [];
        $actualbilldate = isset($_GET['actualbilldate']) ? $_GET['actualbilldate'] : [];
        $billnumber = isset($_GET['billnumber']) ? $_GET['billnumber'] : [];
        $billamount = isset($_GET['billamount']) ? $_GET['billamount'] : [];
        $billpaidamount = isset($_GET['billpaidamount']) ? $_GET['billpaidamount'] : [];
        $billpaymentdate = isset($_GET['billpaymentdate']) ? $_GET['billpaymentdate'] : [];
        $nextreminderdate = isset($_GET['nextreminderdate']) ? $_GET['nextreminderdate'] : [];

        $count = count($billpaidamount);

        $totalpaid = 0;
        for ($i = 0; $i < $count; $i++) {
            $totalpaid += (float) $billpaidamount[$i];
        }

        BillingPaymentCyclesModel::where('contractno', $contractno)->delete();

        for ($i = 0; $i < $count; $i++) {
            $paid = isset($billpaidamount[$i]) ? $billpaidamount[$i] : '';
            $paydate = isset($billpaymentdate[$i]) ? $billpaymentdate[$i] : '';
            $billno = isset($billnumber[$i]) ? $billnumber[$i] : '';
            $billamt = isset($billamount[$i]) ? $billamount[$i] : '';
            $estdate = isset($estimatedbillingdate[$i]) ? $estimatedbillingdate[$i] : '';
            $actdate = isset($actualbilldate[$i]) ? $actualbilldate[$i] : '';

            if ($paid == '' && $paydate == '' && $billno == '' && $estdate == '' && $actdate == '') {
                continue;
            }

            $cycle = new BillingPaymentCyclesModel();
            $cycle->contractno = $contractno;
            $cycle->paymentcycleno = $i + 1;
            $cycle->estimatedbillingdate = $this->checkifdataisempty($estdate);
            $cycle->actualbilldate = $this->checkifdataisempty($actdate);
            $cycle->billnumber = $this->checkifdataisempty($billno);
            $cycle->billamount = $this->checkifdataisempty($billamt);
            $cycle->billpaidamount = $this->checkifdataisempty($paid);
            $cycle->billpaymentdate = $this->checkifdataisempty($paydate);
            $cycle->nextreminderdate = isset($nextreminderdate[$i]) ? $this->checkifdataisempty($nextreminderdate[$i]) : null;
            $cycle->created_at = Carbon::now(new DateTimeZone('Asia/Kolkata'));
            $cycle->created_by = $user->name;
            $cycle->save();
        }

        $cycleslist = BillingPaymentCyclesModel::where('contractno', $contractno)
            ->orderBy('paymentcycleno', 'asc')->get();

        return json_encode(array(
            'cycleslist' => $cycleslist,
            'totalpaid' => $totalpaid,
            'contractno' => $contractno
        ));

    } catch (Exception $exception) {
        return json_encode(array(
            'error' => 'Exception: ' . $exception->getMessage() . ' in ' . $exception->getFile() . ' on line ' . $exception->getLine()
        ));
    }
}

public function getBillingDetails($contractno)
{
    $cycleslist = BillingPaymentCyclesModel::where('contractno', $contractno)
        ->orderBy('paymentcycleno', 'asc')->get();
    return json_encode(array('cycleslist' => $cycleslist));
}


public function addPaymentDetails(Request $request)
{
    try {
        $user = auth()->user();
        $contractno = $request->input('contractno');

        $pd = PaymentDetailsNewModel::where('contractno', $contractno)->first();

        if ($pd == null) {
            $pd = new PaymentDetailsNewModel();
            $pd->contractno = $contractno;
            $pd->created_at = Carbon::now(new DateTimeZone('Asia/Kolkata'));
            $pd->created_by = $user->name;
        } else {
            $pd->updated_at = Carbon::now(new DateTimeZone('Asia/Kolkata'));
            $pd->updated_by = $user->name;
        }

        $pd->formfeesamount = $this->checkifdataisempty($request->input('formfeesamount'));
        $pd->formfeesexemption = $this->checkifdataisempty($request->input('formfeesexemption'));
        $pd->formfeesdatepaid = $this->checkifdataisempty($request->input('formfeesdatepaid'));

        $pd->emdamount = $this->checkifdataisempty($request->input('emdamount'));
        
        $pd->emdexemption = $this->checkifdataisempty($request->input('emdexemption'));
        $pd->emddatepaid = $this->checkifdataisempty($request->input('emddatepaid'));
        $pd->emdestimatedreturndate = $this->checkifdataisempty($request->input('emdestimatedreturndate'));
        $pd->emdreturnamount = $this->checkifdataisempty($request->input('emdreturnamount'));
        $pd->emdreturndate = $this->checkifdataisempty($request->input('emdreturndate'));

        $pd->securitydepositamount = $this->checkifdataisempty($request->input('securitydepositamount'));
        $pd->securitydeposittype = $this->checkifdataisempty($request->input('securitydeposittype'));
        $pd->securitydepositdatepaid = $this->checkifdataisempty($request->input('securitydepositdatepaid'));
        $pd->securitydepositestimatedreturndate = $this->checkifdataisempty($request->input('securitydepositestimatedreturndate'));
        $pd->securitydepositreturnamount = $this->checkifdataisempty($request->input('securitydepositreturnamount'));
        $pd->securitydepositreturndate = $this->checkifdataisempty($request->input('securitydepositreturndate'));

        $pd->adminchargesamount = $this->checkifdataisempty($request->input('adminchargesamount'));
        $pd->adminchargesexemption = $this->checkifdataisempty($request->input('adminchargesexemption'));
        $pd->adminchargesdatepaid = $this->checkifdataisempty($request->input('adminchargesdatepaid'));

        $pd->facilitychargesamount = $this->checkifdataisempty($request->input('facilitychargesamount'));
        $pd->facilitychargesexemption = $this->checkifdataisempty($request->input('facilitychargesexemption'));
        $pd->facilitychargesdatepaid = $this->checkifdataisempty($request->input('facilitychargesdatepaid'));

        $pd->legalchargesamount = $this->checkifdataisempty($request->input('legalchargesamount'));
        $pd->legalchargesexemption = $this->checkifdataisempty($request->input('legalchargesexemption'));
        $pd->legalchargesdatepaid = $this->checkifdataisempty($request->input('legalchargesdatepaid'));

        $pd->addnlsecuritydepositamount = $this->checkifdataisempty($request->input('addnlsecuritydepositamount'));
        $pd->addnlsecuritydepositexemption = $this->checkifdataisempty($request->input('addnlsecuritydepositexemption'));
        $pd->addnlsecuritydepositdatepaid = $this->checkifdataisempty($request->input('addnlsecuritydepositdatepaid'));
        $pd->addnlsecuritydepositrefunddate = $this->checkifdataisempty($request->input('addnlsecuritydepositrefunddate'));

        $pd->save();

        // handle document uploads into shared contract_documents table
        $docRow = ContractDocumentsModel::where('contractno', $contractno)
            ->where('type', 'contract')
            ->where('subtype', 'payment')
            ->first();

        if ($docRow == null) {
            $docRow = new ContractDocumentsModel();
            $docRow->contractno = $contractno;
            $docRow->type = 'contract';
            $docRow->subtype = 'payment';
            $docRow->created_at = Carbon::now(new DateTimeZone('Asia/Kolkata'));
            $docRow->created_by = $user->name;
        } else {
            $docRow->updated_at = Carbon::now(new DateTimeZone('Asia/Kolkata'));
            $docRow->updated_by = $user->name;
        }

        if ($request->hasFile('doc1')) {
            $file = $request->file('doc1');
            $filename = time() . '_' . $file->getClientOriginalName();
            $docRow->doc1 = $file->storeAs('contracts/' . $contractno . '/payment', $filename, 'public');
        }

        if ($request->hasFile('doc2')) {
            $file = $request->file('doc2');
            $filename = time() . '_' . $file->getClientOriginalName();
            $docRow->doc2 = $file->storeAs('contracts/' . $contractno . '/payment', $filename, 'public');
        }

        if ($request->hasFile('doc3')) {
            $file = $request->file('doc3');
            $filename = time() . '_' . $file->getClientOriginalName();
            $docRow->doc3 = $file->storeAs('contracts/' . $contractno . '/payment', $filename, 'public');
        }

        $docRow->save();

        return json_encode(array('paymentdetails' => $pd, 'contractno' => $contractno));

    } catch (Exception $exception) {
        return json_encode(array(
            'error' => 'Exception: ' . $exception->getMessage() . ' in ' . $exception->getFile() . ' on line ' . $exception->getLine()
        ));
    }
}

public function getPaymentDetails($contractno)
{
    $paymentdetails = PaymentDetailsNewModel::where('contractno', $contractno)->first();
    $document = ContractDocumentsModel::where('contractno', $contractno)
        ->where('type', 'contract')
        ->where('subtype', 'payment')
        ->first();

    return json_encode(array('paymentdetails' => $paymentdetails, 'document' => $document));
}

public function viewPaymentDocument($contractno, $docField)
{
    $doc = ContractDocumentsModel::where('contractno', $contractno)
        ->where('type', 'contract')
        ->where('subtype', 'payment')
        ->first();

    if ($doc && $doc->$docField) {
        $filePath = storage_path('app/public/' . $doc->$docField);
        if (file_exists($filePath)) {
            $extension = pathinfo($filePath, PATHINFO_EXTENSION);

            if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                return response()->file($filePath);
            }

            if ($extension == 'pdf') {
                return response()->file($filePath, [
                    'Content-Type' => 'application/pdf',
                    'Content-Disposition' => 'inline; filename="' . basename($filePath) . '"'
                ]);
            }

            return response()->download($filePath);
        }
    }

    return redirect()->back()->with('error', 'File not found');
}

public function downloadPaymentDocument($contractno, $docField)
{
    $doc = ContractDocumentsModel::where('contractno', $contractno)
        ->where('type', 'contract')
        ->where('subtype', 'payment')
        ->first();

    if ($doc && $doc->$docField) {
        $filePath = storage_path('app/public/' . $doc->$docField);
        if (file_exists($filePath)) {
            return response()->download($filePath);
        }
    }

    return redirect()->back()->with('error', 'File not found');
}

public function deletePaymentDocument(Request $request)
{
    try {
        $contractno = $request->contractno;
        $docField = $request->doc_field;

        $doc = ContractDocumentsModel::where('contractno', $contractno)
            ->where('type', 'contract')
            ->where('subtype', 'payment')
            ->first();

        if ($doc && $doc->$docField) {
            if (Storage::disk('public')->exists($doc->$docField)) {
                Storage::disk('public')->delete($doc->$docField);
            }
            $doc->$docField = null;
            $doc->save();

            return response()->json(['success' => true, 'message' => 'Document deleted successfully']);
        }

        return response()->json(['success' => false, 'message' => 'Document not found'], 404);

    } catch (Exception $exception) {
        return response()->json(['success' => false, 'message' => $exception->getMessage()], 500);
    }
}

public function dashboardnew()
{
    $today = Carbon::today(new DateTimeZone('Asia/Kolkata'));

    $alertconfig        = DashboardAlertConfigModel::getAll();
    $expiringSoonDays   = $alertconfig['expiring_soon_days']    ?? 30;
    $criticalDays       = $alertconfig['critical_days']         ?? 5;
    $urgentDays         = $alertconfig['urgent_days']           ?? 15;
    $newContractDays    = $alertconfig['new_contract_days']     ?? 7;
    $billingDueSoonDays = $alertconfig['billing_due_soon_days'] ?? 5;

    // ---------------- CONTRACT EXPIRY ----------------
    $contracts = ContractMasterModel::selectRaw('tblcontractmaster.*, tblcustomermaster.customername')
        ->leftjoin('tblcustomermaster', 'tblcustomermaster.customercode', '=', 'tblcontractmaster.customercode')
        ->get();

    $expiring = collect();
    $expired = collect();
    $newContracts = collect();
    $all = collect();

    

    foreach ($contracts as $c) {
        $daysleft = null;
        if ($c->contracttodate) {
            $todate = Carbon::parse($c->contracttodate);
            $daysleft = $todate->lt($today) ? -1 * $todate->diffInDays($today) : $today->diffInDays($todate);
        }
        $c->daysleft = $daysleft;
        $c->category = $this->getWorkOrderCategory($c->workordertype);


        if ($c->closuredate) {
            $c->status = 'Closed';
            $c->statuscolor = 'default';
        } elseif ($daysleft === null) {
            $c->status = 'No End Date';
            $c->statuscolor = 'default';
        } elseif ($daysleft < 0) {
            $c->status = 'Expired';
            $c->statuscolor = 'danger';
        
        } elseif ($daysleft <= $criticalDays) {
            $c->status = 'Critical';
            $c->statuscolor = 'danger';
        } elseif ($daysleft <= $urgentDays) {
            $c->status = 'Urgent';
            $c->statuscolor = 'warning';
        } elseif ($daysleft <= $expiringSoonDays) {
            $c->status = 'Upcoming';
            $c->statuscolor = 'info';
        }
        
        else {
            $c->status = 'Active';
            $c->statuscolor = 'success';
        }

        $c->isnew = $c->created_at && Carbon::parse($c->created_at)->gte($today->copy()->subDays($newContractDays));

        if (!$c->closuredate && $daysleft !== null && $daysleft >= 0 && $daysleft <= $expiringSoonDays) {
            $expiring->push($c);
        }
        if (!$c->closuredate && $daysleft !== null && $daysleft < 0) {
            $expired->push($c);
        }
        if ($c->isnew) {
            $newContracts->push($c);
        }
        $all->push($c);
    }

    $expiring = $expiring->sortBy('daysleft')->values();
    $expired = $expired->sortBy('daysleft')->values();
    $all = $all->sortBy('daysleft')->values();
    $newContracts = $newContracts->sortByDesc('created_at')->values();

    // ---------------- BILLING ALERTS ----------------
    $cycles = BillingPaymentCyclesModel::selectRaw('tblbillingpaymentcycles.*, tblcontractmaster.customercode, tblcontractmaster.workordertype, tblcustomermaster.customername')
        ->leftjoin('tblcontractmaster', 'tblcontractmaster.contractno', '=', 'tblbillingpaymentcycles.contractno')
        ->leftjoin('tblcustomermaster', 'tblcustomermaster.customercode', '=', 'tblcontractmaster.customercode')
        ->get();

    $billingalerts = collect();

    foreach ($cycles as $b) {
        $tags = [];
        $color = 'success';
        $rank = 99;

        $estdate = $b->estimatedbillingdate ? Carbon::parse($b->estimatedbillingdate) : null;
        $daystoestimated = null;

        if ($estdate) {
            $daystoestimated = $estdate->lt($today) ? -1 * $estdate->diffInDays($today) : $today->diffInDays($estdate);
        }
        $b->daystoestimated = $daystoestimated;
        $b->category = $this->getWorkOrderCategory($b->workordertype); 

        // 1) Bill not raised yet (actualbilldate null)
        if (!$b->actualbilldate && $estdate) {
            if ($daystoestimated < 0) {
                $tags[] = 'Bill Overdue - Not Raised (' . abs($daystoestimated) . ' days late)';
                $color = 'danger';
                $rank = min($rank, 1);
            } elseif ($daystoestimated <= $billingDueSoonDays) {
                $tags[] = 'Bill Due in ' . $daystoestimated . ' day(s)';
                $color = 'warning';
                $rank = min($rank, 2);
            }
        }

        // 2) Payment shortfall (paid less than billed)
        $diff = null;
        if ($b->billamount !== null && $b->billpaidamount !== null) {
            $diff = round((float)$b->billamount - (float)$b->billpaidamount, 2);
            if ($diff > 0) {
                $tags[] = 'Short Paid by Rs.' . number_format($diff, 2);
                $color = 'danger';
                $rank = min($rank, 1);
            }
        }
        $b->diffamount = $diff;

        // 3) Payment received late vs estimated date
        $latedays = null;
        if ($b->billpaymentdate && $estdate) {
            $paymentdate = Carbon::parse($b->billpaymentdate);
            if ($paymentdate->gt($estdate)) {
                $latedays = $estdate->diffInDays($paymentdate);
                $tags[] = 'Paid Late by ' . $latedays . ' day(s)';
                $color = ($color == 'danger') ? 'danger' : 'warning';
                $rank = min($rank, 3);
            }
        }
        $b->latedays = $latedays;

        // 4) Bill was raised but payment never came in
        if ($b->actualbilldate && !$b->billpaymentdate) {
            $tags[] = 'Payment Not Received';
            $color = 'danger';
            $rank = min($rank, 1);
        }

        $b->billstatus = count($tags) ? implode(' | ', $tags) : 'OK';
        $b->billstatuscolor = $color;
        $b->urgencyrank = $rank;

        $billingalerts->push($b);
    }

    $billingalerts = $billingalerts->sortBy('urgencyrank')->values();

    return view('contract.dashboardnew', compact('expiring', 'expired', 'newContracts', 'all', 'billingalerts'));
}

public function getWorkOrderCategory($workordertype)
{
    $softwareTypes  = ['Software development', 'Software Maintenance'];
    $hardwareTypes  = ['Hardware AMC', 'Hardware Warranty', 'Hardware Supply'];
    $manpowerTypes  = ['Scanning', 'Data Entry', 'Manpower Supply'];

    if (in_array($workordertype, $softwareTypes)) {
        return 'software';
    } elseif (in_array($workordertype, $hardwareTypes)) {
        return 'hardware';
    } elseif (in_array($workordertype, $manpowerTypes)) {
        return 'manpower';
    }
    return 'other';
}

public function alertSettings()
{
    $settings = DashboardAlertConfigModel::all();
    return view('contract.alertSettings', compact('settings'));
}

public function updateAlertSettings(Request $request)
{
    foreach ($request->input('alertdays') as $id => $value) {
        $setting = DashboardAlertConfigModel::find($id);
        if ($setting) {
            $setting->alertdays  = $value;
            $setting->updated_by = auth()->user()->name;
            $setting->updated_at = Carbon::now(new DateTimeZone('Asia/Kolkata'));
            $setting->save();
        }
    }
    return redirect()->back()->with('flash_message', 'Alert settings updated.');
}

// Option   Condition
// view    Always shown
// edit  closuredate is empty
// amend Contract expired + type is AMC/Hardware AMC/Warranty + closuredate is empty (Hardware AMC)
}
