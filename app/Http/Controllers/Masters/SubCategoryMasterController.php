<?php

namespace App\Http\Controllers\Masters;

use App\Models\ProductServiceMasterModel;
use DateTimeZone;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SubCategoryMasterModel;
use App\Models\CategoryMasterModel;
use App\Models\IncrementMasterModel;
use App\Http\Controllers\CommonController;
use Carbon\Carbon;
use Auth;
use Illuminate\Http\Response;


class SubCategoryMasterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $subcategorys = SubCategoryMasterModel:: selectRaw('tblsubcategorymaster.*,tblcategorymaster.*, tblcategorymaster.productservicecode, tblproductservicemaster.*')
            -> leftjoin('tblcategorymaster','tblcategorymaster.categorycode','tblsubcategorymaster.categorycode')
            -> leftjoin('tblproductservicemaster','tblproductservicemaster.productservicecode','tblcategorymaster.productservicecode')
            ->get();
        $count =  count($subcategorys);
        /*
                $productservice = ProductServiceMasterModel::all();
                $productservicecode = $productservice->pluck('productservicename', 'productservicecode')->all();
        */

        $Category = CategoryMasterModel::All();
        $Categorycode = $Category->pluck('categoryname', 'categorycode')->all();

        return view('masters.subcategorymasters.index', compact('subcategorys','Categorycode','count'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {

        $Category = CategoryMasterModel::All();
        $Categorycode = $Category->pluck('categoryname', 'categorycode')->all();
        return view('masters.subcategorymasters.create', compact('Categorycode'));
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
            $model = new SubCategoryMasterModel();
            $model->categorycode = $request->Categorycode;
            $model->subcategoryname = $request['subcategoryname'];
            $mystr = $request['subcategoryname'];
            $tablename = "Subcategory";
            $tempcode = $common->DynamicCode($mystr, $tablename);
            $code = $tempcode['code'];
            $incrementid = $tempcode['incrementid'];
            $model->subcategorycode = $code;
            $model->subcategorydescription = $request['subcategorydescription'];
            $model->created_at = Carbon::now(new DateTimeZone('Asia/Kolkata'));
            $model->created_by = Auth::id();
            $model->updated_at=null;
            $model->isactive = $request['isactive'];
            $model->save();
            if ($model->save() == true) {
                $id = "Subcategory";
                $modelincrement = IncrementMasterModel::find(IncrementMasterModel::where('incrementfor', $id)->first()->incrementid);
                $modelincrement->incrementvalue = $incrementid;
                $modelincrement->save();
            }

            return redirect('subcategory');
        } catch (Exception $ex) {
            return $ex->getMessage();
            return 'Some error occurred while processing your request';

        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        try {
            $subcategory = SubCategoryMasterModel::findOrFail($id);
            $category = CategoryMasterModel::all();

            $subcategoryy=$category->where('categorycode', $subcategory->categorycode)->first()->categoryname;
            if ($subcategoryy==null)
            {
                $subcategory->categorycode='-';

            }
            else {
                $subcategory->categorycode =$subcategoryy;
            }


            $subcategorys = SubCategoryMasterModel:: selectRaw('tblsubcategorymaster.*,tblcategorymaster.*, tblcategorymaster.productservicecode, tblproductservicemaster.*')
                -> leftjoin('tblcategorymaster','tblcategorymaster.categorycode','tblsubcategorymaster.categorycode')
                -> leftjoin('tblproductservicemaster','tblproductservicemaster.productservicecode','tblcategorymaster.productservicecode')
                -> where ('tblsubcategorymaster.subcategorycode','=',$id)
                ->get()
                -> first();
//            $count =  count($subcategorys);
//             $subcategory->categorycode = $category->where('categorycode', $subcategory->categorycode)->first()->categoryname;

            return view('masters.subcategorymasters.details', compact('subcategory','subcategorys'));
        } catch (Exception $ex) {
            return $ex->getMessage();
            return 'Some error occurred while processing your request';

        }
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        try {

            $subcategory = SubCategoryMasterModel::findOrFail($id);
            $category = CategoryMasterModel::pluck('categoryname', 'categorycode');
            $categorycode = $subcategory->categorycode;
            $productservicecodes = SubCategoryMasterModel:: selectRaw('tblsubcategorymaster.*,tblcategorymaster.*, tblproductservicemaster.*')
                -> leftjoin('tblcategorymaster','tblcategorymaster.categorycode','tblsubcategorymaster.categorycode')
                -> leftjoin('tblproductservicemaster','tblproductservicemaster.productservicecode','tblcategorymaster.productservicecode')
                -> where ('tblsubcategorymaster.subcategorycode','=',$id)
                ->pluck( 'productservicecode');

            $productservice = ProductServiceMasterModel::all();
            $productservicecode = $productservice->pluck('productservicename', 'productservicecode');

            return view('masters.subcategorymasters.edit', compact('subcategory', 'categorycode', 'category','productservice','productservicecode','productservicecodes'));
        } catch (Exception $ex) {
            return $ex->getMessage();
            return 'Some error occurred while processing your request';
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        try {
            $model = SubCategoryMasterModel::findOrFail($id);
            $model->categorycode = $request->category;
            $model->subcategoryname = $request['subcategoryname'];
            $model->subcategorydescription = $request['subcategorydescription'];
            $model->isactive = $request['isactive'];
            $model->updated_at = Carbon::now(new DateTimeZone('Asia/Kolkata'));  //ajay
            $model->updated_by = Auth::id();
            $model->save();

            return redirect('subcategory');
        } catch (Exception $ex) {
            return $ex->getMessage();
            return 'Some error occurred while processing your request';
        }


    }

    public function getIndexData(Request $request)
    {
        $columns = array(
            0 => 'subcategorycode',
            1 => 'categorycode',
            2 => 'subcategoryname',
            3 => 'subcategorydescription',
            4 => 'isactive',
            5 => 'options',
        );

        $totalData = SubCategoryMasterModel::count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $posts = SubCategoryMasterModel::selectRaw('tblsubcategorymaster.*, tblcategorymaster.categoryname')
                ->Join('tblcategorymaster', 'tblcategorymaster.categorycode', '=', 'tblsubcategorymaster.categorycode')
//                $posts = SubCategoryMasterModel::all()

                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

        } else {

            $search = $request->input('search.value');
            $posts = SubCategoryMasterModel::selectRaw('tblsubcategorymaster.*, tblcategorymaster.categoryname')
                ->Join('tblcategorymaster', 'tblsubcategorymaster.categorycode', '=', 'tblcategorymaster.categorycode')
                ->where('subcategorycode', 'LIKE', "%{$search}%")
                ->orWhere('categoryname', 'LIKE', "%{$search}%")
                ->orWhere('subcategoryname', 'LIKE', "%{$search}%")
                ->orWhere('subcategorydescription', 'LIKE', "%{$search}%")
//                ->orWhere('isactive', 'LIKE',"%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered = SubCategoryMasterModel::selectRaw('tblsubcategorymaster.*, tblcategorymaster.categoryname')
                ->Join('tblcategorymaster', 'tblsubcategorymaster.categorycode', '=', 'tblcategorymaster.categorycode')
                ->where('subcategorycode', 'LIKE', "%{$search}%")
                ->orWhere('categoryname', 'LIKE', "%{$search}%")
                ->orWhere('subcategoryname', 'LIKE', "%{$search}%")
                ->orWhere('subcategorydescription', 'LIKE', "%{$search}%")
//                ->orWhere('isactive', 'LIKE',"%{$search}%")
                ->count();
        }

        $data = array();
        if (!empty($posts)) {
            $count = 1;
            foreach ($posts as $post) {
                $nestedData['id'] = $count++;
                $nestedData['subcategorycode'] = $post->subcategorycode;
                $nestedData['categoryname'] = $post->categoryname;
                $nestedData['subcategoryname'] = $post->subcategoryname;
                $nestedData['subcategorydescription'] = $post->subcategorydescription;
                if ($post->isactive == 1) {
                    $isactive = 'Yes';
                } else {
                    $isactive = 'No';
                }

                $nestedData['isactive'] = $isactive;


                $nestedData['options'] = "&emsp;<a href=\"subcategory/$post->subcategorycode\" style=\"margin-right: 3px;\">view</a>
                                          | <a href=\"subcategory/$post->subcategorycode/edit\" style=\"margin - right: 3px;\">edit</a>";
                $data[] = $nestedData;
            }


        }

        $json_data = array(
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );

        echo json_encode($json_data);
    }
}
