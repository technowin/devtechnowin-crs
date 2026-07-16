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
}