<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome2');
});



Auth::routes();

Route::get('getpartial', 'HomeController@getPartial');
Route::get('getpartialquipment', 'HomeController@getPartialEquipment');

Route::get('/home', 'HomeController@index')->name('home');


Route::get('/blank', function () {
    return view('blank');
})->middleware('auth')->name('blank');



Route::get('feedback/{id?}', 'FeedbackController@create');
Route::post('feedback', 'FeedbackController@store');

Route::group(['middleware' => ['auth', 'assignee']], function () {
    Route::get('/dashboard', 'AssigneeController@dashboard');
    Route::get('assigneechangepassword', 'ChangePasswordController@create');
    Route::post('assigneeupdatepassword', 'ChangePasswordController@update');
    #region Assignee Complaint Managing Routes
    Route::get('/assigneecomplaints','AssigneeController@index');
    Route::post('/getassigneenewcomplaints','AssigneeController@getassigneenewcomplaints');
    Route::post('/getpendingcomplaints','AssigneeController@getpendingcomplaints');
    Route::post('/getassigneenotresolvedcomplaints','AssigneeController@getassigneenotresolvedcomplaints');
    Route::post('/getassigneeresolvedcomplaints','AssigneeController@getassigneeresolvedcomplaints');
    Route::get('/assigneecomplaintsview/{id?}','AssigneeController@show');
    Route::get('/manageassigneecomplaint/{id?}','AssigneeController@edit');
    Route::post('/manageassigneecomplaint/{id?}', 'AssigneeController@update');
    Route::get('/report','ReportController@AssigneeIndex');
    Route::get('/getReportdates/{data?}','ReportController@GetDateWisecomplaintReport');
    Route::get('/getreports/pdf/{data?}','ReportController@htmltopdfreport');
    Route::get('/filesAssignee/{id}','AssigneeController@showFile');
#endregion

});

