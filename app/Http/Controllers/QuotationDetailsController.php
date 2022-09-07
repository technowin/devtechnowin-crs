<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Masters\BranchMasterController;
use App\Models\AssigneeMasterModel;
use App\Models\BranchContactMasterModel;
use App\Models\BranchMasterModel;
use App\Models\CategoryMasterModel;
use App\Models\CustomersModel;
use App\Models\IncrementMasterModel;
use App\Models\ProductServiceMasterModel;
use App\Models\QuotationDetailsModel;
use App\Models\SaleProductModel;
use App\Models\SubCategoryMasterModel;
use App\Models\TicketAssignedModel;
use Carbon\Carbon;
use App\Models\ExistingUserComplaintLodging;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;
use Auth;
use Barryvdh\DomPDF\Facade as PDF;

class QuotationDetailsController extends Controller
{
    public function index()
    {
        $existingusercomplaint=DB::select(\DB::raw('SELECT t1.*,t1.id as tableid, t1.ticketno as Ticket,t1.typeofcall as CallType,t3.customername, t4.branchname, t5.productservicename, t6.categoryname, t7.subcategoryname, t2.* FROM tblexistingcustomercomplaintlodging t1 left
JOIN tblquotationdetails t2 ON t1.ticketno = t2.ticketno left JOIN tblcustomermaster t3 ON t1.customercode = t3.customercode left JOIN tblbranchmaster t4 ON t1.branchcode = t4.branchcode
LEFT JOIN tblproductservicemaster t5 ON t1.productservicecode = t5.productservicecode LEFT JOIN tblcategorymaster t6 ON t1.categorycode = t6.categorycode
LEFT JOIN tblsubcategorymaster t7 ON t1.subcategorycode = t7.subcategorycode WHERE t1.chargedcomplaint = 1 AND t1.typeofcall != \'Sale\''));
        return view('quotation.index',compact('existingusercomplaint'));
    }
    public function genratequotation($id)
    {
        $existingusercomplaint = ExistingUserComplaintLodging::where('id',$id)->get()->first();
        $customername=CustomersModel::where('customercode',$existingusercomplaint->customercode)->get()->first();
        $productservicename=ProductServiceMasterModel::where('productservicecode',$existingusercomplaint->productservicecode)->get()->first();
        $categoryname=CategoryMasterModel::where('categorycode',$existingusercomplaint->categorycode)->get()->first();
        $subcategoryname=SubCategoryMasterModel::where('subcategorycode',$existingusercomplaint->subcategorycode)->get()->first();
        $quotationdetails=QuotationDetailsModel::where('ticketno',$existingusercomplaint->ticketno)->get()->first();
        $branchmaster=BranchMasterModel::where('branchcode',$existingusercomplaint->branchcode)->get()->first();
        $saleproduct=SaleProductModel::where('ticketno',$existingusercomplaint->ticketno)->get()->first();
        if($existingusercomplaint->typeofcall =="Sale"){
            return view('quotation.salegenrate',compact('existingusercomplaint','customername','productservicename','categoryname','subcategoryname','quotationdetails','branchmaster','saleproduct'));

        }else{
            return view('quotation.genrate',compact('existingusercomplaint','customername','productservicename','categoryname','subcategoryname','quotationdetails','branchmaster'));
        }
    }
    public function savequotation(Request $request)
    {
        $lastincrementid= IncrementMasterModel::all()->where('incrementfor','Quotation')->first()->incrementvalue;
        $code = str_pad($lastincrementid+1,3,"0",STR_PAD_LEFT);
        $companytag ="TEC/EST/";
        $startYear = date('Y');
        $endYear = date('y')+ 1;
        $currentyear = "/". $startYear . "-" . $endYear;
        $quotationnumber=$companytag.$code.$currentyear;

        $ticketassigneedetails=TicketAssignedModel::selectraw('tblticketassigneedetails.ticketno,tblticketassigneedetails.assigneecode,tblassigneemaster.assigneename')
            ->leftjoin('tblassigneemaster','tblticketassigneedetails.assigneecode','=','tblassigneemaster.assigneecode')
            ->where('ticketno',$request->ticketno)->get();
        if($request->branchcode==null){
            $branchname=null;
        }else{
            $branchmaster=BranchMasterModel:: where('branchcode',$request->branchcode)->get()->first();
            $branchname=$branchmaster->branchname;
        }
        $assigneename='';
        for($i=0;$i<count($ticketassigneedetails);$i++)
        {
            $assigneename=$assigneename.$ticketassigneedetails[$i]->assigneename;
            if($i<count($ticketassigneedetails)-1)
            {
                $assigneename= $assigneename.', ';
            }
        }
        $quotationdetails = new QuotationDetailsModel();
        $quotationdetails->id=Uuid::uuid1();
        $quotationdetails->ticketno=$request->ticketno;
        $quotationdetails->typeofcall=$request->typeofcall;
        $quotationdetails->productsrno=$request->productsrno;
        $quotationdetails->customerid=$request->customercode;
        $quotationdetails->customersite=$branchname;
        $quotationdetails->serviceengineername=$assigneename;
        $quotationdetails->product=$request->product;
        $quotationdetails->category=$request->category;
        $quotationdetails->subcategory=$this->checkifdataisempty($request->subcategory);
        $quotationdetails->requested_enquiry_repairrequestdate=$request->requestedenquiryrepairrequestdate;
        $quotationdetails->requestedquantity=$request->requestedquantity;
        $quotationdetails->rate=$request->rate;
        $quotationdetails->gstrate=$request->gstrate;
        $quotationdetails->taxvalue=$request->taxvalue;
        $quotationdetails->quotationamount=$request->quotationamount;
        $quotationdetails->quotationnumber=$quotationnumber;
        $quotationdetails->quotationdate=$request->quotationdate;
        $quotationdetails->description=$request->description;
        $quotationdetails->subject=$request->subject;
        $quotationdetails->created_by=Auth::id();
        $quotationdetails->created_at=Carbon::now(new\DateTimeZone('Asia/Kolkata'));
        $quotationdetails->save();
        $incrementid = $code;
        DB::table('tblincrementmaster')->where('incrementfor','Quotation')->limit(1)->update(array('incrementvalue' => $incrementid));
//       return redirect('quotation');
//        return back();
        return redirect()->route('quotationreportdownload', $request->ticketno);
    }
    public function edit($id)
    {
        $quotationdetails=QuotationDetailsModel::where('ticketno',$id)->get()->first();
        $customername=CustomersModel::where('customercode',$quotationdetails->customerid)->get()->first();
        return view('quotation.edit',compact('quotationdetails','customername'));
    }
    public function update(Request $request)
    {
        $quotationdetails=QuotationDetailsModel::find($request->id);
        $quotationdetails->requested_enquiry_repairrequestdate=$request->requestedenquiryrepairrequestdate;
        $quotationdetails->requestedquantity=$request->requestedquantity;
        $quotationdetails->quotationdate=$request->quotationdate;
        $quotationdetails->rate=$request->rate;
        $quotationdetails->gstrate=$request->gstrate;
        $quotationdetails->taxvalue=$request->taxvalue;
        $quotationdetails->quotationamount=$request->quotationamount;
        $quotationdetails->description=$request->description;
        $quotationdetails->subject=$request->subject;
        $quotationdetails->updated_by=Auth::id();
        $quotationdetails->updated_at=Carbon::now(new\DateTimeZone('Asia/Kolkata'));
        $quotationdetails->save();
        return redirect('quotation')->with('flash_message','record successfully update for Quotation no.'.$request->quotationnumber);
    }
    public function quotationreport($ticketno)
    {
        $quotationdetails=QuotationDetailsModel::where('ticketno',$ticketno)->get()->first();
        $date=Carbon::parse($quotationdetails->quotationdate);
        $existingusercomplaint= ExistingUserComplaintLodging::where('ticketno',$ticketno)->get()->first();
        $convertrupee=$this->convertNumberToWord($quotationdetails->quotationamount);
        return view('quotation.quotationreport',compact('quotationdetails','date','existingusercomplaint','convertrupee'));

    }
    public function quotationstatus($ticketno)
    {
        $quotationdetails=QuotationDetailsModel::where('ticketno',$ticketno)->get()->first();
        $date=Carbon::parse($quotationdetails->quotationdate);
        $existingusercomplaint= ExistingUserComplaintLodging::where('ticketno',$ticketno)->get()->first();
        $convertrupee=$this->convertNumberToWord($quotationdetails->quotationamount);
        return view('quotation.quotationstatus',compact('quotationdetails','date','existingusercomplaint','convertrupee'));
    }
    public function savestatus(Request $request)
    {
        $quotationdetails=QuotationDetailsModel::where('quotationnumber',$request->quotationnumber)->get()->first();
        $quotationdetails->quotationstatus=$request->quotationstatus;
        $quotationdetails->finalquotationamount=$request->finalquotationamount;
        $quotationdetails->remarks=$request->remarks;
        $quotationdetails->save();
        return redirect('quotation');
    }
    public function dispatch($ticketno)
    {
        $quotationdetails=QuotationDetailsModel::where('ticketno',$ticketno)->get()->first();
        $customername=CustomersModel::where('customercode',$quotationdetails->customerid)->get()->first();
        return view('quotation.dispatchsale',compact('quotationdetails','customername'));
    }
    public function savedispatch(Request $request)
    {
        $lastincrementid = IncrementMasterModel::all()->where('incrementfor','QuotationInvoice')->first();      //->incrementvalue
        $code = str_pad($lastincrementid+1,3,"0",STR_PAD_LEFT);
        $companytag ="Tec./";
        $startYear = date('Y');
        $endYear = date('y')+ 1;
        $currentyear = "/". $startYear . "-" . $endYear;
        $invoiceno=$companytag.$code.$currentyear;
        $quotationdetails=QuotationDetailsModel::where('quotationnumber',$request->quotationnumber)->get()->first();
        $quotationdetails->invoiceno=$invoiceno;
        $quotationdetails->dispatchsaledate=$request->dispatchsaledate;
        $quotationdetails->dispatchsalequantity=$request->dispatchsalequantity;
        $quotationdetails->dispatchsaledetails=$request->dispatchsaledetails;
        $quotationdetails->saleamount=$request->saleamount;
        $quotationdetails->senttoscrap=$request->senttoscrap;
        $quotationdetails->scrappeddate=$request->scrappeddate;
        $quotationdetails->scrapdetails=$request->scrapdetails;
        $quotationdetails->save();
        $incrementid = $code;
        DB::table('tblincrementmaster')->where('incrementfor','QuotationInvoice')->limit(1)->update(array('incrementvalue' => $incrementid));
        return redirect('quotation');
    }
    public function downloadpdf(Request $request)
    {
        $quotationdetails=QuotationDetailsModel::where('quotationnumber',$request->quotationnumber)->get()->first();
        $date=Carbon::parse($quotationdetails->quotationdate);
        $existingusercomplaint= ExistingUserComplaintLodging::where('ticketno',$quotationdetails->ticketno)->get()->first();
        $convertrupee=$this->convertNumberToWord($quotationdetails->quotationamount);
        $pdf = \PDF::loadView('quotation.pdfview',compact('quotationdetails','date','existingusercomplaint','convertrupee'));
        return $pdf->download($request->quotationnumber.'.pdf');
        return view('quotation.quotationreport');
    }
    public function view($ticketno)
    {
        $quotationdetails=QuotationDetailsModel::where('ticketno',$ticketno)->get()->first();
        return view('quotation.viewquotation',compact('quotationdetails'));
    }
    public function indexsale()
    {
        $existingusercomplaint=DB::select(\DB::raw('select DISTINCT tecl.*,(select customername from tblcustomermaster where customercode=tecl.customercode)as customername,
             (select branchname from tblbranchmaster where branchcode=tecl.branchcode)as branchname,
				 tsp.quotationnumber,tsp.quotationstatus,tsp.productsupply from tblexistingcustomercomplaintlodging as tecl
              left join tblsaleproduct as tsp on tecl.ticketno=tsp.ticketno where chargedcomplaint=1 and tecl.typeofcall="sale"'));

        return view('quotation.indexsale',compact('existingusercomplaint'));
    }
    public function salegenratequotation(Request $request)
    {
        $lastincrementid= IncrementMasterModel::all()->where('incrementfor','Quotation')->first()->incrementvalue;

        $code = str_pad($lastincrementid+1,3,"0",STR_PAD_LEFT);
        $companytag ="TEC/EST/";
        $startYear = date('Y');
        $endYear = date('y')+ 1;
        $currentyear = "/". $startYear . "-" . $endYear;
        $quotationnumber=$companytag.$code.$currentyear;

        $quotationamount=0;
        for($j=0;$j<count($request->productdescription);$j++)
        {
            $quotationamount=$quotationamount+$request->amount[$j];
        }
        for($i=0;$i<count($request->productdescription);$i++)
        {
            $saleproduct=new SaleProductModel();
            $saleproduct->id=Uuid::uuid1();
            $saleproduct->ticketno=$request->ticketno;
            $saleproduct->customername=$request->customername;
            $saleproduct->customersite=$request->branchname;
            $saleproduct->productsupply=$request->productsupply;
            $saleproduct->productdescription=$request->productdescription[$i];
            $saleproduct->requestedquantity=$request->requestedquantity[$i];
            $saleproduct->rate=$request->rate[$i];
            $saleproduct->gstrate=$request->gst[$i];
            $saleproduct->taxvalue=$request->taxvalue[$i];
            $saleproduct->totalamount=$request->amount[$i];
            $saleproduct->quotationamount=$quotationamount;
            $saleproduct->quotationnumber=$quotationnumber;
            $saleproduct->quotationdate=$request->quotationdate;
            $saleproduct->save();
        }
        $incrementid = $code;
        DB::table('tblincrementmaster')->where('incrementfor','Quotation')->limit(1)->update(array('incrementvalue' => $incrementid));
       // return \Redirect::route('salequotation', $request->ticketno);
        return redirect()->route('salequotationdownload', $request->ticketno);
    }
    public function editsale($ticketno)
    {
        $saleproduct=SaleProductModel::where('ticketno',$ticketno)->orderby('id')->get();
        return view('quotation.saleedit',compact('saleproduct'));
    }
    public function updatesale(Request $request)
    {
        $quotamt=0;
        for($j=0;$j<count($request->productdescription);$j++)
        {
            $quotamt=$quotamt+$request->amount[$j];
        }
        $saleproduct=SaleProductModel::where('quotationnumber',$request->quotationnumber)->get();
        if(count($saleproduct)<count($request->productdescription))
        {
            for($i=0;$i<count($request->productdescription);$i++)
            {
                if($i<count($saleproduct)-1 || $i==count($request->productdescription)-1)
                {
                    if($i==count($request->productdescription)-1){
                        $id=count($saleproduct)-1;
                        $model=SaleProductModel::where('id',$request->id[$id])->get()->first();

                    }else{
                        $model=SaleProductModel::where('id',$request->id[$i])->get()->first();
                    }
                    $model->id=Uuid::uuid1();
                    $model->productsupply=$request->productsupply;
                    $model->productdescription=$request->productdescription[$i];
                    $model->requestedquantity=$request->requestedquantity[$i];
                    $model->rate=$request->rate[$i];
                    $model->gstrate=$request->gst[$i];
                    $model->taxvalue=$request->taxvalue[$i];
                    $model->totalamount=$request->amount[$i];
                    $model->quotationamount=$quotamt;
                    $model->updated_by=Auth::id();
                    $model->updated_at=Carbon::now(new\DateTimeZone('Asia/Kolkata'));
                    $model->save();
                }
                else
                {
                    $salemodel=new SaleProductModel();
                    $salemodel->id=Uuid::uuid1();
                    $salemodel->ticketno=$saleproduct->first()->ticketno;
                    $salemodel->customername=$saleproduct->first()->customername;
                    $salemodel->customersite=$saleproduct->first()->customersite;
                    $salemodel->productsupply=$request->productsupply;
                    $salemodel->productdescription=$request->productdescription[$i];
                    $salemodel->requestedquantity=$request->requestedquantity[$i];
                    $salemodel->rate=$request->rate[$i];
                    $salemodel->gstrate=$request->gst[$i];
                    $salemodel->taxvalue=$request->taxvalue[$i];
                    $salemodel->totalamount=$request->amount[$i];
                    $salemodel->quotationamount=$quotamt;
                    $salemodel->quotationnumber=$saleproduct->first()->quotationnumber;
                    $salemodel->quotationdate=$saleproduct->first()->quotationdate;
                    $salemodel->updated_by=Auth::id();
                    $salemodel->updated_at=Carbon::now(new\DateTimeZone('Asia/Kolkata'));
                    $salemodel->save();
                }
            }
        }
        else
        {
            for($i=0;$i<count($saleproduct);$i++)
            {
                $model=SaleProductModel::where('id',$request->id[$i])->get()->first();
                $model->productsupply=$request->productsupply;
                $model->productdescription=$request->productdescription[$i];
                $model->requestedquantity=$request->requestedquantity[$i];
                $model->rate=$request->rate[$i];
                $model->gstrate=$request->gst[$i];
                $model->taxvalue=$request->taxvalue[$i];
                $model->totalamount=$request->amount[$i];
                $model->quotationamount=$quotamt;
                $model->updated_by=Auth::id();
                $model->updated_at=Carbon::now(new\DateTimeZone('Asia/Kolkata'));
                $model->save();
            }
        }
        return redirect('saleproduct');
    }
    public function salequotation($ticketno)
    {
        $saleproduct=SaleProductModel::where('ticketno',$ticketno)->orderby('id')->get();
        $custaddres=CustomersModel::where('customername',$saleproduct->first()->customername)->get()->first();
        $totalproductamt=0;
        for($i=0;$i<count($saleproduct);$i++)
        {
            if($saleproduct[$i]->productdescription!="Installation Charge"){
                $totalproductamt=$totalproductamt+$saleproduct[$i]->totalamount;
            }
        }
        $date=Carbon::parse($saleproduct->first()->quotationdate);
        $convertrupee=$this->convertNumberToWord($saleproduct->first()->quotationamount);
        return view('quotation.salequotationreport',compact('saleproduct','totalproductamt','date','convertrupee','custaddres'));
    }
    public function salequotationstatus($ticketno)
    {
        $saleproduct=SaleProductModel::where('ticketno',$ticketno)->orderby('id')->get();
        $custaddres=CustomersModel::where('customername',$saleproduct->first()->customername)->get()->first();
        $totalproductamt=0;
        for($i=0;$i<count($saleproduct);$i++)
        {
            if($saleproduct[$i]->productdescription!="Installation Charge"){
                $totalproductamt=$totalproductamt+$saleproduct[$i]->totalamount;
            }
        }
        $date=Carbon::parse($saleproduct->first()->quotationdate);
        $convertrupee=$this->convertNumberToWord($saleproduct->first()->quotationamount);
        return view('quotation.salequotationstatus',compact('saleproduct','totalproductamt','date','convertrupee','custaddres'));
    }
    public function savesalestatus( Request $request)
    {
        $saleproduct=SaleProductModel::where('quotationnumber', $request->quotationnumber)->get();
        for($i=0;$i<count($saleproduct);$i++)
        {   $sale=$saleproduct[$i];
            $sale->quotationstatus=$request->quotationstatus;
            $sale->finalquotationamount=$request->finalquotationamount;
            $sale->remarks=$request->remarks;
            $sale->save();
        }
        return redirect('saleproduct');
    }
    public function saledownload(Request $request)
    {
        $saleproduct=SaleProductModel::where('quotationnumber',$request->quotationnumber)->orderby('id')->get();
        $custaddres=CustomersModel::where('customername',$saleproduct->first()->customername)->get()->first();
        $totalproductamt=0;
        for($i=0;$i<count($saleproduct);$i++)
        {
            if($saleproduct[$i]->productdescription!="Installation Charge"){
                $totalproductamt=$totalproductamt+$saleproduct[$i]->totalamount;
            }
        }
        $date=Carbon::parse($saleproduct->first()->quotationdate);
        $convertrupee=$this->convertNumberToWord($saleproduct->first()->quotationamount);
        $pdf=\PDF::loadView('quotation.salepdfview',compact('saleproduct','totalproductamt','date','convertrupee','custaddres'));
        return $pdf->download($request->quotationnumber.'.pdf');
    }
    public function saleview($ticketno)
    {
        $saleproduct=SaleProductModel::where('ticketno',$ticketno)->orderby('id')->get();
        return view('quotation.saleview',compact('saleproduct'));
    }
    public function checkifdataisempty($date)
    {
        if ($date == '')
            $date = null;
        return $date;
    }
    function convertNumberToWord($num = false)
    {
        $num = str_replace(array(',', ' '), '' , trim($num));
        if(!$num) {
            return false;
        }
        $num = (int) $num;
        $words = array();
        $list1 = array('', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine', 'ten', 'eleven',
            'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen'
        );
        $list2 = array('', 'ten', 'twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety', 'hundred');
        $list3 = array('', 'thousand', 'million', 'billion', 'trillion', 'quadrillion', 'quintillion', 'sextillion', 'septillion',
            'octillion', 'nonillion', 'decillion', 'undecillion', 'duodecillion', 'tredecillion', 'quattuordecillion',
            'quindecillion', 'sexdecillion', 'septendecillion', 'octodecillion', 'novemdecillion', 'vigintillion'
        );
        $num_length = strlen($num);
        $levels = (int) (($num_length + 2) / 3);
        $max_length = $levels * 3;
        $num = substr('00' . $num, -$max_length);
        $num_levels = str_split($num, 3);
        for ($i = 0; $i < count($num_levels); $i++) {
            $levels--;
            $hundreds = (int) ($num_levels[$i] / 100);
            $hundreds = ($hundreds ? ' ' . $list1[$hundreds] . ' hundred' . ' ' : '');
            $tens = (int) ($num_levels[$i] % 100);
            $singles = '';
            if ( $tens < 20 ) {
                $tens = ($tens ? ' ' . $list1[$tens] . ' ' : '' );
            } else {
                $tens = (int)($tens / 10);
                $tens = ' ' . $list2[$tens] . ' ';
                $singles = (int) ($num_levels[$i] % 10);
                $singles = ' ' . $list1[$singles] . ' ';
            }
            $words[] = $hundreds . $tens . $singles . ( ( $levels && ( int ) ( $num_levels[$i] ) ) ? ' ' . $list3[$levels] . ' ' : '' );
        } //end for loop
        $commas = count($words);
        if ($commas > 1) {
            $commas = $commas - 1;
        }
        return implode(' ', $words);
    }
}
