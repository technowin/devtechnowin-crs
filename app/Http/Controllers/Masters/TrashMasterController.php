<?php

namespace App\Http\Controllers\Masters;

use App\Models\BranchContactMasterModel;
use App\Models\ProductServiceMasterModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CategoryMasterModel;
use App\Models\CustomersModel;
use App\Models\BranchMasterModel;
use App\Models\SubCategoryMasterModel;
use App\Models\AssigneeMasterModel;

class TrashMasterController extends Controller
{

    #region category Remove And Restore Data

    public function removecategory($id)
    {
        $categorys = CategoryMasterModel::where('categorycode', $id);
        $categorys->delete();
        return redirect()->back()->with('flash_message', 'complaint deleted');
    }

    public function trashcategory()
    {
        $categorys = CategoryMasterModel::onlyTrashed()->paginate(10);
        return view('masters.categorymaster.trashdata',compact('categorys'));
    }

    public function restorecategory($id)
    {
        $category = CategoryMasterModel::onlyTrashed()->find($id)->restore();
        return redirect()->back()->with('flash_message', 'complaint successfully restore');

    }

    #endregion

    #region Customer Remove And Restore Data
    public function removecustomer($id)
    {

        $customer = CustomersModel::where('customercode', $id);
        $customer->delete();
        return redirect()->back()->with('flash_message', 'complaint deleted');
    }

    public function trashcustomer()
    {
        $customers = CustomersModel::onlyTrashed()->paginate(10);
        return view('masters.customermaster.trashcustomer',compact('customers'));
    }

    public function restorecustomer($id)
    {
        $customer = CustomersModel::onlyTrashed()->find($id)->restore();
        return redirect()->back()->with('flash_message', 'complaint successfully restore');

    }
    #endregion

    #region Branch Remove And Restore Data
    public function removebranch($id)
    {

        $branchsMasters = BranchMasterModel::where('customercode', $id);
        $branchsMasters->delete();
        return redirect()->back()->with('flash_message', 'complaint deleted');
    }

    public function trashbranch()
    {
        $branchsMasters = BranchMasterModel::onlyTrashed()->paginate(10);
        return view('masters.branchmaster.trashdata',compact('branchsMasters'));
    }

    public function restorebranch($id)
    {
        $branchsMasters = BranchMasterModel::onlyTrashed()->find($id)->restore();
        return redirect()->back()->with('flash_message', 'complaint successfully restore');

    }
    #endregion

    #region Branch Contact Remove And Restore Data
    public function removebranchcontact($id)
    {

        $branchscontactMasters = BranchContactMasterModel::where('branchcontactcode', $id);
        $branchscontactMasters->delete();
        return redirect()->back()->with('flash_message', 'complaint deleted');
    }

    public function trashbranchcontact()
    {
        $branches = BranchContactMasterModel::onlyTrashed()->paginate(10);
        return view('masters.branchcontactpersonmasters.trashdata',compact('branches'));
    }

    public function restorebranchcontact($id)
    {
        $branchscontactMasters = BranchContactMasterModel::onlyTrashed()->find($id)->restore();
        return redirect()->back()->with('flash_message', 'complaint successfully restore');

    }
    #endregion

    #region Product Service Remove And Restore Data
    public function removedproductservice($id)
    {
        $branchscontactMasters = ProductServiceMasterModel::where('productservicecode', $id);
        $branchscontactMasters->delete();
        return redirect()->back()->with('flash_message', 'complaint deleted');
    }

    public function trashproductservice()
    {
        $productservices = ProductServiceMasterModel::onlyTrashed()->paginate(10);
        return view('masters.productservicemasters.trashdata',compact('productservices'));
    }

    public function restoreproductservice($id)
    {
        $productservices = ProductServiceMasterModel::onlyTrashed()->find($id)->restore();
        return redirect()->back()->with('flash_message', 'complaint successfully restore');

    }
    #endregion

    #region Sub Category Remove And Restore Data
    public function removedsubcategory($id)
    {
        $subcategorys = SubCategoryMasterModel::where('subcategorycode', $id);
        $subcategorys->delete();
        return redirect()->back()->with('flash_message', 'complaint deleted');
    }

    public function trashsubcategory()
    {
        $subcategorys = SubCategoryMasterModel::onlyTrashed()->paginate(10);
        return view('masters.subcategorymasters.trashdata',compact('subcategorys'));
    }

    public function restoresubcategory($id)
    {

        $subcategorys = SubCategoryMasterModel::onlyTrashed()->find($id)->restore();
        return redirect()->back()->with('flash_message', 'complaint successfully restore');

    }
    #endregion

    #region Sub Assignee Remove And Restore Data
    public function removedassignee($id)
    {
        $assignees = AssigneeMasterModel::where('assigneecode', $id);
        $assignees->delete();
        return redirect()->back()->with('flash_message', 'complaint deleted');
    }

    public function trashassignee()
    {
        $assignees = AssigneeMasterModel::onlyTrashed()->paginate(10);
        return view('masters.assigneemasters.trashdata',compact('assignees'));
    }

    public function restoreassignee($id)
    {

        $assignees = AssigneeMasterModel::onlyTrashed()->find($id)->restore();
        return redirect()->back()->with('flash_message', 'complaint successfully restore');

    }
    #endregion



}
