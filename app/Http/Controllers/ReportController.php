<?php

namespace App\Http\Controllers;

use App\Exports\ComplaintReportExport;
use App\Exports\ContractDetailsExport;
use App\Http\Controllers\Masters\CategoryMasterController;
use App\Http\Controllers\Masters\ProductServiceMasterController;
use App\Models\BranchMasterModel;
use App\Models\CategoryMasterModel;
use App\Models\ComplaintLodgingModel;
use App\Models\EquipmentMasterModel;
use App\Models\ProductServiceMasterModel;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use DateTimeZone;
use Illuminate\Contracts\Session\Session;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use App\Models\AssigneeMasterModel;
use App\Models\ComplaintTypeModel;
use App\Models\ContractMasterModel;
use App\Models\CustomersModel;
use App\Models\TenderViewModel;
use App\Models\TicketAssignedModel;
use App\Models\ExistingUserComplaintLodging;
use App\Models\StatusMasterModel;
use  App\Models\TicketAssignedHistoryModel;
use Yajra\DataTables\Contracts\DataTable;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;


class ReportController extends Controller
{
    #region assignee region
    public function index()
    {
        $complaintstatuslist = StatusMasterModel::whereIn('statuscode',array('CP0004','CP0010','CP0003','CP0002','CP0012','CP0011'))->pluck('statusname','statusname');
        $equipmentsrlist = EquipmentMasterModel::all()->pluck('equipmentsrno','equipmentsrno');
        $assigneesname = AssigneeMasterModel::where('isactive',1)->pluck('assigneename', 'assigneecode');
        $now = Carbon::today(new DateTimeZone('Asia/Kolkata'));
        $idata =  ExistingUserComplaintLodging::selectRaw('tblexistingcustomercomplaintlodging.*,tblproductservicemaster.productservicename,tblcustomermaster.customername,tblcustomermaster.customertype,tblcustomermaster.contactpersonname,tblcustomermaster.contactpersonphone,tblassigneemaster.assigneename,tblassigneemaster.created_at as assigneedate,tblticketassigneedetails.assigneecode')
            ->leftJoin('tblcustomermaster', 'tblcustomermaster.customercode', '=', 'tblexistingcustomercomplaintlodging.customercode')
            ->leftJoin('tblticketassigneedetails', 'tblticketassigneedetails.ticketno', '=', 'tblexistingcustomercomplaintlodging.ticketno')
            ->leftJoin('tblassigneemaster', 'tblassigneemaster.assigneecode', '=', 'tblticketassigneedetails.assigneecode')
            ->leftJoin('tblproductservicemaster', 'tblproductservicemaster.productservicecode', '=', 'tblexistingcustomercomplaintlodging.productservicecode')
            ->where('complaintdate','>=',$now)
            ->get();
//return $idata;
        $CLOSEDcount = 0;
        $RESOLVEDcount = 0;
        $ASSIGNEDcount = 0;
        $ACKNOWLEDGEDcount = 0;

        foreach ($idata as $post)
        {
            if($post->complaintstatus=="CLOSED"){
                $CLOSEDcount++;
            }
            if($post->complaintstatus=="RESOLVED"){
                $RESOLVEDcount++;
            }
            if($post->complaintstatus=="ACKNOWLEDGED"){
                $ACKNOWLEDGEDcount++;
            }
            if($post->complaintstatus=="ASSIGNED"){
                $ASSIGNEDcount++;
            }
        }
        return view('Report.Report',compact('complaintstatuslist','equipmentsrlist','assigneesname','now','idata','CLOSEDcount','RESOLVEDcount','ACKNOWLEDGEDcount','ASSIGNEDcount'));
    }

