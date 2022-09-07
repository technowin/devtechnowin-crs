<?php

namespace App\Http\Controllers\Masters;

use App\Models\SubCategoryMasterModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use  App\Models\ComplaineeDepartmentModel;
use  App\Models\DepartmentMasterModel;
use  App\Models\CategoryMasterModel;
use  App\Models\ProductServiceMasterModel;
use App\Models\IncrementMasterModel;


class ComplaineeDepartmentMasterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try
        {
            $complaineedepartment= ComplaineeDepartmentModel::All();
            $departments = DepartmentMasterModel::all();
            foreach ($complaineedepartment as $data)
            {
                $data->departmentcode = $departments->where('departmentcode', $data->departmentcode)->first()->departmentname;
            }
            $category= CategoryMasterModel::all();
            foreach ($complaineedepartment as $data)
            {
                $data->categorycode = $category->where('category', $data->categorycode)->first()->categoryname;
            }

            $productionservice= ProductServiceMasterModel::all();
            foreach ($complaineedepartment as $data)
            {
                $data->productservicecode = $productionservice->where('product_service', $data->productservicecode)->first()->productservicename;
            }

            $subcategorycode= SubCategoryMasterModel::all();
            foreach ($complaineedepartment as $data)
            {
                $data->subcategorycode = $subcategorycode->where('subcategory', $data->subcategorycode)->first()->subcategoryname;
            }

            return view('masters.complaineedepartmentmaster.index')->with('complaineedepartment',$complaineedepartment);
        }
        catch (\Exception $ex) {
            return $ex->getMessage();
            return 'Some error occurred while processing your request';

        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $departments=DepartmentMasterModel::All();
        $departmentcode=$departments->pluck('departmentname','departmentcode')->all();
        $productins=ProductServiceMasterModel::All();
        $productinscode=$productins->pluck('productservicename','productservicecode')->all();
        $category=CategoryMasterModel::All();
        $categorycode=$category->pluck('categoryname','categorycode')->all();
        $subcategory=SubCategoryMasterModel::All();
        $subcategorycode=$subcategory->pluck('subcategoryname','subcategorycode')->all();

        return view('masters.complaineedepartmentmaster.create',compact('departmentcode','productinscode','categorycode','subcategorycode'));
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

            $model=new ComplaineeDepartmentModel();
            $model->departmentcode=$request->departmentcode;
            $model->product_service=$request->productinscode;
            $model->category=$request->category;
            $model->subcategory=$request->subcategory;
            $model->maxdays=$request['maxdays'];
            $departmentcode=$request->departmentcode;
            $productinscode=$request->productinscode;
            $categorycode=$request->categorycode;
            $subcategorycode=$request->subcategorycode;
            $tempcode = $this->DynamicCode($departmentcode,$productinscode,$categorycode,$subcategorycode);
            $code=$tempcode['code'];
            $model->complaineedepartmentmastercode=$code;
            $incrementid=$tempcode['incrementid'];

            $model->save();
            if ($model->save()== true)
            {
                $id="Assignee";
                $modelincrement = IncrementMasterModel::find(IncrementMasterModel::where('incrementfor',$id)->first()->incrementid);
                $modelincrement->incrementvalue=$incrementid;
                $modelincrement->save();
            }

            return redirect('complaineedepartment');
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
            $complaineedepartment = ComplaineeDepartmentModel::findOrFail($id);
            $departments = DepartmentMasterModel::all();
            $complaineedepartment->departmentcode = $departments->where('departmentcode', $complaineedepartment->departmentcode)->first()->departmentname;
            $SubCategory = SubCategoryMasterModel::all();
            $complaineedepartment->subcategorycode = $SubCategory->where('subcategory', $complaineedepartment->subcategorycode)->first()->subcategoryname;
            $ProductService = ProductServiceMasterModel::all();
            $complaineedepartment->productservicecode = $ProductService->where('product_service', $complaineedepartment->productservicecode)->first()->productservicename;
            $CategoryMaster = CategoryMasterModel::all();
            $complaineedepartment->categorycode = $CategoryMaster->where('category', $complaineedepartment->categorycode)->first()->categoryname;

            return view('masters.complaineedepartmentmaster.details', compact('complaineedepartment'));
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
            $complaineedepartment = ComplaineeDepartmentModel::findOrFail($id);

            $categoryid=$complaineedepartment->category;
            $productid=$complaineedepartment->product_service;

            $departments= DepartmentMasterModel::pluck('departmentname','departmentcode');
            $departmentcode = $complaineedepartment->departmentcode;

            $ProductService= ProductServiceMasterModel::pluck('productservicename','productservicecode');
            $ProductServiceCode = $complaineedepartment->product_service;

            $subcategory = SubCategoryMasterModel::where('categorycode',$categoryid)->get()->pluck('subcategoryname','subcategorycode');
            $subcategorycode = $complaineedepartment->subcategory;

            $category= CategoryMasterModel::where('productservicecode',$productid)->get()->pluck('categoryname','categorycode');
            $categorycode = $complaineedepartment->category;

            return view('masters.complaineedepartmentmaster.edit', compact('complaineedepartment','departmentcode','departments','ProductService','ProductServiceCode','subcategory','subcategorycode','category','categorycode'));
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
           $model= ComplaineeDepartmentModel::findOrFail($id);
           $model->departmentcode=$request->departments;
           $model->product_service=$request->ProductService;
           $model->category=$request->category;
           $model->subcategory=$request->subcategory;
           $model->maxdays=$request['maxdays'];

           $model->save();

           return redirect('complaineedepartment');

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

    public function DynamicCode($departmentcode,$productinscode,$categorycode,$subcategorycode)
{
    $lastincrementid = IncrementMasterModel::all()->where('incrementfor', 'ComplaineeDepartment')->first()->incrementvalue;
    $code = str_pad($lastincrementid+1, 4, "0", STR_PAD_LEFT);
    $newgenrateddepartmentcode=strtoupper(mb_substr($departmentcode,0,2));
    $newgenratedproductinscode=strtoupper(mb_substr($productinscode,0,2));
    $newgenratedcategorycod=strtoupper(mb_substr($categorycode,0,2));
    $newgenratedsubcategorycode=strtoupper(mb_substr($subcategorycode.$newgenratedcategorycod,0,2).($code));

    $newgenratedcode=$newgenrateddepartmentcode.$newgenratedproductinscode.$newgenratedproductinscode.$newgenratedsubcategorycode;
    $itemarray=array('code'=>$newgenratedcode,'incrementid'=>$lastincrementid+1);
    return  $itemarray ;
}


    public function getIndexData(Request $request){
        $columns = array(
            0 =>'complaineedepartmentmastercode',
            1 =>'product_service',
            2 =>'category',
            3 =>'subcategory',
            4 =>'maxdays',
            5 =>'departmentcode',
            6  =>'options',
        );

        $totalData = ComplaineeDepartmentModel::count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if(empty($request->input('search.value')))
        {
            $posts = ComplaineeDepartmentModel::selectRaw('tblcomplaineedepartmentmaster.*, tblproductservicemaster.productservicename,tblcategorymaster.categoryname,tblsubcategorymaster.subcategoryname,tbldepartmentmaster.departmentname')

               ->Join('tblproductservicemaster','tblproductservicemaster.productservicecode','=','tblcomplaineedepartmentmaster.product_service')
                ->Join('tblcategorymaster','tblcategorymaster.categorycode','=','tblcomplaineedepartmentmaster.category')
                ->Join('tblsubcategorymaster','tblsubcategorymaster.subcategorycode','=','tblcomplaineedepartmentmaster.subcategory')
                ->Join('tbldepartmentmaster','tbldepartmentmaster.departmentcode','=','tblcomplaineedepartmentmaster.departmentcode')


                ->limit($limit)
                ->orderBy($order,$dir)
                ->get();

        }
        else {

            $search = $request->input('search.value');
            $posts =  ComplaineeDepartmentModel::selectRaw('tblcomplaineedepartmentmaster.*, tblproductservicemaster.productservicename,tblcategorymaster.categoryname,tblsubcategorymaster.subcategoryname,tbldepartmentmaster.departmentname')
                ->Join('tblproductservicemaster','tblproductservicemaster.productservicecode','=','tblcomplaineedepartmentmaster.product_service')
                ->Join('tblcategorymaster','tblcategorymaster.categorycode','=','tblcomplaineedepartmentmaster.category')
                ->Join('tblsubcategorymaster','tblsubcategorymaster.subcategorycode','=','tblcomplaineedepartmentmaster.subcategory')
                ->Join('tbldepartmentmaster','tbldepartmentmaster.departmentcode','=','tblcomplaineedepartmentmaster.departmentcode')
                ->where('productservicename','LIKE',"%{$search}%")
                ->orWhere('categoryname', 'LIKE',"%{$search}%")
                ->orWhere('subcategoryname', 'LIKE',"%{$search}%")
                ->orWhere('departmentname', 'LIKE',"%{$search}%")
                ->orWhere('maxdays', 'LIKE',"%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get();

               $totalFiltered = ComplaineeDepartmentModel::selectRaw('tblcomplaineedepartmentmaster.*, tblproductservicemaster.productservicename,tblcategorymaster.categoryname,tblsubcategorymaster.subcategoryname,tbldepartmentmaster.departmentname')
                 ->Join('tblproductservicemaster','tblproductservicemaster.productservicecode','=','tblcomplaineedepartmentmaster.product_service')
                ->Join('tblcategorymaster','tblcategorymaster.categorycode','=','tblcomplaineedepartmentmaster.category')
                ->Join('tblsubcategorymaster','tblsubcategorymaster.subcategorycode','=','tblcomplaineedepartmentmaster.subcategory')
                ->Join('tbldepartmentmaster','tbldepartmentmaster.departmentcode','=','tblcomplaineedepartmentmaster.departmentcode')
                ->where('productservicename','LIKE',"%{$search}%")
                ->orWhere('categoryname', 'LIKE',"%{$search}%")
                ->orWhere('subcategoryname', 'LIKE',"%{$search}%")
                ->orWhere('departmentname', 'LIKE',"%{$search}%")
                ->orWhere('maxdays', 'LIKE',"%{$search}%")
                ->count();
        }

        $data = array();
        if(!empty($posts))
        {
            $count = 1;
            foreach ($posts as $post)
            {
                $nestedData['id'] = $count++;
                $nestedData['complaineedepartmentmastercode'] = $post->complaineedepartmentmastercode;
                $nestedData['productservicename'] = $post->productservicename;
                $nestedData['categoryname'] = $post->categoryname;
                $nestedData['subcategoryname'] = $post->subcategoryname;
                $nestedData['departmentname'] = $post->departmentname;
                $nestedData['maxdays'] = $post->maxdays;

                $nestedData['options'] = "&emsp;<a href=\"complaineedepartment/$post->complaineedepartmentmastercode\" style=\"margin-right: 3px;\">view</a>
                                          | <a href=\"complaineedepartment/$post->complaineedepartmentmastercode/edit\" style=\"margin - right: 3px;\">edit</a>";
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
