<?php

namespace App\Http\Controllers;

use App\Models\ContractMasterModel;
use App\Models\EquipmentMasterModel;
use Exception;
use Mail;
use DateTimeZone;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\CustomersModel;
use App\Models\TenderViewModel;
use App\Models\MailMasterModel;
use App\Models\BranchMasterModel;
use App\Models\CategoryMasterModel;
use App\Models\TransactionErrorModel;
use App\Models\SubCategoryMasterModel;
use App\Models\IncrementMasterModel;
use App\Models\ExistingUserComplaintLodging;


use App\Models\DashboardAlertConfigModel;
use Illuminate\Support\Facades\DB;


class CommonController extends Controller
{
    public function ErrorLogging(Exception $exception, $controllername, $methodname)
    {
        $model = new TransactionErrorModel;
        $model->controllername = $controllername;
        $model->methodname = $methodname;
        $model->message = $exception->getMessage();
        $model->errortime = Carbon::now(new DateTimeZone('Asia/Kolkata'));
        $model->save();
    }

    public function SendingNotifications(){
        $sendingstatus = null;

        $mailmaster = MailMasterModel::where('sendingdate',Carbon::now(new DateTimeZone('Asia/Kolkata'))->toDateString())->where('sendingstatus', 'Remaining')->get();

        foreach ($mailmaster as $item) {
            $tender = TenderViewModel::where('tenderno', $item->tenderno)->first();

            $receivermailid = $item->receivermailid;
            if($item->mailfor == 'queryenddate'){
                try{
                    $data = [
                        'tenderno' => $tender->tenderno,
                        'company' => $tender->organisation,
                        'department' => $tender->department,
                        'date' => date("d-m-Y", strtotime($tender->queryenddate)),
                        'receivermailid' => $receivermailid
                    ];

                    Mail::send('emails.queryenddate', $data, function ($message) use ($receivermailid)
                    {
                        $message->to($receivermailid, $receivermailid)->subject('Tender : Query End Date Reminder');
                        $message->from('technowinitinfra@gmail.com', 'Technowin IT Infra');
                    });

                    $sendingstatus = 'Success';
                }
                catch (Exception $ex){
                    $sendingstatus = 'Failed';
                    $this->ErrorLogging($ex, 'CommonController', 'SendingNotifications/queryenddate');
                    continue;
                }
            }
            elseif($item->mailfor == 'prebidmeetingdate'){
                try{
                    $data = [
                        'tenderno' => $tender->tenderno,
                        'company' => $tender->organisation,
                        'department' => $tender->department,
                        'date' => date("d-m-Y", strtotime($tender->prebidmeetingdate))
                    ];

                    Mail::send('emails.prebidmeeting', $data, function ($message) use ($receivermailid)
                    {
                        $message->to($receivermailid, $receivermailid)->subject('Tender : Pre Bid Meeting Date Reminder');
                        $message->from('technowinitinfra@gmail.com', 'Technowin IT Infra');
                    });

                    $sendingstatus = 'Success';
                }
                catch (Exception $ex){
                    $sendingstatus = 'Failed';
                    $this->ErrorLogging($ex, 'CommonController', 'SendingNotifications/prebidmeetingdate');
                    continue;
                }
            }
            elseif($item->mailfor == 'bidsubmissiondate'){
                try{
                    $data = [
                        'tenderno' => $tender->tenderno,
                        'company' => $tender->organisation,
                        'department' => $tender->department,
                        'date' => date("d-m-Y", strtotime($tender->bidsubmissiondate))
                    ];

                    Mail::send('emails.bidsubmissiondate', $data, function ($message) use ($receivermailid)
                    {
                        $message->to($receivermailid, $receivermailid)->subject('Tender : Bid Submission Date Reminder');
                        $message->from('technowinitinfra@gmail.com', 'Technowin IT Infra Pvt. Ltd.');
                    });

                    $sendingstatus = 'Success';
                }
                catch (Exception $ex){
                    $sendingstatus = 'Failed';
                    $this->ErrorLogging($ex, 'CommonController', 'SendingNotifications/bidsubmissiondate');
                    continue;
                }
            }
            elseif($item->mailfor == 'extendeddate'){
                try{
                    $data = [
                        'tenderno' => $tender->tenderno,
                        'company' => $tender->organisation,
                        'department' => $tender->department,
                        'date' => date("d-m-Y", strtotime($tender->extendeddate))
                    ];

                    Mail::send('emails.extendeddate', $data, function ($message) use ($receivermailid)
                    {
                        $message->to($receivermailid, $receivermailid)->subject('Tender : Extended Date New Due Date Reminder');
                        $message->from('technowinitinfra@gmail.com', 'Technowin IT Infra');
                    });

                    $sendingstatus = 'Success';
                }
                catch (Exception $ex){
                    $sendingstatus = 'Failed';
                    $this->ErrorLogging($ex, 'CommonController', 'SendingNotifications/extendeddate');
                    continue;
                }
            }
            elseif($item->mailfor == 'technicalbidopendate'){
                try{
                    $data = [
                        'tenderno' => $tender->tenderno,
                        'company' => $tender->organisation,
                        'department' => $tender->department,
                        'date' => date("d-m-Y", strtotime($tender->technicalbidopendate))
                    ];

                    Mail::send('emails.technicalbidopendate', $data, function ($message) use ($receivermailid)
                    {
                        $message->to($receivermailid, $receivermailid)->subject('Tender : Technical Bid Open Date Reminder');
                        $message->from('technowinitinfra@gmail.com', 'Technowin IT Infra');
                    });

                    $sendingstatus = 'Success';
                }
                catch (Exception $ex){
                    $sendingstatus = 'Failed';
                    $this->ErrorLogging($ex, 'CommonController', 'SendingNotifications/technicalbidopendate');
                    continue;
                }
            }
            elseif($item->mailfor == 'commercialbidopendate'){
                try{
                    $data = [
                        'tenderno' => $tender->tenderno,
                        'company' => $tender->organisation,
                        'department' => $tender->department,
                        'date' => date("d-m-Y", strtotime($tender->commercialbidopendate))
                    ];

                    Mail::send('emails.commercialbidopendate', $data, function ($message) use ($receivermailid)
                    {
                        $message->to($receivermailid, $receivermailid)->subject('Tender : Commercial Bid Open Date Reminder');
                        $message->from('technowinitinfra@gmail.com', 'Technowin IT Infra');
                    });

                    $sendingstatus = 'Success';
                }
                catch (Exception $ex){
                    $sendingstatus = 'Failed';
                    $this->ErrorLogging($ex, 'CommonController', 'SendingNotifications/commercialbidopendate');
                    continue;
                }
            }
            elseif($item->mailfor == 'emdreturndate'){
                try{
                    $data = [
                        'tenderno' => $tender->tenderno,
                        'company' => $tender->organisation,
                        'department' => $tender->department,
                        'date' => date("d-m-Y", strtotime($tender->emdreturndate))
                    ];

                    Mail::send('emails.emdreturndate', $data, function ($message) use ($receivermailid)
                    {
                        $message->to($receivermailid, $receivermailid)->subject('Tender : EMD Return Date Reminder');
                        $message->from('technowinitinfra@gmail.com', 'Technowin IT Infra');
                    });

                    $sendingstatus = 'Success';
                }
                catch (Exception $ex){
                    $sendingstatus = 'Failed';
                    $this->ErrorLogging($ex, 'CommonController', 'SendingNotifications/emdreturndate');
                    continue;
                }
            }

            $mailsave = MailMasterModel::find($item->mailmasterid);
            $mailsave->sendingstatus = $sendingstatus;
            $mailsave->save();
        }
    }