    public function GetDateWisecomplaintReport()
    {
        $fromdate = $_GET['fromdateid'];
        $todate = $_GET['todateid'];
        $complaintstatus = $_GET['complaintstatusid'];
        $dynamicolumn = "";
        $assigneesname = $_GET['assigneesname'];
        if($complaintstatus == "ACKNOWLEDGED" || $complaintstatus == "")
            $dynamicolumn ='complaintdate';
        elseif($complaintstatus == "RESOLVED")
            $dynamicolumn ='callenddate';
        elseif($complaintstatus == "ASSIGNED")
            $dynamicolumn ='assigneestartdate';
        elseif($complaintstatus == "PENDING")
            $dynamicolumn = 'pendingstatusdate';
        elseif($complaintstatus == "NOT RESOLVED")
            $dynamicolumn = 'unresolvestatusddate';
        elseif($complaintstatus == "CLOSED")
            $dynamicolumn ='callclosuredate';

        if($fromdate !="" && $todate !="" && $complaintstatus=="" ){
            if($fromdate == $todate){
                $start = new Carbon($_GET['todateid']);
                $increfromdatedate=$start->modify('+1 day');
                if($assigneesname !="") {
                    $idata =  ExistingUserComplaintLodging::selectRaw('tblexistingcustomercomplaintlodging.*,tblproductservicemaster.productservicename,tblcustomermaster.customername,tblcustomermaster.customertype,tblcustomermaster.contactpersonname,tblcustomermaster.contactpersonphone,tblassigneemaster.assigneename,tblticketassigneedetails.*')
                        ->leftJoin('tblcustomermaster', 'tblcustomermaster.customercode', '=', 'tblexistingcustomercomplaintlodging.customercode')
                        ->leftJoin('tblticketassigneedetails', 'tblticketassigneedetails.ticketno', '=', 'tblexistingcustomercomplaintlodging.ticketno')
                        ->leftJoin('tblassigneemaster', 'tblassigneemaster.assigneecode', '=', 'tblticketassigneedetails.assigneecode')
                        ->leftJoin('tblproductservicemaster', 'tblproductservicemaster.productservicecode', '=', 'tblexistingcustomercomplaintlodging.productservicecode')
                        ->where($dynamicolumn,'>=',$fromdate)
                        ->where($dynamicolumn,'<=',$increfromdatedate)
                        ->where('tblticketassigneedetails.assigneecode','=',$assigneesname)
                        ->get();
                }
                else {
                    $idata =  ExistingUserComplaintLodging::selectRaw('tblexistingcustomercomplaintlodging.*,tblproductservicemaster.productservicename,tblcustomermaster.customername,tblcustomermaster.customertype,tblcustomermaster.contactpersonname,tblcustomermaster.contactpersonphone,tblassigneemaster.assigneename,tblassigneemaster.created_at as assigneedate,tblticketassigneedetails.assigneecode')
                        ->leftJoin('tblcustomermaster', 'tblcustomermaster.customercode', '=', 'tblexistingcustomercomplaintlodging.customercode')
                        ->leftJoin('tblticketassigneedetails', 'tblticketassigneedetails.ticketno', '=', 'tblexistingcustomercomplaintlodging.ticketno')
                        ->leftJoin('tblassigneemaster', 'tblassigneemaster.assigneecode', '=', 'tblticketassigneedetails.assigneecode')
                        ->leftJoin('tblproductservicemaster', 'tblproductservicemaster.productservicecode', '=', 'tblexistingcustomercomplaintlodging.productservicecode')
                        ->where($dynamicolumn,'>=',$fromdate)
                        ->where($dynamicolumn,'<=',$increfromdatedate)
                        ->get();
                }
            }
            else {
                if($assigneesname !=""){
                    $idata =  ExistingUserComplaintLodging::selectRaw('tblexistingcustomercomplaintlodging.*,tblproductservicemaster.productservicename,tblcustomermaster.customername,tblcustomermaster.customertype,tblcustomermaster.contactpersonname,tblcustomermaster.contactpersonphone,tblassigneemaster.assigneename,tblticketassigneedetails.*')
                        ->leftJoin('tblcustomermaster', 'tblcustomermaster.customercode', '=', 'tblexistingcustomercomplaintlodging.customercode')
                        ->leftJoin('tblticketassigneedetails', 'tblticketassigneedetails.ticketno', '=', 'tblexistingcustomercomplaintlodging.ticketno')
                        ->leftJoin('tblassigneemaster', 'tblassigneemaster.assigneecode', '=', 'tblticketassigneedetails.assigneecode')
                        ->leftJoin('tblproductservicemaster', 'tblproductservicemaster.productservicecode', '=', 'tblexistingcustomercomplaintlodging.productservicecode')
                        ->where($dynamicolumn,'>=',$fromdate)
                        ->where($dynamicolumn,'<=',$todate)
                        ->where('tblticketassigneedetails.assigneecode','=',$assigneesname)
                        ->get();
                }
                else{
                    $start = new Carbon($_GET['todateid']);
                    $increfromdatedate = $start->modify('+1 day');
                    $idata =  ExistingUserComplaintLodging::selectRaw('tblexistingcustomercomplaintlodging.*,tblproductservicemaster.productservicename,tblcustomermaster.customername,tblcustomermaster.customertype,tblcustomermaster.contactpersonname,tblcustomermaster.contactpersonphone,tblassigneemaster.assigneename,tblticketassigneedetails.assigneecode')
                        ->leftJoin('tblcustomermaster', 'tblcustomermaster.customercode', '=', 'tblexistingcustomercomplaintlodging.customercode')
                        ->leftJoin('tblticketassigneedetails', 'tblticketassigneedetails.ticketno', '=', 'tblexistingcustomercomplaintlodging.ticketno')
                        ->leftJoin('tblassigneemaster', 'tblassigneemaster.assigneecode', '=', 'tblticketassigneedetails.assigneecode')
                        ->leftJoin('tblproductservicemaster', 'tblproductservicemaster.productservicecode', '=', 'tblexistingcustomercomplaintlodging.productservicecode')
                        ->where($dynamicolumn,'>=',$fromdate)
                        ->where($dynamicolumn,'<=',$increfromdatedate)
                        ->get();
                }
            }
        }
        elseif ($complaintstatus !="" && $fromdate=="" && $todate==""){
            if($complaintstatus == 'ASSIGNED'){
                $idata =  ExistingUserComplaintLodging::selectRaw('tblexistingcustomercomplaintlodging.*,tblproductservicemaster.productservicename,tblcustomermaster.customername,tblcustomermaster.customertype,tblcustomermaster.contactpersonname,tblcustomermaster.contactpersonphone,tblassigneemaster.assigneename,tblticketassigneedetails.*')
                    ->leftJoin('tblcustomermaster', 'tblcustomermaster.customercode', '=', 'tblexistingcustomercomplaintlodging.customercode')
                    ->leftJoin('tblticketassigneedetails', 'tblticketassigneedetails.ticketno', '=', 'tblexistingcustomercomplaintlodging.ticketno')
                    ->leftJoin('tblassigneemaster', 'tblassigneemaster.assigneecode', '=', 'tblticketassigneedetails.assigneecode')
                    ->leftJoin('tblproductservicemaster', 'tblproductservicemaster.productservicecode', '=', 'tblexistingcustomercomplaintlodging.productservicecode')
                    ->where('complaintstatus','=',$complaintstatus)
                    ->where('assigneestatus','!=','PENDING')
                    ->where('assigneestatus','!=','NOT RESOLVED')
                    ->where('assigneestatus','!=','UnresolvedReassigned')
                    ->get();

            }
            elseif($complaintstatus == 'PENDING')
            {
                $idata =  ExistingUserComplaintLodging::selectRaw('tblexistingcustomercomplaintlodging.*,tblproductservicemaster.productservicename,tblcustomermaster.customername,tblcustomermaster.customertype,tblcustomermaster.contactpersonname,tblcustomermaster.contactpersonphone,tblassigneemaster.assigneename,tblticketassigneedetails.*')
                    ->leftJoin('tblcustomermaster', 'tblcustomermaster.customercode', '=', 'tblexistingcustomercomplaintlodging.customercode')
                    ->leftJoin('tblticketassigneedetails', 'tblticketassigneedetails.ticketno', '=', 'tblexistingcustomercomplaintlodging.ticketno')
                    ->leftJoin('tblassigneemaster', 'tblassigneemaster.assigneecode', '=', 'tblticketassigneedetails.assigneecode')
                    ->leftJoin('tblproductservicemaster', 'tblproductservicemaster.productservicecode', '=', 'tblexistingcustomercomplaintlodging.productservicecode')
                    ->where('complaintstatus','=','ASSIGNED')
                    ->where('assigneestatus','=',$complaintstatus)
                    ->get();
            }
            elseif($complaintstatus == 'ACKNOWLEDGED')
            {
                $idata = ExistingUserComplaintLodging::selectRaw('tblexistingcustomercomplaintlodging.*,tblproductservicemaster.productservicename,tblcustomermaster.customername,tblcustomermaster.customertype,tblcustomermaster.contactpersonname,tblcustomermaster.contactpersonphone')
                    ->leftJoin('tblcustomermaster', 'tblcustomermaster.customercode', '=', 'tblexistingcustomercomplaintlodging.customercode')
//                    ->leftJoin('tblticketassigneedetails', 'tblticketassigneedetails.ticketno', '=', 'tblexistingcustomercomplaintlodging.ticketno')
//                    ->leftJoin('tblassigneemaster', 'tblassigneemaster.assigneecode', '=', 'tblticketassigneedetails.assigneecode')
                    ->leftJoin('tblproductservicemaster', 'tblproductservicemaster.productservicecode', '=', 'tblexistingcustomercomplaintlodging.productservicecode')
                    ->where('complaintstatus', '=', $complaintstatus)
                    ->get();
            }
            elseif($complaintstatus == 'CLOSED'){
                $idata = ExistingUserComplaintLodging::selectRaw('tblexistingcustomercomplaintlodging.*,tblproductservicemaster.productservicename,tblcustomermaster.customername,tblcustomermaster.customertype,tblcustomermaster.contactpersonname,tblcustomermaster.contactpersonphone,tblassigneemaster.assigneename,tblticketassigneedetails.assigneecode')
                    ->leftJoin('tblcustomermaster', 'tblcustomermaster.customercode', '=', 'tblexistingcustomercomplaintlodging.customercode')
                    ->leftJoin('tblticketassigneedetails', 'tblticketassigneedetails.ticketno', '=', 'tblexistingcustomercomplaintlodging.ticketno')
                    ->leftJoin('tblassigneemaster', 'tblassigneemaster.assigneecode', '=', 'tblticketassigneedetails.assigneecode')
                    ->leftJoin('tblproductservicemaster', 'tblproductservicemaster.productservicecode', '=', 'tblexistingcustomercomplaintlodging.productservicecode')
                    ->where('complaintstatus', '=', $complaintstatus)
//                    ->orWhere('complaintstatus','=','ClosedByAdmin')
                    ->get();
            }
            elseif($complaintstatus == 'RESOLVED'){
                $idata = ExistingUserComplaintLodging::selectRaw('tblexistingcustomercomplaintlodging.*,tblproductservicemaster.productservicename,tblcustomermaster.customername,tblcustomermaster.customertype,tblcustomermaster.contactpersonname,tblcustomermaster.contactpersonphone,tblassigneemaster.assigneename,tblticketassigneedetails.*')
                    ->leftJoin('tblcustomermaster', 'tblcustomermaster.customercode', '=', 'tblexistingcustomercomplaintlodging.customercode')
                    ->leftJoin('tblticketassigneedetails', 'tblticketassigneedetails.ticketno', '=', 'tblexistingcustomercomplaintlodging.ticketno')
                    ->leftJoin('tblassigneemaster', 'tblassigneemaster.assigneecode', '=', 'tblticketassigneedetails.assigneecode')
                    ->leftJoin('tblproductservicemaster', 'tblproductservicemaster.productservicecode', '=', 'tblexistingcustomercomplaintlodging.productservicecode')
                    ->where('complaintstatus', '=', $complaintstatus)
                    ->get();
            }
            else{
            $idata =  ExistingUserComplaintLodging::selectRaw('tblexistingcustomercomplaintlodging.*,tblproductservicemaster.productservicename,tblcustomermaster.customername,tblcustomermaster.customertype,tblcustomermaster.contactpersonname,tblcustomermaster.contactpersonphone,tblassigneemaster.assigneename,tblticketassigneedetails.*')
                ->leftJoin('tblcustomermaster', 'tblcustomermaster.customercode', '=', 'tblexistingcustomercomplaintlodging.customercode')
                ->leftJoin('tblticketassigneedetails', 'tblticketassigneedetails.ticketno', '=', 'tblexistingcustomercomplaintlodging.ticketno')
                ->leftJoin('tblassigneemaster', 'tblassigneemaster.assigneecode', '=', 'tblticketassigneedetails.assigneecode')
                ->leftJoin('tblproductservicemaster', 'tblproductservicemaster.productservicecode', '=', 'tblexistingcustomercomplaintlodging.productservicecode')
                ->where('assigneestatus','=',$complaintstatus)
                ->get();
            }
        }
        elseif ($assigneesname !="" && $complaintstatus =="" && $fromdate=="" && $todate=="") {
            $idata =  ExistingUserComplaintLodging::selectRaw('tblexistingcustomercomplaintlodging.*,tblproductservicemaster.productservicename,tblcustomermaster.customername,tblcustomermaster.customertype,tblcustomermaster.contactpersonname,tblcustomermaster.contactpersonphone,tblassigneemaster.assigneename,tblticketassigneedetails.*')
                ->leftJoin('tblcustomermaster', 'tblcustomermaster.customercode', '=', 'tblexistingcustomercomplaintlodging.customercode')
                ->leftJoin('tblticketassigneedetails', 'tblticketassigneedetails.ticketno', '=', 'tblexistingcustomercomplaintlodging.ticketno')
                ->leftJoin('tblassigneemaster', 'tblassigneemaster.assigneecode', '=', 'tblticketassigneedetails.assigneecode')
                ->leftJoin('tblproductservicemaster', 'tblproductservicemaster.productservicecode', '=', 'tblexistingcustomercomplaintlodging.productservicecode')
                ->where('tblticketassigneedetails.assigneecode','=',$assigneesname)
                ->get();
        }
        elseif ($fromdate !="" && $todate !="" && $complaintstatus !="" && $assigneesname =="") {
            if($complaintstatus == 'ASSIGNED'){
                $start = new Carbon($_GET['todateid']);
                $increfromdatedate=$start->modify('+1 day');
                $idata =  ExistingUserComplaintLodging::selectRaw('tblexistingcustomercomplaintlodging.*,tblproductservicemaster.productservicename,tblcustomermaster.customername,tblcustomermaster.customertype,tblcustomermaster.contactpersonname,tblcustomermaster.contactpersonphone,tblassigneemaster.assigneename,tblticketassigneedetails.*')
                    ->leftJoin('tblcustomermaster', 'tblcustomermaster.customercode', '=', 'tblexistingcustomercomplaintlodging.customercode')
                    ->leftJoin('tblticketassigneedetails', 'tblticketassigneedetails.ticketno', '=', 'tblexistingcustomercomplaintlodging.ticketno')
                    ->leftJoin('tblassigneemaster', 'tblassigneemaster.assigneecode', '=', 'tblticketassigneedetails.assigneecode')
                    ->leftJoin('tblproductservicemaster', 'tblproductservicemaster.productservicecode', '=', 'tblexistingcustomercomplaintlodging.productservicecode')
                    ->where($dynamicolumn,'>=',$fromdate)
                    ->where($dynamicolumn,'<=',$increfromdatedate)
                    ->where('complaintstatus','=',$complaintstatus)
                    ->where('assigneestatus','!=','PENDING')
                    ->where('assigneestatus','!=','NOT RESOLVED')
                    ->where('assigneestatus','!=','UnresolvedReassigned')
                    ->get();
            }
            elseif($complaintstatus == 'PENDING'){
                $start = new Carbon($_GET['todateid']);
                $increfromdatedate=$start->modify('+1 day');
                $idata =  ExistingUserComplaintLodging::selectRaw('tblexistingcustomercomplaintlodging.*,tblproductservicemaster.productservicename,tblcustomermaster.customername,tblcustomermaster.customertype,tblcustomermaster.contactpersonname,tblcustomermaster.contactpersonphone,tblassigneemaster.assigneename,tblticketassigneedetails.*')
                    ->leftJoin('tblcustomermaster', 'tblcustomermaster.customercode', '=', 'tblexistingcustomercomplaintlodging.customercode')
                    ->leftJoin('tblticketassigneedetails', 'tblticketassigneedetails.ticketno', '=', 'tblexistingcustomercomplaintlodging.ticketno')
                    ->leftJoin('tblassigneemaster', 'tblassigneemaster.assigneecode', '=', 'tblticketassigneedetails.assigneecode')
                    ->leftJoin('tblproductservicemaster', 'tblproductservicemaster.productservicecode', '=', 'tblexistingcustomercomplaintlodging.productservicecode')
                    ->where($dynamicolumn,'>=',$fromdate)
                    ->where($dynamicolumn,'<=',$increfromdatedate)
                    ->where('complaintstatus','=','ASSIGNED')
                    ->where('assigneestatus','=',$complaintstatus)
                    ->get();
            }
            elseif($complaintstatus == 'ACKNOWLEDGED') {
                $start = new Carbon($_GET['todateid']);
                $increfromdatedate = $start->modify('+1 day');
                $idata = ExistingUserComplaintLodging::selectRaw('tblexistingcustomercomplaintlodging.*,tblproductservicemaster.productservicename,tblcustomermaster.customername,tblcustomermaster.customertype,tblcustomermaster.contactpersonname,tblcustomermaster.contactpersonphone')
                    ->leftJoin('tblcustomermaster', 'tblcustomermaster.customercode', '=', 'tblexistingcustomercomplaintlodging.customercode')
//                    ->leftJoin('tblticketassigneedetails', 'tblticketassigneedetails.ticketno', '=', 'tblexistingcustomercomplaintlodging.ticketno')
//                    ->leftJoin('tblassigneemaster', 'tblassigneemaster.assigneecode', '=', 'tblticketassigneedetails.assigneecode')
                    ->leftJoin('tblproductservicemaster', 'tblproductservicemaster.productservicecode', '=', 'tblexistingcustomercomplaintlodging.productservicecode')
                    ->where($dynamicolumn, '>=', $fromdate)
                    ->where($dynamicolumn, '<=', $increfromdatedate)
                    ->where('complaintstatus', '=', $complaintstatus)
                    ->get();
            }
            elseif($complaintstatus == 'CLOSED'){
                $start = new Carbon($_GET['todateid']);
                $increfromdatedate = $start->modify('+1 day');
                $idata = ExistingUserComplaintLodging::selectRaw('tblexistingcustomercomplaintlodging.*,tblproductservicemaster.productservicename,tblcustomermaster.customername,tblcustomermaster.customertype,tblcustomermaster.contactpersonname,tblcustomermaster.contactpersonphone,tblassigneemaster.assigneename,tblticketassigneedetails.assigneecode')
                    ->leftJoin('tblcustomermaster', 'tblcustomermaster.customercode', '=', 'tblexistingcustomercomplaintlodging.customercode')
                    ->leftJoin('tblticketassigneedetails', 'tblticketassigneedetails.ticketno', '=', 'tblexistingcustomercomplaintlodging.ticketno')
                    ->leftJoin('tblassigneemaster', 'tblassigneemaster.assigneecode', '=', 'tblticketassigneedetails.assigneecode')
                    ->leftJoin('tblproductservicemaster', 'tblproductservicemaster.productservicecode', '=', 'tblexistingcustomercomplaintlodging.productservicecode')
                    ->where($dynamicolumn, '>=', $fromdate)
                    ->where($dynamicolumn, '<=', $increfromdatedate)
                    ->where('complaintstatus', '=', $complaintstatus)
//                    ->orWhere('complaintstatus','=','ClosedByAdmin')
                    ->get();
            }
            elseif($complaintstatus == 'RESOLVED'){
                $start = new Carbon($_GET['todateid']);
                $increfromdatedate = $start->modify('+1 day');
                $idata = ExistingUserComplaintLodging::selectRaw('tblexistingcustomercomplaintlodging.*,tblproductservicemaster.productservicename,tblcustomermaster.customername,tblcustomermaster.customertype,tblcustomermaster.contactpersonname,tblcustomermaster.contactpersonphone,tblassigneemaster.assigneename,tblticketassigneedetails.*')
                    ->leftJoin('tblcustomermaster', 'tblcustomermaster.customercode', '=', 'tblexistingcustomercomplaintlodging.customercode')
                    ->leftJoin('tblticketassigneedetails', 'tblticketassigneedetails.ticketno', '=', 'tblexistingcustomercomplaintlodging.ticketno')
                    ->leftJoin('tblassigneemaster', 'tblassigneemaster.assigneecode', '=', 'tblticketassigneedetails.assigneecode')
                    ->leftJoin('tblproductservicemaster', 'tblproductservicemaster.productservicecode', '=', 'tblexistingcustomercomplaintlodging.productservicecode')
                    ->where($dynamicolumn, '>=', $fromdate)
                    ->where($dynamicolumn, '<=', $increfromdatedate)
                    ->where('complaintstatus', '=', $complaintstatus)
                    ->get();
            }
            else{
            $start = new Carbon($_GET['todateid']);
            $increfromdatedate=$start->modify('+1 day');
            $idata =  ExistingUserComplaintLodging::selectRaw('tblexistingcustomercomplaintlodging.*,tblproductservicemaster.productservicename,tblcustomermaster.customername,tblcustomermaster.customertype,tblcustomermaster.contactpersonname,tblcustomermaster.contactpersonphone,tblassigneemaster.assigneename,tblticketassigneedetails.*')
                ->leftJoin('tblcustomermaster', 'tblcustomermaster.customercode', '=', 'tblexistingcustomercomplaintlodging.customercode')
                ->leftJoin('tblticketassigneedetails', 'tblticketassigneedetails.ticketno', '=', 'tblexistingcustomercomplaintlodging.ticketno')
                ->leftJoin('tblassigneemaster', 'tblassigneemaster.assigneecode', '=', 'tblticketassigneedetails.assigneecode')
                ->leftJoin('tblproductservicemaster', 'tblproductservicemaster.productservicecode', '=', 'tblexistingcustomercomplaintlodging.productservicecode')
                ->where($dynamicolumn,'>=',$fromdate)
                ->where($dynamicolumn,'<=',$increfromdatedate)
                ->where('assigneestatus','=',$complaintstatus)
                ->get();
            }
        }
        else{
            if($fromdate == $todate){
                if($complaintstatus == 'ASSIGNED'){
                    $start = new Carbon($_GET['todateid']);
                    $increfromdatedate=$start->modify('+1 day');
                    $idata =  ExistingUserComplaintLodging::selectRaw('tblexistingcustomercomplaintlodging.*,tblproductservicemaster.productservicename,tblcustomermaster.customername,tblcustomermaster.customertype,tblcustomermaster.contactpersonname,tblcustomermaster.contactpersonphone,tblassigneemaster.assigneename,tblticketassigneedetails.*')
                        ->leftJoin('tblcustomermaster', 'tblcustomermaster.customercode', '=', 'tblexistingcustomercomplaintlodging.customercode')
                        ->leftJoin('tblticketassigneedetails', 'tblticketassigneedetails.ticketno', '=', 'tblexistingcustomercomplaintlodging.ticketno')
                        ->leftJoin('tblassigneemaster', 'tblassigneemaster.assigneecode', '=', 'tblticketassigneedetails.assigneecode')
                        ->leftJoin('tblproductservicemaster', 'tblproductservicemaster.productservicecode', '=', 'tblexistingcustomercomplaintlodging.productservicecode')
                        ->where($dynamicolumn,'>=',$fromdate)
                        ->where($dynamicolumn,'<=',$increfromdatedate)
                        ->where('complaintstatus','=',$complaintstatus)
                        ->where('assigneestatus','!=','PENDING')
                        ->where('assigneestatus','!=','NOT RESOLVED')
                        ->where('assigneestatus','!=','UnresolvedReassigned')
                        ->where('tblticketassigneedetails.assigneecode','=',$assigneesname)
                        ->get();
                }
                elseif ($complaintstatus == 'PENDING'){
                    $start = new Carbon($_GET['todateid']);
                    $increfromdatedate=$start->modify('+1 day');
                    $idata =  ExistingUserComplaintLodging::selectRaw('tblexistingcustomercomplaintlodging.*,tblproductservicemaster.productservicename,tblcustomermaster.customername,tblcustomermaster.customertype,tblcustomermaster.contactpersonname,tblcustomermaster.contactpersonphone,tblassigneemaster.assigneename,tblticketassigneedetails.*')
                        ->leftJoin('tblcustomermaster', 'tblcustomermaster.customercode', '=', 'tblexistingcustomercomplaintlodging.customercode')
                        ->leftJoin('tblticketassigneedetails', 'tblticketassigneedetails.ticketno', '=', 'tblexistingcustomercomplaintlodging.ticketno')
                        ->leftJoin('tblassigneemaster', 'tblassigneemaster.assigneecode', '=', 'tblticketassigneedetails.assigneecode')
                        ->leftJoin('tblproductservicemaster', 'tblproductservicemaster.productservicecode', '=', 'tblexistingcustomercomplaintlodging.productservicecode')
                        ->where($dynamicolumn,'>=',$fromdate)
                        ->where($dynamicolumn,'<=',$increfromdatedate)
                        ->where('complaintstatus','=','ASSIGNED')
                        ->where('assigneestatus','=',$complaintstatus)
                        ->where('tblticketassigneedetails.assigneecode','=',$assigneesname)
                        ->get();
                }
                elseif ($complaintstatus == 'ACKNOWLEDGED'){
                    $start = new Carbon($_GET['todateid']);
                    $increfromdatedate=$start->modify('+1 day');
                    $idata =  ExistingUserComplaintLodging::selectRaw('tblexistingcustomercomplaintlodging.*,tblproductservicemaster.productservicename,tblcustomermaster.customername,tblcustomermaster.customertype,tblcustomermaster.contactpersonname,tblcustomermaster.contactpersonphone')
                        ->leftJoin('tblcustomermaster', 'tblcustomermaster.customercode', '=', 'tblexistingcustomercomplaintlodging.customercode')
//                        ->leftJoin('tblticketassigneedetails', 'tblticketassigneedetails.ticketno', '=', 'tblexistingcustomercomplaintlodging.ticketno')
//                        ->leftJoin('tblassigneemaster', 'tblassigneemaster.assigneecode', '=', 'tblticketassigneedetails.assigneecode')
                        ->leftJoin('tblproductservicemaster', 'tblproductservicemaster.productservicecode', '=', 'tblexistingcustomercomplaintlodging.productservicecode')
                        ->where($dynamicolumn,'>=',$fromdate)
                        ->where($dynamicolumn,'<=',$increfromdatedate)
                        ->where('complaintstatus','=',$complaintstatus)
//                        ->where('tblticketassigneedetails.assigneecode','=',$assigneesname)
                        ->get();
                }
                elseif ($complaintstatus == 'CLOSED'){
                    $start = new Carbon($_GET['todateid']);
                    $increfromdatedate=$start->modify('+1 day');
                    $idata =  ExistingUserComplaintLodging::selectRaw('tblexistingcustomercomplaintlodging.*,tblproductservicemaster.productservicename,tblcustomermaster.customername,tblcustomermaster.customertype,tblcustomermaster.contactpersonname,tblcustomermaster.contactpersonphone,tblassigneemaster.assigneename,tblticketassigneedetails.assigneecode')
                        ->leftJoin('tblcustomermaster', 'tblcustomermaster.customercode', '=', 'tblexistingcustomercomplaintlodging.customercode')
                        ->leftJoin('tblticketassigneedetails', 'tblticketassigneedetails.ticketno', '=', 'tblexistingcustomercomplaintlodging.ticketno')
                        ->leftJoin('tblassigneemaster', 'tblassigneemaster.assigneecode', '=', 'tblticketassigneedetails.assigneecode')
                        ->leftJoin('tblproductservicemaster', 'tblproductservicemaster.productservicecode', '=', 'tblexistingcustomercomplaintlodging.productservicecode')
                        ->where($dynamicolumn,'>=',$fromdate)
                        ->where($dynamicolumn,'<=',$increfromdatedate)
                        ->where('complaintstatus','=',$complaintstatus)
//                        ->orWhere('assigneestatus','=','ClosedByAdmin')
                        ->where('tblticketassigneedetails.assigneecode','=',$assigneesname)
                        ->get();
                }
                elseif ($complaintstatus == 'RESOLVED'){
                    $start = new Carbon($_GET['todateid']);
                    $increfromdatedate=$start->modify('+1 day');
                    $idata =  ExistingUserComplaintLodging::selectRaw('tblexistingcustomercomplaintlodging.*,tblproductservicemaster.productservicename,tblcustomermaster.customername,tblcustomermaster.customertype,tblcustomermaster.contactpersonname,tblcustomermaster.contactpersonphone,tblassigneemaster.assigneename,tblticketassigneedetails.*')
                        ->leftJoin('tblcustomermaster', 'tblcustomermaster.customercode', '=', 'tblexistingcustomercomplaintlodging.customercode')
                        ->leftJoin('tblticketassigneedetails', 'tblticketassigneedetails.ticketno', '=', 'tblexistingcustomercomplaintlodging.ticketno')
                        ->leftJoin('tblassigneemaster', 'tblassigneemaster.assigneecode', '=', 'tblticketassigneedetails.assigneecode')
                        ->leftJoin('tblproductservicemaster', 'tblproductservicemaster.productservicecode', '=', 'tblexistingcustomercomplaintlodging.productservicecode')
                        ->where($dynamicolumn,'>=',$fromdate)
                        ->where($dynamicolumn,'<=',$increfromdatedate)
                        ->where('complaintstatus','=',$complaintstatus)
                        ->where('tblticketassigneedetails.assigneecode','=',$assigneesname)
                        ->get();
                }
                else {
                    $start = new Carbon($_GET['todateid']);
                    $increfromdatedate = $start->modify('+1 day');
                    $idata = ExistingUserComplaintLodging::selectRaw('tblexistingcustomercomplaintlodging.*,tblproductservicemaster.productservicename,tblcustomermaster.customername,tblcustomermaster.customertype,tblcustomermaster.contactpersonname,tblcustomermaster.contactpersonphone,tblassigneemaster.assigneename,tblticketassigneedetails.*')
                        ->leftJoin('tblcustomermaster', 'tblcustomermaster.customercode', '=', 'tblexistingcustomercomplaintlodging.customercode')
                        ->leftJoin('tblticketassigneedetails', 'tblticketassigneedetails.ticketno', '=', 'tblexistingcustomercomplaintlodging.ticketno')
                        ->leftJoin('tblassigneemaster', 'tblassigneemaster.assigneecode', '=', 'tblticketassigneedetails.assigneecode')
                        ->leftJoin('tblproductservicemaster', 'tblproductservicemaster.productservicecode', '=', 'tblexistingcustomercomplaintlodging.productservicecode')
                        ->where($dynamicolumn, '>=', $fromdate)
                        ->where($dynamicolumn, '<=', $increfromdatedate)
                        ->where('assigneestatus', '=', $complaintstatus)
                        ->where('tblticketassigneedetails.assigneecode', '=', $assigneesname)
                        ->get();
                }
            }
            else {

                if($complaintstatus == 'ASSIGNED'){
                    $start = new Carbon($_GET['todateid']);
                    $increfromdatedate=$start->modify('+1 day');
                    $idata =  ExistingUserComplaintLodging::selectRaw('tblexistingcustomercomplaintlodging.*,tblproductservicemaster.productservicename,tblcustomermaster.customername,tblcustomermaster.customertype,tblcustomermaster.contactpersonname,tblcustomermaster.contactpersonphone,tblassigneemaster.assigneename,tblticketassigneedetails.*')
                        ->leftJoin('tblcustomermaster', 'tblcustomermaster.customercode', '=', 'tblexistingcustomercomplaintlodging.customercode')
                        ->leftJoin('tblticketassigneedetails', 'tblticketassigneedetails.ticketno', '=', 'tblexistingcustomercomplaintlodging.ticketno')
                        ->leftJoin('tblassigneemaster', 'tblassigneemaster.assigneecode', '=', 'tblticketassigneedetails.assigneecode')
                        ->leftJoin('tblproductservicemaster', 'tblproductservicemaster.productservicecode', '=', 'tblexistingcustomercomplaintlodging.productservicecode')
                        ->where($dynamicolumn,'>=',$fromdate)
                        ->where($dynamicolumn,'<=',$increfromdatedate)
                        ->where('complaintstatus','=',$complaintstatus)
                        ->where('assigneestatus','!=','PENDING')
                        ->where('assigneestatus','!=','NOT RESOLVED')
                        ->where('assigneestatus','!=','UnresolvedReassigned')
                        ->where('tblticketassigneedetails.assigneecode','=',$assigneesname)
                        ->get();
                }
                elseif ($complaintstatus == 'PENDING'){
                    $start = new Carbon($_GET['todateid']);
                    $increfromdatedate=$start->modify('+1 day');
                    $idata =  ExistingUserComplaintLodging::selectRaw('tblexistingcustomercomplaintlodging.*,tblproductservicemaster.productservicename,tblcustomermaster.customername,tblcustomermaster.customertype,tblcustomermaster.contactpersonname,tblcustomermaster.contactpersonphone,tblassigneemaster.assigneename,tblticketassigneedetails.*')
                        ->leftJoin('tblcustomermaster', 'tblcustomermaster.customercode', '=', 'tblexistingcustomercomplaintlodging.customercode')
                        ->leftJoin('tblticketassigneedetails', 'tblticketassigneedetails.ticketno', '=', 'tblexistingcustomercomplaintlodging.ticketno')
                        ->leftJoin('tblassigneemaster', 'tblassigneemaster.assigneecode', '=', 'tblticketassigneedetails.assigneecode')
                        ->leftJoin('tblproductservicemaster', 'tblproductservicemaster.productservicecode', '=', 'tblexistingcustomercomplaintlodging.productservicecode')
                        ->where($dynamicolumn,'>=',$fromdate)
                        ->where($dynamicolumn,'<=',$increfromdatedate)
                        ->where('complaintstatus','=','ASSIGNED')
                        ->where('assigneestatus','=',$complaintstatus)
                        ->where('tblticketassigneedetails.assigneecode','=',$assigneesname)
                        ->get();
                }
                elseif ($complaintstatus == 'ACKNOWLEDGED'){
                    $start = new Carbon($_GET['todateid']);
                    $increfromdatedate=$start->modify('+1 day');
                    $idata =  ExistingUserComplaintLodging::selectRaw('tblexistingcustomercomplaintlodging.*,tblproductservicemaster.productservicename,tblcustomermaster.customername,tblcustomermaster.customertype,tblcustomermaster.contactpersonname,tblcustomermaster.contactpersonphone')
                        ->leftJoin('tblcustomermaster', 'tblcustomermaster.customercode', '=', 'tblexistingcustomercomplaintlodging.customercode')
//                        ->leftJoin('tblticketassigneedetails', 'tblticketassigneedetails.ticketno', '=', 'tblexistingcustomercomplaintlodging.ticketno')
//                        ->leftJoin('tblassigneemaster', 'tblassigneemaster.assigneecode', '=', 'tblticketassigneedetails.assigneecode')
                        ->leftJoin('tblproductservicemaster', 'tblproductservicemaster.productservicecode', '=', 'tblexistingcustomercomplaintlodging.productservicecode')
                        ->where($dynamicolumn,'>=',$fromdate)
                        ->where($dynamicolumn,'<=',$increfromdatedate)
                        ->where('complaintstatus','=',$complaintstatus)
//                        ->where('tblticketassigneedetails.assigneecode','=',$assigneesname)
                        ->get();
                }
                elseif ($complaintstatus == 'CLOSED'){
                    $start = new Carbon($_GET['todateid']);
                    $increfromdatedate=$start->modify('+1 day');
                    $idata =  ExistingUserComplaintLodging::selectRaw('tblexistingcustomercomplaintlodging.*,tblproductservicemaster.productservicename,tblcustomermaster.customername,tblcustomermaster.customertype,tblcustomermaster.contactpersonname,tblcustomermaster.contactpersonphone,tblassigneemaster.assigneename,tblticketassigneedetails.assigneecode')
                        ->leftJoin('tblcustomermaster', 'tblcustomermaster.customercode', '=', 'tblexistingcustomercomplaintlodging.customercode')
                        ->leftJoin('tblticketassigneedetails', 'tblticketassigneedetails.ticketno', '=', 'tblexistingcustomercomplaintlodging.ticketno')
                        ->leftJoin('tblassigneemaster', 'tblassigneemaster.assigneecode', '=', 'tblticketassigneedetails.assigneecode')
                        ->leftJoin('tblproductservicemaster', 'tblproductservicemaster.productservicecode', '=', 'tblexistingcustomercomplaintlodging.productservicecode')
                        ->where($dynamicolumn,'>=',$fromdate)
                        ->where($dynamicolumn,'<=',$increfromdatedate)
                        ->where('complaintstatus','=',$complaintstatus)
//                        ->orWhere('assigneestatus','=','ClosedByAdmin')
                        ->where('tblticketassigneedetails.assigneecode','=',$assigneesname)
                        ->get();
                }
                elseif ($complaintstatus == 'RESOLVED'){
                    $start = new Carbon($_GET['todateid']);
                    $increfromdatedate=$start->modify('+1 day');
                    $idata =  ExistingUserComplaintLodging::selectRaw('tblexistingcustomercomplaintlodging.*,tblproductservicemaster.productservicename,tblcustomermaster.customername,tblcustomermaster.customertype,tblcustomermaster.contactpersonname,tblcustomermaster.contactpersonphone,tblassigneemaster.assigneename,tblticketassigneedetails.*')
                        ->leftJoin('tblcustomermaster', 'tblcustomermaster.customercode', '=', 'tblexistingcustomercomplaintlodging.customercode')
                        ->leftJoin('tblticketassigneedetails', 'tblticketassigneedetails.ticketno', '=', 'tblexistingcustomercomplaintlodging.ticketno')
                        ->leftJoin('tblassigneemaster', 'tblassigneemaster.assigneecode', '=', 'tblticketassigneedetails.assigneecode')
                        ->leftJoin('tblproductservicemaster', 'tblproductservicemaster.productservicecode', '=', 'tblexistingcustomercomplaintlodging.productservicecode')
                        ->where($dynamicolumn,'>=',$fromdate)
                        ->where($dynamicolumn,'<=',$increfromdatedate)
                        ->where('complaintstatus','=',$complaintstatus)
                        ->where('tblticketassigneedetails.assigneecode','=',$assigneesname)
                        ->get();
                }
                else {
                    $start = new Carbon($_GET['todateid']);
                    $increfromdatedate = $start->modify('+1 day');
                    $idata = ExistingUserComplaintLodging::selectRaw('tblexistingcustomercomplaintlodging.*,tblproductservicemaster.productservicename,tblcustomermaster.customername,tblcustomermaster.customertype,tblcustomermaster.contactpersonname,tblcustomermaster.contactpersonphone,tblassigneemaster.assigneename,tblticketassigneedetails.*')
                        ->leftJoin('tblcustomermaster', 'tblcustomermaster.customercode', '=', 'tblexistingcustomercomplaintlodging.customercode')
                        ->leftJoin('tblticketassigneedetails', 'tblticketassigneedetails.ticketno', '=', 'tblexistingcustomercomplaintlodging.ticketno')
                        ->leftJoin('tblassigneemaster', 'tblassigneemaster.assigneecode', '=', 'tblticketassigneedetails.assigneecode')
                        ->leftJoin('tblproductservicemaster', 'tblproductservicemaster.productservicecode', '=', 'tblexistingcustomercomplaintlodging.productservicecode')
                        ->where($dynamicolumn, '>=', $fromdate)
                        ->where($dynamicolumn, '<=', $increfromdatedate)
                        ->where('assigneestatus', '=', $complaintstatus)
                        ->where('tblticketassigneedetails.assigneecode', '=', $assigneesname)
                        ->get();
                }
            }
        }

        $CLOSEDcount = 0;
        $RESOLVEDcount = 0;
        $ASSIGNEDcount = 0;
        $ACKNOWLEDGEDcount = 0;

        foreach ($idata as $post)
        {
            if($post->complaintstatus=="CLOSED"){
                $CLOSEDcount++;
            }
            if($post->complaintstatus=="RESOLVED"){
                $RESOLVEDcount++;
            }
            if($post->complaintstatus=="ACKNOWLEDGED"){
                $ACKNOWLEDGEDcount++;
            }
            if($post->complaintstatus=="ASSIGNED"){
                $ASSIGNEDcount++;
            }
        }

        return json_encode(array('idata'=>$idata,'CLOSEDcount'=>$CLOSEDcount,'RESOLVEDcount'=>$RESOLVEDcount,'ACKNOWLEDGEDcount'=>$ACKNOWLEDGEDcount,'ASSIGNEDcount'=>$ASSIGNEDcount));
    }

