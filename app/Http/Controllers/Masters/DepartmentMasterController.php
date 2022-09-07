<?php

namespace App\Http\Controllers\Masters;

use App\Models\ProductServiceMasterModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DepartmentMasterModel;
use App\Models\SectorMasterModel;
use App\Models\IncrementMasterModel;


class DepartmentMasterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sectors = SectorMasterModel::all();
        $DepartmentMasetrs= DepartmentMasterModel::all();
        foreach ($DepartmentMasetrs as $data)
        {
            $data->sectorcode = $sectors->where('sectorcode', $data->sectorcode)->first()->sectorname;
        }
        return view('masters.departmentmaster.index')->with('DepartmentMasetrs', $DepartmentMasetrs);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sectors = SectorMasterModel::all();
        $sectorscode = $sectors->pluck('sectorname','sectorcode')->all();
        return view('masters.departmentmaster.create',compact('sectorscode'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try
        {

            $model=new DepartmentMasterModel();
            $model->sectorcode=$request->sectorscode;
            $model->departmentname=$request["departmentname"];
            $model->departmentdescription=$request["departmentdescription"];
            $mystr=$request["departmentname"];
            $tempcode=$this->DynamicCode($mystr);
            $code=$tempcode['code'];
            $model->departmentcode=$code;
            $incrementid=$tempcode['incrementid'];
            $model->save();

            if ($model->save()== true)
            {
                $id="Department";
                $modelincrement = IncrementMasterModel::find(IncrementMasterModel::where('incrementfor',$id)->first()->incrementid);
                $modelincrement->incrementvalue=$incrementid;
                $modelincrement->save();
            }
            return redirect('department');
        }

        catch (\Exception $ex) {
            return $ex->getMessage();
            return 'Some error occurred while processing your request';
        }


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try
        {
            $departmentmasters = DepartmentMasterModel::findOrFail($id);
            $sectors = SectorMasterModel::all();
            $departmentmasters->sectorcode = $sectors->where('sectorcode', $departmentmasters->sectorcode)->first()->sectorname;
            return view('masters.departmentmaster.details', compact('departmentmasters'));
        }
        catch (\Exception $ex){
            return $ex->getMessage();
            return 'Some error occurred while processing your request';
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        try
        {
            $departmentmaster = DepartmentMasterModel::findOrFail($id);
            $department = SectorMasterModel::pluck('sectorname','sectorcode');
            $sectorcode = $departmentmaster->sectorcode;
            return view('masters.departmentmaster.edit', compact('departmentmaster','department','sectorcode'));
        }
        catch (\Exception $ex){
            return $ex->getMessage();
            return 'Some error occurred while processing your request';
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
       $model= DepartmentMasterModel::findOrFail($id);
        $model->sectorcode=$request->department;
        $model->departmentname=$request["departmentname"];
        $model->departmentdescription=$request["departmentdescription"];

        $model->save();
        return redirect('department');

    }

    public function DynamicCode($mystr)
    {
        $lastincrementid = IncrementMasterModel::all()->where('incrementfor', 'Department')->first()->incrementvalue;
        $code = str_pad($lastincrementid+1, 4, "0", STR_PAD_LEFT);
        $newgenratedcode=strtoupper(mb_substr($mystr,0,2).($code));
        $itemarray=array('code'=>$newgenratedcode,'incrementid'=>$lastincrementid+1);
        return  $itemarray ;

    }


    public function getIndexData(Request $request){
        $columns = array(
            0 =>'departmentcode',
            1 =>'sectorcode',
            2 =>'departmentname',
            3 =>'departmentdescription',
            4 =>'options',
        );

        $totalData = DepartmentMasterModel::count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if(empty($request->input('search.value')))
        {
            $posts = DepartmentMasterModel::selectRaw('tbldepartmentmaster.*, tblsectormaster.sectorname')
                ->Join('tblsectormaster','tblsectormaster.sectorcode','=','tbldepartmentmaster.sectorcode')
//                $posts = DepartmentMasterModel::all()

                ->limit($limit)
                ->orderBy($order,$dir)
                ->get();

        }
        else {

            $search = $request->input('search.value');
            $posts = DepartmentMasterModel::selectRaw('tbldepartmentmaster.*, tblsectormaster.sectorname')
                ->Join('tblsectormaster','tblsectormaster.sectorcode','=','tbldepartmentmaster.sectorcode')
                ->where('departmentcode','LIKE',"%{$search}%")
                ->orWhere('sectorname', 'LIKE',"%{$search}%")
                ->orWhere('departmentname', 'LIKE',"%{$search}%")
                ->orWhere('departmentdescription', 'LIKE',"%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get();

            $totalFiltered = DepartmentMasterModel::selectRaw('tbldepartmentmaster.*, tblsectormaster.sectorname')
                ->Join('tblsectormaster','tblsectormaster.sectorcode','=','tbldepartmentmaster.sectorcode')
                 ->where('departmentcode','LIKE',"%{$search}%")
                ->orWhere('sectorname', 'LIKE',"%{$search}%")
                ->orWhere('departmentname', 'LIKE',"%{$search}%")
                ->orWhere('departmentdescription', 'LIKE',"%{$search}%")
                ->count();
        }

        $data = array();
        if(!empty($posts))
        {
            $count = 1;
            foreach ($posts as $post)
            {
                $nestedData['id'] = $count++;
                $nestedData['departmentcode'] = $post->departmentcode;
                $nestedData['sectorname'] = $post->sectorname;
                $nestedData['departmentname'] = $post->departmentname;
                $nestedData['departmentdescription'] = $post->departmentdescription;
                $nestedData['options'] = "&emsp;<a href=\"department/$post->departmentcode\" style=\"margin-right: 3px;\">view</a>
                                          | <a href=\"department/$post->departmentcode/edit\" style=\"margin - right: 3px;\">edit</a>";
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