    public function customerslist()
    {
        try{
            $customers = CustomersModel::all();
            return json_encode($customers);
        }
        catch (Exception $ex) {
            $this->ErrorLogging($ex,'UserComplaint', 'customerslist');
            return 'Some error occurred while processing your request';
        }
    }

    public function categorylist($id)
    {
        try{
            $category = CategoryMasterModel::where('productservicecode',$id)->get();
            return json_encode($category);
        }
        catch (Exception $ex) {
            $this->ErrorLogging($ex,'UserComplaint', 'newcomplaintregister');
            return 'Some error occurred while processing your request';
        }
    }

    public function subcategorylist($id)
    {
        try{
            $subcategory = SubCategoryMasterModel::where('categorycode',$id)->get();
            return json_encode($subcategory);
        }
        catch (Exception $ex) {
            $this->ErrorLogging($ex,'UserComplaint', 'newcomplaintregister');
            return 'Some error occurred while processing your request';
        }
    }

    public function branchlist($id)
    {
        try{
            $branch = BranchMasterModel::where('customercode',$id)->get();
            return json_encode($branch);
        }
        catch (Exception $ex) {
            $this->ErrorLogging($ex,'UserComplaint', 'newcomplaintregister');
            return 'Some error occurred while processing your request';
        }
    }

