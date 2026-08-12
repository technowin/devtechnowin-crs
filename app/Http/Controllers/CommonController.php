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
    $softwareTypes = ['Software development', 'Software Maintenance & Suppport'];
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
                'remindertype' => $reminderType,
            ];

            try {
                Mail::send('emails.contractexpiry', $data, function ($message) use ($toEmails, $ccEmail) {
                    $message->to($toEmails);
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

public function SendBillingPaymentReminders()
{
    $today = Carbon::now(new DateTimeZone('Asia/Kolkata'))->startOfDay();
    $alertconfig = DashboardAlertConfigModel::getAll();

    $billingDueSoonDays  = $alertconfig['billing_due_soon_days'] ?? 2;
    $billingOverdueDays  = $alertconfig['billing_overdue_days'] ?? 2;
    $dueDateOverdue1Day  = $alertconfig['due_date_overdue_1day'] ?? 1;
    $dueDateOverdue2Days = $alertconfig['due_date_overdue_2days'] ?? 2;
    $dueDateOverdue5Days = $alertconfig['due_date_overdue_5days'] ?? 5;

    $cycles = DB::table('tblbillingpaymentcycles')
        ->selectRaw('tblbillingpaymentcycles.*, tblcontractmaster.customercode, tblcontractmaster.workordertype, tblcontractmaster.billingownername, tblcustomermaster.customername')
        ->leftJoin('tblcontractmaster', 'tblcontractmaster.contractno', '=', 'tblbillingpaymentcycles.contractno')
        ->leftJoin('tblcustomermaster', 'tblcustomermaster.customercode', '=', 'tblcontractmaster.customercode')
        ->get();

    foreach ($cycles as $cycle) {
        $estDate = $cycle->estimatedbillingdate ? Carbon::parse($cycle->estimatedbillingdate, 'Asia/Kolkata')->startOfDay() : null;
        $billPaymentDate = $cycle->billpaymentdate ? Carbon::parse($cycle->billpaymentdate, 'Asia/Kolkata')->startOfDay() : null;
        $nextReminderDate = $cycle->nextreminderdate ? Carbon::parse($cycle->nextreminderdate, 'Asia/Kolkata')->startOfDay() : null;
        $billingOwner = trim($cycle->billingownername ?? '');

        if (!$estDate || empty($billingOwner) || !filter_var($billingOwner, FILTER_VALIDATE_EMAIL)) {
            continue;
        }

        if ($billPaymentDate) {
            continue;
        }

        // ===== Determine CC based on category, same rule as contract expiry =====
        $category = $this->getWorkOrderCategoryCommon($cycle->workordertype);
        $ccEmail = ($category == 'software') ? 'anjali@technowin.co.in' :
                   (($category == 'hardware' || $category == 'manpower') ? 'mahesf4v@gmail.com' : null);

        $daysFromEstimate = $estDate->diffInDays($today, false);

        // N DAYS BEFORE ESTIMATED DATE
        if ($daysFromEstimate == -$billingDueSoonDays) {
            $this->sendBillingReminder($cycle, $estDate, $today, 'billing_due_soon', 'emails.billingduesoon', [
                'contractno' => $cycle->contractno,
                'customername' => $cycle->customername,
                'paymentcycleno' => $cycle->paymentcycleno,
                'billingduedate' => $estDate->format('d-m-Y'),
                'billamount' => $cycle->billamount,
            ], $billingOwner, 'Billing Due Soon - Payment Required', $ccEmail);
        }

        // ON THE ESTIMATED DATE ITSELF
        if ($daysFromEstimate == 0) {
            $this->sendBillingReminder($cycle, $estDate, $today, 'billing_due_today', 'emails.billingduesoon', [
                'contractno' => $cycle->contractno,
                'customername' => $cycle->customername,
                'paymentcycleno' => $cycle->paymentcycleno,
                'billingduedate' => $estDate->format('d-m-Y'),
                'billamount' => $cycle->billamount,
            ], $billingOwner, 'Billing Due Today - Payment Required', $ccEmail);
        }

        // N DAYS AFTER ESTIMATED DATE (still unpaid)
        if ($daysFromEstimate == $billingOverdueDays) {
            $this->sendBillingReminder($cycle, $estDate, $today, 'billing_overdue_' . $billingOverdueDays . 'days', 'emails.billingoverdue', [
                'contractno' => $cycle->contractno,
                'customername' => $cycle->customername,
                'paymentcycleno' => $cycle->paymentcycleno,
                'estimateddate' => $estDate->format('d-m-Y'),
                'billamount' => $cycle->billamount,
                'daysoverdue' => $daysFromEstimate,
            ], $billingOwner, 'Payment Overdue - Immediate Action Required', $ccEmail);
        }

        // DUE DATE (nextreminderdate) ESCALATIONS
        if ($nextReminderDate) {
            $daysFromDueDate = $nextReminderDate->diffInDays($today, false);

            if ($daysFromDueDate == $dueDateOverdue1Day) {
                $this->sendBillingReminder($cycle, $nextReminderDate, $today, 'due_date_overdue_1day', 'emails.billingoverdue', [
                    'contractno' => $cycle->contractno,
                    'customername' => $cycle->customername,
                    'paymentcycleno' => $cycle->paymentcycleno,
                    'estimateddate' => $nextReminderDate->format('d-m-Y'),
                    'billamount' => $cycle->billamount,
                    'daysoverdue' => $daysFromDueDate,
                ], $billingOwner, 'Due Date Passed - Payment Required', $ccEmail);
            }

            if ($daysFromDueDate == $dueDateOverdue2Days) {
                $this->sendBillingReminder($cycle, $nextReminderDate, $today, 'due_date_overdue_2days', 'emails.billingoverdue', [
                    'contractno' => $cycle->contractno,
                    'customername' => $cycle->customername,
                    'paymentcycleno' => $cycle->paymentcycleno,
                    'estimateddate' => $nextReminderDate->format('d-m-Y'),
                    'billamount' => $cycle->billamount,
                    'daysoverdue' => $daysFromDueDate,
                ], $billingOwner, 'Due Date Passed - Payment Required (2 Days)', $ccEmail);
            }

            if ($daysFromDueDate == $dueDateOverdue5Days) {
                $this->sendBillingReminder($cycle, $nextReminderDate, $today, 'due_date_overdue_5days', 'emails.billingoverdue', [
                    'contractno' => $cycle->contractno,
                    'customername' => $cycle->customername,
                    'paymentcycleno' => $cycle->paymentcycleno,
                    'estimateddate' => $nextReminderDate->format('d-m-Y'),
                    'billamount' => $cycle->billamount,
                    'daysoverdue' => $daysFromDueDate,
                ], $billingOwner, 'URGENT: Due Date Passed by 5 Days', $ccEmail);
            }
        }
    }
}
/**
 * Shared helper to avoid duplicating the "already sent?" + send + log block 6 times.
 */
private function sendBillingReminder($cycle, $refDate, $today, $reminderType, $view, $data, $to, $subject, $cc = null)
{
    $alreadySent = DB::table('tblcontractreminderlog')
        ->where('contractno', $cycle->contractno)
        ->where('remindertype', $reminderType)
        ->where('paymentcycleno', $cycle->paymentcycleno)
        ->where('senddate', $today->toDateString())
        ->exists();

    if ($alreadySent) {
        return;
    }

    try {
        Mail::send($view, $data, function ($message) use ($to, $cc, $subject) {
            $message->to($to);
            if ($cc) {
                $message->cc($cc);
            }
            $message->subject($subject);
            $message->from('technowinitinfra@gmail.com', 'Technowin IT Infra');
        });

        DB::table('tblcontractreminderlog')->insert([
            'contractno' => $cycle->contractno,
            'paymentcycleno' => $cycle->paymentcycleno,
            'remindertype' => $reminderType,
            'senddate' => $today->toDateString(),
            'created_at' => Carbon::now(new DateTimeZone('Asia/Kolkata')),
        ]);
        } catch (Exception $ex) {
        $this->ErrorLogging($ex, 'CommonController', 'SendBillingPaymentReminders/' . $reminderType);
        echo $ex->getFile() . ':' . $ex->getLine() . "\n";
    }
}

}