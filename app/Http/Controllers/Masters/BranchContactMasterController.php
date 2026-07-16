<?php

namespace App\Http\Controllers\Masters;

use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\BranchContactMasterModel;
use App\Models\BranchMasterModel;
use App\Http\Controllers\CommonController;
use App\Models\IncrementMasterModel;
use Illuminate\Http\Response;

class BranchContactMasterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $request->user()->authorizeRoles(['admin']);

        $count = BranchContactMasterModel::all()->count();
        $branches = BranchContactMasterModel::orderBy('contactpersonname')->paginate($count);

        $branchmasters = BranchMasterModel::all();

        $branchmastercode = $branchmasters->pluck('branchname','branchcode')->all();

        return view('masters.branchcontactpersonmasters.index', compact('branches', 'branchmasters', 'branchmastercode'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $branchcontactmasters = BranchMasterModel::all();

        $branchmastercode = $branchcontactmasters->pluck('branchname','branchcode')->all();

        return view('masters.branchcontactpersonmasters.create' ,compact('branchmastercode'));
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
            $common = new CommonController();
            $model= new BranchContactMasterModel();
            $model->contactpersonname=$request["contactpersonname"];
            $mystr=$request['contactpersonname'];
            $tablename="BranchContactPerson";
            $tempcode = $common->DynamicCode($mystr,$tablename);
            $code=$tempcode['code'];
            $model->branchcontactcode=$code;
            $incrementid=$tempcode['incrementid'];
            $model->branchcode=$request->branchmastercode;
            $model->phone=$request["phone"];
            $model->fax=$request["fax"];
            $model->emailid=$request["emailid"];
            $model->designation=$request["designation"];
            $model->save();

            if ($model->save()== true)
            {
                $id="BranchContactPerson";
                $modelincrement = IncrementMasterModel::find(IncrementMasterModel::where('incrementfor',$id)->first()->incrementid);
                $modelincrement->incrementvalue=$incrementid;
                $modelincrement->save();
            }
            return redirect('branchescontactperson');
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
            $branchcontactmasters = BranchContactMasterModel::findOrFail($id);
            $branchs = BranchMasterModel::all();
            $branchcontactmasters->branchcode = $branchs->where('branchcode', $branchcontactmasters->branchcode)->first()->branchname;
            return view('masters.branchcontactpersonmasters.details', compact('branchcontactmasters'));
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

            $branchcontactmasters = BranchContactMasterModel::findOrFail($id);
            $branchmasters= BranchMasterModel::pluck('branchname','branchcode');
            $customercode = $branchcontactmasters->branchcode;
            return view('masters.branchcontactpersonmasters.edit', compact('branchcontactmasters','customercode','branchmasters'));
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
        $model=BranchContactMasterModel::findOrFail($id);
        $model->contactpersonname=$request["contactpersonname"];
        $model->branchcode=$request->branchmasters;
        $model->phone=$request["phone"];
        $model->fax=$request["fax"];
        $model->emailid=$request["emailid"];
        $model->designation=$request["designation"];
        $model->save();
        return redirect('branchescontactperson');


    }
    public function getIndexData(Request $request){
        $columns = array(
            0 =>'branchcontactcode',
            1 =>'branchcode',
            2 =>'contactpersonname',
            3 =>'phone',
            4 =>'fax',
            4 =>'emailid',
            4 =>'designation',
            5 =>'options',
        );

        $totalData = BranchContactMasterModel::count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if(empty($request->input('search.value')))
        {
            $posts = BranchContactMasterModel::selectRaw('tblbranchcontactmaster.*, tblworkorderbranchmaster.branchname')
                ->Join('tblworkorderbranchmaster','tblworkorderbranchmaster.branchcode','=','tblbranchcontactmaster.branchcode')
//                $posts = SubCategoryMasterModel::all()

                ->limit($limit)
                ->orderBy($order,$dir)
                ->get();

        }
        else {

            $search = $request->input('search.value');
            $posts = BranchContactMasterModel::selectRaw('tblbranchcontactmaster.*, tblbranchmaster.branchname')
                ->Join('tblbranchmaster','tblbranchmaster.branchcode','=','tblbranchcontactmaster.branchcode')
                ->where('branchcontactcode','LIKE',"%{$search}%")
                ->orWhere('branchname', 'LIKE',"%{$search}%")
                ->orWhere('contactpersonname', 'LIKE',"%{$search}%")
//                ->orWhere('phone', 'LIKE',"%{$search}%")
//                ->orWhere('fax', 'LIKE',"%{$search}%")
                ->orWhere('emailid', 'LIKE',"%{$search}%")
                ->orWhere('designation', 'LIKE',"%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get();

            $totalFiltered = BranchContactMasterModel::selectRaw('tblbranchcontactmaster.*, tblbranchmaster.branchname')
                ->Join('tblbranchmaster','tblbranchmaster.branchcode','=','tblbranchcontactmaster.branchcode')
                ->where('branchcontactcode','LIKE',"%{$search}%")
                ->orWhere('branchname', 'LIKE',"%{$search}%")
                ->orWhere('contactpersonname', 'LIKE',"%{$search}%")
//                ->orWhere('phone', 'LIKE',"%{$search}%")
//                ->orWhere('fax', 'LIKE',"%{$search}%")
               ->orWhere('emailid', 'LIKE',"%{$search}%")
                ->orWhere('designation', 'LIKE',"%{$search}%")
                ->count();
        }

        $data = array();
        if(!empty($posts))
        {
            $count = 1;
            foreach ($posts as $post)
            {
                $nestedData['id'] = $count++;
                $nestedData['branchcontactcode'] = $post->branchcontactcode;
                $nestedData['branchname'] = $post->branchname;
                $nestedData['contactpersonname'] = $post->contactpersonname;
                $nestedData['phone'] = $post->phone;
                $nestedData['fax'] = $post->fax;
                $nestedData['emailid'] = $post->emailid;
                $nestedData['designation'] = $post->designation;

                $nestedData['options'] = "&emsp;<a href=\"branchescontactperson/$post->branchcontactcode\" style=\"margin-right: 3px;\">view</a>
                                          | <a href=\"branchescontactperson/$post->branchcontactcode/edit\" style=\"margin - right: 3px;\">edit</a>";
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
