<?php

namespace App\Http\Controllers\Masters;

use App\User;
use App\Role;
use Exception;
use Illuminate\Http\Response;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AssigneeMasterModel;
use App\Models\DepartmentMasterModel;
use App\Http\Controllers\CommonController;
use App\Models\EmployeeMasterModel;
use App\Models\IncrementMasterModel;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Facades\DB;


class AssigneeMasterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $request->user()->authorizeRoles(['admin']);
        $count = AssigneeMasterModel::all()->count();
        $assignees = AssigneeMasterModel::where('isactive',1)->orderBy('assigneename')->paginate($count);

        $departments = DepartmentMasterModel::All();
        $departmentcode = $departments->pluck('departmentname', 'departmentcode')->all();
        $emplyees = EmployeeMasterModel::All();
        $emplyeescode = $emplyees->pluck('employeename', 'employeeid')->all();
        return view('masters.assigneemasters.index', compact('assignees', 'departmentcode', 'emplyeescode'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $departments = DepartmentMasterModel::All();
        $departmentcode = $departments->pluck('departmentname', 'departmentcode')->all();
        $emplyees = EmployeeMasterModel::All();
        $emplyeescode = $emplyees->pluck('employeename', 'employeeid')->all();
        return view('masters.assigneemasters.create', compact('departmentcode', 'emplyeescode'));
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
//           return $test = $request['emailid'];
            $prep = AssigneeMasterModel::where('emailid',$request['emailid'])->get()->first();
            if ($prep != null)
            {
                        return redirect('assignee')->with('flash_message', $request['emailid'].  'This email already exists');
            }
           else if ($request['password'] != $request['password_confirmation']) {
                return redirect()->back()->withInput($request->all);
            }
            else
            {
                $common = new CommonController();
                $model = new AssigneeMasterModel();
//                $model->id = Uuid::uuid1();
                $model->departmentcode = $request->departmentcode;
                $model->assigneename = $request['assigneename'];
                $mystr = $request['assigneename'];
                $tablename = "Assignee";
                $tempcode = $common->DynamicCode($mystr, $tablename);
                $code = $tempcode['code'];
                $incrementid = $tempcode['incrementid'];
                $model->assigneecode = $code;
                $model->mobileno = $request['mobileno'];
                $model->emailid = $request['emailid'];
                $model->isactive = $request['isactive'];
                $model->labourcost = $request['labourcost'];
                $model->employeeid = $request->emplyeescode;

                $model->save();
                if ($model->save() == true) {
                    $id = "Assignee";
                    $modelincrement = IncrementMasterModel::find(IncrementMasterModel::where('incrementfor', $id)->first()->incrementid);
                    $modelincrement->incrementvalue = $incrementid;
                    $modelincrement->save();
                }
                $user = new User();
                $user->name = $request["assigneename"];
                $user->email = $request["emailid"];
                $user->mobile = $request["mobileno"];
                $user->password = $request["password"];
                $user->assigneecode = $code;
                $user->is_verified = "No";
                $user->save();

                $role = Role::where('name', '=', 'assignee')->first()->id;
                $role_r = Role::where('id', '=', $role)->firstOrFail();
                $user->assignRole($role_r);
                DB::table('role_user')->insert(['role_id' => $role, 'user_id' => $user->id]);
                return redirect('assignee');
            }

//            $assigneecheck = AssigneeMasterModel::where('emailid',$exitemail)->get();
//            $abc =  $assigneecheck->where('emailid',$exitemail);
//            if($assigneecheck == true)
//            {
//                return redirect()->back()->with('flash_message', 'There is  already  Assignee');
////                return redirect()->back()->with('flash_message', 'There is  already  Assignee');
//            }
//            else
//            {

//            }

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
         $assignees = AssigneeMasterModel::findOrFail($id);
        $departments = DepartmentMasterModel::all();
        $assignees->departmentcode = $departments->where('departmentcode', $assignees->departmentcode)->first()->departmentname;
        $employees = EmployeeMasterModel::all();
        $assignees->employeeid = $employees->where('employeeid', $assignees->employeeid)->first()->employeename;

        return view('masters.assigneemasters.details', compact('assignees'));
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

            $assignees = AssigneeMasterModel::findOrFail($id);
            $departments = DepartmentMasterModel::pluck('departmentname', 'departmentcode');
            $departmentcode = $assignees->departmentcode;
            $employees = EmployeeMasterModel::pluck('employeename', 'employeeid');
            $employeescode = $assignees->employeeid;
            return view('masters.assigneemasters.edit', compact('assignees', 'departmentcode', 'departments', 'employees', 'employeescode'));
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

            $model = AssigneeMasterModel::findOrFail($id);
            $model->departmentcode = $request->departments;
            $model->assigneename = $request['assigneename'];
            $model->mobileno = $request['mobileno'];
            $model->emailid = $request['emailid'];
            $model->isactive = $request['isactive'];
            $model->labourcost = $request['labourcost'];
            $model->employeeid = $request->employees;
            $model->save();
            return redirect('assignee');
        } catch (Exception $ex) {
            return $ex->getMessage();
            return 'Some error occurred while processing your request';
        }


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        $assignee = AssigneeMasterModel::findOrFail($id);

        $assignee->delete();

        return redirect('assignee')->with('flash_message', 'assignee successfully deleted');
    }

    public function getIndexData(Request $request)
    {
        $columns = array(
            0 => 'assigneecode',
            1 => 'departmentcode',
            2 => 'assigneename',
            3 => 'mobileno',
            4 => 'emailid',
            5 => 'labourcost',
            6 => 'isactive',
            7 => 'employeeid',
            8 => 'options',
        );

        $totalData = AssigneeMasterModel::count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $posts = AssigneeMasterModel::selectRaw('tblassigneemaster.*, tbldepartmentmaster.departmentname,tblemployeemaster.employeename')
                ->Join('tbldepartmentmaster', 'tbldepartmentmaster.departmentcode', '=', 'tblassigneemaster.departmentcode')
                ->Join('tblemployeemaster', 'tblemployeemaster.employeeid', '=', 'tblassigneemaster.employeeid')
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

        } else {

            $search = $request->input('search.value');
            $posts = AssigneeMasterModel::selectRaw('tblassigneemaster.*, tbldepartmentmaster.departmentname,tblemployeemaster.employeename')
                ->Join('tbldepartmentmaster', 'tbldepartmentmaster.departmentcode', '=', 'tblassigneemaster.departmentcode')
                ->Join('tblemployeemaster', 'tblemployeemaster.employeeid', '=', 'tblassigneemaster.employeeid')
                ->where('assigneecode', 'LIKE', "%{$search}%")
                ->orWhere('departmentname', 'LIKE', "%{$search}%")
                ->orWhere('employeename', 'LIKE', "%{$search}%")
                ->orWhere('assigneename', 'LIKE', "%{$search}%")
                ->orWhere('emailid', 'LIKE', "%{$search}%")
                ->orWhere('labourcost', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered = AssigneeMasterModel::selectRaw('tblassigneemaster.*, tbldepartmentmaster.departmentname,tblemployeemaster.employeename')
                ->Join('tbldepartmentmaster', 'tbldepartmentmaster.departmentcode', '=', 'tblassigneemaster.departmentcode')
                ->Join('tblemployeemaster', 'tblemployeemaster.employeeid', '=', 'tblassigneemaster.employeeid')
                ->where('assigneecode', 'LIKE', "%{$search}%")
                ->orWhere('departmentname', 'LIKE', "%{$search}%")
                ->orWhere('employeename', 'LIKE', "%{$search}%")
                ->orWhere('assigneename', 'LIKE', "%{$search}%")
                ->orWhere('emailid', 'LIKE', "%{$search}%")
                ->orWhere('labourcost', 'LIKE', "%{$search}%")
                ->count();
        }

        $data = array();
        if (!empty($posts)) {
            $count = 1;
            foreach ($posts as $post) {
                $nestedData['id'] = $count++;
                $nestedData['assigneecode'] = $post->assigneecode;
                $nestedData['departmentname'] = $post->departmentname;
                $nestedData['assigneename'] = $post->assigneename;
                $nestedData['mobileno'] = $post->mobileno;
                $nestedData['emailid'] = $post->emailid;
                $nestedData['labourcost'] = $post->labourcost;
                $nestedData['employeename'] = $post->employeename;
                if ($post->isactive == 1) {
                    $isactive = 'Yes';
                } else {
                    $isactive = 'No';
                }

                $nestedData['isactive'] = $isactive;

                $nestedData['options'] = "&emsp;<a href=\"assignee/$post->assigneecode\" style=\"margin-right: 3px;\">view</a>
                                          | <a href=\"assignee/$post->assigneecode/edit\" style=\"margin - right: 3px;\">edit</a>";
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