    public function DynamicCode($mystr,$tablename)
    {
        $lastincrementid = IncrementMasterModel::all()->where('incrementfor',$tablename)->first()->incrementvalue;
        $code = str_pad($lastincrementid+1,4,"0",STR_PAD_LEFT);
        $newgenrateddepartmentcode=strtoupper(mb_substr($mystr,0,2).($code));
        $newgenratedcode=$newgenrateddepartmentcode;
        $itemarray=array('code'=>$newgenratedcode,'incrementid'=>$lastincrementid+1);
        return $itemarray ;
    }

    public  function getworkorderno($id)
    {
        $workorderlist = ContractMasterModel::where('customercode',$id)->where('closuredate',null)->get();
        return json_encode($workorderlist);
    }

    public  function getworkordernowisebranch()
    {
        $workorderlist = ContractMasterModel::where('workorderno',$_GET['workordernoid'])->get()->first();
        $contractno = $workorderlist->contractno;
        $branchlist =  BranchMasterModel::where('contractno',$contractno)->get();
        $fromdate = date("Y-m-d", strtotime($workorderlist->contractfromdate));
        $todate = date("Y-m-d", strtotime($workorderlist->contracttodate));
        $workordertype = $workorderlist->workordertype;
        $comprehensivetype = $workorderlist->comprehensivetype;
        return json_encode(array('contractno'=>$contractno,'branchlist'=>$branchlist,'fromdate'=>$fromdate,'todate'=>$todate,'workordertype'=>$workordertype,'comprehensivetype'=>$comprehensivetype));
    }

    public function  getequipmentsrcustomerwise($id)
    {
        $equipmentlist = EquipmentMasterModel::where('customercode',$id)->where('status','Active')->get();
        return json_encode($equipmentlist);
    }

    public function chkDuplicaterecord($customers,$customersite,$productservice,$category,$subcategory,$productserialno)
    {
        $count = count(ExistingUserComplaintLodging::where('complaintstatus','=','ACKNOWLEDGED')
            ->where('customercode','=',$customers)->where('branchcode','=',$customersite)
            ->where('productservicecode','=',$productservice)->where('categorycode','=',$category)
            ->where('subcategorycode','=',$subcategory)
            ->where('productsrno_accountno','=',$productserialno)->get());
        return $count;
    }