    public function htmltopdfreport($data){
        $data = explode(",", $data);
        $fromdate = $data[0];
        $todate =  $data[1];
        $complaintstatus =  $data[2];
        $assigneesname = $data[3];
        $dynamicolumn = "";
        if($complaintstatus == "ACKNOWLEDGED" || $complaintstatus == "")
            $dynamicolumn ='complaintdate';
        elseif($complaintstatus == "RESOLVED")
            $dynamicolumn ='callenddate';
        elseif($complaintstatus == "ASSIGNED")
            $dynamicolumn ='assigneestartdate';
        elseif($complaintstatus == "PENDING")
            $dynamicolumn = 'pendingstatusdate';
        elseif($complaintstatus == "NOT RESOLVED")
            $dynamicolumn = 'unresolvestatusddate';
        elseif($complaintstatus == "CLOSED")
            $dynamicolumn ='callclosuredate';

        if($fromdate !="" && $todate !="" && $complaintstatus=="" ){
            if($fromdate == $todate){
                $start =  new Carbon($todate);
                $increfromdatedate=$start->modify('+1 day');

                if($assigneesname !="") {
                    $idata =  ExistingUserComplaintLodging::selectRaw('tblexistingcustomercomplaintlodging.*,tblproductservicemaster.productservicename,tblcustomermaster.customername,tblcustomermaster.customertype,tblcustomermaster.contactpersonname,tblcustomermaster.contactpersonphone,tblassigneemaster.assigneename,tblticketassigneedetails.*')
                        ->leftJoin('tblcustomermaster', 'tblcustomermaster.customercode', '=', 'tblexistingcustomercomplaintlodging.customercode')
                        ->leftJoin('tblticketassigneedetails', 'tblticketassigneedetails.ticketno', '=', 'tblexistingcustomercomplaintlodging.ticketno')
                        ->leftJoin('tblassigneemaster', 'tblassigneemaster.assigneecode', '=', 'tblticketassigneedetails.assigneecode')
                        ->leftJoin('tblproductservicemaster', 'tblproductservicemaster.productservicecode', '=', 'tblexistingcustomercomplaintlodging.productservicecode')
                        ->where($dynamicolumn,'>=',$fromdate)
                        ->where($dynamicolumn,'<=',$increfromdatedate)
                        ->where('tblticketassigneedetails.assigneecode','=',$assigneesname)
                        ->get();
                }
                else {
                    $idata =  ExistingUserComplaintLodging::selectRaw('tblexistingcustomercomplaintlodging.*,tblproductservicemaster.productservicename,tblcustomermaster.customername,tblcustomermaster.customertype,tblcustomermaster.contactpersonname,tblcustomermaster.contactpersonphone,tblassigneemaster.assigneename,tblassigneemaster.created_at as assigneedate,tblticketassigneedetails.*')
                        ->leftJoin('tblcustomermaster', 'tblcustomermaster.customercode', '=', 'tblexistingcustomercomplaintlodging.customercode')
                        ->leftJoin('tblticketassigneedetails', 'tblticketassigneedetails.ticketno', '=', 'tblexistingcustomercomplaintlodging.ticketno')
                        ->leftJoin('tblassigneemaster', 'tblassigneemaster.assigneecode', '=', 'tblticketassigneedetails.assigneecode')
                        ->leftJoin('tblproductservicemaster', 'tblproductservicemaster.productservicecode', '=', 'tblexistingcustomercomplaintlodging.productservicecode')
                        ->where($dynamicolumn,'>=',$fromdate)
                        ->where($dynamicolumn,'<=',$increfromdatedate)
                        ->get();
                }
            }
            else {
                if($assigneesname !=""){
                    $idata =  ExistingUserComplaintLodging::selectRaw('tblexistingcustomercomplaintlodging.*,tblproductservicemaster.productservicename,tblcustomermaster.customername,tblcustomermaster.customertype,tblcustomermaster.contactpersonname,tblcustomermaster.contactpersonphone,tblassigneemaster.assigneename,tblticketassigneedetails.*')
                        ->leftJoin('tblcustomermaster', 'tblcustomermaster.customercode', '=', 'tblexistingcustomercomplaintlodging.customercode')
                        ->leftJoin('tblticketassigneedetails', 'tblticketassigneedetails.ticketno', '=', 'tblexistingcustomercomplaintlodging.ticketno')
                        ->leftJoin('tblassigneemaster', 'tblassigneemaster.assigneecode', '=', 'tblticketassigneedetails.assigneecode')
                        ->leftJoin('tblproductservicemaster', 'tblproductservicemaster.productservicecode', '=', 'tblexistingcustomercomplaintlodging.productservicecode')
                        ->where($dynamicolumn,'>=',$fromdate)
                        ->where($dynamicolumn,'<=',$todate)
                        ->where('tblticketassigneedetails.assigneecode','=',$assigneesname)
                        ->get();
                }
                else{
                    $idata =  ExistingUserComplaintLodging::selectRaw('tblexistingcustomercomplaintlodging.*,tblproductservicemaster.productservicename,tblcustomermaster.customername,tblcustomermaster.customertype,tblcustomermaster.contactpersonname,tblcustomermaster.contactpersonphone,tblassigneemaster.assigneename,tblticketassigneedetails.assigneecode')
                        ->leftJoin('tblcustomermaster', 'tblcustomermaster.customercode', '=', 'tblexistingcustomercomplaintlodging.customercode')
                        ->leftJoin('tblticketassigneedetails', 'tblticketassigneedetails.ticketno', '=', 'tblexistingcustomercomplaintlodging.ticketno')
                        ->leftJoin('tblassigneemaster', 'tblassigneemaster.assigneecode', '=', 'tblticketassigneedetails.assigneecode')
                        ->leftJoin('tblproductservicemaster', 'tblproductservicemaster.productservicecode', '=', 'tblexistingcustomercomplaintlodging.productservicecode')
                        ->where($dynamicolumn,'>=',$fromdate)
                        ->where($dynamicolumn,'<=',$todate)
                        ->get();
                }
            }
        }
        elseif ($complaintstatus !="" && $fromdate=="" && $todate==""){
            if($complaintstatus == 'ASSIGNED'){
                $idata =  ExistingUserComplaintLodging::selectRaw('tblexistingcustomercomplaintlodging.*,tblproductservicemaster.productservicename,tblcustomermaster.customername,tblcustomermaster.customertype,tblcustomermaster.contactpersonname,tblcustomermaster.contactpersonphone,tblassigneemaster.assigneename,tblticketassigneedetails.*')
                    ->leftJoin('tblcustomermaster', 'tblcustomermaster.customercode', '=', 'tblexistingcustomercomplaintlodging.customercode')
                    ->leftJoin('tblticketassigneedetails', 'tblticketassigneedetails.ticketno', '=', 'tblexistingcustomercomplaintlodging.ticketno')
                    ->leftJoin('tblassigneemaster', 'tblassigneemaster.assigneecode', '=', 'tblticketassigneedetails.assigneecode')
                    ->leftJoin('tblproductservicemaster', 'tblproductservicemaster.productservicecode', '=', 'tblexistingcustomercomplaintlodging.productservicecode')
                    ->where('complaintstatus','=',$complaintstatus)
                    ->where('assigneestatus','!=','PENDING')
                    ->where('assigneestatus','!=','NOT RESOLVED')
                    ->where('assigneestatus','!=','UnresolvedReassigned')
                    ->get();
            }
            elseif($complaintstatus == 'PENDING'){
                $idata =  ExistingUserComplaintLodging::selectRaw('tblexistingcustomercomplaintlodging.*,tblproductservicemaster.productservicename,tblcustomermaster.customername,tblcustomermaster.customertype,tblcustomermaster.contactpersonname,tblcustomermaster.contactpersonphone,tblassigneemaster.assigneename,tblticketassigneedetails.*')
                    ->leftJoin('tblcustomermaster', 'tblcustomermaster.customercode', '=', 'tblexistingcustomercomplaintlodging.customercode')
                    ->leftJoin('tblticketassigneedetails', 'tblticketassigneedetails.ticketno', '=', 'tblexistingcustomercomplaintlodging.ticketno')
                    ->leftJoin('tblassigneemaster', 'tblassigneemaster.assigneecode', '=', 'tblticketassigneedetails.assigneecode')
                    ->leftJoin('tblproductservicemaster', 'tblproductservicemaster.productservicecode', '=', 'tblexistingcustomercomplaintlodging.productservicecode')
                    ->where('complaintstatus','=','ASSIGNED')
                    ->where('assigneestatus','=',$complaintstatus)
                    ->get();
            }
            elseif($complaintstatus == 'ACKNOWLEDGED'){
                $idata =  ExistingUserComplaintLodging::selectRaw('tblexistingcustomercomplaintlodging.*,tblproductservicemaster.productservicename,tblcustomermaster.customername,tblcustomermaster.customertype,tblcustomermaster.contactpersonname,tblcustomermaster.contactpersonphone')
                    ->leftJoin('tblcustomermaster', 'tblcustomermaster.customercode', '=', 'tblexistingcustomercomplaintlodging.customercode')
//                    ->leftJoin('tblticketassigneedetails', 'tblticketassigneedetails.ticketno', '=', 'tblexistingcustomercomplaintlodging.ticketno')
//                    ->leftJoin('tblassigneemaster', 'tblassigneemaster.assigneecode', '=', 'tblticketassigneedetails.assigneecode')
                    ->leftJoin('tblproductservicemaster', 'tblproductservicemaster.productservicecode', '=', 'tblexistingcustomercomplaintlodging.productservicecode')
                    ->where('complaintstatus','=',$complaintstatus)
                    ->get();
            }
            elseif($complaintstatus == 'CLOSED'){
                $idata =  ExistingUserComplaintLodging::selectRaw('tblexistingcustomercomplaintlodging.*,tblproductservicemaster.productservicename,tblcustomermaster.customername,tblcustomermaster.customertype,tblcustomermaster.contactpersonname,tblcustomermaster.contactpersonphone,tblassigneemaster.assigneename,tblticketassigneedetails.assigneecode')
                    ->leftJoin('tblcustomermaster', 'tblcustomermaster.customercode', '=', 'tblexistingcustomercomplaintlodging.customercode')
                    ->leftJoin('tblticketassigneedetails', 'tblticketassigneedetails.ticketno', '=', 'tblexistingcustomercomplaintlodging.ticketno')
                    ->leftJoin('tblassigneemaster', 'tblassigneemaster.assigneecode', '=', 'tblticketassigneedetails.assigneecode')
                    ->leftJoin('tblproductservicemaster', 'tblproductservicemaster.productservicecode', '=', 'tblexistingcustomercomplaintlodging.productservicecode')
                    ->where('complaintstatus','=',$complaintstatus)
//                    ->orWhere('complaintstatus','=','ClosedByAdmin')
                    ->get();
            }
            elseif($complaintstatus == 'RESOLVED'){
                $idata =  ExistingUserComplaintLodging::selectRaw('tblexistingcustomercomplaintlodging.*,tblproductservicemaster.productservicename,tblcustomermaster.customername,tblcustomermaster.customertype,tblcustomermaster.contactpersonname,tblcustomermaster.contactpersonphone,tblassigneemaster.assigneename,tblticketassigneedetails.*')
                    ->leftJoin('tblcustomermaster', 'tblcustomermaster.customercode', '=', 'tblexistingcustomercomplaintlodging.customercode')
                    ->leftJoin('tblticketassigneedetails', 'tblticketassigneedetails.ticketno', '=', 'tblexistingcustomercomplaintlodging.ticketno')
                    ->leftJoin('tblassigneemaster', 'tblassigneemaster.assigneecode', '=', 'tblticketassigneedetails.assigneecode')
                    ->leftJoin('tblproductservicemaster', 'tblproductservicemaster.productservicecode', '=', 'tblexistingcustomercomplaintlodging.productservicecode')
                    ->where('complaintstatus','=',$complaintstatus)
                    ->get();
            }
            else {
                $idata = ExistingUserComplaintLodging::selectRaw('tblexistingcustomercomplaintlodging.*,tblproductservicemaster.productservicename,tblcustomermaster.customername,tblcustomermaster.customertype,tblcustomermaster.contactpersonname,tblcustomermaster.contactpersonphone,tblassigneemaster.assigneename,tblticketassigneedetails.*')
                    ->leftJoin('tblcustomermaster', 'tblcustomermaster.customercode', '=', 'tblexistingcustomercomplaintlodging.customercode')
                    ->leftJoin('tblticketassigneedetails', 'tblticketassigneedetails.ticketno', '=', 'tblexistingcustomercomplaintlodging.ticketno')
                    ->leftJoin('tblassigneemaster', 'tblassigneemaster.assigneecode', '=', 'tblticketassigneedetails.assigneecode')
                    ->leftJoin('tblproductservicemaster', 'tblproductservicemaster.productservicecode', '=', 'tblexistingcustomercomplaintlodging.productservicecode')
                    ->where('assigneestatus', '=', $complaintstatus)
                    ->get();
            }
        }
        elseif ($assigneesname !="" && $complaintstatus =="" && $fromdate=="" && $todate=="") {
            $idata =  ExistingUserComplaintLodging::selectRaw('tblexistingcustomercomplaintlodging.*,tblproductservicemaster.productservicename,tblcustomermaster.customername,tblcustomermaster.customertype,tblcustomermaster.contactpersonname,tblcustomermaster.contactpersonphone,tblassigneemaster.assigneename,tblticketassigneedetails.*')
                ->leftJoin('tblcustomermaster', 'tblcustomermaster.customercode', '=', 'tblexistingcustomercomplaintlodging.customercode')
                ->leftJoin('tblticketassigneedetails', 'tblticketassigneedetails.ticketno', '=', 'tblexistingcustomercomplaintlodging.ticketno')
                ->leftJoin('tblassigneemaster', 'tblassigneemaster.assigneecode', '=', 'tblticketassigneedetails.assigneecode')
                ->leftJoin('tblproductservicemaster', 'tblproductservicemaster.productservicecode', '=', 'tblexistingcustomercomplaintlodging.productservicecode')
                ->where('tblticketassigneedetails.assigneecode','=',$assigneesname)
                ->get();
        }

        elseif ($fromdate !="" && $todate !="" && $complaintstatus !="" && $assigneesname =="") {
            if($complaintstatus == 'ASSIGNED'){
                    $start = new Carbon($todate);
                    $increfromdatedate = $start->modify('+1 day');
                    $idata = ExistingUserComplaintLodging::selectRaw('tblexistingcustomercomplaintlodging.*,tblproductservicemaster.productservicename,tblcustomermaster.customername,tblcustomermaster.customertype,tblcustomermaster.contactpersonname,tblcustomermaster.contactpersonphone,tblassigneemaster.assigneename,tblticketassigneedetails.*')
                        ->leftJoin('tblcustomermaster', 'tblcustomermaster.customercode', '=', 'tblexistingcustomercomplaintlodging.customercode')
                        ->leftJoin('tblticketassigneedetails', 'tblticketassigneedetails.ticketno', '=', 'tblexistingcustomercomplaintlodging.ticketno')
                        ->leftJoin('tblassigneemaster', 'tblassigneemaster.assigneecode', '=', 'tblticketassigneedetails.assigneecode')
                        ->leftJoin('tblproductservicemaster', 'tblproductservicemaster.productservicecode', '=', 'tblexistingcustomercomplaintlodging.productservicecode')
                        ->where($dynamicolumn, '>=', $fromdate)
                        ->where($dynamicolumn, '<=', $increfromdatedate)
                        ->where('complaintstatus', '=', $complaintstatus)
                        ->where('assigneestatus', '!=','PENDING')
                        ->where('assigneestatus', '!=','NOT RESOLVED')
                        ->where('assigneestatus', '!=','UnresolvedReassigned')
                        ->get();
            }
            elseif($complaintstatus == 'PENDING'){
                $start = new Carbon($todate);
                $increfromdatedate = $start->modify('+1 day');
                $idata = ExistingUserComplaintLodging::selectRaw('tblexistingcustomercomplaintlodging.*,tblproductservicemaster.productservicename,tblcustomermaster.customername,tblcustomermaster.customertype,tblcustomermaster.contactpersonname,tblcustomermaster.contactpersonphone,tblassigneemaster.assigneename,tblticketassigneedetails.*')
                    ->leftJoin('tblcustomermaster', 'tblcustomermaster.customercode', '=', 'tblexistingcustomercomplaintlodging.customercode')
                    ->leftJoin('tblticketassigneedetails', 'tblticketassigneedetails.ticketno', '=', 'tblexistingcustomercomplaintlodging.ticketno')
                    ->leftJoin('tblassigneemaster', 'tblassigneemaster.assigneecode', '=', 'tblticketassigneedetails.assigneecode')
                    ->leftJoin('tblproductservicemaster', 'tblproductservicemaster.productservicecode', '=', 'tblexistingcustomercomplaintlodging.productservicecode')
                    ->where($dynamicolumn, '>=', $fromdate)
                    ->where($dynamicolumn, '<=', $increfromdatedate)
                    ->where('complaintstatus', '=', 'ASSIGNED')
                    ->where('assigneestatus', '=',$complaintstatus)
                    ->get();
            }
            elseif($complaintstatus == 'ACKNOWLEDGED') {
                $start = new Carbon($todate);
                $increfromdatedate = $start->modify('+1 day');
                $idata = ExistingUserComplaintLodging::selectRaw('tblexistingcustomercomplaintlodging.*,tblproductservicemaster.productservicename,tblcustomermaster.customername,tblcustomermaster.customertype,tblcustomermaster.contactpersonname,tblcustomermaster.contactpersonphone   ')
                    ->leftJoin('tblcustomermaster', 'tblcustomermaster.customercode', '=', 'tblexistingcustomercomplaintlodging.customercode')
//                    ->leftJoin('tblticketassigneedetails', 'tblticketassigneedetails.ticketno', '=', 'tblexistingcustomercomplaintlodging.ticketno')
//                    ->leftJoin('tblassigneemaster', 'tblassigneemaster.assigneecode', '=', 'tblticketassigneedetails.assigneecode')
                    ->leftJoin('tblproductservicemaster', 'tblproductservicemaster.productservicecode', '=', 'tblexistingcustomercomplaintlodging.productservicecode')
                    ->where($dynamicolumn, '>=', $fromdate)
                    ->where($dynamicolumn, '<=', $increfromdatedate)
                    ->Where('complaintstatus', '=', $complaintstatus)
                    ->get();
            }
            elseif($complaintstatus == 'CLOSED'){
                $start = new Carbon($todate);
                $increfromdatedate = $start->modify('+1 day');
                $idata = ExistingUserComplaintLodging::selectRaw('tblexistingcustomercomplaintlodging.*,tblproductservicemaster.productservicename,tblcustomermaster.customername,tblcustomermaster.customertype,tblcustomermaster.contactpersonname,tblcustomermaster.contactpersonphone,tblassigneemaster.assigneename,tblticketassigneedetails.assigneecode')
                    ->leftJoin('tblcustomermaster', 'tblcustomermaster.customercode', '=', 'tblexistingcustomercomplaintlodging.customercode')
                    ->leftJoin('tblticketassigneedetails', 'tblexistingcustomercomplaintlodging.ticketno', '=', 'tblticketassigneedetails.ticketno')
                    ->leftJoin('tblassigneemaster', 'tblassigneemaster.assigneecode', '=', 'tblticketassigneedetails.assigneecode')
                    ->leftJoin('tblproductservicemaster', 'tblproductservicemaster.productservicecode', '=', 'tblexistingcustomercomplaintlodging.productservicecode')
                    ->where($dynamicolumn, '>=', $fromdate)
                    ->where($dynamicolumn, '<=', $increfromdatedate)
                    ->Where('complaintstatus', '=',$complaintstatus)
//                    ->orWhere('complaintstatus','=','ClosedByAdmin')
                    ->get();
            }
            elseif($complaintstatus == 'RESOLVED'){
                $start = new Carbon($todate);
                $increfromdatedate = $start->modify('+1 day');
                $idata = ExistingUserComplaintLodging::selectRaw('tblexistingcustomercomplaintlodging.*,tblproductservicemaster.productservicename,tblcustomermaster.customername,tblcustomermaster.customertype,tblcustomermaster.contactpersonname,tblcustomermaster.contactpersonphone,tblassigneemaster.assigneename,tblticketassigneedetails.*')
                    ->leftJoin('tblcustomermaster', 'tblcustomermaster.customercode', '=', 'tblexistingcustomercomplaintlodging.customercode')
                    ->leftJoin('tblticketassigneedetails', 'tblticketassigneedetails.ticketno', '=', 'tblexistingcustomercomplaintlodging.ticketno')
                    ->leftJoin('tblassigneemaster', 'tblassigneemaster.assigneecode', '=', 'tblticketassigneedetails.assigneecode')
                    ->leftJoin('tblproductservicemaster', 'tblproductservicemaster.productservicecode', '=', 'tblexistingcustomercomplaintlodging.productservicecode')
                    ->where($dynamicolumn, '>=', $fromdate)
                    ->where($dynamicolumn, '<=', $increfromdatedate)
                    ->Where('complaintstatus', '=',$complaintstatus)
                    ->get();
            }
            else{
                $start = new Carbon($todate);
                $increfromdatedate = $start->modify('+1 day');
                $idata = ExistingUserComplaintLodging::selectRaw('tblexistingcustomercomplaintlodging.*,tblproductservicemaster.productservicename,tblcustomermaster.customername,tblcustomermaster.customertype,tblcustomermaster.contactpersonname,tblcustomermaster.contactpersonphone,tblassigneemaster.assigneename,tblticketassigneedetails.*')
                    ->leftJoin('tblcustomermaster', 'tblcustomermaster.customercode', '=', 'tblexistingcustomercomplaintlodging.customercode')
                    ->leftJoin('tblticketassigneedetails', 'tblticketassigneedetails.ticketno', '=', 'tblexistingcustomercomplaintlodging.ticketno')
                    ->leftJoin('tblassigneemaster', 'tblassigneemaster.assigneecode', '=', 'tblticketassigneedetails.assigneecode')
                    ->leftJoin('tblproductservicemaster', 'tblproductservicemaster.productservicecode', '=', 'tblexistingcustomercomplaintlodging.productservicecode')
                    ->where($dynamicolumn, '>=', $fromdate)
                    ->where($dynamicolumn, '<=', $increfromdatedate)
                    ->where('assigneestatus', '=', $complaintstatus)
                    ->get();
            }
        }
        else{
            if($fromdate == $todate){
                if($complaintstatus == 'ASSIGNED'){
                    $start = new Carbon($todate);
                    $increfromdatedate=$start->modify('+1 day');
                    $idata = ExistingUserComplaintLodging::selectRaw('tblexistingcustomercomplaintlodging.*,tblproductservicemaster.productservicename,tblcustomermaster.customername,tblcustomermaster.customertype,tblcustomermaster.contactpersonname,tblcustomermaster.contactpersonphone,tblassigneemaster.assigneename,tblticketassigneedetails.*')
                        ->leftJoin('tblcustomermaster', 'tblcustomermaster.customercode', '=', 'tblexistingcustomercomplaintlodging.customercode')
                        ->leftJoin('tblticketassigneedetails', 'tblticketassigneedetails.ticketno', '=', 'tblexistingcustomercomplaintlodging.ticketno')
                        ->leftJoin('tblassigneemaster', 'tblassigneemaster.assigneecode', '=', 'tblticketassigneedetails.assigneecode')
                        ->leftJoin('tblproductservicemaster', 'tblproductservicemaster.productservicecode', '=', 'tblexistingcustomercomplaintlodging.productservicecode')
                        ->where($dynamicolumn, '>=', $fromdate)
                        ->where($dynamicolumn, '<=', $increfromdatedate)
                        ->where('complaintstatus', '=', $complaintstatus)
                        ->where('assigneestatus','!=','PENDING')
                        ->where('assigneestatus','!=','NOT RESOLVED')
                        ->where('assigneestatus','!=','UnresolvedReassigned')
                        ->where('tblticketassigneedetails.assigneecode', '=', $assigneesname)
                        ->get();
                }
                elseif($complaintstatus == 'PENDING'){
                    $start = new Carbon($todate);
                    $increfromdatedate=$start->modify('+1 day');
                    $idata = ExistingUserComplaintLodging::selectRaw('tblexistingcustomercomplaintlodging.*,tblproductservicemaster.productservicename,tblcustomermaster.customername,tblcustomermaster.customertype,tblcustomermaster.contactpersonname,tblcustomermaster.contactpersonphone,tblassigneemaster.assigneename,tblticketassigneedetails.*')
                        ->leftJoin('tblcustomermaster', 'tblcustomermaster.customercode', '=', 'tblexistingcustomercomplaintlodging.customercode')
                        ->leftJoin('tblticketassigneedetails', 'tblticketassigneedetails.ticketno', '=', 'tblexistingcustomercomplaintlodging.ticketno')
                        ->leftJoin('tblassigneemaster', 'tblassigneemaster.assigneecode', '=', 'tblticketassigneedetails.assigneecode')
                        ->leftJoin('tblproductservicemaster', 'tblproductservicemaster.productservicecode', '=', 'tblexistingcustomercomplaintlodging.productservicecode')
                        ->where($dynamicolumn, '>=', $fromdate)
                        ->where($dynamicolumn, '<=', $increfromdatedate)
                        ->where('complaintstatus', '=', 'ASSIGNED')
                        ->where('assigneestatus','=',$complaintstatus)
                        ->where('tblticketassigneedetails.assigneecode', '=', $assigneesname)
                        ->get();
                }
                elseif($complaintstatus == 'ACKNOWLEDGED'){
                    $start = new Carbon($todate);
                    $increfromdatedate=$start->modify('+1 day');
                    $idata = ExistingUserComplaintLodging::selectRaw('tblexistingcustomercomplaintlodging.*,tblproductservicemaster.productservicename,tblcustomermaster.customername,tblcustomermaster.customertype,tblcustomermaster.contactpersonname,tblcustomermaster.contactpersonphone')
                        ->leftJoin('tblcustomermaster', 'tblcustomermaster.customercode', '=', 'tblexistingcustomercomplaintlodging.customercode')
//                        ->leftJoin('tblticketassigneedetails', 'tblticketassigneedetails.ticketno', '=', 'tblexistingcustomercomplaintlodging.ticketno')
//                        ->leftJoin('tblassigneemaster', 'tblassigneemaster.assigneecode', '=', 'tblticketassigneedetails.assigneecode')
                        ->leftJoin('tblproductservicemaster', 'tblproductservicemaster.productservicecode', '=', 'tblexistingcustomercomplaintlodging.productservicecode')
                        ->where($dynamicolumn, '>=', $fromdate)
                        ->where($dynamicolumn, '<=', $increfromdatedate)
                        ->where('complaintstatus','=',$complaintstatus)
//                        ->where('tblticketassigneedetails.assigneecode', '=', $assigneesname)
                        ->get();
                }
                elseif($complaintstatus == 'CLOSED'){
                    $start = new Carbon($todate);
                    $increfromdatedate=$start->modify('+1 day');
                    $idata = ExistingUserComplaintLodging::selectRaw('tblexistingcustomercomplaintlodging.*,tblproductservicemaster.productservicename,tblcustomermaster.customername,tblcustomermaster.customertype,tblcustomermaster.contactpersonname,tblcustomermaster.contactpersonphone,tblassigneemaster.assigneename,tblticketassigneedetails.*')
                        ->leftJoin('tblcustomermaster', 'tblcustomermaster.customercode', '=', 'tblexistingcustomercomplaintlodging.customercode')
                        ->leftJoin('tblticketassigneedetails', 'tblticketassigneedetails.ticketno', '=', 'tblexistingcustomercomplaintlodging.ticketno')
                        ->leftJoin('tblassigneemaster', 'tblassigneemaster.assigneecode', '=', 'tblticketassigneedetails.assigneecode')
                        ->leftJoin('tblproductservicemaster', 'tblproductservicemaster.productservicecode', '=', 'tblexistingcustomercomplaintlodging.productservicecode')
                        ->where($dynamicolumn, '>=', $fromdate)
                        ->where($dynamicolumn, '<=', $increfromdatedate)
                        ->where('complaintstatus','=',$complaintstatus)
                        ->orWhere('complaintstatus','=','ClosedByAdmin')
                        ->where('tblticketassigneedetails.assigneecode', '=', $assigneesname)
                        ->get();
                }
                elseif($complaintstatus == 'RESOLVED'){
                    $start = new Carbon($todate);
                    $increfromdatedate=$start->modify('+1 day');
                    $idata = ExistingUserComplaintLodging::selectRaw('tblexistingcustomercomplaintlodging.*,tblproductservicemaster.productservicename,tblcustomermaster.customername,tblcustomermaster.customertype,tblcustomermaster.contactpersonname,tblcustomermaster.contactpersonphone,tblassigneemaster.assigneename,tblticketassigneedetails.*')
                        ->leftJoin('tblcustomermaster', 'tblcustomermaster.customercode', '=', 'tblexistingcustomercomplaintlodging.customercode')
                        ->leftJoin('tblticketassigneedetails', 'tblticketassigneedetails.ticketno', '=', 'tblexistingcustomercomplaintlodging.ticketno')
                        ->leftJoin('tblassigneemaster', 'tblassigneemaster.assigneecode', '=', 'tblticketassigneedetails.assigneecode')
                        ->leftJoin('tblproductservicemaster', 'tblproductservicemaster.productservicecode', '=', 'tblexistingcustomercomplaintlodging.productservicecode')
                        ->where($dynamicolumn, '>=', $fromdate)
                        ->where($dynamicolumn, '<=', $increfromdatedate)
                        ->where('complaintstatus','=',$complaintstatus)
                        ->where('tblticketassigneedetails.assigneecode', '=', $assigneesname)
                        ->get();
                }
                else{
                    $start = new Carbon($todate);
                    $increfromdatedate=$start->modify('+1 day');
                    $idata =  ExistingUserComplaintLodging::selectRaw('tblexistingcustomercomplaintlodging.*,tblproductservicemaster.productservicename,tblcustomermaster.customername,tblcustomermaster.customertype,tblcustomermaster.contactpersonname,tblcustomermaster.contactpersonphone,tblassigneemaster.assigneename,tblticketassigneedetails.*')
                        ->leftJoin('tblcustomermaster', 'tblcustomermaster.customercode', '=', 'tblexistingcustomercomplaintlodging.customercode')
                        ->leftJoin('tblticketassigneedetails', 'tblticketassigneedetails.ticketno', '=', 'tblexistingcustomercomplaintlodging.ticketno')
                        ->leftJoin('tblassigneemaster', 'tblassigneemaster.assigneecode', '=', 'tblticketassigneedetails.assigneecode')
                        ->leftJoin('tblproductservicemaster', 'tblproductservicemaster.productservicecode', '=', 'tblexistingcustomercomplaintlodging.productservicecode')
                        ->where($dynamicolumn,'>=',$fromdate)
                        ->where($dynamicolumn,'<=',$increfromdatedate)
                        ->where('assigneestatus','=',$complaintstatus)
                        ->where('tblticketassigneedetails.assigneecode','=',$assigneesname)
                        ->get();
                }
            }
            else {
                if($complaintstatus == 'ASSIGNED') {
                    $idata = ExistingUserComplaintLodging::selectRaw('tblexistingcustomercomplaintlodging.*,tblproductservicemaster.productservicename,tblcustomermaster.customername,tblcustomermaster.customertype,tblcustomermaster.contactpersonname,tblcustomermaster.contactpersonphone,tblassigneemaster.assigneename,tblticketassigneedetails.*')
                        ->leftJoin('tblcustomermaster', 'tblcustomermaster.customercode', '=', 'tblexistingcustomercomplaintlodging.customercode')
                        ->leftJoin('tblticketassigneedetails', 'tblticketassigneedetails.ticketno', '=', 'tblexistingcustomercomplaintlodging.ticketno')
                        ->leftJoin('tblassigneemaster', 'tblassigneemaster.assigneecode', '=', 'tblticketassigneedetails.assigneecode')
                        ->leftJoin('tblproductservicemaster', 'tblproductservicemaster.productservicecode', '=', 'tblexistingcustomercomplaintlodging.productservicecode')
                        ->where($dynamicolumn, '>=', $fromdate)
                        ->where($dynamicolumn, '<=', $todate)
                        ->where('complaintstatus', '=', $complaintstatus)
                        ->where('assigneestatus','!=','PENDING')
                        ->where('assigneestatus','!=','NOT RESOLVED')
                        ->where('assigneestatus','!=','UnresolvedReassigned')
                        ->where('tblticketassigneedetails.assigneecode', '=', $assigneesname)
                        ->get();
                }
                elseif($complaintstatus == 'PENDING'){
                    $idata = ExistingUserComplaintLodging::selectRaw('tblexistingcustomercomplaintlodging.*,tblproductservicemaster.productservicename,tblcustomermaster.customername,tblcustomermaster.customertype,tblcustomermaster.contactpersonname,tblcustomermaster.contactpersonphone,tblassigneemaster.assigneename,tblticketassigneedetails.*')
                        ->leftJoin('tblcustomermaster', 'tblcustomermaster.customercode', '=', 'tblexistingcustomercomplaintlodging.customercode')
                        ->leftJoin('tblticketassigneedetails', 'tblticketassigneedetails.ticketno', '=', 'tblexistingcustomercomplaintlodging.ticketno')
                        ->leftJoin('tblassigneemaster', 'tblassigneemaster.assigneecode', '=', 'tblticketassigneedetails.assigneecode')
                        ->leftJoin('tblproductservicemaster', 'tblproductservicemaster.productservicecode', '=', 'tblexistingcustomercomplaintlodging.productservicecode')
                        ->where($dynamicolumn, '>=', $fromdate)
                        ->where($dynamicolumn, '<=', $todate)
                        ->where('complaintstatus', '=', 'ASSIGNED')
                        ->where('assigneestatus','=',$complaintstatus)
                        ->where('tblticketassigneedetails.assigneecode', '=', $assigneesname)
                        ->get();
                }
                elseif($complaintstatus == 'ACKNOWLEDGED'){
                    $idata = ExistingUserComplaintLodging::selectRaw('tblexistingcustomercomplaintlodging.*,tblproductservicemaster.productservicename,tblcustomermaster.customername,tblcustomermaster.customertype,tblcustomermaster.contactpersonname,tblcustomermaster.contactpersonphone')
                        ->leftJoin('tblcustomermaster', 'tblcustomermaster.customercode', '=', 'tblexistingcustomercomplaintlodging.customercode')
//                        ->leftJoin('tblticketassigneedetails', 'tblticketassigneedetails.ticketno', '=', 'tblexistingcustomercomplaintlodging.ticketno')
//                        ->leftJoin('tblassigneemaster', 'tblassigneemaster.assigneecode', '=', 'tblticketassigneedetails.assigneecode')
                        ->leftJoin('tblproductservicemaster', 'tblproductservicemaster.productservicecode', '=', 'tblexistingcustomercomplaintlodging.productservicecode')
                        ->where($dynamicolumn, '>=', $fromdate)
                        ->where($dynamicolumn, '<=', $todate)
                        ->where('complaintstatus','=',$complaintstatus)
//                        ->where('tblticketassigneedetails.assigneecode', '=', $assigneesname)
                        ->get();
                }
                elseif($complaintstatus == 'CLOSED'){
                    $idata = ExistingUserComplaintLodging::selectRaw('tblexistingcustomercomplaintlodging.*,tblproductservicemaster.productservicename,tblcustomermaster.customername,tblcustomermaster.customertype,tblcustomermaster.contactpersonname,tblcustomermaster.contactpersonphone,tblassigneemaster.assigneename,tblticketassigneedetails.*')
                        ->leftJoin('tblcustomermaster', 'tblcustomermaster.customercode', '=', 'tblexistingcustomercomplaintlodging.customercode')
                        ->leftJoin('tblticketassigneedetails', 'tblticketassigneedetails.ticketno', '=', 'tblexistingcustomercomplaintlodging.ticketno')
                        ->leftJoin('tblassigneemaster', 'tblassigneemaster.assigneecode', '=', 'tblticketassigneedetails.assigneecode')
                        ->leftJoin('tblproductservicemaster', 'tblproductservicemaster.productservicecode', '=', 'tblexistingcustomercomplaintlodging.productservicecode')
                        ->where($dynamicolumn, '>=', $fromdate)
                        ->where($dynamicolumn, '<=', $todate)
                        ->where('complaintstatus','=',$complaintstatus)
//                        ->orWhere('assigneestatus','=','ClosedByAdmin')
                        ->where('tblticketassigneedetails.assigneecode', '=', $assigneesname)
                        ->get();
                }
                elseif($complaintstatus == 'RESOLVED'){
                    $idata = ExistingUserComplaintLodging::selectRaw('tblexistingcustomercomplaintlodging.*,tblproductservicemaster.productservicename,tblcustomermaster.customername,tblcustomermaster.customertype,tblcustomermaster.contactpersonname,tblcustomermaster.contactpersonphone,tblassigneemaster.assigneename,tblticketassigneedetails.*')
                        ->leftJoin('tblcustomermaster', 'tblcustomermaster.customercode', '=', 'tblexistingcustomercomplaintlodging.customercode')
                        ->leftJoin('tblticketassigneedetails', 'tblticketassigneedetails.ticketno', '=', 'tblexistingcustomercomplaintlodging.ticketno')
                        ->leftJoin('tblassigneemaster', 'tblassigneemaster.assigneecode', '=', 'tblticketassigneedetails.assigneecode')
                        ->leftJoin('tblproductservicemaster', 'tblproductservicemaster.productservicecode', '=', 'tblexistingcustomercomplaintlodging.productservicecode')
                        ->where($dynamicolumn, '>=', $fromdate)
                        ->where($dynamicolumn, '<=', $todate)
                        ->where('complaintstatus','=',$complaintstatus)
                        ->where('tblticketassigneedetails.assigneecode', '=', $assigneesname)
                        ->get();
                }
                else{
                    $start = new Carbon($todate);
                    $increfromdatedate = $start->modify('+1 day');
                    $idata = ExistingUserComplaintLodging::selectRaw('tblexistingcustomercomplaintlodging.*,tblproductservicemaster.productservicename,tblcustomermaster.customername,tblcustomermaster.customertype,tblcustomermaster.contactpersonname,tblcustomermaster.contactpersonphone,tblassigneemaster.assigneename,tblticketassigneedetails.*')
                        ->leftJoin('tblcustomermaster', 'tblcustomermaster.customercode', '=', 'tblexistingcustomercomplaintlodging.customercode')
                        ->leftJoin('tblticketassigneedetails', 'tblticketassigneedetails.ticketno', '=', 'tblexistingcustomercomplaintlodging.ticketno')
                        ->leftJoin('tblassigneemaster', 'tblassigneemaster.assigneecode', '=', 'tblticketassigneedetails.assigneecode')
                        ->leftJoin('tblproductservicemaster', 'tblproductservicemaster.productservicecode', '=', 'tblexistingcustomercomplaintlodging.productservicecode')
                        ->where($dynamicolumn, '>=', $fromdate)
                        ->where($dynamicolumn, '<=', $increfromdatedate)
                        ->where('assigneestatus', '=', $complaintstatus)
                        ->where('tblticketassigneedetails.assigneecode', '=', $assigneesname)
                        ->get();
                }
            }
        }

        $CLOSEDcount = 0;
        $RESOLVEDcount = 0;
        $ASSIGNEDcount = 0;
        $ACKNOWLEDGEDcount = 0;

        foreach ($idata as $post)
        {
            if($post->complaintstatus=="CLOSED"){
                $CLOSEDcount++;
            }
            if($post->complaintstatus=="RESOLVED"){
                $RESOLVEDcount++;
            }
            if($post->complaintstatus=="ACKNOWLEDGED"){
                $ACKNOWLEDGEDcount++;
            }
            if($post->complaintstatus=="ASSIGNED"){
                $ASSIGNEDcount++;
            }
        }
        $count = count($idata);
        if($count >0) {
   //         return $idata;
            $pdf = PDF::loadView('Report.Htmltopdfreport',array('idata' => $idata,
                'CLOSEDcount' => $CLOSEDcount,
                'RESOLVEDcount' => $RESOLVEDcount,
                'ACKNOWLEDGEDcount' => $ACKNOWLEDGEDcount,
                'ASSIGNEDcount' => $ASSIGNEDcount))->setPaper('a4', 'landscape');
            return $pdf->download('Report.pdf');
        }
        elseif($count == 0){
            return redirect()->back()->with('alert', 'No Data Found!');
        }
    }

