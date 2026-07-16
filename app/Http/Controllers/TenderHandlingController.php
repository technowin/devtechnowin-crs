<?php

namespace App\Http\Controllers;

use App;
use App\User;
use DateTimeZone;
use Exception;
use Illuminate\Http\Request;
use App\Models\TenderViewModel;
use App\Models\MailMasterModel;
use App\Models\SectorMasterModel;
use Carbon\Carbon;
use PDF;
use phpDocumentor\Reflection\Types\Null_;
use Psy\Test\Exception\RuntimeExceptionTest;
use Ramsey\Uuid\Codec\GuidStringCodec;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use App\Models\TenderStatusMaster;
use App\Models\TenderStatusDetails;
use App\Models\TenderBidderDetailsModel;
use App\Models\TenderbidderCompanyModel;
use Auth;
use App\Models\FileUplodedModel;
use Validator;


class TenderHandlingController extends Controller
{
    public function index()
    {
         $customers = \DB::select(\DB::raw('select id,tenderno,technicalbidstatus,commercialbidstatus,tenderstatus,bidtobesubmited,emdstatus,tenderdate,organisationname,department,subject,flagkey,ms_me from  tbltenderdetails where tenderstatus=\'Active\' or bidtobesubmited=\'YES\' and  (technicalbidstatus <> \'Rejected\' or technicalbidstatus  is null)and(technicalbidstatus <> \'Scrape\' or technicalbidstatus  is null)and(commercialbidstatus <> \'Rejected\' or commercialbidstatus  is null)and(commercialbidstatus <> \'Scrape\' or commercialbidstatus  is null)and tenderstatus != \'Expire Tenders\''));
         $expiredgetalltenderdata = TenderViewModel::where('tenderstatus', 'Expire Tenders')->get();
         $pendingemdtendersdata = TenderViewModel::select('id', 'tenderno', 'tenderdate', 'organisationname', 'department', 'subject', 'workordernumber','flagkey','bidtobesubmited')->whereRaw('(tenderstatus = ? OR tenderstatus = ?)and (bidtobesubmited  IS NULL OR bidtobesubmited != ?)', ['Active', 'Prospectice Rejected', 'YES'])->get();
         $emdnotcollected = TenderViewModel::where('emdstatus', '!=', 'Yes')->get();
         $emdcollected = TenderViewModel::where('emdstatus', '!=', 'No')->get();
         $alltenders = TenderViewModel::All();
        return view('tender.index', compact('customers', 'expiredgetalltenderdata', 'pendingemdtendersdata', 'emdnotcollected', 'alltenders','emdcollected'));
    }

    public function create()
    {
        $organisationname = TenderViewModel::pluck('organisationname','organisationname');
        $department = TenderViewModel::pluck('department','department');
        return view('tender.tenderregistration',compact('organisationname','department'));
    }