    public function getWorkOrderCategoryCommon($workordertype)
{
    $softwareTypes = ['Software development', 'Software Maintenance'];
    $hardwareTypes = ['Hardware AMC', 'Hardware Warranty', 'Hardware Supply'];
    $manpowerTypes = ['Scanning', 'Data Entry', 'Manpower Supply'];

    if (in_array($workordertype, $softwareTypes)) {
        return 'software';
    } elseif (in_array($workordertype, $hardwareTypes)) {
        return 'hardware';
    } elseif (in_array($workordertype, $manpowerTypes)) {
        return 'manpower';
    }
    return 'other';
}

// public function SendContractExpiryReminders()
// {
//     $today = Carbon::now(new DateTimeZone('Asia/Kolkata'))->startOfDay();

//     echo "1. Method Started\n";

//     $alertconfig = DashboardAlertConfigModel::getAll();
//     $criticalDays = $alertconfig['critical_days'] ?? 5;

//     echo "2. Critical Days: " . $criticalDays . "\n";

//     $targetDate = $today->copy()->addDays($criticalDays)->toDateString();

//     echo "3. Target Date: " . $targetDate . "\n";

//     $remindertype = 'expiry_critical';

//     $contracts = ContractMasterModel::selectRaw('tblcontractmaster.*, tblcustomermaster.customername')
//         ->leftJoin('tblcustomermaster', 'tblcustomermaster.customercode', '=', 'tblcontractmaster.customercode')
//         ->whereDate('contracttodate', $targetDate)
//         ->whereNull('closuredate')
//         ->get();

//     echo "4. Contracts Found: " . $contracts->count() . "\n";

//     foreach ($contracts as $contract) {

//         echo "\n=============================\n";
//         echo "Contract No : " . $contract->contractno . "\n";

//         $alreadySent = DB::table('tblcontractreminderlog')
//             ->where('contractno', $contract->contractno)
//             ->where('remindertype', $remindertype)
//             ->where('senddate', $today->toDateString())
//             ->exists();

//         echo "Already Sent : ";
//         var_dump($alreadySent);

//         if ($alreadySent) {
//             echo "Skipping...\n";
//             continue;
//         }

//         $toEmails = [];

//         $projectEmail = trim($contract->projectownername ?? '');
//         $billingEmail = trim($contract->billingownername ?? '');

//         echo "Project Email : " . $projectEmail . "\n";
//         echo "Billing Email : " . $billingEmail . "\n";

//         if (!empty($projectEmail) && filter_var($projectEmail, FILTER_VALIDATE_EMAIL)) {
//             $toEmails[] = $projectEmail;
//         }

//         if (!empty($billingEmail)
//             && filter_var($billingEmail, FILTER_VALIDATE_EMAIL)
//             && $billingEmail != $projectEmail) {

//             $toEmails[] = $billingEmail;
//         }

//         echo "To Emails : ";
//         print_r($toEmails);

//         $category = $this->getWorkOrderCategoryCommon($contract->workordertype);

//         if ($category == 'software') {
//             $ccEmail = 'anjali@technowin.co.in';
//         } elseif ($category == 'hardware' || $category == 'manpower') {
//             $ccEmail = 'mahesf4v@gmail.com';
//         } else {
//             $ccEmail = null;
//         }

//         echo "CC Email : " . $ccEmail . "\n";

// echo "Before Mail::send()\n";

// try {

//     Mail::raw('This is a test email.', function ($message) {

//     echo "Inside Closure\n";

//     echo "Setting TO...\n";
//     $message->to('riya@technowin.co.in');

//     echo "TO Done\n";

//     echo "Setting FROM...\n";
//     $message->from('technowinitinfra@gmail.com', 'Technowin IT Infra');

//     echo "FROM Done\n";

//     echo "Setting Subject...\n";
//     $message->subject('Test Email');

//     echo "Subject Done\n";
// });

//     dd("MAIL SENT");

// } catch (\Exception $e) {

//     dd(
//         $e->getMessage(),
//         $e->getFile(),
//         $e->getLine()
//     );
// }

//     } 
//     echo "\nFinished\n";

// }




// public function SendContractExpiryReminders()
// {
//     $today = Carbon::now(new DateTimeZone('Asia/Kolkata'))->startOfDay();

//     $alertconfig  = DashboardAlertConfigModel::getAll();
//     $criticalDays = $alertconfig['critical_days'] ?? 5;

//     $targetDate = $today->copy()->addDays($criticalDays)->toDateString();
//     $remindertype = 'expiry_critical';

//     $contracts = ContractMasterModel::selectRaw('tblcontractmaster.*, tblcustomermaster.customername')
//         ->leftjoin('tblcustomermaster', 'tblcustomermaster.customercode', '=', 'tblcontractmaster.customercode')
//         ->whereDate('contracttodate', $targetDate)
//         ->whereNull('closuredate')
//         ->get();

//     foreach ($contracts as $contract) {

//         $alreadySent = DB::table('tblcontractreminderlog')
//             ->where('contractno', $contract->contractno)
//             ->where('remindertype', $remindertype)
//             ->where('senddate', $today->toDateString())
//             ->exists();

//         if ($alreadySent) {
//             continue;
//         }

//         $toEmails = [];

//         $projectEmail = trim($contract->projectownername ?? '');
//         $billingEmail = trim($contract->billingownername ?? '');

//         // Only add if it's a properly formatted email
//         if (!empty($projectEmail) && filter_var($projectEmail, FILTER_VALIDATE_EMAIL)) {
//             $toEmails[] = $projectEmail;
//         }

//         if (!empty($billingEmail) && filter_var($billingEmail, FILTER_VALIDATE_EMAIL) && $billingEmail != $projectEmail) {
//             $toEmails[] = $billingEmail;
//         }

//         if (empty($toEmails)) {
//             continue; // no valid email found, skip this contract
//         }

//         $category = $this->getWorkOrderCategoryCommon($contract->workordertype);

//         if ($category == 'software') {
//             $ccEmail = 'anjali@technowin.co.in';
//         } elseif ($category == 'hardware' || $category == 'manpower') {
//             $ccEmail = 'mahesf4v@gmail.com';
//         } else {
//             $ccEmail = null;
//         }

//         $data = [
//             'contractno'    => $contract->contractno,
//             'customername'  => $contract->customername,
//             'expirydate'    => date("d-m-Y", strtotime($contract->contracttodate)),
//             'daysremaining' => $criticalDays,
//         ];

//         try {
//             Mail::send('emails.contractexpiry', $data, function ($message) use ($toEmails, $ccEmail) {
//                 $message->to($toEmails);
//                 if ($ccEmail) {
//                     $message->cc($ccEmail);
//                 }
//                 $message->subject('Contract Expiry Reminder');
//                 $message->from('technowinitinfra@gmail.com', 'Technowin IT Infra');
//             });

//             DB::table('tblcontractreminderlog')->insert([
//                 'contractno'   => $contract->contractno,
//                 'remindertype' => $remindertype,
//                 'senddate'     => $today->toDateString(),
//                 'created_at'   => Carbon::now(new DateTimeZone('Asia/Kolkata')),
//             ]);

//         } catch (Exception $ex) {
//             $this->ErrorLogging($ex, 'CommonController', 'SendContractExpiryReminders');
//             continue;
//         }
//     }
// }




public function SendContractExpiryReminders()
{
    $today = Carbon::now(new DateTimeZone('Asia/Kolkata'))->startOfDay();
    $alertconfig = DashboardAlertConfigModel::getAll();

    // Define all reminder types and their config keys
    $reminderTypes = [
        'expiry_soon' => $alertconfig['expiring_soon_days'] ?? 30,
        'expiry_urgent' => $alertconfig['urgent_days'] ?? 15,
        'expiry_critical' => $alertconfig['critical_days'] ?? 5,
        'billing_due_soon' => $alertconfig['billing_due_soon_days'] ?? 4,
    ];

    foreach ($reminderTypes as $reminderType => $daysThreshold) {
        $targetDate = $today->copy()->addDays($daysThreshold)->toDateString();

        $contracts = ContractMasterModel::selectRaw('tblcontractmaster.*, tblcustomermaster.customername')
            ->leftJoin('tblcustomermaster', 'tblcustomermaster.customercode', '=', 'tblcontractmaster.customercode')
            ->whereDate('contracttodate', $targetDate)
            ->whereNull('closuredate')
            ->get();

        foreach ($contracts as $contract) {

            $alreadySent = DB::table('tblcontractreminderlog')
                ->where('contractno', $contract->contractno)
                ->where('remindertype', $reminderType)
                ->where('senddate', $today->toDateString())
                ->exists();

            if ($alreadySent) {
                continue;
            }

            $toEmails = [];
            $projectEmail = trim($contract->projectownername ?? '');
            $billingEmail = trim($contract->billingownername ?? '');

            if (!empty($projectEmail) && filter_var($projectEmail, FILTER_VALIDATE_EMAIL)) {
                $toEmails[] = $projectEmail;
            }

            if (!empty($billingEmail) && filter_var($billingEmail, FILTER_VALIDATE_EMAIL) && $billingEmail != $projectEmail) {
                $toEmails[] = $billingEmail;
            }

            if (empty($toEmails)) {
                continue;
            }

            $category = $this->getWorkOrderCategoryCommon($contract->workordertype);
            $ccEmail = ($category == 'software') ? 'anjali@technowin.co.in' : 
                       (($category == 'hardware' || $category == 'manpower') ? 'mahesf4v@gmail.com' : null);

            $data = [
                'contractno' => $contract->contractno,
                'customername' => $contract->customername,
                'expirydate' => date("d-m-Y", strtotime($contract->contracttodate)),
                'daysremaining' => $daysThreshold,
                'remindertype' => $reminderType, // Pass this to blade for conditional messaging
            ];

            try {
                Mail::send('emails.contractexpiry', $data, function ($message) use ($toEmails, $ccEmail) {
                    $message->to($toEmails);
                    // if ($ccEmail) {
                    //     $message->cc($ccEmail);
                    // }
                    $message->subject('Contract Expiry Reminder');
                    $message->from('technowinitinfra@gmail.com', 'Technowin IT Infra');
                });

                DB::table('tblcontractreminderlog')->insert([
                    'contractno' => $contract->contractno,
                    'remindertype' => $reminderType,
                    'senddate' => $today->toDateString(),
                    'created_at' => Carbon::now(new DateTimeZone('Asia/Kolkata')),
                ]);

            } catch (Exception $ex) {
                $this->ErrorLogging($ex, 'CommonController', 'SendContractExpiryReminders');
                continue;
            }
        }
    }
}

}