    public function reportExport($data){
        $data = explode(",", $data);
        $fromdate = $data[0];
        $todate =  $data[1];
        $complaintstatus =  $data[2];
        $assigneesname = $data[3];
        $dynamicolumn = "";
        if($complaintstatus == "ACKNOWLEDGED" || $complaintstatus == "")
            $dynamicolumn ='complaintdate';
        elseif($complaintstatus == "RESOLVED")
            $dynamicolumn ='callenddate';
        elseif($complaintstatus == "ASSIGNED")
            $dynamicolumn ='assigneestartdate';
        elseif($complaintstatus == "PENDING")
            $dynamicolumn = 'pendingstatusdate';
        elseif($complaintstatus == "NOT RESOLVED")
            $dynamicolumn = 'unresolvestatusddate';
        elseif($complaintstatus == "CLOSED")
            $dynamicolumn ='callclosuredate';

        if($fromdate !="" && $todate !="" && $complaintstatus=="" ){
            if($fromdate == $todate){
                $start =  new Carbon($todate);
                $increfromdatedate=$start->modify('+1 day');

                if($assigneesname !="") {
                    $idata =  ExistingUserComplaintLodging::selectRaw('tblexistingcustomercomplaintlodging.*,tblproductservicemaster.productservicename,tblcustomermaster.customername,tblcustomermaster.customertype,tblcustomermaster.contactpersonname,tblcustomermaster.contactpersonphone,tblassigneemaster.assigneename,tblticketassigneedetails.*')
                        ->leftJoin('tblcustomermaster', 'tblcustomermaster.customercode', '=', 'tblexistingcustomercomplaintlodging.customercode')
                        ->leftJoin('tblticketassigneedetails', 'tblticketassigneedetails.ticketno', '=', 'tblexistingcustomercomplaintlodging.ticketno')
                        ->leftJoin('tblassigneemaster', 'tblassigneemaster.assigneecode', '=', 'tblticketassigneedetails.assigneecode')
                        ->leftJoin('tblproductservicemaster', 'tblproductservicemaster.productservicecode', '=', 'tblexistingcustomercomplaintlodging.productservicecode')
                        ->where($dynamicolumn,'>=',$fromdate)
                        ->where($dynamicolumn,'<=',$increfromdatedate)
                        ->where('tblticketassigneedetails.assigneecode','=',$assigneesname)
                        ->get();
                }
                else {
                    $idata =  ExistingUserComplaintLodging::selectRaw('tblexistingcustomercomplaintlodging.*,tblproductservicemaster.productservicename,tblcustomermaster.customername,tblcustomermaster.customertype,tblcustomermaster.contactpersonname,tblcustomermaster.contactpersonphone,tblassigneemaster.assigneename,tblassigneemaster.created_at as assigneedate,tblticketassigneedetails.*')
                        ->leftJoin('tblcustomermaster', 'tblcustomermaster.customercode', '=', 'tblexistingcustomercomplaintlodging.customercode')
                        ->leftJoin('tblticketassigneedetails', 'tblticketassigneedetails.ticketno', '=', 'tblexistingcustomercomplaintlodging.ticketno')
                        ->leftJoin('tblassigneemaster', 'tblassigneemaster.assigneecode', '=', 'tblticketassigneedetails.assigneecode')
                        ->leftJoin('tblproductservicemaster', 'tblproductservicemaster.productservicecode', '=', 'tblexistingcustomercomplaintlodging.productservicecode')
                        ->where($dynamicolumn,'>=',$fromdate)
                        ->where($dynamicolumn,'<=',$increfromdatedate)
                        ->get();
                }
            }
            else {
                if($assigneesname !=""){
                    $idata =  ExistingUserComplaintLodging::selectRaw('tblexistingcustomercomplaintlodging.*,tblproductservicemaster.productservicename,tblcustomermaster.customername,tblcustomermaster.customertype,tblcustomermaster.contactpersonname,tblcustomermaster.contactpersonphone,tblassigneemaster.assigneename,tblticketassigneedetails.*')
                        ->leftJoin('tblcustomermaster', 'tblcustomermaster.customercode', '=', 'tblexistingcustomercomplaintlodging.customercode')
                        ->leftJoin('tblticketassigneedetails', 'tblticketassigneedetails.ticketno', '=', 'tblexistingcustomercomplaintlodging.ticketno')
                        ->leftJoin('tblassigneemaster', 'tblassigneemaster.assigneecode', '=', 'tblticketassigneedetails.assigneecode')
                        ->leftJoin('tblproductservicemaster', 'tblproductservicemaster.productservicecode', '=', 'tblexistingcustomercomplaintlodging.productservicecode')
                        ->where($dynamicolumn,'>=',$fromdate)
                        ->where($dynamicolumn,'<=',$todate)
                        ->where('tblticketassigneedetails.assigneecode','=',$assigneesname)
                        ->get();
                }
                else{
                    $idata =  ExistingUserComplaintLodging::selectRaw('tblexistingcustomercomplaintlodging.*,tblproductservicemaster.productservicename,tblcustomermaster.customername,tblcustomermaster.customertype,tblcustomermaster.contactpersonname,tblcustomermaster.contactpersonphone,tblassigneemaster.assigneename,tblticketassigneedetails.*')
                        ->leftJoin('tblcustomermaster', 'tblcustomermaster.customercode', '=', 'tblexistingcustomercomplaintlodging.customercode')
                        ->leftJoin('tblticketassigneedetails', 'tblticketassigneedetails.ticketno', '=', 'tblexistingcustomercomplaintlodging.ticketno')
                        ->leftJoin('tblassigneemaster', 'tblassigneemaster.assigneecode', '=', 'tblticketassigneedetails.assigneecode')
                        ->leftJoin('tblproductservicemaster', 'tblproductservicemaster.productservicecode', '=', 'tblexistingcustomercomplaintlodging.productservicecode')
                        ->where($dynamicolumn,'>=',$fromdate)
                        ->where($dynamicolumn,'<=',$todate)
                        ->get();
                }
            }
        }
        elseif ($complaintstatus !="" && $fromdate=="" && $todate==""){
            if($complaintstatus == 'ASSIGNED'){
                $idata =  ExistingUserComplaintLodging::selectRaw('tblexistingcustomercomplaintlodging.*,tblproductservicemaster.productservicename,tblcustomermaster.customername,tblcustomermaster.customertype,tblcustomermaster.contactpersonname,tblcustomermaster.contactpersonphone,tblassigneemaster.assigneename,tblticketassigneedetails.*')
                    ->leftJoin('tblcustomermaster', 'tblcustomermaster.customercode', '=', 'tblexistingcustomercomplaintlodging.customercode')
                    ->leftJoin('tblticketassigneedetails', 'tblticketassigneedetails.ticketno', '=', 'tblexistingcustomercomplaintlodging.ticketno')
                    ->leftJoin('tblassigneemaster', 'tblassigneemaster.assigneecode', '=', 'tblticketassigneedetails.assigneecode')
                    ->leftJoin('tblproductservicemaster', 'tblproductservicemaster.productservicecode', '=', 'tblexistingcustomercomplaintlodging.productservicecode')
                    ->where('complaintstatus','=',$complaintstatus)
                    ->where('assigneestatus','!=','PENDING')
                    ->where('assigneestatus','!=','NOT RESOLVED')
                    ->where('assigneestatus','!=','UnresolvedReassigned')
                    ->get();
            }
            elseif($complaintstatus == 'PENDING'){
                $idata =  ExistingUserComplaintLodging::selectRaw('tblexistingcustomercomplaintlodging.*,tblproductservicemaster.productservicename,tblcustomermaster.customername,tblcustomermaster.customertype,tblcustomermaster.contactpersonname,tblcustomermaster.contactpersonphone,tblassigneemaster.assigneename,tblticketassigneedetails.*')
                    ->leftJoin('tblcustomermaster', 'tblcustomermaster.customercode', '=', 'tblexistingcustomercomplaintlodging.customercode')
                    ->leftJoin('tblticketassigneedetails', 'tblticketassigneedetails.ticketno', '=', 'tblexistingcustomercomplaintlodging.ticketno')
                    ->leftJoin('tblassigneemaster', 'tblassigneemaster.assigneecode', '=', 'tblticketassigneedetails.assigneecode')
                    ->leftJoin('tblproductservicemaster', 'tblproductservicemaster.productservicecode', '=', 'tblexistingcustomercomplaintlodging.productservicecode')
                    ->where('complaintstatus','=','ASSIGNED')
                    ->where('assigneestatus','=',$complaintstatus)
                    ->get();
            }
            elseif($complaintstatus == 'ACKNOWLEDGED'){
                $idata =  ExistingUserComplaintLodging::selectRaw('tblexistingcustomercomplaintlodging.*,tblproductservicemaster.productservicename,tblcustomermaster.customername,tblcustomermaster.customertype,tblcustomermaster.contactpersonname,tblcustomermaster.contactpersonphone')
                    ->leftJoin('tblcustomermaster', 'tblcustomermaster.customercode', '=', 'tblexistingcustomercomplaintlodging.customercode')
//                    ->leftJoin('tblticketassigneedetails', 'tblticketassigneedetails.ticketno', '=', 'tblexistingcustomercomplaintlodging.ticketno')
//                    ->leftJoin('tblassigneemaster', 'tblassigneemaster.assigneecode', '=', 'tblticketassigneedetails.assigneecode')
                    ->leftJoin('tblproductservicemaster', 'tblproductservicemaster.productservicecode', '=', 'tblexistingcustomercomplaintlodging.productservicecode')
                    ->where('complaintstatus','=',$complaintstatus)
                    ->get();
            }
            elseif($complaintstatus == 'CLOSED'){
                $idata =  ExistingUserComplaintLodging::selectRaw('tblexistingcustomercomplaintlodging.*,tblproductservicemaster.productservicename,tblcustomermaster.customername,tblcustomermaster.customertype,tblcustomermaster.contactpersonname,tblcustomermaster.contactpersonphone,tblassigneemaster.assigneename,tblticketassigneedetails.assigneecode')
                    ->leftJoin('tblcustomermaster', 'tblcustomermaster.customercode', '=', 'tblexistingcustomercomplaintlodging.customercode')
                    ->leftJoin('tblticketassigneedetails', 'tblticketassigneedetails.ticketno', '=', 'tblexistingcustomercomplaintlodging.ticketno')
                    ->leftJoin('tblassigneemaster', 'tblassigneemaster.assigneecode', '=', 'tblticketassigneedetails.assigneecode')
                    ->leftJoin('tblproductservicemaster', 'tblproductservicemaster.productservicecode', '=', 'tblexistingcustomercomplaintlodging.productservicecode')
                    ->where('complaintstatus','=',$complaintstatus)
//                    ->orWhere('complaintstatus','=','ClosedByAdmin')
                    ->get();
            }
            elseif($complaintstatus == 'RESOLVED'){
                $idata =  ExistingUserComplaintLodging::selectRaw('tblexistingcustomercomplaintlodging.*,tblproductservicemaster.productservicename,tblcustomermaster.customername,tblcustomermaster.customertype,tblcustomermaster.contactpersonname,tblcustomermaster.contactpersonphone,tblassigneemaster.assigneename,tblticketassigneedetails.*')
                    ->leftJoin('tblcustomermaster', 'tblcustomermaster.customercode', '=', 'tblexistingcustomercomplaintlodging.customercode')
                    ->leftJoin('tblticketassigneedetails', 'tblticketassigneedetails.ticketno', '=', 'tblexistingcustomercomplaintlodging.ticketno')
                    ->leftJoin('tblassigneemaster', 'tblassigneemaster.assigneecode', '=', 'tblticketassigneedetails.assigneecode')
                    ->leftJoin('tblproductservicemaster', 'tblproductservicemaster.productservicecode', '=', 'tblexistingcustomercomplaintlodging.productservicecode')
                    ->where('complaintstatus','=',$complaintstatus)
                    ->get();
            }
            else {
                $idata = ExistingUserComplaintLodging::selectRaw('tblexistingcustomercomplaintlodging.*,tblproductservicemaster.productservicename,tblcustomermaster.customername,tblcustomermaster.customertype,tblcustomermaster.contactpersonname,tblcustomermaster.contactpersonphone,tblassigneemaster.assigneename,tblticketassigneedetails.*')
                    ->leftJoin('tblcustomermaster', 'tblcustomermaster.customercode', '=', 'tblexistingcustomercomplaintlodging.customercode')
                    ->leftJoin('tblticketassigneedetails', 'tblticketassigneedetails.ticketno', '=', 'tblexistingcustomercomplaintlodging.ticketno')
                    ->leftJoin('tblassigneemaster', 'tblassigneemaster.assigneecode', '=', 'tblticketassigneedetails.assigneecode')
                    ->leftJoin('tblproductservicemaster', 'tblproductservicemaster.productservicecode', '=', 'tblexistingcustomercomplaintlodging.productservicecode')
                    ->where('assigneestatus', '=', $complaintstatus)
                    ->get();
            }
        }
        elseif ($assigneesname !="" && $complaintstatus =="" && $fromdate=="" && $todate=="") {
            $idata =  ExistingUserComplaintLodging::selectRaw('tblexistingcustomercomplaintlodging.*,tblproductservicemaster.productservicename,tblcustomermaster.customername,tblcustomermaster.customertype,tblcustomermaster.contactpersonname,tblcustomermaster.contactpersonphone,tblassigneemaster.assigneename,tblticketassigneedetails.*')
                ->leftJoin('tblcustomermaster', 'tblcustomermaster.customercode', '=', 'tblexistingcustomercomplaintlodging.customercode')
                ->leftJoin('tblticketassigneedetails', 'tblticketassigneedetails.ticketno', '=', 'tblexistingcustomercomplaintlodging.ticketno')
                ->leftJoin('tblassigneemaster', 'tblassigneemaster.assigneecode', '=', 'tblticketassigneedetails.assigneecode')
                ->leftJoin('tblproductservicemaster', 'tblproductservicemaster.productservicecode', '=', 'tblexistingcustomercomplaintlodging.productservicecode')
                ->where('tblticketassigneedetails.assigneecode','=',$assigneesname)
                ->get();
        }

        elseif ($fromdate !="" && $todate !="" && $complaintstatus !="" && $assigneesname =="") {
            if($complaintstatus == 'ASSIGNED'){
                $start = new Carbon($todate);
                $increfromdatedate = $start->modify('+1 day');
                $idata = ExistingUserComplaintLodging::selectRaw('tblexistingcustomercomplaintlodging.*,tblproductservicemaster.productservicename,tblcustomermaster.customername,tblcustomermaster.customertype,tblcustomermaster.contactpersonname,tblcustomermaster.contactpersonphone,tblassigneemaster.assigneename,tblticketassigneedetails.*')
                    ->leftJoin('tblcustomermaster', 'tblcustomermaster.customercode', '=', 'tblexistingcustomercomplaintlodging.customercode')
                    ->leftJoin('tblticketassigneedetails', 'tblticketassigneedetails.ticketno', '=', 'tblexistingcustomercomplaintlodging.ticketno')
                    ->leftJoin('tblassigneemaster', 'tblassigneemaster.assigneecode', '=', 'tblticketassigneedetails.assigneecode')
                    ->leftJoin('tblproductservicemaster', 'tblproductservicemaster.productservicecode', '=', 'tblexistingcustomercomplaintlodging.productservicecode')
                    ->where($dynamicolumn, '>=', $fromdate)
                    ->where($dynamicolumn, '<=', $increfromdatedate)
                    ->where('complaintstatus', '=', $complaintstatus)
                    ->where('assigneestatus', '!=','PENDING')
                    ->where('assigneestatus', '!=','NOT RESOLVED')
                    ->where('assigneestatus', '!=','UnresolvedReassigned')
                    ->get();
            }
            elseif($complaintstatus == 'PENDING'){
                $start = new Carbon($todate);
                $increfromdatedate = $start->modify('+1 day');
                $idata = ExistingUserComplaintLodging::selectRaw('tblexistingcustomercomplaintlodging.*,tblproductservicemaster.productservicename,tblcustomermaster.customername,tblcustomermaster.customertype,tblcustomermaster.contactpersonname,tblcustomermaster.contactpersonphone,tblassigneemaster.assigneename,tblticketassigneedetails.*')
                    ->leftJoin('tblcustomermaster', 'tblcustomermaster.customercode', '=', 'tblexistingcustomercomplaintlodging.customercode')
                    ->leftJoin('tblticketassigneedetails', 'tblticketassigneedetails.ticketno', '=', 'tblexistingcustomercomplaintlodging.ticketno')
                    ->leftJoin('tblassigneemaster', 'tblassigneemaster.assigneecode', '=', 'tblticketassigneedetails.assigneecode')
                    ->leftJoin('tblproductservicemaster', 'tblproductservicemaster.productservicecode', '=', 'tblexistingcustomercomplaintlodging.productservicecode')
                    ->where($dynamicolumn, '>=', $fromdate)
                    ->where($dynamicolumn, '<=', $increfromdatedate)
                    ->where('complaintstatus', '=', 'ASSIGNED')
                    ->where('assigneestatus', '=',$complaintstatus)
                    ->get();
            }
            elseif($complaintstatus == 'ACKNOWLEDGED') {
                $start = new Carbon($todate);
                $increfromdatedate = $start->modify('+1 day');
                $idata = ExistingUserComplaintLodging::selectRaw('tblexistingcustomercomplaintlodging.*,tblproductservicemaster.productservicename,tblcustomermaster.customername,tblcustomermaster.customertype,tblcustomermaster.contactpersonname,tblcustomermaster.contactpersonphone   ')
                    ->leftJoin('tblcustomermaster', 'tblcustomermaster.customercode', '=', 'tblexistingcustomercomplaintlodging.customercode')
//                    ->leftJoin('tblticketassigneedetails', 'tblticketassigneedetails.ticketno', '=', 'tblexistingcustomercomplaintlodging.ticketno')
//                    ->leftJoin('tblassigneemaster', 'tblassigneemaster.assigneecode', '=', 'tblticketassigneedetails.assigneecode')
                    ->leftJoin('tblproductservicemaster', 'tblproductservicemaster.productservicecode', '=', 'tblexistingcustomercomplaintlodging.productservicecode')
                    ->where($dynamicolumn, '>=', $fromdate)
                    ->where($dynamicolumn, '<=', $increfromdatedate)
                    ->Where('complaintstatus', '=', $complaintstatus)
                    ->get();
            }
            elseif($complaintstatus == 'CLOSED'){
                $start = new Carbon($todate);
                $increfromdatedate = $start->modify('+1 day');
                $idata = ExistingUserComplaintLodging::selectRaw('tblexistingcustomercomplaintlodging.*,tblproductservicemaster.productservicename,tblcustomermaster.customername,tblcustomermaster.customertype,tblcustomermaster.contactpersonname,tblcustomermaster.contactpersonphone,tblassigneemaster.assigneename,tblticketassigneedetails.assigneecode')
                    ->leftJoin('tblcustomermaster', 'tblcustomermaster.customercode', '=', 'tblexistingcustomercomplaintlodging.customercode')
                    ->leftJoin('tblticketassigneedetails', 'tblexistingcustomercomplaintlodging.ticketno', '=', 'tblticketassigneedetails.ticketno')
                    ->leftJoin('tblassigneemaster', 'tblassigneemaster.assigneecode', '=', 'tblticketassigneedetails.assigneecode')
                    ->leftJoin('tblproductservicemaster', 'tblproductservicemaster.productservicecode', '=', 'tblexistingcustomercomplaintlodging.productservicecode')
                    ->where($dynamicolumn, '>=', $fromdate)
                    ->where($dynamicolumn, '<=', $increfromdatedate)
                    ->Where('complaintstatus', '=',$complaintstatus)
//                    ->orWhere('complaintstatus','=','ClosedByAdmin')
                    ->get();
            }
            elseif($complaintstatus == 'RESOLVED'){
                $start = new Carbon($todate);
                $increfromdatedate = $start->modify('+1 day');
                $idata = ExistingUserComplaintLodging::selectRaw('tblexistingcustomercomplaintlodging.*,tblproductservicemaster.productservicename,tblcustomermaster.customername,tblcustomermaster.customertype,tblcustomermaster.contactpersonname,tblcustomermaster.contactpersonphone,tblassigneemaster.assigneename,tblticketassigneedetails.*')
                    ->leftJoin('tblcustomermaster', 'tblcustomermaster.customercode', '=', 'tblexistingcustomercomplaintlodging.customercode')
                    ->leftJoin('tblticketassigneedetails', 'tblticketassigneedetails.ticketno', '=', 'tblexistingcustomercomplaintlodging.ticketno')
                    ->leftJoin('tblassigneemaster', 'tblassigneemaster.assigneecode', '=', 'tblticketassigneedetails.assigneecode')
                    ->leftJoin('tblproductservicemaster', 'tblproductservicemaster.productservicecode', '=', 'tblexistingcustomercomplaintlodging.productservicecode')
                    ->where($dynamicolumn, '>=', $fromdate)
                    ->where($dynamicolumn, '<=', $increfromdatedate)
                    ->Where('complaintstatus', '=',$complaintstatus)
                    ->get();
            }
            else{
                $start = new Carbon($todate);
                $increfromdatedate = $start->modify('+1 day');
                $idata = ExistingUserComplaintLodging::selectRaw('tblexistingcustomercomplaintlodging.*,tblproductservicemaster.productservicename,tblcustomermaster.customername,tblcustomermaster.customertype,tblcustomermaster.contactpersonname,tblcustomermaster.contactpersonphone,tblassigneemaster.assigneename,tblticketassigneedetails.*')
                    ->leftJoin('tblcustomermaster', 'tblcustomermaster.customercode', '=', 'tblexistingcustomercomplaintlodging.customercode')
                    ->leftJoin('tblticketassigneedetails', 'tblticketassigneedetails.ticketno', '=', 'tblexistingcustomercomplaintlodging.ticketno')
                    ->leftJoin('tblassigneemaster', 'tblassigneemaster.assigneecode', '=', 'tblticketassigneedetails.assigneecode')
                    ->leftJoin('tblproductservicemaster', 'tblproductservicemaster.productservicecode', '=', 'tblexistingcustomercomplaintlodging.productservicecode')
                    ->where($dynamicolumn, '>=', $fromdate)
                    ->where($dynamicolumn, '<=', $increfromdatedate)
                    ->where('assigneestatus', '=', $complaintstatus)
                    ->get();
            }
        }
        else{
            if($fromdate == $todate){
                if($complaintstatus == 'ASSIGNED'){
                    $start = new Carbon($todate);
                    $increfromdatedate=$start->modify('+1 day');
                    $idata = ExistingUserComplaintLodging::selectRaw('tblexistingcustomercomplaintlodging.*,tblproductservicemaster.productservicename,tblcustomermaster.customername,tblcustomermaster.customertype,tblcustomermaster.contactpersonname,tblcustomermaster.contactpersonphone,tblassigneemaster.assigneename,tblticketassigneedetails.*')
                        ->leftJoin('tblcustomermaster', 'tblcustomermaster.customercode', '=', 'tblexistingcustomercomplaintlodging.customercode')
                        ->leftJoin('tblticketassigneedetails', 'tblticketassigneedetails.ticketno', '=', 'tblexistingcustomercomplaintlodging.ticketno')
                        ->leftJoin('tblassigneemaster', 'tblassigneemaster.assigneecode', '=', 'tblticketassigneedetails.assigneecode')
                        ->leftJoin('tblproductservicemaster', 'tblproductservicemaster.productservicecode', '=', 'tblexistingcustomercomplaintlodging.productservicecode')
                        ->where($dynamicolumn, '>=', $fromdate)
                        ->where($dynamicolumn, '<=', $increfromdatedate)
                        ->where('complaintstatus', '=', $complaintstatus)
                        ->where('assigneestatus','!=','PENDING')
                        ->where('assigneestatus','!=','NOT RESOLVED')
                        ->where('assigneestatus','!=','UnresolvedReassigned')
                        ->where('tblticketassigneedetails.assigneecode', '=', $assigneesname)
                        ->get();
                }
                elseif($complaintstatus == 'PENDING'){
                    $start = new Carbon($todate);
                    $increfromdatedate=$start->modify('+1 day');
                    $idata = ExistingUserComplaintLodging::selectRaw('tblexistingcustomercomplaintlodging.*,tblproductservicemaster.productservicename,tblcustomermaster.customername,tblcustomermaster.customertype,tblcustomermaster.contactpersonname,tblcustomermaster.contactpersonphone,tblassigneemaster.assigneename,tblticketassigneedetails.*')
                        ->leftJoin('tblcustomermaster', 'tblcustomermaster.customercode', '=', 'tblexistingcustomercomplaintlodging.customercode')
                        ->leftJoin('tblticketassigneedetails', 'tblticketassigneedetails.ticketno', '=', 'tblexistingcustomercomplaintlodging.ticketno')
                        ->leftJoin('tblassigneemaster', 'tblassigneemaster.assigneecode', '=', 'tblticketassigneedetails.assigneecode')
                        ->leftJoin('tblproductservicemaster', 'tblproductservicemaster.productservicecode', '=', 'tblexistingcustomercomplaintlodging.productservicecode')
                        ->where($dynamicolumn, '>=', $fromdate)
                        ->where($dynamicolumn, '<=', $increfromdatedate)
                        ->where('complaintstatus', '=', 'ASSIGNED')
                        ->where('assigneestatus','=',$complaintstatus)
                        ->where('tblticketassigneedetails.assigneecode', '=', $assigneesname)
                        ->get();
                }
                elseif($complaintstatus == 'ACKNOWLEDGED'){
                    $start = new Carbon($todate);
                    $increfromdatedate=$start->modify('+1 day');
                    $idata = ExistingUserComplaintLodging::selectRaw('tblexistingcustomercomplaintlodging.*,tblproductservicemaster.productservicename,tblcustomermaster.customername,tblcustomermaster.customertype,tblcustomermaster.contactpersonname,tblcustomermaster.contactpersonphone')
                        ->leftJoin('tblcustomermaster', 'tblcustomermaster.customercode', '=', 'tblexistingcustomercomplaintlodging.customercode')
//                        ->leftJoin('tblticketassigneedetails', 'tblticketassigneedetails.ticketno', '=', 'tblexistingcustomercomplaintlodging.ticketno')
//                        ->leftJoin('tblassigneemaster', 'tblassigneemaster.assigneecode', '=', 'tblticketassigneedetails.assigneecode')
                        ->leftJoin('tblproductservicemaster', 'tblproductservicemaster.productservicecode', '=', 'tblexistingcustomercomplaintlodging.productservicecode')
                        ->where($dynamicolumn, '>=', $fromdate)
                        ->where($dynamicolumn, '<=', $increfromdatedate)
                        ->where('complaintstatus','=',$complaintstatus)
//                        ->where('tblticketassigneedetails.assigneecode', '=', $assigneesname)
                        ->get();
                }
                elseif($complaintstatus == 'CLOSED'){
                    $start = new Carbon($todate);
                    $increfromdatedate=$start->modify('+1 day');
                    $idata = ExistingUserComplaintLodging::selectRaw('tblexistingcustomercomplaintlodging.*,tblproductservicemaster.productservicename,tblcustomermaster.customername,tblcustomermaster.customertype,tblcustomermaster.contactpersonname,tblcustomermaster.contactpersonphone,tblassigneemaster.assigneename,tblticketassigneedetails.*')
                        ->leftJoin('tblcustomermaster', 'tblcustomermaster.customercode', '=', 'tblexistingcustomercomplaintlodging.customercode')
                        ->leftJoin('tblticketassigneedetails', 'tblticketassigneedetails.ticketno', '=', 'tblexistingcustomercomplaintlodging.ticketno')
                        ->leftJoin('tblassigneemaster', 'tblassigneemaster.assigneecode', '=', 'tblticketassigneedetails.assigneecode')
                        ->leftJoin('tblproductservicemaster', 'tblproductservicemaster.productservicecode', '=', 'tblexistingcustomercomplaintlodging.productservicecode')
                        ->where($dynamicolumn, '>=', $fromdate)
                        ->where($dynamicolumn, '<=', $increfromdatedate)
                        ->where('complaintstatus','=',$complaintstatus)
                        ->orWhere('complaintstatus','=','ClosedByAdmin')
                        ->where('tblticketassigneedetails.assigneecode', '=', $assigneesname)
                        ->get();
                }
                elseif($complaintstatus == 'RESOLVED'){
                    $start = new Carbon($todate);
                    $increfromdatedate=$start->modify('+1 day');
                    $idata = ExistingUserComplaintLodging::selectRaw('tblexistingcustomercomplaintlodging.*,tblproductservicemaster.productservicename,tblcustomermaster.customername,tblcustomermaster.customertype,tblcustomermaster.contactpersonname,tblcustomermaster.contactpersonphone,tblassigneemaster.assigneename,tblticketassigneedetails.*')
                        ->leftJoin('tblcustomermaster', 'tblcustomermaster.customercode', '=', 'tblexistingcustomercomplaintlodging.customercode')
                        ->leftJoin('tblticketassigneedetails', 'tblticketassigneedetails.ticketno', '=', 'tblexistingcustomercomplaintlodging.ticketno')
                        ->leftJoin('tblassigneemaster', 'tblassigneemaster.assigneecode', '=', 'tblticketassigneedetails.assigneecode')
                        ->leftJoin('tblproductservicemaster', 'tblproductservicemaster.productservicecode', '=', 'tblexistingcustomercomplaintlodging.productservicecode')
                        ->where($dynamicolumn, '>=', $fromdate)
                        ->where($dynamicolumn, '<=', $increfromdatedate)
                        ->where('complaintstatus','=',$complaintstatus)
                        ->where('tblticketassigneedetails.assigneecode', '=', $assigneesname)
                        ->get();
                }
                else{
                    $start = new Carbon($todate);
                    $increfromdatedate=$start->modify('+1 day');
                    $idata =  ExistingUserComplaintLodging::selectRaw('tblexistingcustomercomplaintlodging.*,tblproductservicemaster.productservicename,tblcustomermaster.customername,tblcustomermaster.customertype,tblcustomermaster.contactpersonname,tblcustomermaster.contactpersonphone,tblassigneemaster.assigneename,tblticketassigneedetails.*')
                        ->leftJoin('tblcustomermaster', 'tblcustomermaster.customercode', '=', 'tblexistingcustomercomplaintlodging.customercode')
                        ->leftJoin('tblticketassigneedetails', 'tblticketassigneedetails.ticketno', '=', 'tblexistingcustomercomplaintlodging.ticketno')
                        ->leftJoin('tblassigneemaster', 'tblassigneemaster.assigneecode', '=', 'tblticketassigneedetails.assigneecode')
                        ->leftJoin('tblproductservicemaster', 'tblproductservicemaster.productservicecode', '=', 'tblexistingcustomercomplaintlodging.productservicecode')
                        ->where($dynamicolumn,'>=',$fromdate)
                        ->where($dynamicolumn,'<=',$increfromdatedate)
                        ->where('assigneestatus','=',$complaintstatus)
                        ->where('tblticketassigneedetails.assigneecode','=',$assigneesname)
                        ->get();
                }
            }
            else {
                if($complaintstatus == 'ASSIGNED') {
                    $idata = ExistingUserComplaintLodging::selectRaw('tblexistingcustomercomplaintlodging.*,tblproductservicemaster.productservicename,tblcustomermaster.customername,tblcustomermaster.customertype,tblcustomermaster.contactpersonname,tblcustomermaster.contactpersonphone,tblassigneemaster.assigneename,tblticketassigneedetails.*')
                        ->leftJoin('tblcustomermaster', 'tblcustomermaster.customercode', '=', 'tblexistingcustomercomplaintlodging.customercode')
                        ->leftJoin('tblticketassigneedetails', 'tblticketassigneedetails.ticketno', '=', 'tblexistingcustomercomplaintlodging.ticketno')
                        ->leftJoin('tblassigneemaster', 'tblassigneemaster.assigneecode', '=', 'tblticketassigneedetails.assigneecode')
                        ->leftJoin('tblproductservicemaster', 'tblproductservicemaster.productservicecode', '=', 'tblexistingcustomercomplaintlodging.productservicecode')
                        ->where($dynamicolumn, '>=', $fromdate)
                        ->where($dynamicolumn, '<=', $todate)
                        ->where('complaintstatus', '=', $complaintstatus)
                        ->where('assigneestatus','!=','PENDING')
                        ->where('assigneestatus','!=','NOT RESOLVED')
                        ->where('assigneestatus','!=','UnresolvedReassigned')
                        ->where('tblticketassigneedetails.assigneecode', '=', $assigneesname)
                        ->get();
                }
                elseif($complaintstatus == 'PENDING'){
                    $idata = ExistingUserComplaintLodging::selectRaw('tblexistingcustomercomplaintlodging.*,tblproductservicemaster.productservicename,tblcustomermaster.customername,tblcustomermaster.customertype,tblcustomermaster.contactpersonname,tblcustomermaster.contactpersonphone,tblassigneemaster.assigneename,tblticketassigneedetails.*')
                        ->leftJoin('tblcustomermaster', 'tblcustomermaster.customercode', '=', 'tblexistingcustomercomplaintlodging.customercode')
                        ->leftJoin('tblticketassigneedetails', 'tblticketassigneedetails.ticketno', '=', 'tblexistingcustomercomplaintlodging.ticketno')
                        ->leftJoin('tblassigneemaster', 'tblassigneemaster.assigneecode', '=', 'tblticketassigneedetails.assigneecode')
                        ->leftJoin('tblproductservicemaster', 'tblproductservicemaster.productservicecode', '=', 'tblexistingcustomercomplaintlodging.productservicecode')
                        ->where($dynamicolumn, '>=', $fromdate)
                        ->where($dynamicolumn, '<=', $todate)
                        ->where('complaintstatus', '=', 'ASSIGNED')
                        ->where('assigneestatus','=',$complaintstatus)
                        ->where('tblticketassigneedetails.assigneecode', '=', $assigneesname)
                        ->get();
                }
                elseif($complaintstatus == 'ACKNOWLEDGED'){
                    $idata = ExistingUserComplaintLodging::selectRaw('tblexistingcustomercomplaintlodging.*,tblproductservicemaster.productservicename,tblcustomermaster.customername,tblcustomermaster.customertype,tblcustomermaster.contactpersonname,tblcustomermaster.contactpersonphone')
                        ->leftJoin('tblcustomermaster', 'tblcustomermaster.customercode', '=', 'tblexistingcustomercomplaintlodging.customercode')
//                        ->leftJoin('tblticketassigneedetails', 'tblticketassigneedetails.ticketno', '=', 'tblexistingcustomercomplaintlodging.ticketno')
//                        ->leftJoin('tblassigneemaster', 'tblassigneemaster.assigneecode', '=', 'tblticketassigneedetails.assigneecode')
                        ->leftJoin('tblproductservicemaster', 'tblproductservicemaster.productservicecode', '=', 'tblexistingcustomercomplaintlodging.productservicecode')
                        ->where($dynamicolumn, '>=', $fromdate)
                        ->where($dynamicolumn, '<=', $todate)
                        ->where('complaintstatus','=',$complaintstatus)
//                        ->where('tblticketassigneedetails.assigneecode', '=', $assigneesname)
                        ->get();
                }
                elseif($complaintstatus == 'CLOSED'){
                    $idata = ExistingUserComplaintLodging::selectRaw('tblexistingcustomercomplaintlodging.*,tblproductservicemaster.productservicename,tblcustomermaster.customername,tblcustomermaster.customertype,tblcustomermaster.contactpersonname,tblcustomermaster.contactpersonphone,tblassigneemaster.assigneename,tblticketassigneedetails.*')
                        ->leftJoin('tblcustomermaster', 'tblcustomermaster.customercode', '=', 'tblexistingcustomercomplaintlodging.customercode')
                        ->leftJoin('tblticketassigneedetails', 'tblticketassigneedetails.ticketno', '=', 'tblexistingcustomercomplaintlodging.ticketno')
                        ->leftJoin('tblassigneemaster', 'tblassigneemaster.assigneecode', '=', 'tblticketassigneedetails.assigneecode')
                        ->leftJoin('tblproductservicemaster', 'tblproductservicemaster.productservicecode', '=', 'tblexistingcustomercomplaintlodging.productservicecode')
                        ->where($dynamicolumn, '>=', $fromdate)
                        ->where($dynamicolumn, '<=', $todate)
                        ->where('complaintstatus','=',$complaintstatus)
//                        ->orWhere('assigneestatus','=','ClosedByAdmin')
                        ->where('tblticketassigneedetails.assigneecode', '=', $assigneesname)
                        ->get();
                }
                elseif($complaintstatus == 'RESOLVED'){
                    $idata = ExistingUserComplaintLodging::selectRaw('tblexistingcustomercomplaintlodging.*,tblproductservicemaster.productservicename,tblcustomermaster.customername,tblcustomermaster.customertype,tblcustomermaster.contactpersonname,tblcustomermaster.contactpersonphone,tblassigneemaster.assigneename,tblticketassigneedetails.*')
                        ->leftJoin('tblcustomermaster', 'tblcustomermaster.customercode', '=', 'tblexistingcustomercomplaintlodging.customercode')
                        ->leftJoin('tblticketassigneedetails', 'tblticketassigneedetails.ticketno', '=', 'tblexistingcustomercomplaintlodging.ticketno')
                        ->leftJoin('tblassigneemaster', 'tblassigneemaster.assigneecode', '=', 'tblticketassigneedetails.assigneecode')
                        ->leftJoin('tblproductservicemaster', 'tblproductservicemaster.productservicecode', '=', 'tblexistingcustomercomplaintlodging.productservicecode')
                        ->where($dynamicolumn, '>=', $fromdate)
                        ->where($dynamicolumn, '<=', $todate)
                        ->where('complaintstatus','=',$complaintstatus)
                        ->where('tblticketassigneedetails.assigneecode', '=', $assigneesname)
                        ->get();
                }
                else{
                    $start = new Carbon($todate);
                    $increfromdatedate = $start->modify('+1 day');
                    $idata = ExistingUserComplaintLodging::selectRaw('tblexistingcustomercomplaintlodging.*,tblproductservicemaster.productservicename,tblcustomermaster.customername,tblcustomermaster.customertype,tblcustomermaster.contactpersonname,tblcustomermaster.contactpersonphone,tblassigneemaster.assigneename,tblticketassigneedetails.*')
                        ->leftJoin('tblcustomermaster', 'tblcustomermaster.customercode', '=', 'tblexistingcustomercomplaintlodging.customercode')
                        ->leftJoin('tblticketassigneedetails', 'tblticketassigneedetails.ticketno', '=', 'tblexistingcustomercomplaintlodging.ticketno')
                        ->leftJoin('tblassigneemaster', 'tblassigneemaster.assigneecode', '=', 'tblticketassigneedetails.assigneecode')
                        ->leftJoin('tblproductservicemaster', 'tblproductservicemaster.productservicecode', '=', 'tblexistingcustomercomplaintlodging.productservicecode')
                        ->where($dynamicolumn, '>=', $fromdate)
                        ->where($dynamicolumn, '<=', $increfromdatedate)
                        ->where('assigneestatus', '=', $complaintstatus)
                        ->where('tblticketassigneedetails.assigneecode', '=', $assigneesname)
                        ->get();
                }
            }
        }

        $CLOSEDcount = 0;
        $RESOLVEDcount = 0;
        $ASSIGNEDcount = 0;
        $ACKNOWLEDGEDcount = 0;

        foreach ($idata as $post)
        {
            if($post->complaintstatus=="CLOSED"){
                $CLOSEDcount++;
            }
            if($post->complaintstatus=="RESOLVED"){
                $RESOLVEDcount++;
            }
            if($post->complaintstatus=="ACKNOWLEDGED"){
                $ACKNOWLEDGEDcount++;
            }
            if($post->complaintstatus=="ASSIGNED"){
                $ASSIGNEDcount++;
            }
        }

        $count = count($idata);

        $data_array[] = array('COMPLAINT DETAILS');
        $data_array[] = array("Total Records : $count","Received : $ACKNOWLEDGEDcount","Assigned : $ASSIGNEDcount","Resolved : $RESOLVEDcount","Closed : $CLOSEDcount");

        $data_array[] = array('Sr no','Ticket No','Customer Name','Complaint Date','Equipment Name','Equipment No','Description','Status','Assigned Name','Assigned Date',
            'Resolved date','Closed Date');
        $k = 1;
        foreach($idata as $exceldata)
        {
            $data_array[] = array(
                'Sr no.'    =>  $k++,
                'Ticket No'    =>  $exceldata->ticketno,
                'Customer Name'   =>  $exceldata->customername,
                'Complaint Date'   =>  $exceldata->complaintdate,
                'Equipment Name'   =>  $exceldata->productservicename,
                'Equipment No'   =>  $exceldata->productsrno_accountno,
                'Description'   =>  $exceldata->complaintdescription,
                'Status'   =>  $exceldata->complaintstatus,
                'Assigned Name'   =>  $exceldata->assigneename,
                'Assigned Date'   =>  $exceldata->callstartdate,
                'Resolved date'   =>  $exceldata->callenddate,
                'Closed Date'   =>  $exceldata->callclosuredate,
            );

        }

        if($count >0) {
            $count = count($data_array);
            \session()->put('key',$count);
            $new_complaintdata_array = new ComplaintReportExport([$data_array]);
            return Excel::download($new_complaintdata_array, 'Complaint Report.xlsx');
        }
        elseif($count == 0){
            return redirect()->back()->with('alert', 'No Data Found!');
        }
    }