    public function newtenderregistration(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file.*' => 'file|mimes:jpg,jpeg,png,pdf,txt,xls,xlsx,doc,docx|max:8388608'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error-message', 'Only jpg,jpeg,png,pdf and txt are allowed')->withInput();
        } else {
            $model = new TenderViewModel;
            $model->id = Uuid::uuid1();
            $model->tenderno = $request->tenderno;
            $model->tenderdate = $request->tenderdate;
            $model->organisationname = $request->organisationname;
            $model->organisationaddress = $request->organisationaddress;
            $model->department = $request->department;
            $model->subject = $request->subject;
            $model->empanelledwithvendor = $request->empanelledwithvendor;
            $model->contactpersonname = $request->contactpersonname;
            $model->contactpersonmobileno = $request->contactpersonmobileno;
            $model->contactpersonemailid = $request->contactpersonemailid;
            $model->queryenddate = $request->queryenddate;
            $model->documentfee = $request->documentfee;
            $model->earnestmoneydeposit = $request->earnestmoneydeposit;
            $model->ms_me = $request->ms_me;                                    //Added By Maaviya
            $model->technicalbidopendate = $request->technicalbidopendate;
            $model->commercialbidopendate = $request->commercialbidopendate;
            $model->empanelledwithvendor = $request->empanelledwithvendor;
            //$model->contactpersonmobile2 = $request->contactpersonmobile2;
            //$model->contactpersonmobile3 = $request->contactpersonmobile3;
            if($request->bidtobesubmited == "NO")
            {
                $model->tenderstatus = 'Prospectice Rejected';
            }
            else
            {
                $model->tenderstatus = 'Active';
            }
            $model->prebidmeetingdate = $request->prebidmeetingdate;
            $model->bidsubmissiondate = $request->bidsubmissiondate;
            $model->bidtobesubmited = $request->bidtobesubmited;
            $model->created_at = Carbon::now(new DateTimeZone('Asia/Kolkata'));
            $model->created_by = Auth::id();
            $model->save();
            $files = $request->file('file');
            if($request->hasFile('file'))
            {
                $count = count($files);
                for($i=0; $i<$count ; $i++)
                {
                    $product = new FileUplodedModel();
                    $product->tenderno = $request->tenderno;
                    $file = $request->file('file')[$i];
                    $string = $file->getClientOriginalName();
                    $fileName = str_replace(' ', '-', $string);
                    $fileExtension = $file->getClientMimeType();
                    $filesize = $file->getClientSize();
                    $product->filename = $fileName;
                    $product->fileextesion = $fileExtension;
                    $product->filesize = $filesize;

                    $folderpath  = 'uploads'.'/';
                    $file->move($folderpath , $fileName);
                    $product->fileurl = $folderpath;
                    $product->save();
                }
            }
            return redirect('tender')->with('flash_message', $request->tenderno . ' added successfully');
        }
    }

    public function edit($id)
    {
        $model = TenderViewModel::where('id', $id)->get()->first();
        $tenderno = $model->tenderno;
        $tenderdate = isset($model->tenderdate) ? date("Y-m-d", strtotime($model->tenderdate)) : '';
        $organisationname = $model->organisationname;
        $organisationaddress = $model->organisationaddress;
        $subject = $model->subject;
        $documentfee = $model->documentfee;
        $earnestmoneydeposit = $model->earnestmoneydeposit;
        $documentreadandreviewed = isset($model->documentreadandreviewed) ? $model->documentreadandreviewed : 'No';
        $querytocustomer = $model->querytocustomer;
        $customerresponse = $model->customerresponse;
        $internalquery = $model->internalquery;
        $internalresponse = $model->internalresponse;
        $bidsubmissionstatus = $model->bidsubmissionstatus;
        $reasonforbidnotsubmitted = $model->reasonforbidnotsubmitted;
        $corrigendumnumber = $model->corrigendumnumber;
        $reasonforcorrigendum = $model->reasonforcorrigendum;
        $technicalbidstatus = $model->technicalbidstatus;
        $reasonforrejectiontb = $model->reasonforrejectiontb;
        $commercialbidstatus = $model->commercialbidstatus;
        $reasonforrejectioncb = $model->reasonforrejectioncb;
        $empanelledwithvendor = $model->empanelledwithvendor;
        $contactpersonname = $model->contactpersonname;
        $contactpersonmobileno = $model->contactpersonmobileno;
        $contactpersonmobile2 = $model->contactpersonmobile2;
        $contactpersonmobile3 = $model->contactpersonmobile3;
        $contactpersonemailid = $model->contactpersonemailid;
        $prebidmeeting = $model->prebidmeeting;
        $emdmode = $model->emdmode;
        $paymentmode = $model->paymentmode;
        $emdstatus = $model->emdstatus;
        $department = $model->department;
        $modeofbidsubmitted = $model->modeofbidsubmitted;
        $premeetingattended = $model->premeetingattended;
        $bidtobesubmited = $model->bidtobesubmited;
        $ms_me = $model->ms_me;

        $queryenddate = date("Y-m-d\TH:i:s.000", strtotime($model->queryenddate));
        if ($queryenddate == "1970-01-01T00:00:00.000") {
            $queryenddate = null;
        }
        $prebidmeetingdate = date("Y-m-d\TH:i:s.000", strtotime($model->prebidmeetingdate));
        if ($prebidmeetingdate == "1970-01-01T00:00:00.000") {
            $prebidmeetingdate = null;
        }
        $bidsubmissiondate = date("Y-m-d\TH:i:s.000", strtotime($model->bidsubmissiondate));
        if ($bidsubmissiondate == "1970-01-01T00:00:00.000") {
            $bidsubmissiondate = null;
        }
        $extendeddate = date("Y-m-d\TH:i:s.000", strtotime($model->extendeddate));
        if ($extendeddate == "1970-01-01T00:00:00.000") {
            $extendeddate = null;
        }
        $technicalbidopendate = date("Y-m-d\TH:i:s.000", strtotime($model->technicalbidopendate));
        if ($technicalbidopendate == "1970-01-01T00:00:00.000") {
            $technicalbidopendate = null;
        }
        if ($technicalbidopendate == "1970-01-01T00:00:00.000") {
            $technicalbidopendate = null;
        }

        $newtechnicalbiddate = date("Y-m-d\TH:i:s.000", strtotime($model->newtechnicalbiddate));
        if ($newtechnicalbiddate == "1970-01-01T00:00:00.000") {
            $newtechnicalbiddate = null;
        }
        $commercialbidopendate = date("Y-m-d\TH:i:s.000", strtotime($model->commercialbidopendate));
        if ($commercialbidopendate == "1970-01-01T00:00:00.000") {
            $commercialbidopendate = null;
        }

        $newcommercialbiddate = date("Y-m-d\TH:i:s.000", strtotime($model->newcommercialbiddate));
        if ($newcommercialbiddate == "1970-01-01T00:00:00.000") {
            $newcommercialbiddate = null;
        }
        $emdreturndate = date("Y-m-d\TH:i:s.000", strtotime($model->emdreturndate));
        if ($emdreturndate == "1970-01-01T00:00:00.000") {
            $emdreturndate = null;
        }
        $workordernumber = $model->workordernumber;
        $workorderstartdate = date("Y-m-d\TH:i:s.000", strtotime($model->workorderstartdate));
        if ($workorderstartdate == "1970-01-01T00:00:00.000") {
            $workorderstartdate = null;
        }
        $filedetails = FileUplodedModel::where('tenderno',$tenderno)->get();

        return view('tender.edittenderregistration', compact('id', 'tenderno', 'tenderdate', 'model', 'organisationname', 'organisationaddress', 'department',
            'subject', 'queryenddate', 'prebidmeetingdate', 'documentfee', 'earnestmoneydeposit', 'bidsubmissiondate', 'documentreadandreviewed', 'querytocustomer',
            'customerresponse', 'internalquery', 'internalresponse', 'bidsubmissionstatus', 'reasonforbidnotsubmitted', 'corrigendumnumber', 'reasonforcorrigendum',
            'extendeddate', 'technicalbidopendate', 'technicalbidstatus', 'reasonforrejectiontb', 'newtechnicalbiddate', 'commercialbidopendate', 'commercialbidstatus',
            'reasonforrejectioncb', 'newcommercialbiddate', 'emdreturndate', 'workordernumber', 'workorderstartdate', 'empanelledwithvendor', 'contactpersonname',
            'contactpersonmobileno', 'contactpersonemailid', 'prebidmeeting', 'emdcollected', 'emdmode', 'paymentmode', 'emdstatus', 'department', 'modeofbidsubmitted',
            'premeetingattended', 'bidtobesubmited','filedetails','contactpersonmobile2','contactpersonmobile3','ms_me'));
    }

    public function checkifdataisempty($date)
    {
        if ($date == null)
            $date = Null;

        return $date;
    }

    public function edittenderregistration(Request $request)
    {
//        return $request->all();
        #region Edit Existing Tender Details

        try
        {
            $model = TenderViewModel::find($request->tenderno);
            $model->tenderno = $request->tenderno;
            $model->tenderdate = $request->tenderdate;
            $model->organisationname = $request->organisationname;
            $model->organisationaddress = $request->organisationaddress;
            $model->department = $request->department;
            $model->subject = $request->subject;
            $model->queryenddate = $request->queryenddate;
            $model->prebidmeetingdate = $request->prebidmeetingdate;
            $model->documentfee = $request->documentfee;
            $model->earnestmoneydeposit = $request->earnestmoneydeposit;
            $model->bidsubmissiondate = $request->bidsubmissiondate;
            $model->documentreadandreviewed = $request->documentreadandreviewed;
            $model->querytocustomer = $request->querytocustomer;
            $model->customerresponse = $request->customerresponse;
            $model->internalquery = $request->internalquery;
            $model->internalresponse = $request->internalresponse;
            $model->bidsubmissionstatus = $request->bidsubmissionstatus;
            $model->reasonforbidnotsubmitted = $request->reasonfornotsubmitted;
            $model->corrigendumnumber = $request->corrigendumnumber;
            $model->reasonforcorrigendum = $request->reasonforcorrigendum;
            $model->extendeddate = $request->extendeddate;
            $model->technicalbidopendate = $request->technicalbidopendate;
            $model->technicalbidstatus = $request->technicalbidstatus;
            if ($request->technicalbidstatus == "Rejected") {
                $model->tenderstatus = 'Expire Tenders';
            }
            if ($request->technicalbidstatus == "Selected") {
                $model->tenderstatus = 'Active';
            }
            if ($request->technicalbidstatus == "Scrape") {
                $model->tenderstatus = 'Expire Tenders';
            }
//        if ($request->technicalbidstatus == null) {
//            $model->tenderstatus = 'Active';
//        }
            $model->reasonforrejectiontb = $request->technicalbidrejectionreason;
            $model->newtechnicalbiddate = $request->newtechnicalbiddate;
            $model->commercialbidopendate = $request->commercialbidopendate;
            $model->commercialbidstatus = $request->commercialbidstatus;
            if ($request->commercialbidstatus == "Rejected") {
                $model->tenderstatus = 'Expire Tenders';
            }
            if ($request->commercialbidstatus == "Selected") {
                $model->tenderstatus = 'Active';
            }
//        if ($request->commercialbidstatus == null) {
//            $model->tenderstatus = 'Active';
//        }
            $model->reasonforrejectioncb = $request->reasonforrejectionincommercialbid;
            $model->newcommercialbiddate = $request->newcommercialbiddate;
            $model->emdreturndate = $request->emdreturndate;
            $model->workordernumber = $request->workordernumber;
            $model->workorderstartdate = $request->workorderstartdate;
            $model->empanelledwithvendor = $request->empanelledwithvendor;
            $model->contactpersonname = $request->contactpersonname;
            $model->contactpersonmobileno = $request->contactpersonmobileno;
            $model->contactpersonemailid = $request->contactpersonemailid;
            $model->prebidmeeting = $request->prebidmeeting;
            $model->ms_me = $request->ms_me;                                //Added By Maaviya
            $model->updated_by = Auth::id();
            $model->updated_at = Carbon::now(new DateTimeZone('Asia/Kolkata'));
            $model->emdmode = $request->emdmode;
            $model->emdstatus = $request->emdstatus;
            $model->premeetingattended = $request->premeetingattended;
            $model->modeofbidsubmitted = $request->modeofbidsubmitted;
            if ($request->bidtobesubmited == "NO") {
                $model->bidtobesubmited = $request->bidtobesubmited;
                $model->tenderstatus = "Prospectice Rejected";
            } else {
                $model->bidtobesubmited = $request->bidtobesubmited;
            }
            if ($model->bidtobesubmited == "NO") {
                if ($request->bidtobesubmited == "YES") {
                    $model->bidtobesubmited = $request->bidtobesubmited;
                    $model->tenderstatus = "Active";
                }
            }
            $model->save();

            #region Insert Tender Status details into table
            $model = TenderViewModel::find($request->tenderno);
            $tender = $model->tenderno;

            $documentstatus = $model->documentreadandreviewed;
            $querystatus = $model->quary;
            $prebid = $model->prebidmeeting;
            $bid = $model->bidsubmissionstatus;
            $techbid = $model->technicalbidstatus;
            $commbid = $model->commercialbidstatus;
            $emdcollected = $model->emdcollected;

            $st = array($documentstatus, $querystatus, $prebid, $bid, $techbid, $commbid, $emdcollected);

            $statusnames = array('Read', 'Query Status', 'Pre Bid Meeting Status', 'Bid Submission Status', 'Technical Bid Status', 'Commercial Bid Status', 'EMD Collected');

            for ($i = 0; $i < count($statusnames); $i++) {
                $statusname = TenderStatusMaster::where('substatusname', $st[$i])->where('statusname', $statusnames[$i])->first();

                if (count($statusname) > 0) {
                    $checkifexists = null;
                    $getstatusids = TenderStatusMaster::where('statusid', $statusname->statusid)->get();

                    $exists = TenderStatusDetails::where('tenderno', $tender)
                        ->where('statusid', $statusname->statusid)->get();

                    if ($exists->count() > 0) {
                        $status1 = TenderStatusDetails::find($exists[0]->id);
                        $status1->updated_at = Carbon::now(new DateTimeZone('Asia/Kolkata'));
                        $status1->save();

                        $checkifexists = 'asdas';
                    }

                    if ($checkifexists == null) {
                        $status = new TenderStatusDetails();
                        $status->statusid = $statusname->statusid;
                        $status->tenderno = $tender;
                        $status->created_at = Carbon::now(new DateTimeZone('Asia/Kolkata'));
                        $status->updated_at = Carbon::now(new DateTimeZone('Asia/Kolkata'));
                        $status->save();
                    }
                }
            }


            #endregion

            //updating tender documents
            $files = $request->file('file');
//            dump($files);
//            return;
            if($request->hasFile('file'))
            {
                $count = count($files);
                for($i=0; $i<$count; $i++)
                {
                    $product = new FileUplodedModel();
                    $product->tenderno = $request->tenderno;
                    $file = $request->file('file')[$i];
                    $string = $file->getClientOriginalName();
                    $myfilename = str_replace(' ', '-', $string);
                    $fileExtension = $file->getClientMimeType();
                    $filesize = $file->getClientSize();
                    $product->filename = $myfilename;
                    $product->fileextesion = $fileExtension;
                    $product->filesize = $filesize;

//                $destinationPath    = '/uploads';
//                $filesource = $request->file('file')[$i]->move(public_path('/uploads'), $fileName);
//                $filesource = $file->move($destinationPath, $fileName);

                    $folderpath  = 'uploads'.'/';
                    //$file->move($folderpath , $myfilename);
                    $product->fileurl = $folderpath;

                    //$file->move(base_path('\modo\images'), $file->getClientOriginalName());

//                $product->fileurl = $filesource;

                    $product->save();
                }
            }
            #endregion

        }
        
        catch (Exception $ex) {
            $common = new CommonController;
            $common->ErrorLogging($ex, 'UserComplaint', 'newcomplaintregister');
            return 'Some error occurred while processing your request';
        }

        return redirect('tender')->with('flash_message', $request->tenderno . ' edited successfully');
    }

    public function details($id)
    {
        $model = TenderViewModel::where('id', $id)->get()->first();
        $tenderno = $model->tenderno;
        $tenderdate = isset($model->tenderdate) ? date("d-m-Y h:i", strtotime($model->tenderdate)) : ' - ';
        $organisation = isset($model->organisationname) ? $model->organisationname : ' - ';
        $organisationaddress = isset($model->organisationaddress) ? $model->organisationaddress : ' - ';
        $department = isset($model->department) ? $model->department : ' - ';
        $subject = isset($model->subject) ? $model->subject : ' - ';
        $queryenddate = isset($model->queryenddate) ? date("d-m-Y h:i", strtotime($model->queryenddate)) : ' - ';
        $prebidmeetingdate = isset($model->prebidmeetingdate) ? date("d-m-Y h:i", strtotime($model->prebidmeetingdate)) : ' - ';
        $documentfee = isset($model->documentfee) ? $model->documentfee : ' - ';
        $earnestmoneydeposit = isset($model->earnestmoneydeposit) ? $model->earnestmoneydeposit : ' - ';
        $bidsubmissiondate = isset($model->bidsubmissiondate) ? date("d-m-Y h:i", strtotime($model->bidsubmissiondate)) : ' - ';
        $documentreadandreviewed = isset($model->documentreadandreviewed) ? $model->documentreadandreviewed : ' - ';
        $querytocustomer = isset($model->querytocustomer) ? $model->querytocustomer : ' - ';
        $customerresponse = isset($model->customerresponse) ? $model->customerresponse : ' - ';
        $internalquery = isset($model->internalquery) ? $model->internalquery : ' - ';
        $internalresponse = isset($model->internalresponse) ? $model->internalresponse : ' - ';
        $bidsubmissionstatus = isset($model->bidsubmissionstatus) ? $model->bidsubmissionstatus : ' - ';
        $reasonforbidnotsubmitted = isset($model->reasonforbidnotsubmitted) ? $model->reasonforbidnotsubmitted : ' - ';
        $corrigendumnumber = isset($model->corrigendumnumber) ? $model->corrigendumnumber : ' - ';
        $reasonforcorrigendum = isset($model->reasonforcorrigendum) ? $model->reasonforcorrigendum : ' - ';
        $extendeddate = isset($model->extendeddate) ? date("d-m-Y h:i", strtotime($model->extendeddate)) : ' - ';
        $technicalbidopendate = isset($model->technicalbidopendate) ? date("d-m-Y h:i", strtotime($model->technicalbidopendate)) : ' - ';
        $technicalbidstatus = isset($model->technicalbidstatus) ? $model->technicalbidstatus : ' - ';
        $reasonforrejectiontb = isset($model->reasonforrejectiontb) ? $model->reasonforrejectiontb : ' - ';
        $newtechnicalbiddate = isset($model->newtechnicalbiddate) ? date("d-m-Y h:i", strtotime($model->newtechnicalbiddate)) : ' - ';
        $commercialbidopendate = isset($model->commercialbidopendate) ? date("d-m-Y h:i", strtotime($model->commercialbidopendate)) : ' - ';
        $commercialbidstatus = isset($model->commercialbidstatus) ? $model->commercialbidstatus : ' - ';
        $reasonforrejectioncb = isset($model->reasonforrejectioncb) ? $model->reasonforrejectioncb : ' - ';
        $newcommercialbiddate = isset($model->newcommercialbiddate) ? date("d-m-Y h:i", strtotime($model->newcommercialbiddate)) : ' - ';
        $emdreturndate = isset($model->emdreturndate) ? date("d-m-Y h:i", strtotime($model->emdreturndate)) : ' - ';
        $workordernumber = isset($model->workordernumber) ? $model->workordernumber : ' - ';
        $workorderstartdate = isset($model->workorderstartdate) ? date("d-m-Y h:i", strtotime($model->workorderstartdate)) : ' - ';
        $empanelledwithvendor = isset($model->empanelledwithvendor) ? $model->empanelledwithvendor : ' - ';
        $contactpersonname = isset($model->contactpersonname) ? $model->contactpersonname : ' - ';
        $contactpersonmobileno = isset($model->contactpersonmobileno) ? $model->contactpersonmobileno : ' - ';
        $contactpersonmobile2 = isset($model->contactpersonmobile2) ? $model->contactpersonmobile2 : ' - ';
        $contactpersonmobile3 = isset($model->contactpersonmobile3) ? $model->contactpersonmobile3 : ' - ';
        $contactpersonemailid = isset($model->contactpersonemailid) ? $model->contactpersonemailid : ' - ';
        $quary = isset($model->quary) ? $model->quary : ' - ';
        $prebidmeeting = isset($model->prebidmeeting) ? $model->prebidmeeting : ' - ';
        $emdstatus = isset($model->emdstatus) ? $model->emdstatus : ' - ';
        $ms_me = isset($model->ms_me) ? $model->ms_me : ' - ';                      //Added By Maaviya

        $filedetails = FileUplodedModel::where('tenderno',$tenderno)->get();
        return view('tender.tenderregistrationview', compact('tenderno', 'tenderdate', 'organisation', 'organisationaddress', 'department', 'subject',
            'queryenddate', 'prebidmeetingdate', 'documentfee', 'earnestmoneydeposit', 'bidsubmissiondate', 'documentreadandreviewed', 'querytocustomer', 'customerresponse',
            'internalquery', 'internalresponse', 'bidsubmissionstatus', 'reasonforbidnotsubmitted', 'corrigendumnumber', 'reasonforcorrigendum', 'extendeddate',
            'technicalbidopendate', 'technicalbidstatus', 'reasonforrejectiontb', 'newtechnicalbiddate', 'commercialbidopendate', 'commercialbidstatus', 'reasonforrejectioncb',
            'newcommercialbiddate', 'emdreturndate', 'workordernumber', 'workorderstartdate', 'empanelledwithvendor', 'contactpersonname', 'contactpersonmobileno',
            'contactpersonemailid', 'documents', 'quary', 'prebidmeeting', 'emdstatus','filedetails','contactpersonmobile2','contactpersonmobile3','ms_me'));
    }

    public function checktenderno()
    {
        $id = urldecode($_GET['id']);
        $tender = TenderViewModel::where('tenderno', $id)->count();
        if ($tender > 0)
            return 'true';
        else
            return 'false';
    }

    public function getfile($id)
    {
        $files = FileUplodedModel::find($id);
        return json_encode($files);
    }

    public function report()
    {
//       return $posts = TenderViewModel::select('id','tenderno','tenderdate','organisation','department','subject')->whereRaw('empanelledwithvendor is null and (technicalbidstatus = ? and  commercialbidstatus = ? ) or empanelledwithvendor = ? ',['Rejected','Rejected','No'])->get();
        return view('report.report');
    }

    public function statusreport($id)
    {
        try {
            if ($id == 'Selected') {
                $posts = TenderViewModel::where('commercialbidstatus', '=', 'Selected')->where('technicalbidstatus', '=', 'Selected')->where('workordernumber', '<>', '')->get();
            } else if ($id == 'Rejected') {
                $posts = TenderViewModel::where('commercialbidstatus', '=', 'Rejected')->where('technicalbidstatus', '=', 'Rejected')->where('workordernumber', '=', null)->get();
            } else if ($id == 'No') {
                $posts = TenderViewModel::select('id', 'tenderno', 'tenderdate', 'organisation', 'department', 'subject')->whereRaw('empanelledwithvendor is null and (technicalbidstatus = ? and  commercialbidstatus = ? ) or empanelledwithvendor = ? ', ['Rejected', 'Rejected', 'No'])->get();
            } else {
                $tendorno = TenderStatusDetails::select('statusid', 'tenderno')->where('statusid', '=', $id)->first()->tenderno;
                $posts = DB::select(db::raw("select tbltenderdetails.tenderno,tbltenderdetails.tenderdate,tbltenderdetails.organisation,tbltenderdetails.department,tbltenderdetails.subject,tbltenderdetails.id from tbltenderstatusdetails join tbltenderdetails on tbltenderdetails.tenderno=tbltenderstatusdetails.tenderno where tbltenderstatusdetails.id=(select max(id) from tbltenderstatusdetails where tbltenderstatusdetails.tenderno = '$tendorno')"));
            }

            Session::put('posts', $posts);
            return json_encode($posts);


        } catch (Exception $ex) {
            $this->ErrorLogging($ex, 'TenderHandlingController', 'statusreport');
            return 'Some error occurred while processing your request';
        }

    }

    public function tenderbidderview($id)
    {
        $tenderdetails= TenderViewModel::where('id', $id)->get()->first();
        if ($id != null) {
            $values = TenderBidderDetailsModel::where('tenderid', $id)->get();
            $count = count($values);
            foreach ($values as $value) {
                for ($i = 0; $i < $count; $i++) {
                    $nameofbidder = $value->nameofbidder;
                    $bidamount = $value->bidamount;
                    $component = $value->component;
                    $noofquantity = $value->noofquantity;
                    $perunitrate = $value->perunitrate;
                    $rateoftotalquantity = $value->rateoftotalquantity;
                }
            }
        }
        return view('tender.addtenderbidder', compact('id', 'tenderid', 'values', 'nameofbidder', 'bidamount', 'component', 'noofquantity', 'perunitrate',
            'rateoftotalquantity','tenderdetails'));
    }

    public function tenderbidderstore(Request $request, $id)
    {
//        return $test = $request['bidderid'];
        $componentcount = count($request['bidderid']);
        for ($i = 0; $i < $componentcount; $i++) {
            $model = new TenderbidderCompanyModel();
            $companyid = Uuid::uuid1();
            $model->id = $companyid;
            $model->tenderid = $id;
            $model->companyname = $request->nameofbidder[$i];
            $model->totalbidderamt = $request['totalamt'][$i];
            $model->created_at = Carbon::now(new DateTimeZone('Asia/Kolkata'));
            $model->updated_at = Carbon::now(new DateTimeZone('Asia/Kolkata'));
            $model->save();
            if ($model->save() == true) {
                $count = count($request->classid);
                for ($n = 0; $n < $count; $n++) {
                    if ($request['bidderid'][$i] == $request['classid'][$n]) {
                        $model = new TenderBidderDetailsModel();
                        $model->tenderid = $id;
                        $model->biddercompanynameid = $companyid;
                        $model->nameofbidder = $request['nameofbidder'][$i];
                        $model->totalbidderamt = $request['totalamt'][$i];
                        $model->component = $request['component'][$n];
                        $model->noofquantity = $request['noofquantity'][$n];
                        $model->perunitrate = $request['perunitrate'][$n];
                        $model->bidamount = $request['bidamount'][$n];
                        $model->created_at = Carbon::now(new DateTimeZone('Asia/Kolkata'));
                        $model->created_by = Auth::id();
                        $model->save();
                    }
                }
            }
        }
        $updatetender = TenderViewModel::where('id',$id)->get()->first();
        $updatetender->flagkey='1';
        $updatetender->save();
        return redirect('tender');
    }

    public function edittenderbidder($id)
    {
        $tenderbiddercompany = TenderbidderCompanyModel::where('tenderid', $id)->orderby('created_at','asc')->get();
        $tenderbidderdetails = TenderBidderDetailsModel::where('tenderid', $id)->get();
        $tenderdetails= TenderViewModel::where('id', $id)->get()->first();
        return view('tender.editenderbidder', compact('tenderbiddercompany', 'tenderbidderdetails', 'id','tenderdetails'));
    }

    public function updatetenderbidder(Request $request, $id)
    {
//        return $request->all();
        $companycount = count($request['savtendercompanyid']);
        for ($i = 0; $i < $companycount; $i++) {
            if ($request['savtendercompanyid'][$i] != '0') {
                $model = TenderbidderCompanyModel::find($request['savtendercompanyid'][$i]);
                $model->companyname = $request->nameofbidder[$i];
                $model->totalbidderamt = $request['totalbidderamt'][$i];
                $model->updated_at = Carbon::now(new DateTimeZone('Asia/Kolkata'));
                $model->save();

                $componentdetailscount = count($request['tenderdetailsaveid']);
                for ($n = 0; $n < $componentdetailscount; $n++) {
                    if ($request['tenderdetailsaveid'][$n] != '0' && $request['biddercompanynameid'][$n] == $request['savtendercompanyid'][$i]) {
                        $updattenderbidderdetails = TenderBidderDetailsModel::find($request['tenderdetailsaveid'][$n]);
                        $updattenderbidderdetails->component = $request['component'][$n];
                        $updattenderbidderdetails->biddercompanynameid = $request['savtendercompanyid'][$i];
                        $updattenderbidderdetails->noofquantity = $request['noofquantity'][$n];
                        $updattenderbidderdetails->perunitrate = $request['perunitrate'][$n];
                        $updattenderbidderdetails->bidamount = $request['bidamount'][$n];
                        $updattenderbidderdetails->save();
                    }
                    else if ($request['biddercompanynameid'][$n] == $request['savtendercompanyid'][$i]) {
                        $updattenderbidderdetails = new TenderBidderDetailsModel();
                        $updattenderbidderdetails->tenderid = $id;
                        $updattenderbidderdetails->biddercompanynameid = $request['savtendercompanyid'][$i];
                        $updattenderbidderdetails->nameofbidder = $request['nameofbidder'][$i];
                        $updattenderbidderdetails->component = $request['component'][$n];
                        $updattenderbidderdetails->noofquantity = $request['noofquantity'][$n];
                        $updattenderbidderdetails->perunitrate = $request['perunitrate'][$n];
                        $updattenderbidderdetails->bidamount = $request['bidamount'][$n];
                        $updattenderbidderdetails->created_at = Carbon::now(new DateTimeZone('Asia/Kolkata'));
                        $updattenderbidderdetails->created_by = Auth::id();
                        $updattenderbidderdetails->save();
                    }
                }

            } else {
                $model = new TenderbidderCompanyModel();
                $companyid = Uuid::uuid1();
                $model->id = $companyid;
                $model->tenderid = $id;
                $model->companyname = $request->nameofbidder[$i];
                $model->totalbidderamt = $request['totalbidderamt'][$i];
                $model->created_at = Carbon::now(new DateTimeZone('Asia/Kolkata'));
                $model->save();
                if($model->save() == true)
                {
                    $componentdetailscount = count($request['tenderdetailsaveid']);
                    for($c=0; $c < $componentdetailscount; $c++)
                    {
                        if($request['tenderdetailsaveid'][$c] =='0')
                        {
//                            if($request['tenderdetailsaveid'][$c] != '0' && $request['biddercompanynameid'][$c])
//                            {
                            $updattenderbidderdetails = new TenderBidderDetailsModel();
                            $updattenderbidderdetails->tenderid = $id;
                            $updattenderbidderdetails->biddercompanynameid = $companyid;
                            $updattenderbidderdetails->nameofbidder = $request->nameofbidder[$i];
                            $updattenderbidderdetails->component = $request['component'][$c];
                            $updattenderbidderdetails->noofquantity = $request['noofquantity'][$c];
                            $updattenderbidderdetails->perunitrate = $request['perunitrate'][$c];
                            $updattenderbidderdetails->bidamount = $request['bidamount'][$c];
                            $updattenderbidderdetails->created_at = Carbon::now(new DateTimeZone('Asia/Kolkata'));
                            $updattenderbidderdetails->created_by = Auth::id();
                            $updattenderbidderdetails->save();
//                            }
                        }

                    }
                }
            }
        }
        return redirect('tender');
    }

    public function pdfreport($id)
    {

        $value = TenderbidderCompanyModel::where('tenderid', $id)->get();
        $data = TenderBidderDetailsModel::where('tenderid', $id)->get();

        $table = "<table border='1' width='700px'  align='center'>";
        $table = $table . "<tr>";
        $table = $table . '<td colspan="4" style="border: silver 1px solid;" align="center"><b><h1>Report</h1></b>';
        $table = $table . '</td>';
        $table = $table . "</tr>";

        foreach ($value as $val) {
            $table = $table . "<tr>";
            $table = $table . '<td style="border: silver 1px solid;"><b>Company Name : </b>';
            $table = $table . $val->companyname;
            $table = $table . '</td>';
            $table = $table . '<td style="border: silver 1px solid;"><b>Total Amt : </b>';
            $table = $table . $val->totalbidderamt;
            $table = $table . '</td>';
            $table = $table . "</tr>";

            $table = $table . "<tr>";
            $table = $table . '<td style=\'text-align: center\'><b>Component</b>';
            $table = $table . '</td>';
            $table = $table . '<td style=\'text-align: center\'><b>QTY</b>';
            $table = $table . '</td>';
            $table = $table . '<td style=\'text-align: center\'><b>Rate</b>';
            $table = $table . '</td>';
            $table = $table . '<td style=\'text-align: center\'><b>AMT</b>';
            $table = $table . '</td>';
            $table = $table . "</tr>";

            foreach ($data as $mydata) {
                if ($val->id == $mydata->biddercompanynameid) {
                    $table = $table . "<tr>";
                    $table = $table . '<td style=\'text-align: center\'>';
                    $table = $table . $mydata->component;
                    $table = $table . '</td>';
                    $table = $table . '<td style=\'text-align: center\'>';
                    $table = $table . $mydata->noofquantity;
                    $table = $table . '</td>';
                    $table = $table . '<td style=\'text-align: center\'>';
                    $table = $table . $mydata->perunitrate;
                    $table = $table . '</td>';
                    $table = $table . '<td style=\'text-align: center\'>';
                    $table = $table . floatval($mydata->bidamount + 0);
                    $table = $table . '</td>';
                    $table = $table . "</tr>";
                }
            }
        }
        $table = $table . '</table>';
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadHTML($table);
        return $pdf->download();
    }

    public function directexpiredtender(Request $request)
    {
        $tenderno = $request['modal-input-name'];
        $updatetenderstatus = TenderViewModel::where('tenderno',$tenderno)->get()->first();
        $updatetenderstatus->tenderstatus = "Expire Tenders";
        $updatetenderstatus->rejectedreasons = $request['reasondescription'];
        $updatetenderstatus->save();
        return redirect('tender');
    }

    public function convertnotcollectpdf()
    {
//        $data = TenderViewModel::where('emdstatus','No')->get();
        $data = \DB::select(\DB::raw('select tenderno,emdstatus,date(tenderdate)as tenderdate ,department,subject,organisationname,earnestmoneydeposit from tbltenderdetails where emdstatus=\'No\''));
        $total = 0;
        $count = count($data);
        for ($i=0;$i<$count;$i++)
        {
            $total += $data[$i]->earnestmoneydeposit;
        }
//        return view('tender.emdnotcollected',compact('data',$data,'total',$total));
        $pdf = PDF::loadView('tender.emdnotcollected',compact('data',$data,'total',$total));
        return $pdf->download('NotCollectEmd.pdf');
    }

    public function convertcollectpdf($id)
    {
        return $id;
        $data = \DB::select(\DB::raw('select tenderno,emdstatus,date(tenderdate)as tenderdate ,department,subject,organisationname,earnestmoneydeposit from tbltenderdetails where emdstatus=\'Yes\''));
        $total = 0;
        $count = count($data);
        for ($i=0;$i<$count;$i++)
        {
            $total += $data[$i]->earnestmoneydeposit;
        }

        $pdf = PDF::loadView('tender.emdnotcollected',compact('data',$data,'total',$total));
        return $pdf->download('CollectEmd.pdf');
    }
}
