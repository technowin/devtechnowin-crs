<?php

namespace App\Http\Controllers;

use App\Models\ProductServiceMasterModel;
use DateTimeZone;
use Illuminate\Http\Request;
use App\Models\ProspectiveQutationModel;
use App\Models\ProspectiveQutationdetailsModel;
use App\Models\CustomersModel;
use App\Models\CategoryMasterModel;
use App\Models\IncrementMasterModel;
use Auth;
use Carbon\Carbon;
use Ramsey\Uuid\Uuid;
use App\AppUser;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\PDF;

class prospectiveQutationController extends Controller
{

    public function index()
    {
        $ProspectiveQutation = ProspectiveQutationModel::all();
        return view('prospectivequotation.index',compact('ProspectiveQutation'));
    }

    public function create()
    {
        $organisationname = CustomersModel::pluck('customername','customercode')->all();
        $product = ProductServiceMasterModel::pluck('productservicename','productservicecode')->all();
        $category = CategoryMasterModel::pluck('categoryname','categorycode')->all();
        return view('prospectivequotation.create',compact('organisationname','product','category'));
    }

    public function store(Request $request)
    {
        $model = new ProspectiveQutationModel();
        $tablename = "ProspectiveQuotation";
        $tempcode= $this->quotationno($tablename);
        $code = $tempcode['code'];
        $incrementid = $tempcode['incrementid'];
        $model->quotationno = $code;
        $id = Uuid::uuid1();
        $model->id = $id;
        $model->quotationdate = $request->quotationdate;
        $model->customercode = $request->organizationname;
        $model->organizationaddress = $request->organizationaddress;
        $model->emailid = $request->emailid;
        $model->phone = $request->phone;
        $model->subject = $request->subject;
        $model->description = $request->description;
        $model->created_at = Carbon::now(new DateTimeZone('Asia/Kolkata'));
        $model->created_by = Auth::id();
        $model->save();
        if($model->save() == true)
        {
            $product = $request['productservicecode'];
            $count  = count($product);
            for ($i=0; $i < $count; $i++)
            {
                $prospectivequtationdetailsmodel = new ProspectiveQutationdetailsModel();
                $prospectivequtationdetailsmodel->quotationno = $code;
                $prospectivequtationdetailsmodel->productservicecode = $request['productservicecode'][$i];
                $prospectivequtationdetailsmodel->categorycode = $request['categorycode'][$i];
                $prospectivequtationdetailsmodel->configuration = $request['configuration'][$i];
                $prospectivequtationdetailsmodel->qty = $request['qty'][$i];
                $prospectivequtationdetailsmodel->rate = $request['rate'][$i];
                $prospectivequtationdetailsmodel->sgst = $request['sgst'][$i];
                $prospectivequtationdetailsmodel->sgstamt = $request['sgstamt'][$i];
                $prospectivequtationdetailsmodel->cgst = $request['cgst'][$i];
                $prospectivequtationdetailsmodel->cgstamt = $request['cgstamt'][$i];
                $prospectivequtationdetailsmodel->amt = $request['amt'][$i];
                $prospectivequtationdetailsmodel->total = $request['total'][$i];
                $prospectivequtationdetailsmodel->grandamt = $request['grandamt'][$i];
                $prospectivequtationdetailsmodel->modelno = $request['modelno'][$i];
                $prospectivequtationdetailsmodel->created_by = Auth::id();
                $prospectivequtationdetailsmodel->created_by = Auth::id();
                $prospectivequtationdetailsmodel->save();
            }
            $id = "ProspectiveQuotation";
            $modelincrement = IncrementMasterModel::find(IncrementMasterModel::where('incrementfor',$id)->first()->incrementid);
            $modelincrement->incrementvalue=$incrementid;
            $modelincrement->save();
        }
        return redirect('prospectivequotationindex');
    }

    public function edit($id)
    {
        $ProspectiveQutation = ProspectiveQutationModel::find($id);
        $organisationname = CustomersModel::pluck('customername','customercode');
        $organisationnamecode = $ProspectiveQutation->customercode;
        $ProspectiveQutationdetails = ProspectiveQutationdetailsModel::where('quotationno',$ProspectiveQutation->quotationno)->get();
        $product = ProductServiceMasterModel::pluck('productservicename','productservicecode')->all();
        $category = CategoryMasterModel::pluck('categoryname','categorycode')->all();
        $quotationdate = isset($ProspectiveQutation->quotationdate) ? date("Y-m-d", strtotime($ProspectiveQutation->quotationdate)) : '';
        return view('prospectivequotation.edit',compact('ProspectiveQutation','organisationname','organisationnamecode','ProspectiveQutationdetails','product','category','quotationdate'));
    }

    public function show($id)
    {
        $ProspectiveQutation = ProspectiveQutationModel::find($id);
        $organisationname = CustomersModel::pluck('customername','customercode');
        $organisationnamecode = $ProspectiveQutation->organizationname;
        $ProspectiveQutationdetails = ProspectiveQutationdetailsModel::where('quotationno',$ProspectiveQutation->quotationno)->get();
        $product = ProductServiceMasterModel::pluck('productservicename','productservicecode')->all();
        $category = CategoryMasterModel::pluck('categoryname','categorycode')->all();
        return view('prospectivequotation.details',compact('ProspectiveQutation','organisationname','organisationnamecode','ProspectiveQutationdetails','product','category'));
    }