    public function AssigneeIndex(){
        $complaintstatuslist = StatusMasterModel::whereIn('statuscode',array('CP0010','CP0003','CP0002','CP0012','CP0011'))->pluck('statusname','statusname');
        $equipmentsrlist = EquipmentMasterModel::all()->pluck('equipmentsrno','equipmentsrno');
        $assigneesname = AssigneeMasterModel::selectRaw('tblassigneemaster.assigneename,tblassigneemaster.assigneecode,users.id')
                ->join('users','users.assigneecode','=','tblassigneemaster.assigneecode')
                ->where('id' ,'=', Auth::user()->id)
                ->get()->first();
//        $assigneescode = $assigneesname->assigneecode;
        $now = Carbon::today(new DateTimeZone('Asia/Kolkata'));
        $idata =  ExistingUserComplaintLodging::selectRaw('tblexistingcustomercomplaintlodging.*,tblproductservicemaster.productservicename,tblcustomermaster.customername,tblcustomermaster.customertype,tblcustomermaster.contactpersonname,tblcustomermaster.contactpersonphone,tblassigneemaster.assigneename,tblassigneemaster.created_at as assigneedate,tblticketassigneedetails.*')
            ->leftJoin('tblcustomermaster', 'tblcustomermaster.customercode', '=', 'tblexistingcustomercomplaintlodging.customercode')
            ->leftJoin('tblticketassigneedetails', 'tblticketassigneedetails.ticketno', '=', 'tblexistingcustomercomplaintlodging.ticketno')
            ->leftJoin('tblassigneemaster', 'tblassigneemaster.assigneecode', '=', 'tblticketassigneedetails.assigneecode')
            ->leftJoin('tblproductservicemaster', 'tblproductservicemaster.productservicecode', '=', 'tblexistingcustomercomplaintlodging.productservicecode')
            ->where('complaintdate','>=',$now)
            ->get();

        $CLOSEDcount = 0;
        $RESOLVEDcount = 0;
        $ASSIGNEDcount = 0;
        $ACKNOWLEDGEDcount = 0;

        foreach ($idata as $post)
        {
            if($post->complaintstatus=="CLOSED"){
                $CLOSEDcount++;
            }
            if($post->complaintstatus=="RESOLVED"){
                $RESOLVEDcount++;
            }
            if($post->complaintstatus=="ACKNOWLEDGED"){
                $ACKNOWLEDGEDcount++;
            }
            if($post->complaintstatus=="ASSIGNED"){
                $ASSIGNEDcount++;
            }
        }
//        return $assigneesname;
        return view('Report.assigneereport',compact('complaintstatuslist','equipmentsrlist','assigneesname','now','idata','CLOSEDcount','RESOLVEDcount','ACKNOWLEDGEDcount','ASSIGNEDcount'));
    }

