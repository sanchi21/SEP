<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'WelcomeController@index');



//--------------------------------------------------------------Abhay
//Authenticated group
Route::group(array('middleware' => ['auth']), function() {
    //GET sign out
    Route::get('sign-out',array('as'=>'sign-out','uses'=>'Authentication_Controller@getSignOut'));

    //GET adminPartialHome
    Route::get('homeal',array('as'=>'home-admin-limited','uses'=>'HomeController@getHomeAdminLimited'));


    Route::get('statistic',array('as'=>'statistic','uses'=>'HomeController@getStatistic'));

    //Project Manager Group
//    Route::group(array('middleware' => ['rolePM']), function() {
//        //GET projectManagerHomePage
//        Route::get('homep', array('as' => 'home-project-manager', 'uses' => 'HomeController@getHomeProjectManager'));
//    });
    Route::get('homep', array('as' => 'home-project-manager', 'uses' => 'HomeController@getHomeProjectManager'));
//GET adminFullHomePage
    Route::get('home',array('as'=>'home-admin-full','uses'=>'HomeController@getHomeAdminFull'));
    //GET AddUser
    Route::get('addUser', array('as' => 'add-user', 'uses' => 'Authentication_Controller@getAddUser'));
    //Administrator Group
    Route::group(array('middleware' => ['role']), function() {
        //CSRF protection group
        Route::group(array('before' => 'csrf'), function () {
            //POST change password
            Route::post('changePassword', array('as' => 'account-change-password-post', 'uses' => 'Authentication_Controller@postChangePassword'));
            //POST delete account
            Route::post('user/delete', array('as' => 'postDelete', 'uses' => 'Authentication_Controller@postDelete'));
            //POST delete account
            Route::post('user/deactivate', array('as' => 'accountDeactivate', 'uses' => 'Autheantication_Controller@accountDeactivate'));
            //POST update permission
            Route::post('user/permission', array('as' => 'permissionUpdate', 'uses' => 'Authentication_Controller@postUpdatePermission'));
            //POST AddUser
            Route::post('addUser', array('as' => 'add-user-post', 'uses' => 'Authentication_Controller@postAddUser'));
        });

//        //GET adminFullHomePage
//        Route::get('home',array('as'=>'home-admin-full','uses'=>'HomeController@getHomeAdminFull'));
//        //GET AddUser
//        Route::get('addUser', array('as' => 'add-user', 'uses' => 'Authentication_Controller@getAddUser'));
    });


//--------------------------------------------------------Sanchayan

    Route::post('hardware',array('as'=>'hardware-post','uses'=>'ResourceController@store'));

    Route::get('hardware',array('as'=>'hardware','uses'=>'ResourceController@index'));
    Route::get('hardware-edit/All',array('as'=>'hardware-edit-get','uses'=>'ResourceController@editAll'));

    Route::post('hardware-edit/{id}',array('as'=>'hardware-edit-post','uses'=>'ResourceController@search')); //parthi search
    Route::get('hardware-edit/{id}',array('as'=>'hardware-edit','uses'=>'ResourceController@edit'));
    Route::get('hardware-change/{d}','ResourceController@editSpecific');
    Route::post('hardware-update','ResourceController@update');

    Route::get('hardware/{id}','ResourceController@hardware');
    Route::get('software',array('as'=>'software-get','uses'=>'SoftwareController@index'));
    Route::post('software','SoftwareController@store');
    Route::post('software-edit/search','SoftwareController@search');
    Route::post('software-edit/','SoftwareController@update');
    Route::get('software-edit',array('as'=>'software-edit-get','uses'=>'SoftwareController@edit'));

    Route::get('change-property/New',array('as'=>'change-property/New','uses'=>'TableController@index'));
    Route::get('change-property/{id}','TableController@edit');
    Route::post('change-property','TableController@store');
    Route::post('delete-property','TableController@remove');

    Route::get('change-options',array('as'=>'change-options','uses'=>'DropDownController@index'));
    Route::post('change-options','DropDownController@handle');
    Route::post('change-option','DropDownController@handle2');

    Route::get('hardware-depreciate/{id}','DepreciateController@show');
//    Route::get('hardware-d','DepreciateController@index');
    Route::post('hardware-depreciate','DepreciateController@store');

    Route::post('purchase-request/','PurchaseRequestController@store');

    Route::get('purchase-request',array('as'=>'purchase-request','uses'=>'PurchaseRequestController@index'));
    Route::get('purchase-request/{no}','PurchaseRequestController@create');
//    Route::post('purchase-request','PurchaseRequestController@create');

    Route::get('request-type/New',array('as'=>'request-type/New','uses'=>'RequestTableController@index'));
    Route::get('request-type/{id}','RequestTableController@edit');
    Route::post('request-type/New','RequestTableController@store');
    Route::post('delete-request','RequestTableController@destroy');

    Route::get('other-request',array('as'=>'other-request','uses'=>'OtherRequestController@index'));
    Route::get('other-request/{id}','OtherRequestController@create');
    Route::get('other-request-view/{requestType}/{prCode}/{status}','OtherRequestController@view');
    Route::post('other-request','OtherRequestController@store');
    Route::get('other-request-update',array('as'=>'other-request-update','uses'=>'OtherRequestController@showRequests'));
    Route::get('other-request-update/{id}','OtherRequestController@editAll');
    Route::get('other-request-update/{id}/{pr}','OtherRequestController@edit');
    Route::post('other-request-update','OtherRequestController@update');
    Route::post('other-request-view','OtherRequestController@cancel');

    Route::get('purchase-view/{request_id}',array('as'=>'purchase-view','uses'=>'PurchaseRequestController@inventoryView'));
    Route::get('purchase-inventory/{category}/{request_id}/{item}',array('as'=>'purchase-inventory','uses'=>'ResourceController@inventory'));
    //  Route::post('purchase-inventory/{category}/{request_id}/{item}','ResourceController@store');

    Route::get('hardware-report/{category}',array('as'=>'hardware-report','uses'=>'PrintResourceController@index'));
    Route::post('hardware-report/','PrintResourceController@generateReport');


//--------------------------------------------------------Parthi
    Route::get('addPortion',array('as'=>'addPortion','uses'=>'AddResourcePortion@index'));
    Route::get('delete/{type}/{id}','AddResourcePortion@delete');

    Route::post('addPortion','AddResourcePortion@addOS');
    Route::post('updateOS','AddResourcePortion@updateOS');

    Route::post('addMake','AddResourcePortion@addMake');
    Route::post('updateMake','AddResourcePortion@updateMake');

    Route::post('addScreen','AddResourcePortion@addScreen');
    Route::post('updateScreen','AddResourcePortion@updateScreen');

    Route::post('addProvider','AddResourcePortion@addProvider');
    Route::post('updateProvider','AddResourcePortion@updateProvider');

    Route::post('addRam','AddResourcePortion@addRam');
    Route::post('updateRam','AddResourcePortion@updateRam');

    Route::post('addHardDisk','AddResourcePortion@addHardDisk');
    Route::post('updateHardDisk','AddResourcePortion@updateHardDisk');

    Route::get('renewal',array('as'=>'renewal','uses'=>'RenewalController@index'));
    Route::post('requestRenewal', 'RenewalController@requestRenewal');
    Route::post('cancelRenewal', 'RenewalController@cancelRequest');
    Route::get('renewalAccept',array('as'=>'renewalAccept','uses'=>'RenewalController@adminView'));
    Route::post('renewalAccept', 'RenewalController@adminAccept');

    Route::get('releaseResource',array('as'=>'releaseResource','uses'=>'RenewalController@adminReleaseView'));
    Route::post('releaseResourceProject', 'RenewalController@resourceReleaseProject');
    Route::post('releaseResourceEmployee', 'RenewalController@resourceReleaseEmployee');


    Route::post('searchResource', 'RenewalController@searchResource');

//    Route::get('employeeAllocation', 'RenewalController@employeeAllocationView');
    Route::get('employeeAllocation',array('as'=>'employeeAllocation','uses'=>'RenewalController@employeeAllocationView'));
    Route::post('employeeAllocation', 'RenewalController@employeeAllocation');
    Route::post('searchHardware', 'RenewalController@searchHardware');

    Route::get('viewAllocations', 'RenewalController@viewAllocation');

    Route::get('placeOrder', array('as'=>'placeOrder','uses'=>'PaymentController@index'));
    Route::post('placeOrder', 'PaymentController@viewByRequest');
    Route::post('placeOrder2', 'PaymentController@placeOrder');

    Route::get('viewInvoice', array('as'=>'ViewInvoice','uses'=>'PaymentController@getOrders'));
    Route::post('viewInvoice', 'PaymentController@searchOrders');

    Route::get('viewInvoice/{request_id}',array('as'=>'viewInvoice','uses'=>'PaymentController@getInvoice'));
    Route::post('viewInvoice/{request_id}',array('as'=>'viewInvoice','uses'=>'PaymentController@getInvoice'));

    Route::post('purchaseUp',array('as'=>'purchaseUp','uses'=>'PaymentController@updatePurchase'));
    Route::post('email',array('as'=>'email','uses'=>'PaymentController@sendEmail'));



//---------------------------------------------------------------------Srinithy


//Route::get('hardwarereq','HardwareReqController@v');
    Route::get('hardwarereq',array('as' => 'hardwarereq','uses'=>'HardwareReqController@version'));
    Route::post('hardwarereq', array('as' => 'requestRes','uses'=>'HardwareReqController@save'));
//Route::post('hardwarereq', array('as' => 'DelRequest', 'uses' => 'HardwareReqController@DeleteRequest'));
//Route::post('ftpreq', array('as' => 'DeleteRequestF', 'uses' => 'FtpController@DeleteRequestF'));
//Route::post('hardwarereq','HardwareReqController@DeleteRequest');

    Route::get('Allocate','AllocationController@view');
    Route::post('Allocate', array('as' => 'ViewRequests', 'uses' => 'AllocationController@ViewRequests'));
    Route::post('Allocate/ResourceAllocation', array('as' => 'ResourceAllocation', 'uses' => 'AllocationController@ResourceAllocation'));
    Route::post('Allocate/SearchResource', array('as' => 'SearchResource', 'uses' => 'AllocationController@SearchResource'));
    Route::post('Allocate/SendResource', array('as' => 'SendResource', 'uses' => 'AllocationController@SendResource'));
    Route::post('Allocate/viewAllocatedHardware', array('as' => 'viewAllocatedHardware', 'uses' => 'AllocationController@viewAllocatedHardware'));


    Route::get('ViewAll','AllocationController@getViewAll');
    Route::post('ViewAll', array('as' => 'ViewAll', 'uses' => 'AllocationController@ViewAll'));
    Route::get('ViewHardwareResources','AllocationController@getViewOfAllocations');

    Route::get('ViewGraphs','AllocationController@getAllocationReports');
    Route::post('ViewGraphs', array('as' => 'ViewAllocationGraph', 'uses' => 'AllocationController@ViewAllocationGraph'));

    Route::get('AssignFolder','FolderController@ViewFolder');
    Route::post('AssignFolder', array('as' => 'ViewFolderRequests', 'uses' => 'FolderController@ViewFolderRequests'));
    //Route::post('AssignFolder/AssignData', array('as' => 'AssignData', 'uses' => 'FolderController@AssignData'));
    Route::post('AssignFolder/AssignDataToDb', array('as' => 'AssignDataToDb', 'uses' => 'FolderController@AssignDataToDb'));
    Route::post('AssignFolder/CancelAccount', array('as' => 'CancelAccount', 'uses' => 'FolderController@CancelAccount'));

    Route::post('AssignFolder/AssignSharedFolder', array('as' => 'AssignSharedFolder', 'uses' => 'FolderController@AssignSharedFolder'));
    Route::post('AssignFolder/CancelSharedFolder', array('as' => 'CancelSharedFolder', 'uses' => 'FolderController@CancelSharedFolder'));


    Route::get('Approval','ApprovalController@ViewApproval');
    Route::post('Approval', array('as' => 'ViewRequestsApp', 'uses' =>'ApprovalController@ViewRequestsApp'));
    Route::post('Approval/UpdateChanges', array('as' => 'UpdateChanges', 'uses' =>'ApprovalController@UpdateChanges'));
    Route::post('Approval/ApproveRequest', array('as' => 'ApproveRequest', 'uses' =>'ApprovalController@ApproveRequest'));


    Route::post('ftpreq','FtpController@Ftp');
    Route::get('ftpreq', array('as'=>'ftpreq','uses'=>'FtpController@FindU'));

    Route::get('ViewAccounts','FolderController@getViewAccounts');
    Route::post('ViewAccounts', array('as' => 'EditAccountChanges','uses'=>'FolderController@EditAccountChanges'));

    Route::get('Connectivity','FtpController@ViewConnectivity');
    Route::post('Connectivity', array('as' => 'Connectivity','uses'=>'FtpController@SendConnRequest'));

    Route::get('TrackResource','AllocationController@getTrackResource');
    Route::post('TrackResource', array('as' => 'TrackResource','uses'=>'AllocationController@Track'));
    Route::post('TrackResource/FindHistory', array('as' => 'FindHistory','uses'=>'AllocationController@FindHistory'));

    Route::get('HardwareMaintenance','AllocationController@getHardwareMaintenance');
    Route::post('HardwareMaintenance', array('as' => 'HardwareMaintenance','uses'=>'AllocationController@SaveHardwareCost'));

    Route::get('MonthlyExpenses','MonthlyExpensesController@getMonthlyExpenses');
    Route::post('MonthlyExpenses', array('as' => 'ViewMonthlyExpenses', 'uses' => 'MonthlyExpensesController@ViewMonthlyExpenses'));


    Route::get('/download/{id}', 'ApprovalController@getDownload');




//GET change password
Route::get('changePassword', array('as' => 'account-change-password', 'uses' => 'Authentication_Controller@getChangePassword'));

});
//Route::post('addUser', array('as' => 'add-user-post', 'uses' => 'Authentication_Controller@postAddUser'));
//Route::get('addUser', array('as' => 'add-user', 'uses' => 'Authentication_Controller@getAddUser'));






