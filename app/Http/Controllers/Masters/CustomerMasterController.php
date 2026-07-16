<?php

namespace App\Http\Controllers\Masters;

use DateTimeZone;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CustomersModel;
use App\Models\IncrementMasterModel;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Response;


class CustomerMasterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
//      return $test = CustomersModel::orderBy('created_at', 'desc')->get();
//           ->orderBy('something', 'asc');

        $request->user()->authorizeRoles(['admin']);
        $count = CustomersModel::all()->count();
        $customers = CustomersModel::orderBy('customername', 'asc')->paginate($count);
//        $customers = CustomersModel::orderBy('created_at', 'desc')->paginate($count);
        $costomercode = $customers->pluck('customername','customername')->all();

        return view('masters.customermaster.index',compact('customers','costomercode'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {

        $customers = CustomersModel::all();
        $costomercode = $customers->pluck('customername','customername')->all();
        return view('masters.customermaster.create' ,compact('costomercode'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
       try
       {
           $model= new CustomersModel();
           $model->customername=$request["customername"];
           $mystr=$request["customername"];
           $tempcode = $this->DynamicCode($mystr);
           $code=$tempcode['code'];
           $model->customercode=$code;
           $incrementid=$tempcode['incrementid'];
           $model->customerphone=$request["customerphone"];
           $model->customerfax=$request["customerfax"];
           $model->emailid=$request["emailid"];
           $model->customerwebsite=$request["customerwebsite"];
           $model->contactpersonname=$request["contactpersonname"];
           $model->contactpersondesignation=$request["contactpersondesignation"];
           $model->contactpersonphone=$request["contactpersonphone"];
           $model->contactpersonmobile=$request["contactpersonmobile"];
           $model->contactpersonemailid=$request["contactpersonemailid"];
           $model->customerpanno=$request["customerpanno"];
           $model->customergstno=$request["customergstno"];
           $model->customertype=$request["customertype"];
           $model->contactpersondepartment=$request["contactpersondepartment"];
           $model->address=$request["address"];
           $model->contactpersonname=$request["contactpersonname"];
           $model->state=$request["state"];
           $model->statecode=$request["statecode"];
           $model->created_at = Carbon::now(new DateTimeZone('Asia/Kolkata'));
           $model->created_by = Auth::id();
           $model->updated_at = null;


           $model->save();
           if ($model->save()== true)
           {
               $id="Customer";
               $modelincrement = IncrementMasterModel::find(IncrementMasterModel::where('incrementfor',$id)->first()->incrementid);
               $modelincrement->incrementvalue=$incrementid;
               $modelincrement->save();
           }
           return redirect('customers');

       }
       catch (Exception $ex) {
           return $ex->getMessage();
           return 'Some error occurred while processing your request';

       }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        try
        {
            $customers = CustomersModel::findOrFail($id);

            return view('masters.customermaster.details', compact('customers'));
        }
        catch (Exception $ex){
            return $ex->getMessage();
            return 'Some error occurred while processing your request';
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        try
        {


            $customers = CustomersModel::findOrFail($id);
            return view('masters.customermaster.edit', compact('customers'));

        }
        catch (Exception $ex){
            return $ex->getMessage();
            return 'Some error occurred while processing your request';
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {

        $model = CustomersModel::findOrFail($id);
        $model->customername=$request["customername"];
        $model->customerphone=$request["customerphone"];
        $model->customerfax=$request["customerfax"];
        $model->emailid=$request["emailid"];
        $model->customerwebsite=$request["customerwebsite"];
        $model->contactpersonname=$request["contactpersonname"];
        $model->contactpersondesignation=$request["contactpersondesignation"];
        $model->contactpersonphone=$request["contactpersonphone"];
        $model->contactpersonmobile=$request["contactpersonmobile"];
        $model->contactpersonemailid=$request["contactpersonemailid"];
        $model->customerpanno=$request["customerpanno"];
        $model->customergstno=$request["customergstno"];
        $model->customertype=$request["customertype"];
        $model->contactpersondepartment=$request["contactpersondepartment"];
        $model->address=$request["address"];
        $model->contactpersonname=$request["contactpersonname"];
        $model->state=$request["state"];
        $model->statecode=$request["statecode"];

        $model->updated_at = Carbon::now(new DateTimeZone('Asia/Kolkata'));  //ajay
        $model->updated_by = Auth::id();
        $model->save();

        return redirect('customers');
    }


    public function DynamicCode($mystr)
    {
        $lastincrementid = IncrementMasterModel::all()->where('incrementfor', 'Customer')->first()->incrementvalue;
        $code = str_pad($lastincrementid+1, 4, "0", STR_PAD_LEFT);
        $newgenratedcode=strtoupper(mb_substr($mystr,0,2).($code));
        $itemarray=array('code'=>$newgenratedcode,'incrementid'=>$lastincrementid+1);
        return  $itemarray ;
    }


    public function getIndexData(Request $request){
        $columns = array(
            0 =>'customercode',
            1 =>'customername',
            2 =>'customerphone',
            3 =>'customerfax',
            4 =>'emailid',
            5 =>'customerwebsite',
            6 =>'contactpersonname',
            7 =>'contactpersonphone',
            8 =>'contactpersonmobile',
            9 =>'contactpersonemailid',
            10 =>'customerpanno',
            11 =>'customergstno',
            12=>'contactpersondesignation',
            13 =>'options',
        );

        $totalData = CustomersModel::count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if(empty($request->input('search.value')))
        {
                $posts = CustomersModel::offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get();

        }
        else {
            $search = $request->input('search.value');

            $posts =  CustomersModel::where('customercode','LIKE',"%{$search}%")
                ->orWhere('customername', 'LIKE',"%{$search}%")
                ->orWhere('contactpersonphone', 'LIKE',"%{$search}%")
                ->orWhere('emailid', 'LIKE',"%{$search}%")
                ->orWhere('customertype', 'LIKE',"%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get();

            $totalFiltered = CustomersModel::where('customercode','LIKE',"%{$search}%")
                ->orWhere('customername', 'LIKE',"%{$search}%")
                ->orWhere('contactpersonphone', 'LIKE',"%{$search}%")
                ->orWhere('emailid', 'LIKE',"%{$search}%")
                ->orWhere('customertype', 'LIKE',"%{$search}%")
                ->count();
        }

        $data = array();
        if(!empty($posts))
        {
            $count = 1;
            foreach ($posts as $post)
            {
                $nestedData['id'] = $count++;
                 $nestedData['customercode'] = $post->customercode;
               $nestedData['customername'] = $post->customername;
               $nestedData['customerphone'] = $post->customerphone;
               $nestedData['customerfax'] = $post->customerfax;
               $nestedData['emailid'] = $post->emailid;
               $nestedData['customerwebsite'] = $post->customerwebsite;
               $nestedData['contactpersonname'] = $post->contactpersonname;
               $nestedData['contactpersondesignation'] = $post->contactpersondesignation;
               $nestedData['contactpersonmobile'] = $post->contactpersonmobile;
               $nestedData['contactpersonemailid'] = $post->contactpersonemailid;
               $nestedData['customerpanno'] = $post->customerpanno;
               $nestedData['customergstno'] = $post->customergstno;
                $nestedData['customertype'] = $post->customertype;


                $nestedData['options'] = "&emsp;<a href=\"customers/$post->customercode\" style=\"margin-right: 3px;\">view</a>
                                          | <a href=\"customers/$post->customercode/edit\" style=\"margin - right: 3px;\">edit</a>";
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



    public function autoComplete(Request $request) {

        $query = $request->get('term','');

        $products=CustomersModel::where('name','LIKE','%'.$query.'%')->get();

        $data=array();
        foreach ($products as $product) {
            $data[]=array('value'=>$product->name,'id'=>$product->id);
        }
        if(count($data))
            return $data;
        else
            return ['value'=>'No Result Found','id'=>''];
    }

}
