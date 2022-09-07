<?php

namespace App\Http\Controllers\Masters;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\VendorMasterModel;
use App\Http\Controllers\CommonController;
use Ramsey\Uuid\Uuid;
use App\Models\IncrementMasterModel;



class VendorMasterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('masters.vendormaster.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('masters.vendormaster.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $common = new CommonController();
        $model=new VendorMasterModel();
        $uuid = Uuid::uuid1();
        $model->id = $uuid;
        $model->vendorname=$request['vendorname'];
        $mystr=$request['vendorname'];
        $tablename="Vendor";
        $tempcode = $common->DynamicCode($mystr,$tablename);
        $code=$tempcode['code'];
        $incrementid=$tempcode['incrementid'];
        $model->vendorcode=$code;
        $model->vendorphoneno=$request['vendorphoneno'];
        $model->vendoremail=$request['vendoremail'];
        $model->vendorfax=$request['vendorfax'];
        $model->contactpersonno=$request['contactpersonno'];
        $model->contactpersonemail=$request['contactpersonemail'];
        $model->vendorwebsite=$request['vendorwebsite'];
        $model->save();

        if ($model->save()== true)
        {
            $id="Vendor";
            $modelincrement = IncrementMasterModel::find(IncrementMasterModel::where('incrementfor',$id)->first()->incrementid);
            $modelincrement->incrementvalue=$incrementid;
            $modelincrement->save();
        }
        return redirect('vendor');

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
            $vendor = VendorMasterModel::findOrFail($id);

            return view('masters.vendormaster.details', compact('vendor'));
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
            $vendor = VendorMasterModel::findOrFail($id);

            return view('masters.vendormaster.edit', compact('vendor'));
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
        try
        {
            $model = VendorMasterModel::findOrFail($id);
            $model->vendorname=$request['vendorname'];
            $model->vendorphoneno=$request['vendorphoneno'];
            $model->vendoremail=$request['vendoremail'];
            $model->vendorfax=$request['vendorfax'];
            $model->contactpersonno=$request['contactpersonno'];
            $model->contactpersonemail=$request['contactpersonemail'];
            $model->vendorwebsite=$request['vendorwebsite'];
            $model->save();
            return redirect('vendor');
        }
        catch (\Exception $ex){

            return $ex->getMessage();
            return 'Some error occurred while processing your request';
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    public function getIndexData(Request $request){
        $columns = array(
            0 =>'id',
            1 =>'vendorcode',
            2 =>'vendorname',
            3 =>'vendorphoneno',
            4 =>'vendoremail',
            5 =>'vendorfax',
            6 =>'contactpersonno',
            7 =>'contactpersonemail',
            8 =>'options',
        );

        $totalData = VendorMasterModel::count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if(empty($request->input('search.value')))
        {
            $posts = VendorMasterModel::offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get();

        }
        else {

            $search = $request->input('search.value');
            $posts =  VendorMasterModel::where('vendorcode','LIKE',"%{$search}%")
                ->orWhere('vendorname', 'LIKE',"%{$search}%")
                ->orWhere('vendorphoneno', 'LIKE',"%{$search}%")
                ->orWhere('vendoremail', 'LIKE',"%{$search}%")
                ->orWhere('vendorfax', 'LIKE',"%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get();

            $totalFiltered = VendorMasterModel::where('vendorcode','LIKE',"%{$search}%")
                ->orWhere('vendorname', 'LIKE',"%{$search}%")
                ->orWhere('vendorphoneno', 'LIKE',"%{$search}%")
                ->orWhere('vendoremail', 'LIKE',"%{$search}%")
                ->orWhere('vendorfax', 'LIKE',"%{$search}%")
                ->count();
        }

        $data = array();
        if(!empty($posts))
        {
            $count = 1;
            foreach ($posts as $post)
            {
                $nestedData['id'] = $count++;
                $nestedData['vendorcode'] = $post->vendorcode;
                $nestedData['vendorname'] = $post->vendorname;
                $nestedData['vendorphoneno'] = $post->vendorphoneno;
                $nestedData['vendoremail'] = $post->vendoremail;
                $nestedData['vendorfax'] = $post->vendorfax;

                $nestedData['options'] = "&emsp;<a href=\"vendor/$post->vendorcode\" style=\"margin-right: 3px;\">view</a>
                                          | <a href=\"vendor/$post->vendorcode/edit\" style=\"margin - right: 3px;\">edit</a>";
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
