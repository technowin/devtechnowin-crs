<?php

namespace App\Http\Controllers\Masters;

use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SectorMasterModel;
use App\Models\IncrementMasterModel;
use Symfony\Component\HttpKernel\EventListener\SaveSessionListener;
use Auth;

class SectorMasterController extends Controller
{
    public function index()
    {
//        $sectors = SectorMasterModel::all();
        return view('masters.sectormaster.index');
//            ->with('sectorMaster', $sectors);
    }

    public function create()
    {
        return view('masters.sectormaster.create');
    }

    public function store(Request $request)
    {

        try
        {
            $model=new SectorMasterModel();

            $model->sectorname=$request['sectorname'];
            $mystr=$request['sectorname'];
            $tempcode = $this->DynamicCode($mystr);
            $code=$tempcode['code'];
            $incrementid=$tempcode['incrementid'];
            $model->sectorcode=$code;
            $model->sectordescription=$request['sectordescription'];
            $model->isactive=$request['isactive'];

            $model->save();

            if ($model->save()== true)
            {
                $id="Sector";
                $modelincrement = IncrementMasterModel::find(IncrementMasterModel::where('incrementfor',$id)->first()->incrementid);
                $modelincrement->incrementvalue=$incrementid;
                $modelincrement->save();
            }

//          return redirect('masters.sectormaster.index');
            return redirect('sectors');
        }
        catch (Exception $ex) {
            return $ex->getMessage();
            return 'Some error occurred while processing your request';

        }
    }

    public function show($id)
    {
        try
        {
            $sectors = SectorMasterModel::findOrFail($id);

            return view('masters.sectormaster.details', compact('sectors'));
        }
        catch (Exception $ex){
            return $ex->getMessage();
            return 'Some error occurred while processing your request';
        }

    }

    public function edit($id)
    {
        try
        {
            $sectors = SectorMasterModel::findOrFail($id);

            return view('masters.sectormaster.edit', compact('sectors'));
        }
        catch (Exception $ex){
            return $ex->getMessage();
            return 'Some error occurred while processing your request';
        }

    }

    public function update(Request $request, $id)
    {
        try
        {
            $model = SectorMasterModel::findOrFail($id);
//          $model->sectorcode=$request['sectorcode'];
            $model->sectorname=$request['sectorname'];
            $model->sectordescription=$request['sectordescription'];
            $model->isactive=$request['isactive'];
            $model->save();
            return redirect('sectors');
        }
        catch (Exception $ex){

            return $ex->getMessage();
            return 'Some error occurred while processing your request';
        }
    }

    public function DynamicCode($mystr)
    {
        $lastincrementid = IncrementMasterModel::all()->where('incrementfor', 'Sector')->first()->incrementvalue;
        $code = str_pad($lastincrementid+1, 4, "0", STR_PAD_LEFT);
        $newgenratedcode=strtoupper(mb_substr($mystr,0,2).($code));
        $itemarray=array('code'=>$newgenratedcode,'incrementid'=>$lastincrementid+1);
        return  $itemarray ;
    }

    public function getIndexData(Request $request){
        $columns = array(
            0 =>'sectorcode',
            1 =>'sectorname',
            2=> 'sectordescription',
            3=> 'options',
        );

        $totalData = SectorMasterModel::count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if(empty($request->input('search.value')))
        {
            $posts = SectorMasterModel::offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get();
        }
        else {
            $search = $request->input('search.value');

            $posts =  SectorMasterModel::where('sectorcode','LIKE',"%{$search}%")
                ->orWhere('sectorname', 'LIKE',"%{$search}%")
                ->orWhere('sectordescription', 'LIKE',"%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get();

            $totalFiltered = SectorMasterModel::where('sectorcode','LIKE',"%{$search}%")
                ->orWhere('sectorname', 'LIKE',"%{$search}%")
                ->orWhere('sectordescription', 'LIKE',"%{$search}%")
                ->count();
        }

        $data = array();
        if(!empty($posts))
        {
            $count = 1;
            foreach ($posts as $post)
            {
                $nestedData['id'] = $count++;
                $nestedData['sectorcode'] = $post->sectorcode;
                $nestedData['sectorname'] = $post->sectorname;
                $nestedData['sectordescription'] = $post->sectordescription;
                $nestedData['options'] = "&emsp;<a href=\"sectors/$post->sectorcode\" style=\"margin-right: 3px;\">view</a>
                                          | <a href=\"sectors/$post->sectorcode/edit\" style=\"margin - right: 3px;\">edit</a>";
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