    public function contractReport(){

        $now = Carbon::today(new DateTimeZone('Asia/Kolkata'));
        $customers = ContractMasterModel::selectRaw('tblcontractmaster.*,tblcustomermaster.customercode,tblcustomermaster.customername')
            ->leftjoin('tblcustomermaster','tblcustomermaster.customercode','=','tblcontractmaster.customercode')
            ->whereNull('tblcontractmaster.closuredate')
            ->pluck('customername','customercode');

        $productlist = ProductServiceMasterModel::selectRaw('tblproductservicemaster.productservicecode,tblproductservicemaster.productservicename')
            ->where('productservicecode','=','CO0002')
            ->Orwhere('productservicecode','=','PR0001')
            ->Orwhere('productservicecode','=','SC0009')
            ->Orwhere('productservicecode','=','SE0007')
            ->pluck('productservicename','productservicecode');

        return view('Report.contractReport',compact('now','customers','productlist'));
    }

    public function getBranchsCustomerWise($customerid){
        $branchlist = BranchMasterModel::where('customercode',$customerid)->distinct()->get();
        return json_encode($branchlist);
    }

    public function contractdata()
    {
        $table = DB::select('CALL `stp_contractReport`()');
        return json_encode(array('idata'=>$table));
    }

    public function contractFilters(){
        $customercode = $_GET['customers'];
        if($customercode != ""){
            $customername = CustomersModel::select('customername')->where('customercode','=',$customercode)->get()->first();
        }
        else{
            $customername = "";
        }
        $branchcode = $_GET['departmentid'];
        if($branchcode != ""){
            $branchname = BranchMasterModel::select('branchname')->where('branchcode','=',$branchcode)->get()->first();
        }
        else{
            $branchname = "";
        }
        $equipmentcode = $_GET['equipmentid'];
        $workordertype = $_GET['workordertypeid'];
        $fromdate = $_GET['fromdateid'];
        $todate = $_GET['todateid'];


        $table = DB::select('CALL `stp_contractReport`()');

        Schema::create('temp_table', function (Blueprint $table1) {
            $table1->string('contractno')->nullable()->default(NULL);
            $table1->string('customername')->nullable()->default(NULL);
            $table1->string('branchname')->nullable()->default(NULL);
            $table1->integer('pcCount')->nullable()->default(NULL);
            $table1->integer('printerCount')->nullable()->default(NULL);
            $table1->integer('scannerCount')->nullable()->default(NULL);
            $table1->integer('serverCount')->nullable()->default(NULL);
            $table1->string('workorderno')->nullable()->default(NULL);
            $table1->string('workordertype')->nullable()->default(NULL);
            $table1->date('contractfromdate')->nullable()->default(NULL);
            $table1->date('contracttodate')->nullable()->default(NULL);
            $table1->decimal('yearsvalue',17,2)->nullable()->default(NULL);
            $table1->decimal('monthvalue',17,2)->nullable()->default(NULL);
            $table1->decimal('totalcost',17,2)->nullable()->default(NULL);
            $table1->decimal('contractperiod',17,2)->nullable()->default(NULL);
            $table1->timestamps();
            $table1->temporary();
        });
        for($i=0; $i < count($table);$i++) {
            DB::table('temp_table')->insert(['contractno' => $table[$i]->contractno, 'customername' =>  $table[$i]->customername,
                'branchname' =>  $table[$i]->branchname, 'pcCount' =>  $table[$i]->pcCount, 'printerCount' =>  $table[$i]->printerCount,
                'scannerCount' =>  $table[$i]->scannerCount, 'serverCount' =>  $table[$i]->serverCount, 'workorderno' =>  $table[$i]->workorderno,
                'workordertype' =>  $table[$i]->workordertype, 'contractfromdate' =>  $table[$i]->contractfromdate, 'contracttodate' =>  $table[$i]->contracttodate,
                'yearsvalue' =>  $table[$i]->yearsvalue,'monthvalue' =>  $table[$i]->monthvalue,'totalcost' =>  $table[$i]->totalcost,'contractperiod' =>  $table[$i]->contractperiod]);
        }

        $data ="";
        if($customercode != ""){
            if($customercode != "" && $branchcode != "" && $equipmentcode == "" &&  $workordertype == "" && $fromdate == "" && $todate == ""){
                $data = DB::table('temp_table')
                    ->where('customername','=',$customername->customername)
                    ->where('branchname','=',$branchname->branchname)
                    ->get();
            }
            elseif ($customercode != "" && $equipmentcode != "" && $branchcode == "" &&  $workordertype == "" && $fromdate == "" && $todate == ""){
                if($equipmentcode == 'CO0002') {
                    $data = DB::table('temp_table')
                        ->where('customername', '=', $customername->customername)
                        ->where('pcCount', '!=', '')
                        ->get();
                }
                elseif($equipmentcode == 'PR0001'){
                    $data = DB::table('temp_table')
                        ->where('customername', '=', $customername->customername)
                        ->where('printerCount', '!=', '')
                        ->get();
                }
                elseif($equipmentcode == 'SC0009'){
                    $data = DB::table('temp_table')
                        ->where('customername', '=', $customername->customername)
                        ->where('scannerCount', '!=', '')
                        ->get();
                }
                else{
                    $data = DB::table('temp_table')
                        ->where('customername', '=', $customername->customername)
                        ->where('serverCount', '!=', '')
                        ->get();
                }
            }
            elseif($customercode != "" && $workordertype != "" && $branchcode == "" &&  $equipmentcode == "" && $fromdate == "" && $todate == ""){
                $data = DB::table('temp_table')
                        ->where('customername', '=', $customername->customername)
                        ->where('workordertype', '=', $workordertype)
                        ->get();
            }
            elseif($customercode != "" && $fromdate != "" && $todate != "" && $workordertype == "" && $branchcode == "" &&  $equipmentcode == ""){
                $data = DB::table('temp_table')
                    ->where('customername', '=', $customername->customername)
                    ->where('contractfromdate', '>=', $fromdate)
                    ->where('contracttodate', '<=', $todate)
                    ->get();
            }
            elseif($customercode != "" && $branchcode != "" && $equipmentcode != "" &&  $workordertype == "" && $fromdate == "" && $todate == ""){
                if($equipmentcode == 'CO0002') {
                    $data = DB::table('temp_table')
                        ->where('customername', '=', $customername->customername)
                        ->where('branchname','=',$branchname->branchname)
                        ->where('pcCount', '!=', '')
                        ->get();
                }
                elseif($equipmentcode == 'PR0001'){
                    $data = DB::table('temp_table')
                        ->where('customername', '=', $customername->customername)
                        ->where('branchname','=',$branchname->branchname)
                        ->where('printerCount', '!=', '')
                        ->get();
                }
                elseif($equipmentcode == 'SC0009'){
                    $data = DB::table('temp_table')
                        ->where('customername', '=', $customername->customername)
                        ->where('branchname','=',$branchname->branchname)
                        ->where('scannerCount', '!=', '')
                        ->get();
                }
                else{
                    $data = DB::table('temp_table')
                        ->where('customername', '=', $customername->customername)
                        ->where('branchname','=',$branchname->branchname)
                        ->where('serverCount', '!=', '')
                        ->get();
                }
            }
            elseif($customercode != "" && $branchcode != "" && $workordertype != "" &&  $equipmentcode == "" && $fromdate == "" && $todate == ""){
                $data = DB::table('temp_table')
                    ->where('customername', '=', $customername->customername)
                    ->where('branchname','=',$branchname->branchname)
                    ->where('workordertype', '=', $workordertype)
                    ->get();
            }
            elseif($customercode != "" && $branchcode != "" && $fromdate != "" && $todate != "" && $workordertype == "" &&  $equipmentcode == ""){
                $data = DB::table('temp_table')
                    ->where('customername', '=', $customername->customername)
                    ->where('branchname','=',$branchname->branchname)
                    ->where('contractfromdate', '>=', $fromdate)
                    ->where('contracttodate', '<=', $todate)
                    ->get();
            }
            elseif($customercode != "" && $branchcode != "" && $equipmentcode != "" && $workordertype != "" && $fromdate == "" && $todate == ""){
                if($equipmentcode == 'CO0002') {
                    $data = DB::table('temp_table')
                        ->where('customername', '=', $customername->customername)
                        ->where('branchname','=',$branchname->branchname)
                        ->where('workordertype', '=', $workordertype)
                        ->where('pcCount', '!=', '')
                        ->get();
                }
                elseif($equipmentcode == 'PR0001'){
                    $data = DB::table('temp_table')
                        ->where('customername', '=', $customername->customername)
                        ->where('branchname','=',$branchname->branchname)
                        ->where('workordertype', '=', $workordertype)
                        ->where('printerCount', '!=', '')
                        ->get();
                }
                elseif($equipmentcode == 'SC0009'){
                    $data = DB::table('temp_table')
                        ->where('customername', '=', $customername->customername)
                        ->where('branchname','=',$branchname->branchname)
                        ->where('workordertype', '=', $workordertype)
                        ->where('scannerCount', '!=', '')
                        ->get();
                }
                else{
                    $data = DB::table('temp_table')
                        ->where('customername', '=', $customername->customername)
                        ->where('branchname','=',$branchname->branchname)
                        ->where('workordertype', '=', $workordertype)
                        ->where('serverCount', '!=', '')
                        ->get();
                }
            }
            elseif($customercode != "" && $branchcode != "" && $equipmentcode != "" && $fromdate != "" && $todate != "" && $workordertype == ""){
                if($equipmentcode == 'CO0002') {
                    $data = DB::table('temp_table')
                        ->where('customername', '=', $customername->customername)
                        ->where('branchname','=',$branchname->branchname)
                        ->where('contractfromdate', '>=', $fromdate)
                        ->where('contracttodate', '<=', $todate)
                        ->where('pcCount', '!=', '')
                        ->get();
                }
                elseif($equipmentcode == 'PR0001'){
                    $data = DB::table('temp_table')
                        ->where('customername', '=', $customername->customername)
                        ->where('branchname','=',$branchname->branchname)
                        ->where('contractfromdate', '>=', $fromdate)
                        ->where('contracttodate', '<=', $todate)
                        ->where('printerCount', '!=', '')
                        ->get();
                }
                elseif($equipmentcode == 'SC0009'){
                    $data = DB::table('temp_table')
                        ->where('customername', '=', $customername->customername)
                        ->where('branchname','=',$branchname->branchname)
                        ->where('contractfromdate', '>=', $fromdate)
                        ->where('contracttodate', '<=', $todate)
                        ->where('scannerCount', '!=', '')
                        ->get();
                }
                else{
                    $data = DB::table('temp_table')
                        ->where('customername', '=', $customername->customername)
                        ->where('branchname','=',$branchname->branchname)
                        ->where('contractfromdate', '>=', $fromdate)
                        ->where('contracttodate', '<=', $todate)
                        ->where('serverCount', '!=', '')
                        ->get();
                }
            }
            elseif($customercode != "" && $branchcode != "" &&  $workordertype != "" && $fromdate != "" && $todate != "" &&  $equipmentcode == ""){
                $data = DB::table('temp_table')
                    ->where('customername', '=', $customername->customername)
                    ->where('branchname','=',$branchname->branchname)
                    ->where('workordertype', '=', $workordertype)
                    ->where('contractfromdate', '>=', $fromdate)
                    ->where('contracttodate', '<=', $todate)
                    ->get();
            }
            elseif($customercode != "" && $branchcode != "" && $equipmentcode != "" &&  $workordertype != "" && $fromdate != "" && $todate != ""){
                if($equipmentcode == 'CO0002') {
                    $data = DB::table('temp_table')
                        ->where('customername', '=', $customername->customername)
                        ->where('branchname','=',$branchname->branchname)
                        ->where('workordertype', '=', $workordertype)
                        ->where('contractfromdate', '>=', $fromdate)
                        ->where('contracttodate', '<=', $todate)
                        ->where('pcCount', '!=', '')
                        ->get();
                }
                elseif($equipmentcode == 'PR0001'){
                    $data = DB::table('temp_table')
                        ->where('customername', '=', $customername->customername)
                        ->where('branchname','=',$branchname->branchname)
                        ->where('workordertype', '=', $workordertype)
                        ->where('contractfromdate', '>=', $fromdate)
                        ->where('contracttodate', '<=', $todate)
                        ->where('printerCount', '!=', '')
                        ->get();
                }
                elseif($equipmentcode == 'SC0009'){
                    $data = DB::table('temp_table')
                        ->where('customername', '=', $customername->customername)
                        ->where('branchname','=',$branchname->branchname)
                        ->where('workordertype', '=', $workordertype)
                        ->where('contractfromdate', '>=', $fromdate)
                        ->where('contracttodate', '<=', $todate)
                        ->where('scannerCount', '!=', '')
                        ->get();
                }
                else{
                    $data = DB::table('temp_table')
                        ->where('customername', '=', $customername->customername)
                        ->where('branchname','=',$branchname->branchname)
                        ->where('workordertype', '=', $workordertype)
                        ->where('contractfromdate', '>=', $fromdate)
                        ->where('contracttodate', '<=', $todate)
                        ->where('serverCount', '!=', '')
                        ->get();
                }
            }
            elseif($customercode != "" && $equipmentcode != "" &&  $workordertype != "" && $branchcode == "" && $fromdate == "" && $todate == ""){
                if($equipmentcode == 'CO0002') {
                    $data = DB::table('temp_table')
                        ->where('customername', '=', $customername->customername)
                        ->where('workordertype', '=', $workordertype)
                        ->where('pcCount', '!=', '')
                        ->get();
                }
                elseif($equipmentcode == 'PR0001'){
                    $data = DB::table('temp_table')
                        ->where('customername', '=', $customername->customername)
                        ->where('workordertype', '=', $workordertype)
                        ->where('printerCount', '!=', '')
                        ->get();
                }
                elseif($equipmentcode == 'SC0009'){
                    $data = DB::table('temp_table')
                        ->where('customername', '=', $customername->customername)
                        ->where('workordertype', '=', $workordertype)
                        ->where('scannerCount', '!=', '')
                        ->get();
                }
                else{
                    $data = DB::table('temp_table')
                        ->where('customername', '=', $customername->customername)
                        ->where('workordertype', '=', $workordertype)
                        ->where('serverCount', '!=', '')
                        ->get();
                }
            }
            elseif($customercode != "" && $equipmentcode != "" && $fromdate != "" && $todate != "" && $workordertype == "" && $branchcode == ""){
                if($equipmentcode == 'CO0002') {
                    $data = DB::table('temp_table')
                        ->where('customername', '=', $customername->customername)
                        ->where('contractfromdate', '>=', $fromdate)
                        ->where('contracttodate', '<=', $todate)
                        ->where('pcCount', '!=', '')
                        ->get();
                }
                elseif($equipmentcode == 'PR0001'){
                    $data = DB::table('temp_table')
                        ->where('customername', '=', $customername->customername)
                        ->where('contractfromdate', '>=', $fromdate)
                        ->where('contracttodate', '<=', $todate)
                        ->where('printerCount', '!=', '')
                        ->get();
                }
                elseif($equipmentcode == 'SC0009'){
                    $data = DB::table('temp_table')
                        ->where('customername', '=', $customername->customername)
                        ->where('contractfromdate', '>=', $fromdate)
                        ->where('contracttodate', '<=', $todate)
                        ->where('scannerCount', '!=', '')
                        ->get();
                }
                else{
                    $data = DB::table('temp_table')
                        ->where('customername', '=', $customername->customername)
                        ->where('contractfromdate', '>=', $fromdate)
                        ->where('contracttodate', '<=', $todate)
                        ->where('serverCount', '!=', '')
                        ->get();
                }
            }
            elseif($customercode != "" && $equipmentcode != "" &&  $workordertype != "" && $fromdate != "" && $todate != "" && $branchcode == ""){
                if($equipmentcode == 'CO0002') {
                    $data = DB::table('temp_table')
                        ->where('customername', '=', $customername->customername)
                        ->where('workordertype', '=', $workordertype)
                        ->where('contractfromdate', '>=', $fromdate)
                        ->where('contracttodate', '<=', $todate)
                        ->where('pcCount', '!=', '')
                        ->get();
                }
                elseif($equipmentcode == 'PR0001'){
                    $data = DB::table('temp_table')
                        ->where('customername', '=', $customername->customername)
                        ->where('workordertype', '=', $workordertype)
                        ->where('contractfromdate', '>=', $fromdate)
                        ->where('contracttodate', '<=', $todate)
                        ->where('printerCount', '!=', '')
                        ->get();
                }
                elseif($equipmentcode == 'SC0009'){
                    $data = DB::table('temp_table')
                        ->where('customername', '=', $customername->customername)
                        ->where('workordertype', '=', $workordertype)
                        ->where('contractfromdate', '>=', $fromdate)
                        ->where('contracttodate', '<=', $todate)
                        ->where('scannerCount', '!=', '')
                        ->get();
                }
                else{
                    $data = DB::table('temp_table')
                        ->where('customername', '=', $customername->customername)
                        ->where('workordertype', '=', $workordertype)
                        ->where('contractfromdate', '>=', $fromdate)
                        ->where('contracttodate', '<=', $todate)
                        ->where('serverCount', '!=', '')
                        ->get();
                }
            }
            elseif($customercode != "" && $workordertype != "" && $fromdate != "" && $todate != "" && $branchcode == "" &&  $equipmentcode == ""){
                $data = DB::table('temp_table')
                    ->where('customername', '=', $customername->customername)
                    ->where('workordertype', '=', $workordertype)
                    ->where('contractfromdate', '>=', $fromdate)
                    ->where('contracttodate', '<=', $todate)
                    ->get();
            }
            else{
                $data = DB::table('temp_table')
                    ->where('customername','=',$customername->customername)
                    ->get();
            }
        }
        elseif($equipmentcode != ""){
            if($equipmentcode != "" && $workordertype != "" && $customercode != "" && $branchcode == "" && $fromdate == "" && $todate == ""){
                if($equipmentcode == 'CO0002') {
                    $data = DB::table('temp_table')
                        ->where('workordertype', '=', $workordertype)
                        ->where('pcCount', '!=', '')
                        ->get();
                }
                elseif($equipmentcode == 'PR0001'){
                    $data = DB::table('temp_table')
                        ->where('workordertype', '=', $workordertype)
                        ->where('printerCount', '!=', '')
                        ->get();
                }
                elseif($equipmentcode == 'SC0009'){
                    $data = DB::table('temp_table')
                        ->where('workordertype', '=', $workordertype)
                        ->where('scannerCount', '!=', '')
                        ->get();
                }
                else{
                    $data = DB::table('temp_table')
                        ->where('workordertype', '=', $workordertype)
                        ->where('serverCount', '!=', '')
                        ->get();
                }
            }
            elseif($equipmentcode != "" && $fromdate != "" && $todate != "" && $customercode != "" && $branchcode == "" && $workordertype == ""){
                if($equipmentcode == 'CO0002') {
                    $data = DB::table('temp_table')
                        ->where('contractfromdate', '>=', $fromdate)
                        ->where('contracttodate', '<=', $todate)
                        ->where('pcCount', '!=', '')
                        ->get();
                }
                elseif($equipmentcode == 'PR0001'){
                    $data = DB::table('temp_table')
                        ->where('contractfromdate', '>=', $fromdate)
                        ->where('contracttodate', '<=', $todate)
                        ->where('printerCount', '!=', '')
                        ->get();
                }
                elseif($equipmentcode == 'SC0009'){
                    $data = DB::table('temp_table')
                        ->where('contractfromdate', '>=', $fromdate)
                        ->where('contracttodate', '<=', $todate)
                        ->where('scannerCount', '!=', '')
                        ->get();
                }
                else{
                    $data = DB::table('temp_table')
                        ->where('contractfromdate', '>=', $fromdate)
                        ->where('contracttodate', '<=', $todate)
                        ->where('serverCount', '!=', '')
                        ->get();
                }
            }
            elseif($equipmentcode != "" && $workordertype != "" && $fromdate != "" && $todate != "" && $customercode != "" && $branchcode == ""){
                if($equipmentcode == 'CO0002') {
                    $data = DB::table('temp_table')
                        ->where('workordertype', '=', $workordertype)
                        ->where('contractfromdate', '>=', $fromdate)
                        ->where('contracttodate', '<=', $todate)
                        ->where('pcCount', '!=', '')
                        ->get();
                }
                elseif($equipmentcode == 'PR0001'){
                    $data = DB::table('temp_table')
                        ->where('workordertype', '=', $workordertype)
                        ->where('contractfromdate', '>=', $fromdate)
                        ->where('contracttodate', '<=', $todate)
                        ->where('printerCount', '!=', '')
                        ->get();
                }
                elseif($equipmentcode == 'SC0009'){
                    $data = DB::table('temp_table')
                        ->where('workordertype', '=', $workordertype)
                        ->where('contractfromdate', '>=', $fromdate)
                        ->where('contracttodate', '<=', $todate)
                        ->where('scannerCount', '!=', '')
                        ->get();
                }
                else{
                    $data = DB::table('temp_table')
                        ->where('workordertype', '=', $workordertype)
                        ->where('contractfromdate', '>=', $fromdate)
                        ->where('contracttodate', '<=', $todate)
                        ->where('serverCount', '!=', '')
                        ->get();
                }
            }
            else{
                if($equipmentcode == 'CO0002') {
                    $data = DB::table('temp_table')
                        ->where('pcCount', '!=', '')
                        ->get();
                }
                elseif($equipmentcode == 'PR0001'){
                    $data = DB::table('temp_table')
                        ->where('printerCount', '!=', '')
                        ->get();
                }
                elseif($equipmentcode == 'SC0009'){
                    $data = DB::table('temp_table')
                        ->where('scannerCount', '!=', '')
                        ->get();
                }
                else{
                    $data = DB::table('temp_table')
                        ->where('serverCount', '!=', '')
                        ->get();
                }
            }
        }
        elseif( $workordertype != ""){
            if($workordertype != "" && $fromdate != "" && $todate != "" && $customercode != "" && $branchcode == "" &&  $equipmentcode == ""){
            $data = DB::table('temp_table')
                ->where('workordertype', '=', $workordertype)
                ->where('contractfromdate', '>=', $fromdate)
                ->where('contracttodate', '<=', $todate)
                ->get();
            }
            else{
                $data = DB::table('temp_table')
                    ->where('workordertype', '=', $workordertype)
                    ->get();
            }
        }
        elseif($fromdate != "" && $todate != "" && $customercode != "" && $branchcode == "" &&  $equipmentcode == "" && $workordertype == ""){
            $data = DB::table('temp_table')
                ->where('contractfromdate', '>=', $fromdate)
                ->where('contracttodate', '<=', $todate)
                ->get();
        }
        else{
            $data = DB::table('temp_table')->get();
        }
        
        Schema::drop('temp_table');

//        return $data;
        return json_encode(array('idata'=>$data));
    }