Route::group(['middleware' => ['auth', 'admin']], function () {
    Route::get('dashboard', 'HomeController@index');
    Route::get('maintenances', 'HomeController@index');
    Route::get('adminchangepassword', 'ChangePasswordController@create');
    Route::post('adminupdatepassword', 'ChangePasswordController@update');
    Route::get('users', 'UserController@index');
    Route::get('createuser', 'UserController@create')->name('createuser');
    Route::post('createuser', 'UserController@store');
    Route::get('viewuser/{id?}', 'UserController@show');
    Route::get('edituser/{id?}', 'UserController@edit');
    Route::post('edituser/{id?}', 'UserController@update');
    Route::get('deleteuser/{id?}', 'UserController@destroy');
    Route::get('roles', 'RoleController@index');
    Route::get('createrole', 'RoleController@create');
    Route::post('createrole', 'RoleController@store');
    Route::get('viewrole/{id?}', 'RoleController@show');
    Route::get('editrole/{id?}', 'RoleController@edit');
    Route::post('editrole/{id?}', 'RoleController@update');
    Route::get('deleterole/{id?}', 'RoleController@destroy');
    Route::get('menus', 'MenuController@index')->name('menus');
    Route::get('createmenu', 'MenuController@create')->name('createmenu');
    Route::post('createmenu', 'MenuController@store');
    Route::post('store_sub_menu', 'MenuController@store_sub_menu');
    Route::get('viewmenu/{id?}', 'MenuController@show');
    Route::get('editmenu/{id?}', 'MenuController@edit');
    Route::post('editmenu/{id?}', 'MenuController@update');
    Route::get('deletemenu/{id?}', 'MenuController@destroy');
    Route::get('userlodgedcomplaints', 'ComplaintsFilterController@index')->name('userlodgedcomplaints');
    Route::get('createnewcomplaint', 'AppAdminController@createComplaint')->name('createnewcomplaint');
    Route::post('storenewcomplaint', 'AppAdminController@storeComplaint');
    Route::post('/allclosedcomplaint', 'ComplaintsFilterController@getclosedcomplaintlist');
    Route::get('/closedcomplaints', 'ComplaintsFilterController@closedcomplaintlist');
    Route::get('/complaints', 'ComplaintHandlingController@shownewcomplaints');
    Route::get('/complaints/view/{id}', 'ComplaintHandlingController@viewcustomercomplaint');
    Route::post('/complaint/newcomplaints', 'ComplaintHandlingController@getNewComplaints');
    Route::post('/complaint/assignedcomplaints', 'ComplaintHandlingController@getAssignedComplaints');
    Route::post('/complaint/resolvedcomplaints', 'ComplaintHandlingController@getResolvedComplaints');
    Route::get('/complaints/close/{id?}', 'CustomerComplaintListController@closecomplaint');
    Route::post('/complaints/close/{id?}', 'CustomerComplaintListController@closecomplaintupdate');

    //supply close complaint
    Route::get('/supplycomplaints/supplyclose/{id?}', 'CustomerComplaintListController@closecomplaintsupply');
    Route::post('/supplycomplaints/supplyclose/{id?}', 'CustomerComplaintListController@supplyclosecomplaintupdate');

//    added
    Route::get('/complaint/Reopen/{id?}','CustomerComplaintListController@reopenComplaint');
    Route::get('/registration/existingcustomercomplaintview/{id?}', 'ComplaintHandlingController@show');

        //service assignee complaint
    Route::get('/registration/assigncomplaint/{id?}/{serviceID?}', 'ComplaintHandlingController@create');
    Route::post('/registration/assigncomplaint', 'ComplaintHandlingController@store');

    //supply mamagement storesupply
    Route::get('/registrationSupply/assigncomplaintSupply/{id?}/{serviceID?}', 'ComplaintHandlingController@createsupply');
    Route::post('/registrationSupply/assigncomplaintSupply', 'ComplaintHandlingController@storesuppy');


    Route::get('/registration/edit/{id}/{ticketno}', 'ComplaintHandlingController@edit');
    Route::post('/registration/update/{id?}', 'ComplaintHandlingController@update');
    Route::post('/getuserlodgedcomplaint', 'ComplaintController@getUserLoggedComplaints');
    Route::get('/registration/manageusernewcomplaint/{id}', 'ComplaintsFilterController@manageusersnewcomplaint');
    Route::post('/newcomplaint/register', 'UserComplaintController@newcomplaintregister');
    Route::post('/rejectcomplaint', 'ComplaintsFilterController@rejectcomplaint');
    Route::post('/lodgeusercomplaint','ComplaintsFilterController@lodgeusercomplaint');
    Route::get('/getallstatusshowpage','ComplaintsFilterController@getallstatusshowpage');
    Route::get('/getallstatusshowpage/view/{ticketno}','ComplaintsFilterController@allStatusView');

  //  Route::get('/getallstatusshowpage/view/{ticketno}','ComplaintsFilterController@allStatusView');
    Route::get('/file/{id}','ComplaintsFilterController@showFile');
    #region Masters Routes
    Route::post('allcomplaintype', 'Masters\ComplaintTypeMaster@getIndexData');
    Route::post('allassignee', 'Masters\AssigneeMasterController@getIndexData');
    Route::post('allbranches', 'Masters\BranchMasterController@getIndexData');
    Route::post('allcategory', 'Masters\CategoryMasterController@getIndexData');
    Route::post('allsubcaregory', 'Masters\SubCategoryMasterController@getIndexData');
    Route::post('allbranchcontact', 'Masters\BranchContactMasterController@getIndexData');
    Route::post('allcustomer', 'Masters\CustomerMasterController@getIndexData');
    Route::post('allcomplaineedepartment', 'Masters\ComplaineeDepartmentMasterController@getIndexData');
    Route::post('allproductservice', 'Masters\ProductServiceMasterController@getIndexData');
    Route::resource('branches', 'Masters\BranchMasterController');
    Route::resource('customers', 'Masters\CustomerMasterController');
    Route::resource('complainttypes', 'Masters\ComplaintTypeMaster');
    Route::resource('branchescontactperson', 'Masters\BranchContactMasterController');
    Route::resource('productservice', 'Masters\ProductServiceMasterController');
    Route::resource('assignee', 'Masters\AssigneeMasterController');
    Route::resource('subcategory', 'Masters\SubCategoryMasterController');
    Route::resource('complaineedepartment', 'Masters\ComplaineeDepartmentMasterController');
    Route::resource('category', 'Masters\CategoryMasterController');
    Route::resource('sectors', 'Masters\SectorMasterController');
    Route::get('/getequipment/{id?}', 'AppAdminController@getequipmentdate');
//    added
    Route::get('/getcategory/{productservicecode?}/{customersite?}','AppAdminController@getcategory');
    Route::get('/getcomhersivetype/{id?}', 'AppAdminController@getcomhernsivetype');
    Route::post('/updatesubmenu/{id}', 'MenuController@submenu_update');
    Route::post('store_nested_menu', 'MenuController@store_nasted_menu');

    Route::get('/registrationcomplaintsclose/edit/{id}/{ticketno}', 'ComplaintHandlingController@registercomplaintclose');
    Route::get('/registrationreassigne/edit/{id}/{ticketno}', 'ComplaintHandlingController@registerassignecomplaint');

    Route::get('/getequipmentproductsrno/{data?}', 'AppAdminController@getequipmentproductsrnodate');
    Route::get('/closecomplint/{id}', 'ComplaintHandlingController@closecomplint');
    Route::get('/complaints/edit/{id}', 'UserComplaintController@EditGuestComplaint');
    Route::post('updateguestcomplaint', 'UserComplaintController@UpdateGuestComplaint');
    Route::post('updatenewcomplaintbyequipment', 'UserComplaintController@updatenewcomplaintbyequipment');
    Route::post('updateeditcomplaintsbyworkorder', 'UserComplaintController@updateeditcomplaintsbyworkorder');

    Route::get('/complaints/reopencomplaint/{id}','ComplaintHandlingController@reopenComplaint');
    Route::post('complaintreopen','ComplaintHandlingController@storeReopenComplaint');

    Route::get('/addcomments/{ticketno}','ComplaintHandlingController@addcomments');
    Route::post('/commentpost/','ComplaintHandlingController@commentspost');
    #endregion


    #region Contract Route

    Route::get('/contracts', 'ContractController@index');
    Route::post('/getAllContracts','ContractController@getAllContractsDT');
    Route::get('editcontract/{id?}', 'ContractController@edit');
    Route::get('/updatecontract/{id?}', 'ContractController@updateContract');
    Route::get('showcontract/{id?}', 'ContractController@showContract');
    Route::get('/addnewcontract', 'ContractController@create');
    Route::get('/addcontractmasterdata', 'ContractController@addNewContract');
    Route::get('/addnewcontractdetails', 'ContractController@addContractDetails');
    Route::get('/addnewcontractsitemaster', 'ContractController@addnewcontractsitemaster');
    Route::get('/addnewcontractsitecontactmaster', 'ContractController@addnewcontractsitecontactmaster');
//    Route::get('/addnewequipmentdetails', 'ContractController@addequipmentDetails');
    Route::get('/addnewpaymentterms/{data?}','ContractController@addPaymentTerms');
    Route::post('/addnewpayables','ContractController@addPayables');
    Route::get('/workorders/{id}','ContractController@getworkorders');
    Route::get('/workorders/{id}','ContractController@getworkorders');
    Route::get('/uploadexcel','ContractController@uploadExcel');
    Route::post('/uploadexcelpost','ContractController@uploadExcelPost');
    Route::post('/edituploadexcel','ContractController@editUploadExcel');
    Route::get('/equipmentforexcel/{id}/{contractno}/{branchcode}','ContractController@getequipmentexcelupload');

    Route::get('/addequipmentdetails', 'ContractController@addequipmentDetails');

    Route::get('/getservicedate/{data?}','ContractController@getservicedate');
    Route::get('/getyear/{data?}','ContractController@getYears');

    Route::get('updatecontractmasterdata', 'ContractController@updateContract');
    Route::get('/updatecontractsitemaster', 'ContractController@updatecontractsitemaster');
    Route::get('/updatecontractsitecontactmaster', 'ContractController@updatecontractsitecontactmaster');
    Route::get('/updateContractDetails', 'ContractController@updateContractDetails');
    Route::post('/updateequipmentdetails', 'ContractController@updateequipmentDetails');


    Route::get('/getcheckpostedvalues/{data?}','ServiceController@getchkvalues');
    #region Service Management
    Route::get('/pendingservice', 'ServiceController@serviceindex');
    Route::get('/managecomplaint/manage/{id}', 'ServiceController@index');
    Route::get('/managecomplaint/show/{id}', 'ServiceController@show');
    Route::get('/managecomplaint/assignee/{id}/{serviceId}', 'ServiceController@assignee');
    Route::get('/storeequipment/{data?}','ServiceController@storeequipment');
    Route::get('/servicehome','ServiceController@servicehome');
    Route::get('/serviceview/{ticketno}','ServiceController@serviceview');

    Route::get('servicemanagement','ServiceController@servicecompletionindex');
    Route::get('servicemanagementview/{id?}','ServiceController@servicecompletionview');
    Route::get('servicemanagementedit/{id?}','ServiceController@servicecompletionedit');
    Route::post('servicemanagementeditpost{id?}','ServiceController@servicecompletionupdated');
    #endregion
    #region Supply Management
    Route::get('/pendingsupply', 'SupplyManagementController@index');
    Route::get('/pendingsupply', 'SupplyManagementController@index');
    Route::get('/show/{id}', 'SupplyManagementController@show');
    Route::get('/manage/{id}', 'SupplyManagementController@manage');
    Route::get('/storemanage/{data?}','SupplyManagementController@storemanage');
    Route::get('supply/assignee/{id}', 'SupplyManagementController@assignee');
    Route::get('/pendinginstallationsupply', 'SupplyManagementController@pendinginstalletionindex');


    Route::get('/getcheckpostedvaluessupply/{data?}','SupplyManagementController@getchkvaluessupply');
   // Route::get('/registrationSupply/assigncomplaintSupply/{id?}/{serviceID?}', 'ComplaintHandlingController@createsupply');

    Route::get('supplymanagement','SupplyManagementController@supplycompletionindex');
    Route::get('supplymanagementview/{id?}','SupplyManagementController@view');
    Route::get('supplymanagementedit/{id?}','SupplyManagementController@edit');
    Route::post('supplymanagementupdate{id?}','SupplyManagementController@update');

    Route::get('/gettenderdate{data?}', 'ContractController@gettenderdate');

    #endregion


    Route::get('/addnewpaymentterms','ContractController@addPaymentTerms');
    Route::get('/updatepaymenterms','ContractController@updatepaymenterms');

    #endregion

    #region Trash category Master
    Route::get('trashcategory','Masters\TrashMasterController@trashcategory');
    Route::get('restorecategory/{id}','Masters\TrashMasterController@restorecategory');
    Route::get('deletecategory/{id}','Masters\TrashMasterController@removecategory');
    #endregion

    #region Trash Customer Master
    Route::get('trashcustomer','Masters\TrashMasterController@trashcustomer');
    Route::get('restorecustomer/{id}','Masters\TrashMasterController@restorecustomer');
    Route::get('deletecustomer/{id}','Masters\TrashMasterController@removecustomer');
    #endregion

    #region Trash Customer Master
    Route::get('trashcustomer','Masters\TrashMasterController@trashcustomer');
    Route::get('restorecustomer/{id}','Masters\TrashMasterController@restorecustomer');
    Route::get('deletecustomer/{id}','Masters\TrashMasterController@removecustomer');
    #endregion

    #region Trash Branch Master
    Route::get('trashbranch','Masters\TrashMasterController@trashbranch');
    Route::get('restorebranch/{id}','Masters\TrashMasterController@restorebranch');
    Route::get('deletebranch/{id}','Masters\TrashMasterController@removebranch');
    #endregion

    #region Trash Branch Contact Master
    Route::get('trashbranchcontact','Masters\TrashMasterController@trashbranchcontact');
    Route::get('restorebranchcontact/{id}','Masters\TrashMasterController@restorebranchcontact');
    Route::get('deletebranchcontact/{id}','Masters\TrashMasterController@removebranchcontact');
    #endregion

    #region Trash Product Service Master
    Route::get('trashproductservice','Masters\TrashMasterController@trashproductservice');
    Route::get('restoreproductservice/{id}','Masters\TrashMasterController@restoreproductservice');
    Route::get('deleteproductservice/{id}','Masters\TrashMasterController@removedproductservice');
    #endregion

    #region Trash subcategory Master
    Route::get('trashsubcategory','Masters\TrashMasterController@trashsubcategory');
    Route::get('restoresubcategory/{id}','Masters\TrashMasterController@restoresubcategory');
    Route::get('deletesubcategory/{id}','Masters\TrashMasterController@removedsubcategory');
    #endregion

    #region Trash Assignee Master
    Route::get('trashassignee','Masters\TrashMasterController@trashassignee');
    Route::get('restoreassignee/{id}','Masters\TrashMasterController@restoreassignee');
    Route::get('deleteassignee/{id}','Masters\TrashMasterController@removedassignee');
    #endregion

    Route::get('/addpaymentdetails', 'ContractController@addPaymentTerms');

    Route::get('/deletequipment/{data?}', 'ContractController@delete');

    Route::get('/amendcontract/{id}/{customername}','ContractController@amendcontract');
    Route::post('/amendcontractcreatenewcontract/{contractno}','ContractController@amendcontractcreatenewcontract');

    Route::get('callreport','EngineerCallMonitoringReportController@callreport');

    // Engineer Report routes
    Route::get('getuserinput','EngineerCallMonitoringReportController@create');
    Route::post('getuserinput','EngineerCallMonitoringReportController@getuserinput');

//    Route::get('newcomplaint', 'ComplaintController@storeNewUserComplaint');
//    Route::post('/newcomplaint', 'ComplaintController@storeNewGuestComplaint');

    Route::get('newcomplaint', 'UserComplaintController@createGuestComplaint');
    Route::post('/newcomplaint', 'UserComplaintController@storeGuestComplaint');
    Route::get('/newusercomplaint', 'UserComplaintController@newUserComplaint');
    Route::post('/storenewusercomplaint', 'UserComplaintController@storeNewUserComplaint');

    Route::get('/invoicestore/{id}','InvoicePaymentController@create');
    Route::get('/invoiceedit/{contractno}/{paymentcycle}','InvoicePaymentController@edit');

    Route::get('invoicepaymentdetails','InvoicePaymentController@index');
    Route::post('/invosave/{id}','InvoicePaymentController@saveinvoice');
    Route::get('/invoicereport/{contractno}/{paymentcycle}','InvoicePaymentController@invoicereport');
    Route::get('/sendinvoice/{contractno}/{paymentcycle}','InvoicePaymentController@squotationendinvoice');
    Route::post('/savesenddate/','InvoicePaymentController@savesenddate');
    Route::post('/downloadinv/','InvoicePaymentController@download');
    Route::post('/invoiceupdate/','InvoicePaymentController@update');
    Route::get('/htmlpage/','InvoicePaymentController@htmlpage');
    Route::post('/generate-pdf/','InvoicePaymentController@pdfview');

    Route::get('paymentdetails','PaymentDetailsController@paymentdetails');
    Route::get('paymentedit/{id}','PaymentDetailsController@paymentedit');
    Route::post('paymentupdate','PaymentDetailsController@paymentupdate');
    Route::get('/viewpayment/{id}','PaymentDetailsController@viewpayment');




    //    supplyinvoice

    Route::get('supplyindex','InvoicePaymentController@supplyindex');
    Route::get('supplyinvoice/{id}/{paymentcycle}','InvoicePaymentController@supplyinvoice');
    Route::post('supplysaveinvoice','InvoicePaymentController@supplysaveinvoice');
    Route::get('supplyedit/{contractno}/{paymentcycle}','InvoicePaymentController@supplyedit');
    Route::post('/supplyupdate/','InvoicePaymentController@supplyupdate');

    Route::get('examplegetmenu','HomeController@menu');
    Route::get('examplegetmenuindex','HomeController@examenuindex');

//    Route::get('chkcustomername','UserComplaintController@chkcustomername');
    Route::get('/chkcustomername/{id}', 'UserComplaintController@chkcustomername');
    Route::post('/allcomplaints', 'ComplaintsFilterController@allcomplaints');
    Route::post('/closecomplaint', 'ComplaintHandlingController@closecomplaints');

    Route::post('/allsaleslead', 'SalesLeadController@getallsaleslead')->middleware('auth');
    Route::get('/saleslead', 'SalesLeadController@index')->middleware('auth');
    Route::get('/saleslead/edit/{id}', 'SalesLeadController@edit')->middleware('auth');
    Route::get('/saleslead/show/{id}', 'SalesLeadController@show')->middleware('auth');
    Route::get('/saleslead/addnewlead', 'SalesLeadController@create')->middleware('auth');
    Route::post('/saleslead/newlead', 'SalesLeadController@addnewlead')->middleware('auth');
    Route::post('/saleslead/editlead', 'SalesLeadController@editlead')->middleware('auth');
    Route::get('/shiftedequipmentindex','ShiftedequipmentController@index');
    Route::get('/shiftedequipment','ShiftedequipmentController@create');
    Route::get('/getproductwiseequipment/{data?}','ShiftedequipmentController@getproductwiseequipment');
    Route::post('storeshiftequipment', 'ShiftedequipmentController@storeshiftequipment');
    Route::get('/getcontractdetails/{id}', 'ShiftedequipmentController@getcontractdetails');
    Route::get('/excel/{id}', 'TenderHandlingController@convertcollectpdf');
    Route::get('/newquipmentdetails', 'NewEquipmentDetailsController@create');

    Route::get('/addequipmentdetailsnewcustomer', 'UserComplaintController@addaddequipmentdetailsnewcustomer');
    Route::get('/getequipmentdetailsnewcustomer/{id}', 'UserComplaintController@getequipmentdetailsnewcustomer');

    #region Quatation
    Route::get('quotation','QuotationDetailsController@index');
    Route::get('/genratequotation/{id}','QuotationDetailsController@genratequotation');
    Route::post('/savequotation','QuotationDetailsController@savequotation');
    Route::get('/edit/{id}','QuotationDetailsController@edit');
    Route::post('/update','QuotationDetailsController@update');
    Route::get('/quotationreport/{ticketno}','QuotationDetailsController@quotationreport')->name('quotationreportdownload');
    Route::get('/quotationstatus/{ticketno}','QuotationDetailsController@quotationstatus');
    Route::post('/status','QuotationDetailsController@savestatus');
    Route::get('/dispatch/{ticketno}','QuotationDetailsController@dispatch');
    Route::post('/savedispatch','QuotationDetailsController@savedispatch');
    Route::post('/download','QuotationDetailsController@downloadpdf');
    Route::get('/details/{ticketno}','QuotationDetailsController@view');
    Route::get('/saleproduct','QuotationDetailsController@indexsale');

//salequotationquotation changed to salequotation
   // Route::get('/salequotationquotation/{ticketno}','QuotationDetailsController@salequotation');
    Route::get('/salequotation/{ticketno}','QuotationDetailsController@salequotation')->name('salequotationdownload');
    Route::post('/salegenratequotation','QuotationDetailsController@salegenratequotation');
    Route::get('/editsale/{ticketno}','QuotationDetailsController@editsale');
    Route::post('/saleupdate','QuotationDetailsController@updatesale');
    Route::get('/salestatus/{ticketno}','QuotationDetailsController@salequotationstatus');
    Route::post('/savesalestatus','QuotationDetailsController@savesalestatus');
    Route::post('/saledownload','QuotationDetailsController@saledownload');
    Route::get('/saledetails/{ticketno}','QuotationDetailsController@saleview');

    Route::get('/newuserindex','QuotationDetailsController@newUserIndex');
    Route::get('/quotation/{ticketno}','QuotationDetailsController@quotation');
    Route::post('/savenewuserquotation','QuotationDetailsController@saveNewUserQuotation');
    Route::get('/editnewuserquotation/{ticketno}','QuotationDetailsController@editNewUserQuotation');
    Route::post('/updatenewuserquotation','QuotationDetailsController@updateNewUserQuotation');


    #endregion

    Route::get('newcomplaintbyequipment', 'AppAdminController@newcomplaintbyequipment');
    Route::post('/storecomplaintbyequipment', 'AppAdminController@storecomplaintbyequipment');
    Route::get('/Getequipmentbyworkorderdata/{data?}', 'AppAdminController@Getequipmentbyworkorderdata');
    Route::get('/Getproductbyworkorderdata/{data?}', 'AppAdminController@Getproductbyworkorderdata');

    #region All Report
    Route::get('getreport', 'ReportController@index');
    Route::get('/getReportdate/{data?}','ReportController@GetDateWisecomplaintReport');
    Route::get('/getcallerdetails/{id?}', 'AppAdminController@getcallerdetails');
    Route::get('/checkproductsrno/','AppAdminController@checkProductSrNo');
    Route::get('/checkequipment/','AppAdminController@checkEquipmentSrNo');
    Route::get('/getreport/pdf/{data?}','ReportController@htmltopdfreport');
    Route::get('/contractreport','ReportController@contractReport');
    Route::get('/contractreport/excel/{data?}','ReportController@export');
    Route::get('/customerwisereport','ReportController@customerWiseReport');
    Route::get('/contracttypereport','ReportController@contracttypeReport');
    Route::get('/complaintreport/excel/{data?}','ReportController@reportExport');
    Route::get('/getbranchscustomerwise/{customerid}','ReportController@getBranchsCustomerWise');
    Route::get('/getequipmentsbranchwise/{customerid}/{departmentid}/','ReportController@getEquipmentsBranchWise');
    Route::get('/getcontractdata/','ReportController@contractdata');
    Route::get('/getcustomerwisedata/','ReportController@customerwisedata');
    Route::get('/getcontracttypedata/','ReportController@contracttypedata');
    Route::get('/getcontractfilters/{data}','ReportController@contractFilters');
    #endregion
    Route::get('/getassigneeassigneddata/{id}', 'ComplaintHandlingController@getassigneeassigneddata');

    Route::get('/getproductsrno/{id}', 'ComplaintHandlingController@GetProductsrno');
    Route::post('/updateproductsrnocomplaint', 'ComplaintHandlingController@updateproductsrnocomplaint');

    #region Inward And Outward
    Route::get('/inwardindex','InwardOutwardController@inwardindex');
    Route::get('/addinward','InwardOutwardController@addinward');
    Route::post('/saveinward','InwardOutwardController@saveinward');
    Route::get('/getticketdetails/{ticket}','InwardOutwardController@getticketdetails');
    Route::get('/editinward/{ticket}/{id}','InwardOutwardController@editinward');
    Route::post('/updateinward','InwardOutwardController@updateinward');
    Route::get('/outwardindex','InwardOutwardController@outwardindex');
    Route::get('/viewdetails/{ticket}/{id}','InwardOutwardController@viewdetails');
    Route::get('/generatechallan/{ticket}/{id}','InwardOutwardController@generatechallan');
    Route::post('/downloadchallan','InwardOutwardController@downloadChallan');
    Route::get('/addoutward/{ticketno}/{id}','InwardOutwardController@addoutward');
    Route::post('/saveoutward','InwardOutwardController@saveoutward');
    Route::get('/challandetails/{ticketno}/{id}','InwardOutwardController@challandetails');
    #endregion

    #region Vendor
    Route::get('/vendorindex','VendorController@index');
    Route::get('/editvendor/{id}','VendorController@edit');
    Route::post('/updatevendor','VendorController@update');
    Route::get('/addcommentvendor/{ticketno}','VendorController@addComments');
    Route::post('/submitcomments/','VendorController@postComments');
    Route::get('/closevendorcomplaint/{ticketno}','VendorController@closeVendorComplaint');
    Route::post('/submitvendorcomplaint/{ticketno}','VendorController@submitVendorComplaint');

    #endregion


});

