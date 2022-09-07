<?php

namespace App\Http\Controllers;

use App\Models\ProductServiceMasterModel;
use App\Models\SalesLeadModel;
use App\Models\SalesLeadProductModel;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;
use Carbon\Carbon;
use Auth;

class SalesLeadController extends Controller
{
    public function index()
    {

        return view('saleslead.index');
    }

    public function getallsaleslead(Request $request){

        $columns = array(
            0 =>'id',
            1 =>'customername',
            2=> 'customermobileno',
            3=> 'customeremail',
            4=> 'meetingdate',
            5=> 'orderreceived',
            6=> 'options'
        );

        if(auth()->user()->hasRole('employee')){
            $totalData = SalesLeadModel::where('created_by', Auth::id())->count();
        }
        else{
            $totalData = SalesLeadModel::count();
        }

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if(empty($request->input('search.value')))
        {
            if(auth()->user()->hasRole('employee')){
                $posts = SalesLeadModel::where('created_by', Auth::id())
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order,$dir)
                    ->get();
            }
            else{
                $posts = SalesLeadModel::offset($start)
                    ->limit($limit)
                    ->orderBy($order,$dir)
                    ->get();
            }
        }
        else {
            $search = $request->input('search.value');

            if(auth()->user()->hasRole('employee')){
                $posts =  SalesLeadModel::where('created_by', Auth::id())
                    ->where('customername','LIKE',"%{$search}%")
                    ->orWhere('customermobileno', 'LIKE',"%{$search}%")
                    ->orWhere('customeremail', 'LIKE',"%{$search}%")
                    ->orWhere('meetingdate', 'LIKE',"%{$search}%")
                    ->orWhere('salesorderreceived', 'LIKE',"%{$search}%")
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order,$dir)
                    ->get();

                $totalFiltered = SalesLeadModel::where('created_by', Auth::id())
                    ->where('customername','LIKE',"%{$search}%")
                    ->orWhere('customermobileno', 'LIKE',"%{$search}%")
                    ->orWhere('customeremail', 'LIKE',"%{$search}%")
                    ->orWhere('meetingdate', 'LIKE',"%{$search}%")
                    ->orWhere('salesorderreceived', 'LIKE',"%{$search}%")
                    ->count();
            }
            else{
                $posts =  SalesLeadModel::where('customername','LIKE',"%{$search}%")
                    ->orWhere('customermobileno', 'LIKE',"%{$search}%")
                    ->orWhere('customeremail', 'LIKE',"%{$search}%")
                    ->orWhere('meetingdate', 'LIKE',"%{$search}%")
                    ->orWhere('salesorderreceived', 'LIKE',"%{$search}%")
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order,$dir)
                    ->get();

                $totalFiltered = SalesLeadModel::where('customername','LIKE',"%{$search}%")
                    ->orWhere('customermobileno', 'LIKE',"%{$search}%")
                    ->orWhere('customeremail', 'LIKE',"%{$search}%")
                    ->orWhere('meetingdate', 'LIKE',"%{$search}%")
                    ->orWhere('salesorderreceived', 'LIKE',"%{$search}%")
                    ->count();
            }
        }

        $data = array();
        if(!empty($posts))
        {
            $count = 1;
            foreach ($posts as $post)
            {
                $nestedData['id'] = $count++;
                $nestedData['customername'] = $post->customername;
                $nestedData['customermobileno'] = $post->customermobileno;
                $nestedData['customeremail'] = $post->customeremail;
                $nestedData['meetingdate'] = isset($post->meetingdate) ? date('d-m-Y', strtotime($post->meetingdate)) : '';
                $nestedData['orderreceived'] = $post->salesorderreceived;
                $nestedData['options'] = "&emsp;<a href=\"saleslead/show/$post->id\" style=\"margin-right: 3px;\">view</a>
                                          | <a href=\"saleslead/edit/$post->id\" style=\"margin - right: 3px;\">edit</a>";
                $data[] = $nestedData;
            }
        }

        $json_data = array(
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $data
        );

        echo json_encode($json_data);
    }

    public function create(){
        $productservice = ProductServiceMasterModel::pluck('productservicename','productservicecode')->all();
        return view('saleslead.addnewlead', compact('productservice'));
    }

    public function addnewlead(Request $request){

        $sales = new SalesLeadModel;
        $uuid = Uuid::uuid1();
        $sales->id = $uuid;
        $sales->meetingdate = $request->meetingdate;
        $sales->customername = $request->customername;
        $sales->customeraddress = $request->customeraddress;
        $sales->customermobileno = $request->customermobileno;
        $sales->customeremail = $request->customeremail;
        $sales->salescomment = $request->salescomment;
        $sales->futureaction = $request->futureaction;
        $sales->futureactiondate = $request->futureactiondate;
        $sales->salesorderreceived = $request->salesorderreceived;
        $sales->created_at = Carbon::now(new \DateTimeZone('Asia/Kolkata'));
        $sales->created_by = Auth::id();
        $sales->updated_at = Carbon::now(new \DateTimeZone('Asia/Kolkata'));
        $sales->save();

        foreach ($request->product as $all){
            $salesproduct = new SalesLeadProductModel;

            $salesproduct->salesleadid = $uuid;
            $salesproduct->productid = $all;
            $salesproduct->created_at = Carbon::now(new \DateTimeZone('Asia/Kolkata'));
            $salesproduct->created_by = Auth::id();
            $salesproduct->updated_at = Carbon::now(new \DateTimeZone('Asia/Kolkata'));
            $salesproduct->save();
        }

        return redirect('saleslead')->with('flash_message','Sales lead for the customer '.$request->customername.' is added successfully');
    }

