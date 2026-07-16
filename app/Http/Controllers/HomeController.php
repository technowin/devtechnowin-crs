<?php

namespace App\Http\Controllers;

use Auth;
use DateTimeZone;
use Illuminate\Http\Request;
use App\Models\ExistingUserComplaintLodging;
use App\Models\TicketAssignedModel;
use  Carbon\Carbon;
use Illuminate\Http\Response;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return Response
     */
    public function index()
    {
        $user = auth()->user()->roles->first()->name;
        if (!Auth::guest() && $user == 'admin') {
            $user = auth()->user()->roles->first()->name;
            if (!Auth::guest() && $user == 'admin') {

                $totalComplaintCount = ExistingUserComplaintLodging::selectRaw('count(*)')
                    ->where('subcategorycode','!=','service')
                    ->where('complaintdescription','!=','supply')
                    ->where('complaintdate','>','2018-04-01')
                    ->value('count(*)');
                $totalServiceCount = ExistingUserComplaintLodging::selectRaw('count(*)')
                    ->where('subcategorycode','=','service')
                    ->where('complaintdescription','!=','supply')
                    ->where('complaintdate','>','2018-04-01')
                    ->value('count(*)');
                $totalSupplyCount = ExistingUserComplaintLodging::selectRaw('count(*)')
                    ->where('complaintdescription','=','supply')
                    ->where('complaintdate','>','2018-04-01')
                    ->value('count(*)');

                $now = Carbon::today(new DateTimeZone('Asia/Kolkata'));
                //Complaints
                $complaintdateReceived = ExistingUserComplaintLodging::select('complaintdate')
                    ->where('complaintstatus','=','ACKNOWLEDGED')
                    ->where('subcategorycode','!=','service')
                    ->where('complaintdescription','!=','supply')
                    ->where('complaintdate','>','2018-04-01')
                    ->get();

                $twodaysRECount = 0;
                $sevendaysRECount = 0;
                $onemonthRECount = 0;
                $threemonthRECount = 0;

                foreach ($complaintdateReceived as $value){
                    $from = Carbon::createFromFormat('Y-m-d H:i:s', $value->complaintdate);
                    $to = Carbon::createFromFormat('Y-m-d H:i:s', $now);
                    $count = $to->diffInDays($from);
                    if($count>=2&&$count<=7){
                        $twodaysRECount++;
                    }
                    elseif($count>=7&&$count<=30){
                        $sevendaysRECount++;
                    }
                    elseif($count>=30&&$count<=90){
                        $onemonthRECount++;
                    }
                    elseif($count>=90){
                        $threemonthRECount++;
                    }
                }

                $complaintDateAssigned = ExistingUserComplaintLodging::select('complaintdate')
                    ->where('complaintstatus','=','ASSIGNED')
                    ->where('subcategorycode','!=','service')
                    ->where('complaintdescription','!=','supply')
                    ->where('complaintdate','>','2018-04-01')
                    ->get();

                $twodaysASSCount = 0;
                $sevendaysASSCount = 0;
                $onemonthASSCount = 0;
                $threemonthASSCount = 0;

                foreach($complaintDateAssigned as $value){
                    $from = Carbon::createFromFormat('Y-m-d H:i:s', $value->complaintdate);
                    $to = Carbon::createFromFormat('Y-m-d H:i:s', $now);
                    $count = $from->diffInDays($to);

                    if($count>=2&&$count<=7){
                        $twodaysASSCount++;
                    }
                    elseif($count>=7&&$count<=30){
                        $sevendaysASSCount++;
                    }
                    elseif($count>=30&&$count<=90){
                        $onemonthASSCount++;
                    }
                    elseif($count>=90){
                        $threemonthASSCount++;
                    }
                }

                $complaintStatus = ExistingUserComplaintLodging::select('complaintstatus')
                    ->where('subcategorycode','!=','service')
                    ->where('complaintdescription','!=','supply')
                    ->where('complaintdate','>','2018-04-01')
                    ->get();

                $resolvedCount = 0;
                $closedCount = 0;
                foreach ($complaintStatus as $value){

                    if($value->complaintstatus == 'RESOLVED'){
                        $resolvedCount++;
                    }
                    elseif($value->complaintstatus == 'CLOSED'){
                        $closedCount++;
                    }
                }

                $assigneeStatus = TicketAssignedModel::select('assigneestatus')
                    ->join('tblexistingcustomercomplaintlodging','tblexistingcustomercomplaintlodging.ticketno','=','tblticketassigneedetails.ticketno')
                    ->where('tblexistingcustomercomplaintlodging.subcategorycode','!=','service')
                    ->where('complaintdescription','!=','supply')
                    ->where('complaintdate','>','2018-04-01')
                    ->get();
                $notresolvedCount = 0;
                $pendingCount = 0;
                foreach($assigneeStatus as $value) {

                    if($value->assigneestatus == 'NOT RESOLVED') {
                        $notresolvedCount++;
                    }
                    elseif ($value->assigneestatus == 'PENDING') {
                        $pendingCount++;
                    }
                }

                //Service
                $servComplaintdateReceived = ExistingUserComplaintLodging::select('complaintdate')
                    ->where('complaintstatus','=','ACKNOWLEDGED')
                    ->where('subcategorycode','=','service')
                    ->where('complaintdescription','!=','supply')
                    ->where('complaintdate','>','2018-04-01')
                    ->get();

                $servTwodaysRECount = 0;
                $servSevendaysRECount = 0;
                $servOnemonthRECount = 0;
                $servThreemonthRECount = 0;

                foreach ($servComplaintdateReceived as $value){
                    $from = Carbon::createFromFormat('Y-m-d H:i:s', $value->complaintdate);
                    $to = Carbon::createFromFormat('Y-m-d H:i:s', $now);
                    $count = $to->diffInDays($from);
                    if($count>=2&&$count<=7){
                        $servTwodaysRECount++;
                    }
                    elseif($count>=7&&$count<=30){
                        $servSevendaysRECount++;
                    }
                    elseif($count>=30&&$count<=90){
                        $servOnemonthRECount++;
                    }
                    elseif($count>=90){
                        $servThreemonthRECount++;
                    }
                }

                $servComplaintDateAssigned = ExistingUserComplaintLodging::select('complaintdate')
                    ->where('complaintstatus','=','ASSIGNED')
                    ->where('subcategorycode','=','service')
                    ->where('complaintdescription','!=','supply')
                    ->where('complaintdate','>','2018-04-01')
                    ->get();
                $servTwodaysASSCount = 0;
                $servSevendaysASSCount = 0;
                $servOnemonthASSCount = 0;
                $servThreemonthASSCount = 0;

                foreach($servComplaintDateAssigned as $value){
                    $from = Carbon::createFromFormat('Y-m-d H:i:s', $value->complaintdate);
                    $to = Carbon::createFromFormat('Y-m-d H:i:s', $now);
                    $count = $to->diffInDays($from);

                    if($count>=2&&$count<=7){
                        $servTwodaysASSCount++;
                    }
                    elseif($count>=7&&$count<=30){
                        $servSevendaysASSCount++;
                    }
                    elseif($count>=30&&$count<=90){
                        $servOnemonthASSCount++;
                    }
                    elseif($count>=90){
                        $servThreemonthASSCount++;
                    }
                }

                $servComplaintStatus = ExistingUserComplaintLodging::select('complaintstatus')
                    ->where('subcategorycode','=','service')
                    ->where('complaintdescription','!=','supply')
                    ->where('complaintdate','>','2018-04-01')
                    ->get();

                $servResolvedCount = 0;
                $servClosedCount = 0;
                foreach ($servComplaintStatus as $value){

                    if($value->complaintstatus == 'RESOLVED'){
                        $servResolvedCount++;
                    }
                    elseif($value->complaintstatus == 'CLOSED'){
                        $servClosedCount++;
                    }
                }

                $servAssigneeStatus = TicketAssignedModel::select('assigneestatus')
                    ->join('tblexistingcustomercomplaintlodging','tblexistingcustomercomplaintlodging.ticketno','=','tblticketassigneedetails.ticketno')
                    ->where('tblexistingcustomercomplaintlodging.subcategorycode','=','service')
                    ->where('complaintdescription','!=','supply')
                    ->where('complaintdate','>','2018-04-01')
                    ->get();

                $servNotresolvedCount = 0;
                $servPendingCount = 0;
                foreach($servAssigneeStatus as $value) {

                    if($value->assigneestatus == 'NOT RESOLVED') {
                        $servNotresolvedCount++;
                    }
                    elseif ($value->assigneestatus == 'PENDING') {
                        $servPendingCount++;
                    }
                }

                //Supply
                $supplyComplaintdateReceived = ExistingUserComplaintLodging::select('complaintdate')
                    ->where('complaintstatus','=','ACKNOWLEDGED')
                    ->where('complaintdescription','=','supply')
                    ->where('complaintdate','>','2018-04-01')
                    ->get();

                $supplyTwodaysRECount = 0;
                $supplySevendaysRECount = 0;
                $supplyOnemonthRECount = 0;
                $supplyThreemonthRECount = 0;

                foreach ($supplyComplaintdateReceived as $value){
                    $from = Carbon::createFromFormat('Y-m-d H:i:s', $value->complaintdate);
                    $to = Carbon::createFromFormat('Y-m-d H:i:s', $now);
                    $count = $to->diffInDays($from);
                    if($count>=2&&$count<=7){
                        $supplyTwodaysRECount++;
                    }
                    elseif($count>=7&&$count<=30){
                        $supplySevendaysRECount++;
                    }
                    elseif($count>=30&&$count<=90){
                        $supplyOnemonthRECount++;
                    }
                    elseif($count>=90){
                        $supplyThreemonthRECount++;
                    }
                }
                $supplyComplaintDateAssigned = ExistingUserComplaintLodging::select('complaintdate')
                    ->where('complaintstatus','=','ASSIGNED')
                    ->where('complaintdescription','=','supply')
                    ->where('complaintdate','>','2018-04-01')
                    ->get();
                $supplyTwodaysASSCount = 0;
                $supplySevendaysASSCount = 0;
                $supplyOnemonthASSCount = 0;
                $supplyThreemonthASSCount = 0;

                foreach($supplyComplaintDateAssigned as $value){
                    $from = Carbon::createFromFormat('Y-m-d H:i:s', $value->complaintdate);
                    $to = Carbon::createFromFormat('Y-m-d H:i:s', $now);
                    $count = $to->diffInDays($from);

                    if($count>=2&&$count<=7){
                        $supplyTwodaysASSCount++;
                    }
                    elseif($count>=7&&$count<=30){
                        $supplySevendaysASSCount++;
                    }
                    elseif($count>=30&&$count<=90){
                        $supplyOnemonthASSCount++;
                    }
                    elseif($count>=90){
                        $supplyThreemonthASSCount++;
                    }
                }
                $supplyComplaintStatus = ExistingUserComplaintLodging::select('complaintstatus')
                    ->where('complaintdescription','=','supply')
                    ->where('complaintdate','>','2018-04-01')
                    ->get();

                $supplyResolvedCount = 0;
                $supplyClosedCount = 0;
                foreach ($supplyComplaintStatus as $value){

                    if($value->complaintstatus == 'RESOLVED'){
                        $supplyResolvedCount++;
                    }
                    elseif($value->complaintstatus == 'CLOSED'){
                        $supplyClosedCount++;
                    }
                }

                $supplyAssigneeStatus = TicketAssignedModel::select('assigneestatus')
                    ->join('tblexistingcustomercomplaintlodging','tblexistingcustomercomplaintlodging.ticketno','=','tblticketassigneedetails.ticketno')
                    ->where('complaintdescription','=','supply')
                    ->where('complaintdate','>','2018-04-01')
                    ->get();

                $supplyNotresolvedCount = 0;
                $supplyPendingCount = 0;
                foreach($supplyAssigneeStatus as $value) {

                    if($value->assigneestatus == 'NOT RESOLVED') {
                        $supplyNotresolvedCount++;
                    }
                    elseif ($value->assigneestatus == 'PENDING') {
                        $supplyPendingCount++;
                    }
                }

                return view('dashboard.admindashboard',compact('totalComplaintCount','totalServiceCount','totalSupplyCount',
                    'twodaysRECount','sevendaysRECount','onemonthRECount','threemonthRECount',
                    'twodaysASSCount','sevendaysASSCount','onemonthASSCount','threemonthASSCount',
                    'resolvedCount', 'closedCount','notresolvedCount','pendingCount',
                    'servTwodaysRECount','servSevendaysRECount', 'servOnemonthRECount','servThreemonthRECount',
                    'servTwodaysASSCount','servSevendaysASSCount','servOnemonthASSCount','servThreemonthASSCount',
                    'servResolvedCount','servClosedCount','servNotresolvedCount','servPendingCount',
                    'supplyTwodaysRECount', 'supplySevendaysRECount','supplyOnemonthRECount','supplyThreemonthRECount',
                    'supplyTwodaysASSCount','supplySevendaysASSCount', 'supplyOnemonthASSCount','supplyThreemonthASSCount',
                    'supplyResolvedCount','supplyClosedCount','supplyNotresolvedCount','supplyPendingCount'));
            }
            return view('dashboard.admindashboard');
        }
        if (!Auth::guest() && $user == 'user') {
            $user = Auth::user();
            return view('dashboard.userdashboard', compact('user'));
        }
        if (!Auth::guest() && $user == 'assignee') {
            $user = Auth::user();
             $assigneecode= trim($user->assigneecode);
            $newComplaint = TicketAssignedModel::selectRaw('tblticketassigneedetails.*,tblexistingcustomercomplaintlodging.complaintdate')
                ->Join('tblexistingcustomercomplaintlodging', 'tblexistingcustomercomplaintlodging.ticketno', '=', 'tblticketassigneedetails.ticketno')
                ->where('tblticketassigneedetails.assigneecode', $assigneecode)
                ->whereIn('assigneestatus',array('ASSIGNED','REASSIGNED'))
                ->where('complaintdate','>','2018-04-01')
                ->count();

                $pendingComplaint = TicketAssignedModel::selectRaw('tblticketassigneedetails.*,tblexistingcustomercomplaintlodging.complaintdate')
                   ->leftJoin('tblexistingcustomercomplaintlodging', 'tblexistingcustomercomplaintlodging.ticketno', '=', 'tblticketassigneedetails.ticketno')
                   ->where('assigneecode', $assigneecode)->where('assigneestatus','PENDING')
                    ->where('complaintdate','>','2018-04-01')
                   ->count();


                $notResolvedComplaint = TicketAssignedModel::selectRaw('tblticketassigneedetails.*,tblexistingcustomercomplaintlodging.complaintdate')
                    ->leftJoin('tblexistingcustomercomplaintlodging', 'tblexistingcustomercomplaintlodging.ticketno', '=', 'tblticketassigneedetails.ticketno')
                    ->where('assigneecode', $assigneecode)
                    ->where('assigneestatus','NOT RESOLVED')
                    ->where('complaintdate','>','2018-04-01')
                    ->count();

                $resolvedComplaint = TicketAssignedModel::selectRaw('tblticketassigneedetails.*,tblexistingcustomercomplaintlodging.complaintdate,tblexistingcustomercomplaintlodging.complaintstatus')
                    ->leftJoin('tblexistingcustomercomplaintlodging', 'tblexistingcustomercomplaintlodging.ticketno', '=', 'tblticketassigneedetails.ticketno')
                    ->where('assigneecode', $assigneecode)
                    ->whereIn('assigneestatus',array('ReassignedResolved','RESOLVED'))
                    ->where('complaintstatus','!=','CLOSED')
                    ->where('complaintdate','>','2018-04-01')
                    ->count();

                $closedComplaints = TicketAssignedModel::selectRaw('tblticketassigneedetails.*,tblexistingcustomercomplaintlodging.complaintdate,tblexistingcustomercomplaintlodging.complaintstatus')
                ->join('tblexistingcustomercomplaintlodging', 'tblexistingcustomercomplaintlodging.ticketno', '=', 'tblticketassigneedetails.ticketno')
                ->where('assigneecode', $assigneecode)
                ->where('complaintstatus','=','CLOSED')
                    ->where('complaintdate','>','2018-04-01')
                ->count();

                return view('dashboard.assigneedashboard', compact('user','newComplaint','pendingComplaint','notResolvedComplaint',
                    'resolvedComplaint','closedComplaints'));
        }
        if (!Auth::guest() && $user == 'tender') {
            $user = Auth::user();
            return view('dashboard.tenderadmindashboard', compact('user'));
        }
    }

    public function get_modal()
    {
        $this->load->view('delete_modal');
    }

    public function getPartialEquipment(Request $request)
    {
        return view('partials2');
    }

    public function getPartial(Request $request)
    {
        return view('partials');
        return $complaint = DB::table('users')->where('contractno', $request->contractno)->get();

        if ($complaint) {
            return $this->load->view('partials');
//            return view('partials')->with('complaint', $complaint)->renderSections()['content1'];
        } else {
            return 'please check the ticket number you have enter';
        }
    }
}
