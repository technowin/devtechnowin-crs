<?php

namespace App\Http\Controllers;


use App\Models\ContractPaymentschedulesModel;
use App\Models\ContractPaymentTermModel;
use App\Models\ContractPaymentTermsModel;
use App\Models\PaymentdetailsModel;
use App\Models\ServiceManagementModel;

use App\Models\ContractInvoiceDetailsModel;

use App\Models\SupplyManagementModel;
use App\User;
use DateTimeZone;
use Illuminate\Http\Request;
use App\Models\EquipmentMasterModel;
use App\Models\IncrementMasterModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use PDF;
use Psy\Test\Exception\RuntimeExceptionTest;
use App\Models\ContractInvoiceandPaymentsModel;
use App\Models\ContractMasterModel;
use App\Models\ServiceParametersModel;
use App\Models\ContractDetailsModel;
use Auth;
use Ramsey\Uuid\Uuid;
use App\Models\CustomersModel;


class InvoicePaymentController extends Controller
{
    public function index()
    {
       $invoicepayment = DB::select(\DB::raw('select DISTINCT tbser.id, tbser.contractno,tbser.serviceadate,tbser.paymentduedate,tbser.srmdate,tbcp.paymentcycleno,tbinv.invoicebillno,tbinv.invoicesentdate,
  (select customername from tblcustomermaster where customercode=(select customercode from tblcontractmaster where contractno=tbser.contractno))as customername from tblservicemanagement as tbser
left join tblcontractpaymentschedules as tbcp on tbser.contractno=tbcp.contractno and tbser.paymentduedate=tbcp.paymentcycleenddate
left join tblcontractinvoicedetails as tbinv on tbser.contractno=tbinv.contractno and tbser.srmdate=tbinv.srndate
 where tbser.srmdate <= CURDATE() order by tbinv.invoicebillno'));

        return view('invoicepayment.index',compact('invoicepayment'));
    }
    public function create(Request $request,$id)
    {

           $servicemanagement=ServiceManagementModel::where('id',$id)->get()->first();
           $contractpaymentschedules=ContractPaymentschedulesModel::where('contractno',$servicemanagement->contractno)->where('paymentcycleenddate',$servicemanagement->paymentduedate)->get()->first();
            $contractinvoicedetails=ContractInvoiceDetailsModel::where('contractno',$servicemanagement->contractno)->where('srndate',$servicemanagement->srmdate)->get()->first();
           $contractdetails = ContractDetailsModel::where('contractno',$servicemanagement->contractno)->get();
           $invoicebillnodetails=ContractInvoiceDetailsModel::where('contractno',$servicemanagement->contractno)->where('paymentcycle',$contractpaymentschedules->paymentcycleno)->get()->first();
           $paymentinterval=ContractPaymentTermModel::select('paymentintervalforamc')->where('contractno',$servicemanagement->contractno)->get()->first();

          $serviceparametersid=ServiceParametersModel::where('name', $paymentinterval->paymentintervalforamc)->get()->first();
        return view('invoicepayment.genrateinvoice',compact('id','servicemanagement','contractpaymentschedules','contractinvoicedetails','contractdetails','invoicebillnodetails','serviceparametersid'));
    }
    public function saveinvoice(Request $request)
    {

        $lastincrementid = IncrementMasterModel::all()->where('incrementfor', 'InvoicePaymentDetails')->first()->incrementvalue;
        $code = str_pad($lastincrementid+1,3,"0",STR_PAD_LEFT);
        $itemarray=array('code'=>$code,'incrementid'=>$lastincrementid+1);
        $contractno = $request->contractno;
        $companytag ="Tec./";
        $startYear = date('Y');
        $endYear = $startYear  + 1;
        $currentyear = "/". $startYear . "-" . $endYear;
        $tempcode = $this->DynamicCode();
        $code = $tempcode['code'];
        $invoicegencode = $companytag.$code.$currentyear;
        $nofequipment= count($request->productservicename) ;
//        $invoiceamt=0;
//        for($i=0;$i<$nofequipment;$i++)
//        {
//            $invoiceamt=$invoiceamt+$request->totalamount[$i];
//        }
        for($i=0; $i<$nofequipment ;$i++)
        {
            $contractinvoicedetails = new ContractInvoiceDetailsModel();
            $contractinvoicedetails->id = Uuid::uuid1();
            $contractinvoicedetails->invoicebillno = $invoicegencode;
            $contractinvoicedetails->contractno = $request->contractno;
            $contractinvoicedetails->paymentcycle = $request->paymentcycleno;
            $contractinvoicedetails->srndate = $request->srmdate;
            $contractinvoicedetails->srnnotenumber =$this->checkifdataisempty($request->srnotenumber);
            $contractinvoicedetails->chequeno = $request->chequeno;
            $contractinvoicedetails->invoiceamount = $request->newtotal;
            $contractinvoicedetails->initialinvoiceamount = $request->initialinvoiceamount;
            $contractinvoicedetails->equipmenttype=$request->productservicename[$i];
            $contractinvoicedetails->hsncode=$request->hsncode[$i];
            $contractinvoicedetails->quantity=$request->quantity[$i];
            $contractinvoicedetails->rate=$request->rate[$i];
            $contractinvoicedetails->amount=$request->amount[$i];
            $contractinvoicedetails->cgstrate=$request->cgstrate[$i];
            $contractinvoicedetails->cgstamount=$request->cgstamt[$i];
            $contractinvoicedetails->sgstrate=$request->sgstrate[$i];
            $contractinvoicedetails->sgstamount=$request->sgstamt[$i];
            $contractinvoicedetails->taxrate=$request->taxrate[$i];
            $contractinvoicedetails->taxamount= $request->taxamt[$i];
            $contractinvoicedetails->totalamount=$request->totalamount[$i];
            $contractinvoicedetails->remarks=$request->remark[$i];
            $contractinvoicedetails->totalremark=$request->totalremark;
            $contractinvoicedetails->invoicedate=Carbon::now(new\ DateTimeZone('Asia/Kolkata'));
            $contractinvoicedetails->created_at=Carbon::now(new\ DateTimeZone('Asia/Kolkata'));
            $contractinvoicedetails->created_by = Auth::id();
            $contractinvoicedetails->updated_at=null;
            $contractinvoicedetails->save();
        }

         $paymentdetails = new PaymentdetailsModel();
         $paymentdetails->id = Uuid::uuid1();
         $paymentdetails->invoicebillno=$invoicegencode;
         $paymentdetails->invoiceamount=$request->newtotal;
         $paymentdetails->invoicedate=Carbon::now(new\DateTimeZone('Asia/Kolkata'));
         $paymentdetails->created_at=Carbon::now(new\DateTimeZone('Asia/Kolkata'));
         $paymentdetails->created_by=Auth::id();
         $paymentdetails->save();
        $incrementid = $code + 1;
        $id = "InvoicePaymentDetails";
        DB::table('tblincrementmaster')->where('incrementfor',$id)->limit(1)->update(array('incrementvalue' => $incrementid));
        return back()->withInput(array('id'=>$request->id));
    }
    public function DynamicCode()
    {
        $lastincrementid = IncrementMasterModel::all()->where('incrementfor', 'InvoicePaymentDetails')->first()->incrementvalue;
        $code = str_pad($lastincrementid+1,3,"0",STR_PAD_LEFT);
        $itemarray=array('code'=>$code,'incrementid'=>$lastincrementid+1);
        return $itemarray ;
    }
    public function edit($contractno,$paymentcycle)
    {

          $contractinvoicedetails=ContractInvoiceDetailsModel::where('contractno',$contractno)->where('paymentcycle',$paymentcycle)->get();
          $invoicedetails=$contractinvoicedetails->first();
        $paymentinterval=ContractPaymentTermModel::select('paymentintervalforamc')->where('contractno',$contractno)->get()->first();
        $serviceparametersid=ServiceParametersModel::where('name', $paymentinterval->paymentintervalforamc)->get()->first();

        return view('invoicepayment.edit',compact('contractno','contractinvoicedetails','invoicedetails','serviceparametersid'));
    }
    public function update(Request $request)
    {
       
//       return $model= ContractInvoiceDetailsModel::where('invoicebillno',$request->invoicebillno)->where('equipmenttype',$request->equipmenttype[1])->get();
           $nofequipmenttype=count($request->equipmenttype);
//           $invoiceamt=0;
//           for($i=0;$i<$nofequipmenttype;$i++)
//           {
//               $invoiceamt=$invoiceamt+$request->totalamount[$i];
//           }
        for ($i = 0; $i < $nofequipmenttype; $i++) {
            $modelid= ContractInvoiceDetailsModel::where('invoicebillno',$request->invoicebillno)->where('equipmenttype',$request->equipmenttype[$i])->get()->first();
           $model = ContractInvoiceDetailsModel::find($modelid->id);
           $model->invoiceamount=$request->newtotal;
            $model->initialinvoiceamount = $request->initialinvoiceamount;
           $model->quantity = $request->quantity[$i];
            $model->rate = $request->rate[$i];
            $model->amount = $request->amount[$i];
            $model->cgstamount = $request->cgstamount[$i];
            $model->sgstamount = $request->sgstamount[$i];
            $model->taxamount = $request->taxamount[$i];
            $model->totalamount = $request->totalamount[$i];
            $model->remarks = $request->remarks[$i];
            $model->totalremark=$request->totalremark;
            $model->updated_at=Carbon::now(new\DateTimeZone('Asia/Kolkata'));
            $model->updated_by=Auth::id();
            $model->save();
        }
           $paymentdetails=PaymentdetailsModel::find($request->invoicebillno);
           $paymentdetails->invoiceamount=$request->newtotal;

           $paymentdetails->save()                        ;
        return redirect('invoicepaymentdetails');
    }
    public function invoicereport($contractno,$paymentcycle)
    {

        $contractmatsrs=ContractMasterModel::where('contractno',$contractno)->get()->first();
        $contractsdetails = ContractDetailsModel::where('contractno',$contractno)->get()->first();
        $workordercustomer=CustomersModel::where('customercode',$contractmatsrs->customercode)->get()->first();
        $contractinvoicedetails=ContractInvoiceDetailsModel::where('contractno',$contractno)->where('paymentcycle',$paymentcycle)->get();
        $invoicedetails=$contractinvoicedetails->first();
        $convertrupee = $this->convertNumberToWord($invoicedetails->invoiceamount);
        return view('invoicepayment.invoicereport',compact('invoicedetails','contractinvoicedetails','convertrupee','workordercustomer','contractmatsrs','contractsdetails','contractno','paymentcycle'));
    }


    //sendinvoice changed to squotationendinvoice

    public function squotationendinvoice($contractno,$paymentcycle)     //sendinvoice
    {
        $contractmatsrs=ContractMasterModel::where('contractno',$contractno)->get()->first();
        $contractsdetails = ContractDetailsModel::where('contractno',$contractno)->get()->first();
        $workordercustomer=CustomersModel::where('customercode',$contractmatsrs->customercode)->get()->first();
//        $company=CompanyMasterModel::where('companyname',$workordercustomer->customername)->get()->first();
//        $company = CompanyMasterModel::where('address','=','Malad')->get()->first();
        $contractinvoicedetails=ContractInvoiceDetailsModel::where('contractno',$contractno)->where('paymentcycle',$paymentcycle)->get();
        $invoicedetails=$contractinvoicedetails->first();
        $convertrupee = $this->convertNumberToWord($invoicedetails->invoiceamount);
        return view('invoicepayment.sendinvoice',compact('invoicedetails','contractinvoicedetails','convertrupee','workordercustomer','contractmatsrs','contractsdetails'));
    }




    public function savesenddate(Request $request)
    {

       $contractinvoicedetails=ContractInvoiceDetailsModel::where('invoicebillno',$request->invoicebillno)->get();
        for ($i = 0; $i <count($contractinvoicedetails) ; $i++) {
             $model = ContractInvoiceDetailsModel::find($contractinvoicedetails[$i]->id);
            $model->invoicesentdate=$request->invoicesentdate;
            $model->save();
        }

        $paymentdetails=PaymentdetailsModel::find($request->invoicebillno);
        $paymentdetails->invoicesentdate=$request->invoicesentdate;
        $paymentdetails->save();

         $contractmatsrs=ContractMasterModel::where('contractno',$contractinvoicedetails->first()->contractno)->get()->first();
        if($contractmatsrs->workordertype=='Hardware Warranty') {
            return redirect('supplyindex');
        }else{
            return redirect('invoicepaymentdetails');
        }
    }
    public function download(Request $request)
    {
        $contractmatsrs=ContractMasterModel::where('contractno',$request->contractno)->get()->first();
        $contractsdetails = ContractDetailsModel::where('contractno',$request->contractno)->get()->first();
        $workordercustomer=CustomersModel::where('customercode',$contractmatsrs->customercode)->get()->first();
        $contractinvoicedetails=ContractInvoiceDetailsModel::where('contractno',$request->contractno)->where('paymentcycle',$request->paymentcycle)->get();
        $invoicedetails=$contractinvoicedetails->first();
        $convertrupee = $this->convertNumberToWord($invoicedetails->invoiceamount);
        $pdf = PDF::loadView('invoicepayment.pdfview',compact('invoicedetails','contractinvoicedetails','convertrupee','workordercustomer','contractmatsrs','contractsdetails'));
        return $pdf->download($invoicedetails->invoicebillno.'.pdf');
        return view('invoicepayment.invoicereport');
    }
//    supply
    public function supplyindex()
    {
        $invoicesupply=DB::select(\DB::raw('select DISTINCT ts.contractno,ts.customercode,tcps.paymentcycleno,
        tcps.paymentype,ts.installationdate,ts.inspectiondate,tcid.invoicebillno,tcid.invoicesentdate,
        (select customername from tblcustomermaster where customercode=ts.customercode)as customername
         from tblsupplymanagement as ts inner join tblcontractpaymentschedules as tcps on ts.contractno=tcps.contractno
         left join tblcontractinvoicedetails as tcid on ts.contractno=tcid.contractno and tcid.paymentcycle=tcps.paymentcycleno  where paymentype in(
         (case when ts.installationdate is not null then \'Installation Date\'
          end),(case when ts.inspectiondate is not null then \'Commisioning Date\'
          end),case when ts.actualcontractcompletiondate is not null then \'Contract Expiry Date\'end)'));

      return view('invoicepayment.supplyindex',compact('invoicesupply'));
    }
    public function supplyinvoice($contractno,$paymentcycle)
    {
         $supplymanagement=SupplyManagementModel::where('contractno',$contractno)->get()->first();
         $customer= CustomersModel::where('customercode',$supplymanagement->customercode)->get()->first();
         $contractdetails = ContractDetailsModel::where('contractno',$contractno)->get();
         $paymentype=ContractPaymentschedulesModel::where('contractno',$contractno)->where('paymentcycleno',$paymentcycle)->get()->first();
          $paymentterms=ContractPaymentTermsModel::where('contractno',$contractno)->get()->first();
        $contractinvoicedetails=ContractInvoiceDetailsModel::where('contractno',$contractno)->where('paymentcycle',$paymentcycle)->get()->first();

          if($paymentcycle==1) {
              $paymentpercent=$paymentterms->firstpaymentpercent;
          }elseif ($paymentcycle==2){
              $paymentpercent=$paymentterms->secondpaymentpercent;
          }elseif ($paymentcycle==3){
              $paymentpercent=$paymentterms->thirdpaymentpercent;
          }elseif ($paymentcycle==4){
              $paymentpercent=$paymentterms->fourthpaymentpercent;
          }elseif ($paymentcycle==5){
              $paymentpercent=$paymentterms->fifthpaymentpercent;
          }


        return view('invoicepayment.supplygenrateinvoice',compact('supplymanagement','contractdetails','paymentype','customer','paymentpercent','contractinvoicedetails'));
    }
    public function supplysaveinvoice(Request $request)
    {

        $lastincrementid = IncrementMasterModel::all()->where('incrementfor', 'InvoicePaymentDetails')->first()->incrementvalue;
        $code = str_pad($lastincrementid+1,3,"0",STR_PAD_LEFT);
        $itemarray=array('code'=>$code,'incrementid'=>$lastincrementid+1);
        $contractno = $request->contractno;
        $companytag ="Tec./";
        $startYear = date('Y');
        $endYear = $startYear  + 1;
        $currentyear = "/". $startYear . "-" . $endYear;
        $tempcode = $this->DynamicCode();
        $code = $tempcode['code'];
        $invoicegencode = $companytag.$code.$currentyear;
        $nofequipment= count($request->productservicename);

//        $invoiceamt=0;
//        for($i=0;$i<$nofequipment;$i++)
//        {
//            $invoiceamt=$invoiceamt+$request->totalamount[$i];
//        }
        for($i=0;$i<$nofequipment;$i++)
        {
            $contractinvoicedetails = new ContractInvoiceDetailsModel();
            $contractinvoicedetails->id=Uuid::uuid1();
            $contractinvoicedetails->invoicebillno = $invoicegencode;
            $contractinvoicedetails->contractno = $request->contractno;
            $contractinvoicedetails->paymentcycle = $request->paymentcycleno;
            $contractinvoicedetails->chequeno = $request->chequeno;
            $contractinvoicedetails->invoiceamount = $request->newtotal;
            $contractinvoicedetails->initialinvoiceamount = $request->initialinvoiceamount;
            $contractinvoicedetails->equipmenttype=$request->productservicename[$i];
            $contractinvoicedetails->hsncode=$request->hsncode[$i];
            $contractinvoicedetails->quantity=$request->quantity[$i];
            $contractinvoicedetails->rate=$request->rate[$i];
            $contractinvoicedetails->amount=$request->amount[$i];
            $contractinvoicedetails->cgstrate=$request->cgstrate[$i];
            $contractinvoicedetails->cgstamount=$request->cgstamt[$i];
            $contractinvoicedetails->sgstrate=$request->sgstrate[$i];
            $contractinvoicedetails->sgstamount=$request->sgstamt[$i];
            $contractinvoicedetails->taxrate=$request->taxrate[$i];
            $contractinvoicedetails->taxamount= $request->taxamt[$i];
            $contractinvoicedetails->totalamount=$request->totalamount[$i];
            $contractinvoicedetails->remarks=$request->remark[$i];
            $contractinvoicedetails->totalremark=$request->totalremark;
            $contractinvoicedetails->invoicedate=Carbon::now(new\DateTimeZone('Asia/Kolkata'));
            $contractinvoicedetails->created_at=Carbon::now(new\DateTimeZone('Asia/Kolkata'));
            $contractinvoicedetails->created_by = Auth::id();
            $contractinvoicedetails->updated_at=null;
            $contractinvoicedetails->save();
        }
        $paymentdetails=new PaymentdetailsModel();
        $paymentdetails->id=Uuid::uuid1();
        $paymentdetails->invoicebillno=$invoicegencode;
        $paymentdetails->invoiceamount=$request->newtotal;
        $paymentdetails->invoicedate=Carbon::now(new\DateTimeZone('Asia/Kolkata'));
        $paymentdetails->created_at=Carbon::now(new\DateTimeZone('Asia/Kolkata'));
        $paymentdetails->created_by=Auth::id();
        $paymentdetails->save();
        $incrementid = $tempcode['incrementid'];
        $id = "InvoicePaymentDetails";
        DB::table('tblincrementmaster')->where('incrementfor',$id)->limit(1)->update(array('incrementvalue' => $incrementid));
        return back();
    }
    public function supplyedit($contractno,$paymentcycle)
    {

         $contractinvoicedetails = DB::select(\DB::raw('select  tinv.*,tcd.warranty_amcperiod from tblcontractinvoicedetails as tinv
             join tblcontractdetails as tcd on tcd.productservicecode=(select  productservicecode from tblproductservicemaster where productservicename=tinv.equipmenttype)
             and tinv.contractno=tcd.contractno
            where tinv.contractno="'.$contractno.'" and tinv.paymentcycle='.$paymentcycle.''));
//        where tinv.contractno='..$contractno..' and tinv.paymentcycle=".$paymentcycle.""));

//      return  $contractinvoicedetails=ContractInvoiceDetailsModel::selectRaw('tblcontractinvoicedetails.equipmenttype,tblcontractinvoicedetails.quantity,tblcontractinvoicedetails.rate,
//        tblcontractinvoicedetails.amount,tblcontractinvoicedetails.cgstamount,tblcontractinvoicedetails.sgstamount,tblcontractinvoicedetails.taxamount,tblcontractinvoicedetails.totalamount,
//        tblcontractinvoicedetails.remarks,tblcontractinvoicedetails.sgstrate,tblcontractinvoicedetails.cgstrate,tblcontractinvoicedetails.taxrate,tblcontractinvoicedetails.totaltax,
//        tblcontractinvoicedetails.hsncode,tblcontractdetails.warranty_amcperiod')
//            ->leftjoin('tblcontractdetails','tblcontractinvoicedetails.contractno','=','tblcontractdetails.contractno')
//            ->where('tblcontractinvoicedetails.contractno',$contractno)->get();
//

        $invoicedetails = ContractInvoiceDetailsModel::where('contractno',$contractno)->where('paymentcycle',$paymentcycle)->get()->first();

//        $invoicedetails=$contractinvoicedetails->first();
        $contractpaymentschedule= ContractPaymentschedulesModel::where('contractno',$contractno)->where('paymentcycleno',$invoicedetails->paymentcycle)->get()->first();
        $paymentterms=ContractPaymentTermsModel::where('contractno',$contractno)->get()->first();
        $contractdetails = ContractDetailsModel::where('contractno',$contractno)->get();
        if($paymentcycle==1) {
            $paymentpercent=$paymentterms->firstpaymentpercent;
        }elseif ($paymentcycle==2){
            $paymentpercent=$paymentterms->secondpaymentpercent;
        }elseif ($paymentcycle==3){
            $paymentpercent=$paymentterms->thirdpaymentpercent;
        }elseif ($paymentcycle==4){
            $paymentpercent=$paymentterms->fourthpaymentpercent;
        }elseif ($paymentcycle==5){
            $paymentpercent=$paymentterms->fifthpaymentpercent;
        }

//        $paymentinterval=ContractPaymentTermModel::select('paymentintervalforamc')->where('contractno',$contractno)->get()->first();
//        $serviceparametersid=ServiceParametersModel::where('name', $paymentinterval->paymentintervalforamc)->get()->first();
        return view('invoicepayment.supplyedit',compact('contractno','invoicedetails','contractinvoicedetails','contractpaymentschedule','paymentpercent','contractdetails'));
    }
    public function supplyupdate(Request $request)
    {


        $nofequipmenttype=count($request->productservicename);
//        $invoiceamt=0;
//        for($i=0;$i<$nofequipmenttype;$i++)
//        {
//            $invoiceamt=$invoiceamt+$request->totalamount[$i];
//        }

        for ($i = 0; $i < $nofequipmenttype; $i++) {
            $modelid= ContractInvoiceDetailsModel::where('invoicebillno',$request->invoicebillno)->where('equipmenttype',$request->productservicename[$i])->get()->first();
            $model = ContractInvoiceDetailsModel::find($modelid->id);
            $model->invoiceamount=$request->newtotal;
            $model->initialinvoiceamount = $request->initialinvoiceamount;
            $model->quantity = $request->quantity[$i];
            $model->rate = $request->rate[$i];
            $model->amount = $request->amount[$i];
            $model->cgstamount = $request->cgstamt[$i];
            $model->sgstamount = $request->sgstamt[$i];
            $model->taxamount = $request->taxamt[$i];
            $model->totalamount = $request->totalamount[$i];
            $model->remarks = $request->remarks[$i];
            $model->totalremark=$request->totalremark;
            $model->updated_at=Carbon::now(new\DateTimeZone('Asia/Kolkata'));
            $model->updated_by=Auth::id();
            $model->save();
        }
        $paymentdetails=PaymentdetailsModel::find($request->invoicebillno);
        $paymentdetails->invoiceamount=$request->newtotal;
        $paymentdetails->save();
        return redirect('supplyindex');
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
        if(! $num) {
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