//    View Details
    public function show($id){

        $result = SalesLeadModel::find($id);

        $meetingdate = isset($result->meetingdate) ? date("d-m-Y", strtotime($result->meetingdate)) : ' - ';
        $customername = isset($result->customername) ? $result->customername : ' - ';
        $customeraddress = isset($result->customeraddress) ? $result->customeraddress : ' - ';
        $customermobileno = isset($result->customermobileno) ? $result->customermobileno : ' - ';
        $customeremail = isset($result->customeremail) ? $result->customeremail : ' - ';
        $salescomment = isset($result->salescomment) ? $result->salescomment : ' - ';
        $futureaction = isset($result->futureaction) ? $result->futureaction : ' - ';
        $futureactiondate = isset($result->futureactiondate) ? date("d-m-Y", strtotime($result->futureactiondate)) : ' - ';
        $salesorderreceived = isset($result->salesorderreceived) ? $result->salesorderreceived : ' - ';
        $products = SalesLeadProductModel::where('salesleadid', $id)->pluck('productid')->all();


      return  $productservice = ProductServiceMasterModel::select('productservicename','productservicecode')->get();

        $productsname = null;
        foreach ($products as $item) {
            if($productsname == null){
                $productsname = $productservice->where('productservicecode', $item)->pluck('productservicename')->first();
            }
            else{
                $productsname = $productsname.', '.$productservice->where('productservicecode', $item)->pluck('productservicename')->first();
            }
        }
        if($productsname == null){
            $productsname = ' - ';
        }

        return view('saleslead.viewlead', compact('meetingdate', 'customername', 'customeraddress', 'customeremail', 'customermobileno', 'salescomment', 'futureaction', 'futureactiondate', 'salesorderreceived', 'productsname', 'id'));
    }

//    Edit Get
    public function edit($id){

        $result = SalesLeadModel::find($id);
        $meetingdate = isset($result->meetingdate) ? date("Y-m-d", strtotime($result->meetingdate)) : '';
        $customername = $result->customername;
        $customeraddress = $result->customeraddress;
        $customermobileno = $result->customermobileno;
        $customeremail = $result->customeremail;
        $salescomment = $result->salescomment;
        $futureaction = $result->futureaction;
        $futureactiondate = isset($result->futureactiondate) ? date("Y-m-d", strtotime($result->futureactiondate)) : '';
        $salesorderreceived = $result->salesorderreceived;

        $product = SalesLeadProductModel::where('salesleadid', $id)->pluck('productid')->all();
        $productservice = ProductServiceMasterModel::pluck('productservicename','productservicecode')->all();

        return view('saleslead.editlead', compact('meetingdate', 'customername', 'customeraddress', 'customeremail', 'customermobileno', 'salescomment', 'futureaction', 'futureactiondate', 'salesorderreceived', 'product', 'productservice', 'id'));
    }

//    Edit Post
         public function editlead(Request $request){

        $sales = SalesLeadModel::find($request->id);
        $sales->meetingdate = $request->meetingdate;
        $sales->customername = $request->customername;
        $sales->customeraddress = $request->customeraddress;
        $sales->customermobileno = $request->customermobileno;
        $sales->customeremail = $request->customeremail;
        $sales->salescomment = $request->salescomment;
        $sales->futureaction = $request->futureaction;
        $sales->futureactiondate = $request->futureactiondate;
        $sales->salesorderreceived = $request->salesorderreceived;
        $sales->updated_at = Carbon::now(new \DateTimeZone('Asia/Kolkata'));
        $sales->updated_by = Auth::id();
        $sales->save();

        $product = SalesLeadProductModel::where('salesleadid', $request->id)->pluck('productid')->all();

        $addnewvalues = array_diff($request->product, $product);
        $deletevalues = array_diff($product, $request->product);


        foreach ($deletevalues as $value){
            $salesproductsdelete = SalesLeadProductModel::where('salesleadid', $request->id)->where('productid', $value);
            $salesproductsdelete->delete();
        }

        foreach ($addnewvalues as $item){
            $salesproduct = new SalesLeadProductModel;
            $salesproduct->salesleadid = $request->id;
            $salesproduct->productid = $item;
            $salesproduct->created_at = Carbon::now(new \DateTimeZone('Asia/Kolkata'));
            $salesproduct->created_by = Auth::id();
            $salesproduct->updated_at = Carbon::now(new \DateTimeZone('Asia/Kolkata'));
            $salesproduct->save();
        }
        return redirect('saleslead')->with('flash_message','Sales lead for the customer '.$request->customername.' edited successfully');
    }
}