Route::group(['middleware' => ['auth', 'tender']], function () {

    Route::get('tenderchangepassword', 'ChangePasswordController@create');
    Route::post('tenderupdatepassword', 'ChangePasswordController@update');
    Route::get('/tender', 'TenderHandlingController@index');
    Route::get('/tender/editregistration/{id}', 'TenderHandlingController@edit');
    Route::post('/edittenderregistration/{id}', 'TenderHandlingController@edittenderregistration');
    Route::get('/tender/viewtenderregistration/{id}', 'TenderHandlingController@details');
    Route::get('/tender/newregistration', 'TenderHandlingController@create');
    Route::post('/newtenderregistration', 'TenderHandlingController@newtenderregistration');
    Route::get('/tender/tenderbidderview/{id}', 'TenderHandlingController@tenderbidderview');
    Route::post('/addtenderbidder/{id}', 'TenderHandlingController@tenderbidderstore');
    Route::get('/tender/edittenderbidder/{id}', 'TenderHandlingController@edittenderbidder');
    Route::post('/updatetenderbidder/{id}', 'TenderHandlingController@updatetenderbidder');
    Route::get('pdfreport/{id}','TenderHandlingController@pdfreport');
    Route::get('cal/{id}','TenderHandlingController@cal');
    Route::get('dashboard/tenderadmindashboard', 'DashboardController@admindashboard');
    Route::get('fileuploadedindex', 'FileUplodedController@index');
    Route::get('fileuploadedcreate', 'FileUplodedController@create');
    Route::post('storefileuploaded', 'FileUplodedController@store');
    Route::get('/editfileuploded/{id}', 'FileUplodedController@edit');
    Route::post('updatefileuploaded/{id}', 'FileUplodedController@update');
    Route::get('/tender/getfile/{id}', 'TenderHandlingController@getfile');

    Route::get('prospectivequotationindex', 'prospectiveQutationController@index');
    Route::get('prospectivequotation', 'prospectiveQutationController@create');
    Route::post('newprospectivequotation', 'prospectiveQutationController@store');
    Route::get('prospectivequotationedit/{id}', 'prospectiveQutationController@edit');
    Route::post('prospectivequotationupdate/{id}', 'prospectiveQutationController@update');
    Route::get('showprospectivequotation/{id}', 'prospectiveQutationController@show');
    Route::get('prospectivequotationreport', 'prospectiveQutationController@report');
    Route::post('prospectivequotationgetreport', 'prospectiveQutationController@getreport');
    Route::post('prospectivequotationgetreportpdf', 'prospectiveQutationController@getpdf');
    Route::get('genratequtationreport/{id}', 'prospectiveQutationController@genratequtaionreport');
    Route::post('/expiredtenders', 'TenderHandlingController@directexpiredtender');
    Route::get('checktenderno','TenderHandlingController@checktenderno');

    Route::get('/convertnotcollectedpdf', 'TenderHandlingController@convertnotcollectpdf');
    Route::get('/convertcollectedpdf', 'TenderHandlingController@convertcollectpdf');
});

