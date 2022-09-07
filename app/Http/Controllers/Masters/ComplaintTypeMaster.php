<?php

namespace App\Http\Controllers\Masters;

use Illuminate\Http\Request;
use App\Models\IncrementMasterModel;
use App\Http\Controllers\Controller;
use App\Models\ComplaintTypeMasterModel;
use App\Models\ComplaineeDepartmentModel;

class ComplaintTypeMaster extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $complaintypes = ComplaintTypeMasterModel::orderBy('complaintname')->paginate(10);

        return view('masters.complainttypemaster.index', compact('complaintypes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('masters.complainttypemaster.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $model = new ComplaintTypeMasterModel();
            $model->complaintname = $request["complaintname"];
            $mystr = $request['complaintname'];
            $tempcode = $this->DynamicCode($mystr);
            $code = $tempcode['code'];
            $incrementid = $tempcode['incrementid'];
            $model->complaintcode = $code;
            $model->complaintdescription = $request["complaintdescription"];
            $model->isactive = $request["isactive"];
            $model->save();
            if ($model->save() == true) {
                $id = "ComplaintType";
                $modelincrement = IncrementMasterModel::find(IncrementMasterModel::where('incrementfor', $id)->first()->incrementid);
                $modelincrement->incrementvalue = $incrementid;
                $modelincrement->save();
            }
            return redirect('complainttypes');
        } catch (\Exception $ex) {
            return $ex->getMessage();
            return 'Some error occurred while processing your request';
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $complainttypemaster = ComplaintTypeMasterModel::findOrFail($id);

            return view('masters.complainttypemaster.details', compact('complainttypemaster'));
        } catch (\Exception $ex) {
            return $ex->getMessage();
            return 'Some error occurred while processing your request';
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $complainttypemaster = ComplaintTypeMasterModel::findOrFail($id);

            return view('masters.complainttypemaster.edit', compact('complainttypemaster'));
        } catch (\Exception $ex) {
            return $ex->getMessage();
            return 'Some error occurred while processing your request';
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $model = ComplaintTypeMasterModel::findOrFail($id);
            $model->complaintname = $request["complaintname"];
            $model->complaintdescription = $request["complaintdescription"];
            $model->isactive = $request["isactive"];
            $model->save();
            return redirect('complainttypes');
        } catch (\Exception $ex) {

            return $ex->getMessage();
            return 'Some error occurred while processing your request';
        }

    }

    public function DynamicCode($mystr)
    {
        $lastincrementid = IncrementMasterModel::all()->where('incrementfor', 'ComplaintType')->first()->incrementvalue;
        $code = str_pad($lastincrementid + 1, 4, "0", STR_PAD_LEFT);
        $newgenratedcode = strtoupper(mb_substr($mystr, 0, 2) . ($code));
        $itemarray = array('code' => $newgenratedcode, 'incrementid' => $lastincrementid + 1);
        return $itemarray;
    }


    public function getIndexData(Request $request)
    {
        $columns = array(
            0 => 'complaintcode',
            1 => 'complaintname',
            2 => 'complaintdescription',
            3 => 'isactive',
            4 => 'options',
        );

        $totalData = ComplaintTypeMasterModel::count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $posts = ComplaintTypeMasterModel::offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {

            $search = $request->input('search.value');

            $posts = ComplaintTypeMasterModel::where('complaintcode', 'LIKE', "%{$search}%")
                ->orWhere('complaintname', 'LIKE', "%{$search}%")
                ->orWhere('complaintdescription', 'LIKE', "%{$search}%")
                ->orWhere('isactive', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered = ComplaintTypeMasterModel::where('complaintcode', 'LIKE', "%{$search}%")
                ->orWhere('complaintname', 'LIKE', "%{$search}%")
                ->orWhere('complaintdescription', 'LIKE', "%{$search}%")
                ->orWhere('isactive', 'LIKE', "%{$search}%")
                ->count();
        }

        $data = array();
        if (!empty($posts)) {
            $count = 1;
            foreach ($posts as $post) {
                $nestedData['id'] = $count++;
                $nestedData['complaintcode'] = $post->complaintcode;
                $nestedData['complaintname'] = $post->complaintname;
                $nestedData['complaintdescription'] = $post->complaintdescription;
                if ($post->isactive == 1) {
                    $isactive = 'Yes';
                } else {
                    $isactive = 'No';
                }

                $nestedData['isactive'] = $isactive;
                $nestedData['options'] = "&emsp;<a href=\"complainttypes/$post->complaintcode\" style=\"margin-right: 3px;\">view</a>
                                          | <a href=\"complainttypes/$post->complaintcode/edit\" style=\"margin - right: 3px;\">edit</a>";
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