    public function update(Request $request,$id)
    {
//      return $request->all();
        $prospectivequtationmodel = ProspectiveQutationModel::find($id);
        $quotationno =  $request['quotationno'];
        $prospectivequtationmodel->quotationdate = $request['quotationdate'];
        $prospectivequtationmodel->customercode = $request['organizationname'];
        $prospectivequtationmodel->organizationaddress = $request['organizationaddress'];
        $prospectivequtationmodel->emailid = $request['emailid'];
        $prospectivequtationmodel->phone = $request['phone'];
        $prospectivequtationmodel->subject = $request->subject;
        $prospectivequtationmodel->description = $request->description;

        $prospectivequtationmodel->save();
        if($prospectivequtationmodel->save() == true)
        {
            $count = count($request['prospectivequtationdetailsid']);
            for ($i=0;$i < $count; $i++)
            {
                if($request["prospectivequtationdetailsid"][$i] != '0')
                {
                    $prospectivequtationdetails = ProspectiveQutationdetailsModel::find($request["prospectivequtationdetailsid"][$i]);
                    $prospectivequtationdetails->updated_at = Carbon::now(new DateTimeZone('Asia/Kolkata'));
                    $prospectivequtationdetails->updated_by = Auth::id();
                }
                else
                {
                    $prospectivequtationdetails = new ProspectiveQutationdetailsModel();
                    $prospectivequtationdetails->created_at = Carbon::now(new DateTimeZone('Asia/Kolkata'));
                    $prospectivequtationdetails->created_by = Auth::id();
                }
                $prospectivequtationdetails->quotationno = $quotationno;
                $prospectivequtationdetails->productservicecode = $request['productservicecode'][$i];
                $prospectivequtationdetails->categorycode = $request['categorycode'][$i];
                $prospectivequtationdetails->configuration = $request['configuration'][$i];
                $prospectivequtationdetails->qty = $request['qty'][$i];
                $prospectivequtationdetails->rate = $request['rate'][$i];
                $prospectivequtationdetails->sgst = $request['sgst'][$i];
                $prospectivequtationdetails->sgstamt = $request['sgstamt'][$i];
                $prospectivequtationdetails->cgst = $request['cgst'][$i];
                $prospectivequtationdetails->cgstamt = $request['cgstamt'][$i];
                $prospectivequtationdetails->amt = $request['amt'][$i];
                $prospectivequtationdetails->total = $request['total'][$i];
                $prospectivequtationdetails->grandamt = $request['grandamt'][$i];
                $prospectivequtationdetails->modelno = $request['modelno'][$i];
                $prospectivequtationdetails->save();
            }
        }
        return redirect('prospectivequotationindex');
    }

    public function quotationno($tablename)
    {
        $lastincrementid = IncrementMasterModel::all()->where('incrementfor', $tablename)->first()->incrementvalue;
        $code = str_pad($lastincrementid + 1, 4, "0", STR_PAD_LEFT);
        $tech ="TEC/Quotation/";
        $newgenratedcode = $tech . $code . "/" . "2018-2019";
        $itemarray = array('code' => $newgenratedcode, 'incrementid' => $lastincrementid + 1);
        return $itemarray;
    }

    public  function report()
    {
        $organisationname = CustomersModel::pluck('customername','customercode')->all();
        $report = null;
        return view('prospectivequotation.report',compact('organisationname','report'));
    }

    public function getreport(Request $request)
    {
//        return $request->all();
        $fromdate = $request['fromdate'];
        $todate = $request['todate'];
        $customername = $request['organisationname'];
        if($customername != null)
        {
            if($request['fromdate'] !=null && $request['todate'] !=null )
            {
                $report = ProspectiveQutationModel::whereBetween('quotationdate',array($fromdate, $todate))->where('customercode',$customername)->get();
            }
            else
            {
                $report = ProspectiveQutationModel::where('customercode',$customername)->get();
            }
        }
        else
        {
            $report = ProspectiveQutationModel::whereBetween('quotationdate',array($fromdate, $todate))->get();
        }
        $mainreport = ProspectiveQutationdetailsModel::all();
        $organisationname = CustomersModel::pluck('customername','customercode')->all();
        return view('prospectivequotation.report',compact('report','mainreport','organisationname','fromdate','todate','customername'));
    }

    public function getpdf(Request $request)
    {
        $fromdate = $request['hdfromdate'];
        $todate = $request['hdtodate'];
        $organisationname = $request['hdorganisationname'];
        if($organisationname != null)
        {
            if($request['fromdate'] !=null && $request['todate'] !=null )
            {
                $report = ProspectiveQutationModel::whereBetween('quotationdate',array($fromdate, $todate))->where('customercode',$organisationname)->get();
            }
            else
            {
                $report = ProspectiveQutationModel::where('customercode',$organisationname)->get();
            }
        }
        else
        {
            $report = ProspectiveQutationModel::whereBetween('quotationdate',array($fromdate, $todate))->get();
        }
        $mainreport = ProspectiveQutationdetailsModel::all();
        $pdf = \PDF::loadView('prospectivequotation.reportpdf',compact('report','mainreport'));
        return $pdf->download();
    }

    public function genratequtaionreport($id)
    {
        $grandtotal = 0;
        $ProspectiveQutation = ProspectiveQutationModel::find($id);
        $ProspectiveQutationdetails = ProspectiveQutationdetailsModel::where('quotationno',$ProspectiveQutation->quotationno)->get();
       foreach($ProspectiveQutationdetails as $items)
       {
            $grandtotal += $items->grandamt;
       }

        return view('prospectivequotation.qutationreport',compact('ProspectiveQutation','ProspectiveQutationdetails','grandtotal'));
    }
}
