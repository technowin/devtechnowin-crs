<?php

namespace App\Http\Controllers\Masters;

use App\Models\CategoryMasterModel;
use App\Models\ProductServiceMasterModel;
use DateTimeZone;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\IncrementMasterModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Controllers\CommonController;
use Carbon\Carbon;
use Auth;
use Illuminate\Http\Response;

class CategoryMasterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $count = CategoryMasterModel::all()->count();
        $categorys = CategoryMasterModel::orderBy('categoryname')->paginate($count);

        $productservice = ProductServiceMasterModel::all();
        $productservicecode = $productservice->pluck('productservicename', 'productservicecode')->all();

        return view('masters.categorymaster.index',compact('categorys','productservicecode'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $category = CategoryMasterModel::All();
//        $categoryname = $category->pluck('categoryname')->all();

        $productservice = ProductServiceMasterModel::all();
        $productservicecode = $productservice->pluck('productservicename', 'productservicecode')->all();

        return view('masters.categorymaster.create', compact('productservicecode'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        try {
            $common = new CommonController();
            $model = new CategoryMasterModel();
            $model->categoryname = $request['categoryname'];
            $mystr = $request['categoryname'];
            $tablename = "Category";
            $tempcode=$common->DynamicCode($mystr, $tablename);
            $code = $tempcode['code'];
            $incrementid = $tempcode['incrementid'];
            $model->categorycode = $code;
            $model->productservicecode = $request['productservicecode'];
            $model->categorydescription = $request['categorydescription'];
            $model->isactive = $request['isactive'];
            $model->created_at = Carbon::now(new DateTimeZone('Asia/Kolkata'));
            $model->created_by = Auth::id();
            $model->updated_at=null;
            $model->save();

            if ($model->save() == true) {
                $id = "Category";
                $modelincrement = IncrementMasterModel::find(IncrementMasterModel::where('incrementfor', $id)->first()->incrementid);
                $modelincrement->incrementvalue = $incrementid;
                $modelincrement->save();
            }

//          return redirect('masters.categorymaster.index');
            return redirect('category');
        } catch (Exception $ex) {
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

        try {
            $category = CategoryMasterModel::findOrFail($id);

            $productservice = ProductServiceMasterModel::all();
            $category->productservicecode = $productservice->where('productservicecode', $category->productservicecode)->first()->productservicename;

            return view('masters.categorymaster.details', compact('category'));

        } catch (Exception $ex) {
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
        try {
            $category = CategoryMasterModel::findOrFail($id);

            $productservice = ProductServiceMasterModel::all();
            $productservicecode = $productservice->pluck('productservicename', 'productservicecode')->all();

            return view('masters.categorymaster.edit', compact('category'), compact('productservicecode'), compact('categoryname'));

        } catch (Exception $ex) {
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
        try {
            $model = CategoryMasterModel::findOrFail($id);
//          $model->categorycode=$request['categorycode'];
            $model->productservicecode = $request['productservicecode'];
            $model->categoryname = $request['categoryname'];
            $model->categorydescription = $request['categorydescription'];
            $model->isactive = $request['isactive'];
            $model->updated_at = Carbon::now(new DateTimeZone('Asia/Kolkata'));  //ajay
            $model->updated_by = Auth::id();
            $model->save();
            return redirect('category');
        } catch (Exception $ex) {

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

}
