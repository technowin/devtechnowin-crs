<?php

namespace App\Http\Controllers\Masters;

use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\BranchMasterModel;
use App\Models\CustomersModel;
use App\Models\IncrementMasterModel;
use Illuminate\Http\Response;

class BranchMasterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        try
        {
              $count = BranchMasterModel::all()->count();
              $branchsMasters = BranchMasterModel::orderBy('branchname')->paginate($count);
//            $branchsMasters = BranchMasterModel::orderBy('branchname')->get();

        }
        catch (Exception $ex) {
            return $ex->getMessage();
            return 'Some error occurred while processing your request';
        }
        $customers = CustomersModel::all();
        $customercode = $customers->pluck('customername','customercode')->all();

        return view('masters.branchmaster.index',compact('departmentcode','customercode','branchsMasters'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $customers = CustomersModel::all();
        $costomercode = $customers->pluck('customername','customercode')->all();
        return view('masters.branchmaster.create' ,compact('costomercode'));
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
            $model = new BranchMasterModel();
            $model->branchname=$request["branchname"];
            $mystr=$request['branchname'];
            $tempcode = $this->DynamicCode($mystr);
            $code=$tempcode['code'];
            $incrementid=$tempcode['incrementid'];
            $model->branchcode=$code;
            $model->customercode=$request['customercode'];
            $model->phone=$request["phone"];
            $model->fax=$request["fax"];
            $model->email=$request["email"];

            $model->save();

            if ($model->save()== true)
            {
                $id="Branchname";
                $modelincrement = IncrementMasterModel::find(IncrementMasterModel::where('incrementfor',$id)->first()->incrementid);
                $modelincrement->incrementvalue=$incrementid;
                $modelincrement->save();
            }
            return redirect('branches');

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
            $branches = BranchMasterModel::findOrFail($id);
            $customer = CustomersModel::all();
            $branches->customercode = $customer->where('customercode', $branches->customercode)->first()->customername;
            return view('masters.branchmaster.details', compact('branches','customercode','customers'));

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

           $branchesmaster = BranchMasterModel::findOrFail($id);
           $customers = CustomersModel::pluck('customername','customercode');
           $customercode = $branchesmaster->customercode;
           return view('masters.branchmaster.edit', compact('branchesmaster','customercode','customers'));
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
        try
        {
            $model = BranchMasterModel::where('workorderno',$request["workorderno"])->where('branchcode',$request["branchcode"])->get()->first();
//            $model = BranchMasterModel::findOrFail($id);
            $model->branchname=$request["branchname"];
            $model->customercode=$request->customers;
            $model->phone=$request["phone"];
            $model->fax=$request["fax"];
            $model->email=$request["email"];
            $model->save();
            return redirect('branches');
        }
        catch (Exception $ex){
            return $ex->getMessage();
            return 'Some error occurred while processing your request';
        }

     }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }


    public function DynamicCode($mystr)
    {
        $lastincrementid = IncrementMasterModel::all()->where('incrementfor', 'Branchname')->first()->incrementvalue;
        $code = str_pad($lastincrementid+1, 4, "0", STR_PAD_LEFT);
        $newgenratedcode=strtoupper(mb_substr($mystr,0,2).($code));
        $itemarray=array('code'=>$newgenratedcode,'incrementid'=>$lastincrementid+1);
        return  $itemarray ;
    }

    public function getIndexData(Request $request){
        $columns = array(
            0 =>'branchcode',
            1 =>'customercode',
            2 =>'branchname',
            3 =>'phone',
            4 =>'fax',
            5 =>'email',
            6 =>'options',
        );

        $totalData = BranchMasterModel::count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if(empty($request->input('search.value')))
        {
            $posts = BranchMasterModel::selectRaw('tblworkorderbranchmaster.*, tblworkordercustomermaster.customername')
                ->Join('tblworkordercustomermaster','tblworkorderbranchmaster.customercode','=','tblworkordercustomermaster.customercode')
//                $posts = DepartmentMasterModel::all()

                ->limit($limit)
                ->orderBy($order,$dir)
                ->get();

        }
        else {

            $search = $request->input('search.value');
            $posts = BranchMasterModel::selectRaw('tblworkorderbranchmaster.*, tblworkordercustomermaster.customername')
                ->Join('tblworkordercustomermaster','tblworkorderbranchmaster.customercode','=','tblworkordercustomermaster.customercode')
                ->where('branchcode','LIKE',"%{$search}%")
                ->orWhere('customername', 'LIKE',"%{$search}%")
                ->orWhere('branchname', 'LIKE',"%{$search}%")
                ->orWhere('phone', 'LIKE',"%{$search}%")
                ->orWhere('fax', 'LIKE',"%{$search}%")
                ->orWhere('email', 'LIKE',"%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get();

            $totalFiltered = BranchMasterModel::selectRaw('tblworkorderbranchmaster.*, tblworkordercustomermaster.customername')
                ->Join('tblworkordercustomermaster','tblworkorderbranchmaster.customercode','=','tblworkordercustomermaster.customercode')
                ->where('branchcode','LIKE',"%{$search}%")
                ->orWhere('customername', 'LIKE',"%{$search}%")
                ->orWhere('branchname', 'LIKE',"%{$search}%")
                ->orWhere('phone', 'LIKE',"%{$search}%")
                ->orWhere('fax', 'LIKE',"%{$search}%")
                ->orWhere('email', 'LIKE',"%{$search}%")
                ->count();
        }

        $data = array();
        if(!empty($posts))
        {
            $count = 1;
            foreach ($posts as $post)
            {
                $nestedData['id'] = $count++;
                $nestedData['branchcode'] = $post->branchcode;
                $nestedData['customername'] = $post->customername;
                $nestedData['branchname'] = $post->branchname;
                $nestedData['phone'] = $post->phone;
                $nestedData['fax'] = $post->fax;
                $nestedData['email'] = $post->email;
                $nestedData['options'] = "&emsp;<a href=\"branches/$post->branchcode\" style=\"margin-right: 3px;\">view</a>
                                          | <a href=\"branches/$post->branchcode/edit\" style=\"margin - right: 3px;\">edit</a>";
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
}