Route::group(['middleware' => ['auth', 'user']], function () {
    Route::get('dashboard', 'HomeController@index');
    Route::get('maintenances', 'HomeController@index');
    Route::get('userchangepassword', 'ChangePasswordController@create');
    Route::post('userupdatepassword', 'ChangePasswordController@update');
    Route::get('mycomplaints', 'UserComplaintController@indexUserComplaint')->name('mycomplaints');
    Route::get('viewcomplaint/{id?}', 'UserComplaintController@showUserComplaint');
    Route::get('usernewcomplaint', 'UserComplaintController@createUserComplaint');
    Route::post('usernewcomplaint', 'UserComplaintController@storeUserComplaint');
    Route::get('settings', 'UserComplaintController@settingindex')->name('settings');
    Route::post('settings/{id}', 'UserComplaintController@settingupdate');
    Route::post('/getuserlodgedcomplaintsuserwise', 'ComplaintController@getUserLoggedUserWiseComplaints');
});

Route::get('myuser','MyUser@createlogin');
Route::post('newstoreuser','MyUser@storeuser');

/* Guest Access Routes*/

#region Artisan Commands
//Clear Cache facade value:
Route::get('/clear-cache', function () {
    $exitCode = Artisan::call('cache:clear');
    return '<h1>Cache facade value cleared</h1>';
});

