<?php

namespace App\Http\Controllers\Masters;

use DateTimeZone;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ProductServiceMasterModel;
use App\Models\SectorMasterModel;
use App\Models\IncrementMasterModel;
use App\Http\Controllers\CommonController;
use Carbon\Carbon;
use Auth;
use Illuminate\Http\Response;

class ProductServiceMasterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $request->user()->authorizeRoles(['admin']);
        $count = ProductServiceMasterModel::all()->count();
        $productservices = ProductServiceMasterModel::orderBy('productservicename')->paginate($count);

        $sectors = SectorMasterModel::all();
        $sectorcode = $sectors->pluck('sectorname','sectorcode')->all();

        return view('masters.productservicemasters.index',compact('productservices','sectorcode'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
//        $sectors = SectorMasterModel::all();
//        $sectorscode = $sectors->pluck('sectorname','sectorcode')->all();
        return view('masters.productservicemasters.create',compact('sectorscode'));
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
          $model = new ProductServiceMasterModel();
          $model->productservicename=$request["productservicename"];
          $mystr=$request['productservicename'];
          $tablename = "ProductService";
          $tempcode=$common->DynamicCode($mystr, $tablename);
          $code=$tempcode['code'];
          $model->productservicecode=$code;
          $incrementid=$tempcode['incrementid'];
          $model->sectorcode=$request['sectorcode'];
          $model->productservicedescription=$request["productservicedescription"];
          $model->isactive=$request["isactive"];
          $model->created_at = Carbon::now(new DateTimeZone('Asia/Kolkata'));
          $model->created_by = Auth::id();
          $model->updated_at = null;
          $model->save();

          if ($model->save()== true)
          {
              $id="ProductService";
              $modelincrement = IncrementMasterModel::find(IncrementMasterModel::where('incrementfor',$id)->first()->incrementid);
              $modelincrement->incrementvalue=$incrementid;
              $modelincrement->save();
          }
          return redirect('productservice');
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
            $productservices = ProductServiceMasterModel::findOrFail($id);
            $sectors = SectorMasterModel::all();
            $productservices->sectorcode = $sectors->where('sectorcode', $productservices->sectorcode)->first()->sectorname;
            return view('masters.productservicemasters.details', compact('productservices'));
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
            $productservicesmaster = ProductServiceMasterModel::findOrFail($id);
            $sector = SectorMasterModel::pluck('sectorname','sectorcode');
            $sectorcode = $productservicesmaster->sectorcode;
            return view('masters.productservicemasters.edit', compact('productservicesmaster','sector','sectorcode'));
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
            $model = ProductServiceMasterModel::findOrFail($id);
            $model->productservicename= $request["productservicename"];
            $model->sectorcode = $request["sector"];
            $model->productservicedescription=$request["productservicedescription"];
            $model->isactive = $request["isactive"];
            $model->updated_at = Carbon::now(new DateTimeZone('Asia/Kolkata'));
            $model->updated_by = Auth::id();
            $model->save();
        }

        catch (Exception $ex){
            return $ex->getMessage();
            return 'Some error occurred while processing your request';
        }

        return redirect('productservice');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
      return 'hi';
      return  $flights = ProductServiceMasterModel::withTrashed()->where('productservicecode', $id)->get();

    }

    public function DynamicCode($mystr)
    {
        $lastincrementid = IncrementMasterModel::all()->where('incrementfor', 'ProductService')->first()->incrementvalue;
        $code = str_pad($lastincrementid+1, 4, "0", STR_PAD_LEFT);
        $newgenratedcode=strtoupper(mb_substr($mystr,0,2).($code));
        $itemarray=array('code'=>$newgenratedcode,'incrementid'=>$lastincrementid+1);
        return  $itemarray ;
    }


    public function getIndexData(Request $request){
        $columns = array(
            0 =>'productservicecode',
            1 =>'sectorcode',
            2 =>'productservicename',
            3 =>'productservicedescription',
            4 =>'isactive',
            5 =>'options',
        );

        $totalData = ProductServiceMasterModel::count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if(empty($request->input('search.value')))
        {
            $posts = ProductServiceMasterModel::selectRaw('tblproductservicemaster.*, tblsectormaster.sectorname')
                ->Join('tblsectormaster','tblsectormaster.sectorcode','=','tblproductservicemaster.sectorcode')
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get();

        }
        else {

            $search = $request->input('search.value');
            $posts =  ProductServiceMasterModel::selectRaw('tblproductservicemaster.*, tblsectormaster.sectorname')
                ->Join('tblsectormaster','tblsectormaster.sectorcode','=','tblproductservicemaster.sectorcode')
                ->where('productservicecode','LIKE',"%{$search}%")
                ->orWhere('sectorname', 'LIKE',"%{$search}%")
                ->orWhere('productservicename', 'LIKE',"%{$search}%")
                ->orWhere('productservicedescription', 'LIKE',"%{$search}%")


                ->offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get();

            $totalFiltered = ProductServiceMasterModel::selectRaw('tblproductservicemaster.*, tblsectormaster.sectorname')
                ->Join('tblsectormaster','tblsectormaster.sectorcode','=','tblproductservicemaster.sectorcode')
                ->where('productservicecode','LIKE',"%{$search}%")
                ->orWhere('sectorname', 'LIKE',"%{$search}%")
                ->orWhere('productservicename', 'LIKE',"%{$search}%")
                ->orWhere('productservicedescription', 'LIKE',"%{$search}%")
                ->count();
        }

        $data = array();
        if(!empty($posts))
        {
            $count = 1;
            foreach ($posts as $post)
            {
                $nestedData['id'] = $count++;
                $nestedData['productservicecode'] = $post->productservicecode;
                $nestedData['sectorname'] = $post->sectorname;
                $nestedData['productservicename'] = $post->productservicename;
                $nestedData['productservicedescription'] = $post->productservicedescription;
                if($post->isactive == 1)
                {
                    $isactive='Yes';
                }
                else
                {
                    $isactive='No';
                }
                $nestedData['isactive'] = $isactive;
                $nestedData['options'] = "&emsp;<a href=\"productservice/$post->productservicecode\" style=\"margin-right: 3px;\">view</a>
                                          | <a href=\"productservice/$post->productservicecode/edit\" style=\"margin - right: 3px;\">edit</a>";
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