//Unauthenticated Group
Route::group(array('before' => 'guest'), function() {

    //CSRF Protection Group
    Route::group(array('before' => 'csrf'), function () {
        //POST Login
        Route::post('postLogin', array('as' => 'postLogin','uses' => 'Authentication_Controller@postLogin'));
        //POST Forgot Password
        Route::post('forgotPassword', array('as' => 'forgotPassword-post','uses' => 'Authentication_Controller@postForgotPassword'));


    });

    //GET Login
    Route::get('login', array('as' => 'account-login', 'uses' => 'Authentication_Controller@getLogin'));
    //GET SendEmail
    Route::get('activate/{code}',array('as' => 'activate','uses' => 'Authentication_Controller@getActivate'));
    //GET Forgot Password
    Route::get('forgotPassword', array('as' => 'forgotPassword','uses' => 'Authentication_Controller@getForgotPassword'));
    //GET Recover
    Route::get('recover/{code}', array('as' => 'forgot-password-recover', 'uses' => 'Authentication_Controller@getRecover'));
    //GET AccessDenied
    Route::get('accessDenied', array('as' => 'access-permission-denied', 'uses' => 'HomeController@getAccessPermissionDenied'));

});

Route::get('test',['middleware' => 'role', function()
{
    return 'this page is limited';
}]);

Route::get('welcomeee',['middleware' => 'role', function()
{
    return 'this page is limited';
}]);;



//
//
//Route::controllers([
//	'auth' => 'Auth\AuthController',
//	'password' => 'Auth\PasswordController',
//]);