//Reoptimized class loader:
Route::get('/optimize', function () {
    $exitCode = Artisan::call('optimize');
    return '<h1>Reoptimized class loader</h1>';
});

//Route cache:
Route::get('/route-cache', function () {
    $exitCode = Artisan::call('route:cache');
    return '<h1>Routes cached</h1>';
});

//Clear Route cache:
Route::get('/route-clear', function () {
    $exitCode = Artisan::call('route:clear');
    return '<h1>Route cache cleared</h1>';
});

//Clear View cache:
Route::get('/view-clear', function () {
    $exitCode = Artisan::call('view:clear');
    return '<h1>View cache cleared</h1>';
});

//Clear Config cache:
Route::get('/config-cache', function () {
    $exitCode = Artisan::call('config:cache');
    return '<h1>Clear Config cleared</h1>';
});

Route::get('command', function () {
    return URL::to('/');
    return config('app.url');
    return view('account.resetpassword');
});
#endregion

Route::get('sendemail', 'SendMailController@basic_email');

#region Used to populate the dropdowns so should work without authentication
Route::get('/registration/customers', 'CommonController@customerslist');
Route::get('/registration/category/{id}', 'CommonController@categorylist');
Route::get('/registration/subcategory/{id}', 'CommonController@subcategorylist');
Route::get('/registration/branch/{id}', 'CommonController@branchlist');
Route::get('/getbranch/{id}', 'ContractController@getbranch');
Route::get('/getbranchpluseequipmen/{id}', 'ContractController@getbranchandequipmen');

