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

Route::post('hardware','ResourceController@store');

Route::get('hardware','ResourceController@index');
Route::get('hardware-edit/All','ResourceController@editAll');

Route::post('hardware-edit/{id}','ResourceController@search'); //parthi search
Route::get('hardware-edit/{id}','ResourceController@edit');
Route::post('hardware-edit','ResourceController@editSpecific');

Route::get('hardware/{id}','ResourceController@hardware');
Route::get('software','SoftwareController@index');
Route::post('software','SoftwareController@store');
Route::post('software-edit','SoftwareController@update');
Route::get('software-edit','SoftwareController@edit');

//--------------------------------------------------------Parthi
Route::get('addPortion','AddResourcePortion@index');
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



//--------------------------------------------------------------Abhay
//Authenticated group
Route::group(array('middleware' => ['auth']), function() {
    //GET sign out
    Route::get('sign-out',array('as'=>'sign-out','uses'=>'Authentication_Controller@getSignOut'));
    //GET adminFullHomePage
    Route::get('home',array('as'=>'home-admin-full','uses'=>'HomeController@getHomeAdminFull'));
    //GET adminPartialHome
    Route::get('homeal',array('as'=>'home-admin-limited','uses'=>'HomeController@getHomeAdminLimited'));
    //GET projectManagerHomePage
    Route::get('homep',array('as'=>'home-project-manager','uses'=>'HomeController@getHomeProjectManager'));


    //Administrator Group
    Route::group(array('middleware' => ['role']), function() {
        Route::get('addUser', array('as' => 'add-user', 'uses' => 'Authentication_Controller@getAddUser'));
    });
    //CSRF protection group
    Route::group(array('before' => 'csrf'), function () {

        //POST change password
        Route::post('changePassword', array('as' => 'account-change-password-post', 'uses' => 'Authentication_Controller@postChangePassword'));
        //POST delete account
        Route::post('user/delete', array('as' => 'postDelete', 'uses' => 'Authentication_Controller@postDelete'));
        //POST delete account
        Route::post('user/deactivate', array('as' => 'accountDeactivate', 'uses' => 'Authentication_Controller@accountDeactivate'));
        //POST update permission
        Route::post('user/permission', array('as' => 'permissionUpdate', 'uses' => 'Authentication_Controller@postUpdatePermission'));
        //POST AddUser
        Route::post('addUser', array('as' => 'add-user-post', 'uses' => 'Authentication_Controller@postAddUser'));
    });
//GET AddUser

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


//---------------------------------------------------------------------Srinithy


Route::get('hardwarereq','HardwareReqController@v');
Route::get('hardwarereq','HardwareReqController@version');
Route::post('hardwarereq', array('as' => 'requestRes','uses'=>'HardwareReqController@save'));
//Route::post('hardwarereq', array('as' => 'DelRequest', 'uses' => 'HardwareReqController@DeleteRequest'));
//Route::post('ftpreq', array('as' => 'DeleteRequestF', 'uses' => 'FtpController@DeleteRequestF'));
//Route::post('hardwarereq','HardwareReqController@DeleteRequest');

Route::get('ftpreq','FtpController@view');
Route::post('ftpreq','FtpController@Ftp');
Route::get('ftpreq','FtpController@FindU');
Route::get('test','FtpController@getTest');



//
//
//Route::controllers([
//	'auth' => 'Auth\AuthController',
//	'password' => 'Auth\PasswordController',
//]);