    public function export($data){
        $data = explode(",", $data);
        $customercode = $data[0];
        $branchcode =  $data[1];
        $equipmentcode =  $data[2];
        $workordertype = $data[3];
        $fromdate = $data[4];
        $todate = $data[5];

        if($customercode != ""){
            $customername = CustomersModel::select('customername')->where('customercode','=',$customercode)->get()->first();
        }
        else{
            $customername = "";
        }
        if($branchcode != ""){
            $branchname = BranchMasterModel::select('branchname')->where('branchcode','=',$branchcode)->get()->first();
        }
        else{
            $branchname = "";
        }
        $table = DB::select('CALL `stp_contractReport`()');

        Schema::create('temp_table', function (Blueprint $table1) {
            $table1->string('contractno')->nullable()->default(NULL);
            $table1->string('customername')->nullable()->default(NULL);
            $table1->string('branchname')->nullable()->default(NULL);
            $table1->integer('pcCount')->nullable()->default(NULL);
            $table1->integer('printerCount')->nullable()->default(NULL);
            $table1->integer('scannerCount')->nullable()->default(NULL);
            $table1->integer('serverCount')->nullable()->default(NULL);
            $table1->string('workorderno')->nullable()->default(NULL);
            $table1->string('workordertype')->nullable()->default(NULL);
            $table1->date('contractfromdate')->nullable()->default(NULL);
            $table1->date('contracttodate')->nullable()->default(NULL);
            $table1->decimal('yearsvalue',17,2)->nullable()->default(NULL);
            $table1->decimal('monthvalue',17,2)->nullable()->default(NULL);
            $table1->decimal('totalcost',17,2)->nullable()->default(NULL);
            $table1->decimal('contractperiod',17,2)->nullable()->default(NULL);
            $table1->timestamps();
            $table1->temporary();
        });
        for($i=0; $i < count($table);$i++) {
            DB::table('temp_table')->insert(['contractno' => $table[$i]->contractno, 'customername' =>  $table[$i]->customername,
                'branchname' =>  $table[$i]->branchname, 'pcCount' =>  $table[$i]->pcCount, 'printerCount' =>  $table[$i]->printerCount,
                'scannerCount' =>  $table[$i]->scannerCount, 'serverCount' =>  $table[$i]->serverCount, 'workorderno' =>  $table[$i]->workorderno,
                'workordertype' =>  $table[$i]->workordertype, 'contractfromdate' =>  $table[$i]->contractfromdate, 'contracttodate' =>  $table[$i]->contracttodate,
                'yearsvalue' =>  $table[$i]->yearsvalue,'monthvalue' =>  $table[$i]->monthvalue,'totalcost' =>  $table[$i]->totalcost,'contractperiod' =>  $table[$i]->contractperiod]);
        }

        $data ="";
        if($customercode != ""){
            if($customercode != "" && $branchcode != "" && $equipmentcode == "" &&  $workordertype == "" && $fromdate == "" && $todate == ""){
                $data = DB::table('temp_table')
                    ->where('customername','=',$customername->customername)
                    ->where('branchname','=',$branchname->branchname)
                    ->get()->toArray();
            }
            elseif ($customercode != "" && $equipmentcode != "" && $branchcode == "" &&  $workordertype == "" && $fromdate == "" && $todate == ""){
                if($equipmentcode == 'CO0002') {
                    $data = DB::table('temp_table')
                        ->where('customername', '=', $customername->customername)
                        ->where('pcCount', '!=', '')
                        ->get()->toArray();
                }
                elseif($equipmentcode == 'PR0001'){
                    $data = DB::table('temp_table')
                        ->where('customername', '=', $customername->customername)
                        ->where('printerCount', '!=', '')
                        ->get()->toArray();
                }
                elseif($equipmentcode == 'SC0009'){
                    $data = DB::table('temp_table')
                        ->where('customername', '=', $customername->customername)
                        ->where('scannerCount', '!=', '')
                        ->get()->toArray();
                }
                else{
                    $data = DB::table('temp_table')
                        ->where('customername', '=', $customername->customername)
                        ->where('serverCount', '!=', '')
                        ->get()->toArray();
                }
            }
            elseif($customercode != "" && $workordertype != "" && $branchcode == "" &&  $equipmentcode == "" && $fromdate == "" && $todate == ""){
                $data = DB::table('temp_table')
                    ->where('customername', '=', $customername->customername)
                    ->where('workordertype', '=', $workordertype)
                    ->get()->toArray();
            }
            elseif($customercode != "" && $fromdate != "" && $todate != "" && $workordertype == "" && $branchcode == "" &&  $equipmentcode == ""){
                $data = DB::table('temp_table')
                    ->where('customername', '=', $customername->customername)
                    ->where('contractfromdate', '>=', $fromdate)
                    ->where('contracttodate', '<=', $todate)
                    ->get()->toArray();
            }
            elseif($customercode != "" && $branchcode != "" && $equipmentcode != "" &&  $workordertype == "" && $fromdate == "" && $todate == ""){
                if($equipmentcode == 'CO0002') {
                    $data = DB::table('temp_table')
                        ->where('customername', '=', $customername->customername)
                        ->where('branchname','=',$branchname->branchname)
                        ->where('pcCount', '!=', '')
                        ->get()->toArray();
                }
                elseif($equipmentcode == 'PR0001'){
                    $data = DB::table('temp_table')
                        ->where('customername', '=', $customername->customername)
                        ->where('branchname','=',$branchname->branchname)
                        ->where('printerCount', '!=', '')
                        ->get()->toArray();
                }
                elseif($equipmentcode == 'SC0009'){
                    $data = DB::table('temp_table')
                        ->where('customername', '=', $customername->customername)
                        ->where('branchname','=',$branchname->branchname)
                        ->where('scannerCount', '!=', '')
                        ->get()->toArray();
                }
                else{
                    $data = DB::table('temp_table')
                        ->where('customername', '=', $customername->customername)
                        ->where('branchname','=',$branchname->branchname)
                        ->where('serverCount', '!=', '')
                        ->get()->toArray();
                }
            }
            elseif($customercode != "" && $branchcode != "" && $workordertype != "" &&  $equipmentcode == "" && $fromdate == "" && $todate == ""){
                $data = DB::table('temp_table')
                    ->where('customername', '=', $customername->customername)
                    ->where('branchname','=',$branchname->branchname)
                    ->where('workordertype', '=', $workordertype)
                    ->get()->toArray();
            }
            elseif($customercode != "" && $branchcode != "" && $fromdate != "" && $todate != "" && $workordertype == "" &&  $equipmentcode == ""){
                $data = DB::table('temp_table')
                    ->where('customername', '=', $customername->customername)
                    ->where('branchname','=',$branchname->branchname)
                    ->where('contractfromdate', '>=', $fromdate)
                    ->where('contracttodate', '<=', $todate)
                    ->get()->toArray();
            }
            elseif($customercode != "" && $branchcode != "" && $equipmentcode != "" && $workordertype != "" && $fromdate == "" && $todate == ""){
                if($equipmentcode == 'CO0002') {
                    $data = DB::table('temp_table')
                        ->where('customername', '=', $customername->customername)
                        ->where('branchname','=',$branchname->branchname)
                        ->where('workordertype', '=', $workordertype)
                        ->where('pcCount', '!=', '')
                        ->get()->toArray();
                }
                elseif($equipmentcode == 'PR0001'){
                    $data = DB::table('temp_table')
                        ->where('customername', '=', $customername->customername)
                        ->where('branchname','=',$branchname->branchname)
                        ->where('workordertype', '=', $workordertype)
                        ->where('printerCount', '!=', '')
                        ->get()->toArray();
                }
                elseif($equipmentcode == 'SC0009'){
                    $data = DB::table('temp_table')
                        ->where('customername', '=', $customername->customername)
                        ->where('branchname','=',$branchname->branchname)
                        ->where('workordertype', '=', $workordertype)
                        ->where('scannerCount', '!=', '')
                        ->get()->toArray();
                }
                else{
                    $data = DB::table('temp_table')
                        ->where('customername', '=', $customername->customername)
                        ->where('branchname','=',$branchname->branchname)
                        ->where('workordertype', '=', $workordertype)
                        ->where('serverCount', '!=', '')
                        ->get()->toArray();
                }
            }
            elseif($customercode != "" && $branchcode != "" && $equipmentcode != "" && $fromdate != "" && $todate != "" && $workordertype == ""){
                if($equipmentcode == 'CO0002') {
                    $data = DB::table('temp_table')
                        ->where('customername', '=', $customername->customername)
                        ->where('branchname','=',$branchname->branchname)
                        ->where('contractfromdate', '>=', $fromdate)
                        ->where('contracttodate', '<=', $todate)
                        ->where('pcCount', '!=', '')
                        ->get()->toArray();
                }
                elseif($equipmentcode == 'PR0001'){
                    $data = DB::table('temp_table')
                        ->where('customername', '=', $customername->customername)
                        ->where('branchname','=',$branchname->branchname)
                        ->where('contractfromdate', '>=', $fromdate)
                        ->where('contracttodate', '<=', $todate)
                        ->where('printerCount', '!=', '')
                        ->get()->toArray();
                }
                elseif($equipmentcode == 'SC0009'){
                    $data = DB::table('temp_table')
                        ->where('customername', '=', $customername->customername)
                        ->where('branchname','=',$branchname->branchname)
                        ->where('contractfromdate', '>=', $fromdate)
                        ->where('contracttodate', '<=', $todate)
                        ->where('scannerCount', '!=', '')
                        ->get()->toArray();
                }
                else{
                    $data = DB::table('temp_table')
                        ->where('customername', '=', $customername->customername)
                        ->where('branchname','=',$branchname->branchname)
                        ->where('contractfromdate', '>=', $fromdate)
                        ->where('contracttodate', '<=', $todate)
                        ->where('serverCount', '!=', '')
                        ->get()->toArray();
                }
            }
            elseif($customercode != "" && $branchcode != "" &&  $workordertype != "" && $fromdate != "" && $todate != "" &&  $equipmentcode == ""){
                $data = DB::table('temp_table')
                    ->where('customername', '=', $customername->customername)
                    ->where('branchname','=',$branchname->branchname)
                    ->where('workordertype', '=', $workordertype)
                    ->where('contractfromdate', '>=', $fromdate)
                    ->where('contracttodate', '<=', $todate)
                    ->get()->toArray();
            }
            elseif($customercode != "" && $branchcode != "" && $equipmentcode != "" &&  $workordertype != "" && $fromdate != "" && $todate != ""){
                if($equipmentcode == 'CO0002') {
                    $data = DB::table('temp_table')
                        ->where('customername', '=', $customername->customername)
                        ->where('branchname','=',$branchname->branchname)
                        ->where('workordertype', '=', $workordertype)
                        ->where('contractfromdate', '>=', $fromdate)
                        ->where('contracttodate', '<=', $todate)
                        ->where('pcCount', '!=', '')
                        ->get()->toArray();
                }
                elseif($equipmentcode == 'PR0001'){
                    $data = DB::table('temp_table')
                        ->where('customername', '=', $customername->customername)
                        ->where('branchname','=',$branchname->branchname)
                        ->where('workordertype', '=', $workordertype)
                        ->where('contractfromdate', '>=', $fromdate)
                        ->where('contracttodate', '<=', $todate)
                        ->where('printerCount', '!=', '')
                        ->get()->toArray();
                }
                elseif($equipmentcode == 'SC0009'){
                    $data = DB::table('temp_table')
                        ->where('customername', '=', $customername->customername)
                        ->where('branchname','=',$branchname->branchname)
                        ->where('workordertype', '=', $workordertype)
                        ->where('contractfromdate', '>=', $fromdate)
                        ->where('contracttodate', '<=', $todate)
                        ->where('scannerCount', '!=', '')
                        ->get()->toArray();
                }
                else{
                    $data = DB::table('temp_table')
                        ->where('customername', '=', $customername->customername)
                        ->where('branchname','=',$branchname->branchname)
                        ->where('workordertype', '=', $workordertype)
                        ->where('contractfromdate', '>=', $fromdate)
                        ->where('contracttodate', '<=', $todate)
                        ->where('serverCount', '!=', '')
                        ->get()->toArray();
                }
            }
            elseif($customercode != "" && $equipmentcode != "" &&  $workordertype != "" && $branchcode == "" && $fromdate == "" && $todate == ""){
                if($equipmentcode == 'CO0002') {
                    $data = DB::table('temp_table')
                        ->where('customername', '=', $customername->customername)
                        ->where('workordertype', '=', $workordertype)
                        ->where('pcCount', '!=', '')
                        ->get()->toArray();
                }
                elseif($equipmentcode == 'PR0001'){
                    $data = DB::table('temp_table')
                        ->where('customername', '=', $customername->customername)
                        ->where('workordertype', '=', $workordertype)
                        ->where('printerCount', '!=', '')
                        ->get()->toArray();
                }
                elseif($equipmentcode == 'SC0009'){
                    $data = DB::table('temp_table')
                        ->where('customername', '=', $customername->customername)
                        ->where('workordertype', '=', $workordertype)
                        ->where('scannerCount', '!=', '')
                        ->get()->toArray();
                }
                else{
                    $data = DB::table('temp_table')
                        ->where('customername', '=', $customername->customername)
                        ->where('workordertype', '=', $workordertype)
                        ->where('serverCount', '!=', '')
                        ->get()->toArray();
                }
            }
            elseif($customercode != "" && $equipmentcode != "" && $fromdate != "" && $todate != "" && $workordertype == "" && $branchcode == ""){
                if($equipmentcode == 'CO0002') {
                    $data = DB::table('temp_table')
                        ->where('customername', '=', $customername->customername)
                        ->where('contractfromdate', '>=', $fromdate)
                        ->where('contracttodate', '<=', $todate)
                        ->where('pcCount', '!=', '')
                        ->get()->toArray();
                }
                elseif($equipmentcode == 'PR0001'){
                    $data = DB::table('temp_table')
                        ->where('customername', '=', $customername->customername)
                        ->where('contractfromdate', '>=', $fromdate)
                        ->where('contracttodate', '<=', $todate)
                        ->where('printerCount', '!=', '')
                        ->get()->toArray();
                }
                elseif($equipmentcode == 'SC0009'){
                    $data = DB::table('temp_table')
                        ->where('customername', '=', $customername->customername)
                        ->where('contractfromdate', '>=', $fromdate)
                        ->where('contracttodate', '<=', $todate)
                        ->where('scannerCount', '!=', '')
                        ->get()->toArray();
                }
                else{
                    $data = DB::table('temp_table')
                        ->where('customername', '=', $customername->customername)
                        ->where('contractfromdate', '>=', $fromdate)
                        ->where('contracttodate', '<=', $todate)
                        ->where('serverCount', '!=', '')
                        ->get()->toArray();
                }
            }
            elseif($customercode != "" && $equipmentcode != "" &&  $workordertype != "" && $fromdate != "" && $todate != "" && $branchcode == ""){
                if($equipmentcode == 'CO0002') {
                    $data = DB::table('temp_table')
                        ->where('customername', '=', $customername->customername)
                        ->where('workordertype', '=', $workordertype)
                        ->where('contractfromdate', '>=', $fromdate)
                        ->where('contracttodate', '<=', $todate)
                        ->where('pcCount', '!=', '')
                        ->get()->toArray();
                }
                elseif($equipmentcode == 'PR0001'){
                    $data = DB::table('temp_table')
                        ->where('customername', '=', $customername->customername)
                        ->where('workordertype', '=', $workordertype)
                        ->where('contractfromdate', '>=', $fromdate)
                        ->where('contracttodate', '<=', $todate)
                        ->where('printerCount', '!=', '')
                        ->get()->toArray();
                }
                elseif($equipmentcode == 'SC0009'){
                    $data = DB::table('temp_table')
                        ->where('customername', '=', $customername->customername)
                        ->where('workordertype', '=', $workordertype)
                        ->where('contractfromdate', '>=', $fromdate)
                        ->where('contracttodate', '<=', $todate)
                        ->where('scannerCount', '!=', '')
                        ->get()->toArray();
                }
                else{
                    $data = DB::table('temp_table')
                        ->where('customername', '=', $customername->customername)
                        ->where('workordertype', '=', $workordertype)
                        ->where('contractfromdate', '>=', $fromdate)
                        ->where('contracttodate', '<=', $todate)
                        ->where('serverCount', '!=', '')
                        ->get()->toArray();
                }
            }
            elseif($customercode != "" && $workordertype != "" && $fromdate != "" && $todate != "" && $branchcode == "" &&  $equipmentcode == ""){
                $data = DB::table('temp_table')
                    ->where('customername', '=', $customername->customername)
                    ->where('workordertype', '=', $workordertype)
                    ->where('contractfromdate', '>=', $fromdate)
                    ->where('contracttodate', '<=', $todate)
                    ->get()->toArray();
            }
            else{
                $data = DB::table('temp_table')
                    ->where('customername','=',$customername->customername)
                    ->get()->toArray();
            }
        }
        elseif($equipmentcode != ""){
            if($equipmentcode != "" && $workordertype != "" && $customercode != "" && $branchcode == "" && $fromdate == "" && $todate == ""){
                if($equipmentcode == 'CO0002') {
                    $data = DB::table('temp_table')
                        ->where('workordertype', '=', $workordertype)
                        ->where('pcCount', '!=', '')
                        ->get()->toArray();
                }
                elseif($equipmentcode == 'PR0001'){
                    $data = DB::table('temp_table')
                        ->where('workordertype', '=', $workordertype)
                        ->where('printerCount', '!=', '')
                        ->get()->toArray();
                }
                elseif($equipmentcode == 'SC0009'){
                    $data = DB::table('temp_table')
                        ->where('workordertype', '=', $workordertype)
                        ->where('scannerCount', '!=', '')
                        ->get();
                }
                else{
                    $data = DB::table('temp_table')
                        ->where('workordertype', '=', $workordertype)
                        ->where('serverCount', '!=', '')
                        ->get()->toArray();
                }
            }
            elseif($equipmentcode != "" && $fromdate != "" && $todate != "" && $customercode != "" && $branchcode == "" && $workordertype == ""){
                if($equipmentcode == 'CO0002') {
                    $data = DB::table('temp_table')
                        ->where('contractfromdate', '>=', $fromdate)
                        ->where('contracttodate', '<=', $todate)
                        ->where('pcCount', '!=', '')
                        ->get()->toArray();
                }
                elseif($equipmentcode == 'PR0001'){
                    $data = DB::table('temp_table')
                        ->where('contractfromdate', '>=', $fromdate)
                        ->where('contracttodate', '<=', $todate)
                        ->where('printerCount', '!=', '')
                        ->get()->toArray();
                }
                elseif($equipmentcode == 'SC0009'){
                    $data = DB::table('temp_table')
                        ->where('contractfromdate', '>=', $fromdate)
                        ->where('contracttodate', '<=', $todate)
                        ->where('scannerCount', '!=', '')
                        ->get()->toArray();
                }
                else{
                    $data = DB::table('temp_table')
                        ->where('contractfromdate', '>=', $fromdate)
                        ->where('contracttodate', '<=', $todate)
                        ->where('serverCount', '!=', '')
                        ->get()->toArray();
                }
            }
            elseif($equipmentcode != "" && $workordertype != "" && $fromdate != "" && $todate != "" && $customercode != "" && $branchcode == ""){
                if($equipmentcode == 'CO0002') {
                    $data = DB::table('temp_table')
                        ->where('workordertype', '=', $workordertype)
                        ->where('contractfromdate', '>=', $fromdate)
                        ->where('contracttodate', '<=', $todate)
                        ->where('pcCount', '!=', '')
                        ->get()->toArray();
                }
                elseif($equipmentcode == 'PR0001'){
                    $data = DB::table('temp_table')
                        ->where('workordertype', '=', $workordertype)
                        ->where('contractfromdate', '>=', $fromdate)
                        ->where('contracttodate', '<=', $todate)
                        ->where('printerCount', '!=', '')
                        ->get()->toArray();
                }
                elseif($equipmentcode == 'SC0009'){
                    $data = DB::table('temp_table')
                        ->where('workordertype', '=', $workordertype)
                        ->where('contractfromdate', '>=', $fromdate)
                        ->where('contracttodate', '<=', $todate)
                        ->where('scannerCount', '!=', '')
                        ->get()->toArray();
                }
                else{
                    $data = DB::table('temp_table')
                        ->where('workordertype', '=', $workordertype)
                        ->where('contractfromdate', '>=', $fromdate)
                        ->where('contracttodate', '<=', $todate)
                        ->where('serverCount', '!=', '')
                        ->get()->toArray();
                }
            }
            else{
                if($equipmentcode == 'CO0002') {
                    $data = DB::table('temp_table')
                        ->where('pcCount', '!=', '')
                        ->get()->toArray();
                }
                elseif($equipmentcode == 'PR0001'){
                    $data = DB::table('temp_table')
                        ->where('printerCount', '!=', '')
                        ->get()->toArray();
                }
                elseif($equipmentcode == 'SC0009'){
                    $data = DB::table('temp_table')
                        ->where('scannerCount', '!=', '')
                        ->get()->toArray();
                }
                else{
                    $data = DB::table('temp_table')
                        ->where('serverCount', '!=', '')
                        ->get()->toArray();
                }
            }
        }
        elseif( $workordertype != ""){
            if($workordertype != "" && $fromdate != "" && $todate != "" && $customercode != "" && $branchcode == "" &&  $equipmentcode == ""){
                $data = DB::table('temp_table')
                    ->where('workordertype', '=', $workordertype)
                    ->where('contractfromdate', '>=', $fromdate)
                    ->where('contracttodate', '<=', $todate)
                    ->get()->toArray();
            }
            else{
                $data = DB::table('temp_table')
                    ->where('workordertype', '=', $workordertype)
                    ->get()->toArray();
            }
        }
        elseif($fromdate != "" && $todate != "" && $customercode != "" && $branchcode == "" &&  $equipmentcode == "" && $workordertype == ""){
            $data = DB::table('temp_table')
                ->where('contractfromdate', '>=', $fromdate)
                ->where('contracttodate', '<=', $todate)
                ->get()->toArray();
        }
        else{
            $data = DB::table('temp_table')->get()->toArray();
        }

        Schema::drop('temp_table');
        $data_array[] = array('CONTRACT DETAILS');
        $data_array[] = array('Sr no.','Contract No','Customer Name','Branch Name','No. of PC','No. of Printer','No.of Scanner',
            'No. of Server','Work Order No.','Work Order Type','Contract From Date','Contract To Date','Years Value',
            'Month Value','Total Cost','Contract Period');
        $j = 1;
        foreach($data as $exceldata)
        {
            $data_array[] = array(
                'Sr no.'    =>  $j++,
                'Contract No'   =>  $exceldata->contractno,
                'Customer Name'   =>  $exceldata->customername,
                'Branch Name'   =>  $exceldata->branchname,
                'No. of PC'   =>  $exceldata->pcCount,
                'No. of Printer'   =>  $exceldata->printerCount,
                'No.of Scanner'   =>  $exceldata->scannerCount,
                'No. of Server'   =>  $exceldata->serverCount,
                'Work Order No.'   =>  $exceldata->workorderno,
                'Work Order Type'   =>  $exceldata->workordertype,
                'Contract From Date'   =>  $exceldata->contractfromdate,
                'Contract To Date'   =>  $exceldata->contracttodate,
                'Years Value'   =>  $exceldata->yearsvalue,
                'Month Value'   =>  $exceldata->monthvalue,
                'Total Cost'   =>  $exceldata->totalcost,
                'Contract Period'   =>  $exceldata->contractperiod,
            );
        }
        $count = count($data_array);
         array_push($data_array, [
            'Sr no.'    =>  '',
            'Contract No'   =>  'Total',
            'Customer Name'   =>  '',
            'Branch Name'   =>  '',
            'No. of PC'   =>  '=SUM(E2:E'.$count.')',
            'No. of Printer'   =>  '=SUM(F2:F'.$count.')',
            'No.of Scanner'   =>  '=SUM(G2:G'.$count.')',
            'No. of Server'   =>  '=SUM(H2:H'.$count.')',
            'Work Order No.'   =>  '',
            'Work Order Type'   =>  '',
            'Contract From Date'   =>  '',
            'Contract To Date'   =>  '',
            'Years Value'   =>  '',
            'Month Value'   =>  '',
            'Total Cost'   => '',
            'Contract Period'   =>  '',
        ]);
        $count = count($data_array);
        \session()->put('key',$count);
        $new_data_array = new ContractDetailsExport([$data_array]);
        return Excel::download($new_data_array, 'Contract Details.xlsx');
    }

    public function customerWiseReport(){
        return view('Report.cusromerWiseReport');
    }

    public function customerwisedata(){
        $table = DB::select('CALL `stp_CustomerWiseContractReport`()');
        return json_encode(array('idata'=>$table));
    }

    public function contracttypeReport(){
        return view('Report.contracttypeReport');
    }

    public function contracttypedata(){
        $table = DB::select('CALL `stp_ContractTypeReport`()');
        return json_encode(array('idata'=>$table));
    }

}