Route::get('/getworkorderno/{id}', 'CommonController@getworkorderno');
Route::get('/getequipmentsrcustomerwise/{id}', 'CommonController@getequipmentsrcustomerwise');
Route::get('/getworkordernowisebranch/{data?}', 'CommonController@getworkordernowisebranch');


// Contract Documents Routes
// Contract Document Routes
Route::post('upload-multiple-documents', 'ContractController@uploadMultipleDocuments');
Route::get('get-contract-documents/{contractno}', 'ContractController@getContractDocuments');
// Route::delete('delete-contract-document', 'ContractController@deleteContractDocument');
Route::post('delete-contract-document', 'ContractController@deleteContractDocument');
Route::get('view-contract-document/{contractno}/{docField}', 'ContractController@viewContractDocument');
Route::get('download-contract-document/{contractno}/{docField}', 'ContractController@downloadContractDocument');



Route::post('upload-equipment-document', 'ContractController@uploadEquipmentDocument');
Route::get('get-equipment-document/{contractno}', 'ContractController@getEquipmentDocument');
Route::get('view-equipment-document/{contractno}', 'ContractController@viewEquipmentDocument');
Route::get('download-equipment-document/{contractno}', 'ContractController@downloadEquipmentDocument');
Route::post('delete-equipment-document', 'ContractController@deleteEquipmentDocument');
Route::get('addbillingdetails', 'ContractController@addBillingDetails');


Route::get('getbillingdetails/{contractno}', 'ContractController@getBillingDetails');
Route::post('addpaymentdetails', 'ContractController@addPaymentDetails');
Route::get('getpaymentdetails/{contractno}', 'ContractController@getPaymentDetails');

Route::get('view-payment-document/{contractno}/{docField}', 'ContractController@viewPaymentDocument');
Route::get('download-payment-document/{contractno}/{docField}', 'ContractController@downloadPaymentDocument');
Route::post('delete-payment-document', 'ContractController@deletePaymentDocument');

#endregion