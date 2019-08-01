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


/*
|--------------------------------------------------------------------------
| Home
|--------------------------------------------------------------------------
*/



Route::group(['middleware' => 'guest'], function() {
	Route::get('/', 'LandingController@index');
});


/*
|--------------------------------------------------------------------------
| Authorization
|--------------------------------------------------------------------------
*/

Route::group(['namespace' => 'Auth'], function(){
	Route::get('auth/login', 'AuthController@login');
	Route::get('auth/logout', 'AuthController@logout');
});

Route::get('/Inv', function(){
	return view('uility.invantory');
});


//Route::get('dash', ['as' => 'dash', 'uses' => 'DashController@index' ]);
//Route::get('/account', ['as' => 'account', 'uses' => 'AccountsController@index'] );

Route::get('/accounts', [ 'uses' => 'AccountsController@show' ] );



Route::get('/account/add', ['as' => 'add', 'uses' => 'AccountsController@addAccount'] );
Route::post('/account/create', ['as' => 'add', 'uses' => 'AccountsController@create'] );

Route::get('/account/{id}', ['as' => 'account', 'uses' => 'AccountsController@getAccount'] );
Route::get('/account/edit/{id}', ['as' => 'edit', 'uses' => 'AccountsController@editAccount'] );
Route::post('/account/update/{id}', ['as' => 'update', 'uses' => 'AccountsController@edit'] );
Route::delete('/account/{id}', ['as' => 'account.delete', 'uses' => 'AccountsController@destroy']);

Route::get('/account/report/field/{id}', ['as' => 'field', 'uses' => 'ReportsController@getFieldActivity']);
Route::get('/account/report/materialAct/{id}', ['as' => 'material', 'uses' => 'ReportsController@getMaterialUsageAct']);
Route::get('/account/report/materialCost', ['as' => 'materialCost', 'uses' => 'ReportsController@getMaterialGraph']);
Route::get('/account/material/ref', ['as' => 'materialRef', 'uses' => 'ReportsController@getMaterialRef']);
Route::post('/account/material/inv', ['as' => 'materialInv', 'uses' => 'ReportsController@getMaterialInventory']);
Route::post('/account/careOf', ['as' => 'act_co', 'uses' => 'ReportsController@accountCo']);
Route::post('/account/cancelAndComplete', ['as' => 'act_cnc', 'uses' => 'ReportsController@accountCancel']);
Route::post('/account/report/reference_list', ['as' => 'act_ref', 'uses' => 'ReportsController@reference']);
//Route::post('/account/report/bio', ['as' => 'act_bio', 'uses' => 'ReportsController@accountBio']);
Route::post('/account/report/bio', ['as' => 'act_bio', 'uses' => 'ReportsController@bioReport']);
Route::post('/account/exp', ['as' => 'global_exp', 'uses' => 'AccountsController@global_exp'] );
Route::post('/account/exp/update', ['as' => 'global_exp', 'uses' => 'AccountsController@global_exp_update'] );
//Move to a different controller
Route::post('/purge/fetch', ['as' => 'purge_fetch', 'uses' => 'ReportsController@purgeFetch']);
Route::post('/purge/remove', ['as' => 'purge_fetch', 'uses' => 'ReportsController@purgeRemove']);
Route::post('/account/purge/fetch', ['as' => 'purge_account_fetch', 'uses' => 'ReportsController@purgeAccountFetch']);
Route::post('/account/purge/remove', ['as' => 'purge_account_fetch', 'uses' => 'ReportsController@purgeAccountRemove']);

Route::get( '/dash', ['as' => 'dash', 'uses' => 'HomeController@index' ] );

Route::post( '/autocomplete', 'GetItemsController@getAccountAutocomplete' );
Route::post( '/autocomplete/tech', 'HomeController@autolookupTech' );
Route::post( '/autocomplete/mat', 'GetItemsController@autoCompleteMat' );

Route::post( '/autoselect/mat', 'GetItemsController@autoselectMat' );
Route::post( '/autoselect', 'GetItemsController@autoselect' );



Route::get('/technicians', ['as' => 'techs', 'uses' => 'TechnicianController@getTechs'] );
Route::post('/technicians/autocomplete', ['as' => 'techs', 'uses' => 'TechnicianController@autocomplete'] );
Route::post('/technicians/new', ['as' => 'techsNew', 'uses' => 'TechnicianController@create'] );
Route::post('/technicians/edit', ['as' => 'techsNew', 'uses' => 'TechnicianController@edit'] );
Route::post('/technicians/destroy', ['as' => 'techsNew', 'uses' => 'TechnicianController@destroy'] );
Route::post('/technician/account', ['as' => 'accountTech', 'uses' => 'TechnicianController@getTechByAccountId'] );



Route::post( '/users/autocomplete', 'UsersController@userAutocomplete' );
Route::post( '/users/autoselect', 'UsersController@userAutoselect' );
Route::post( '/users/updateUser', 'UsersController@userUpdate' );
Route::post( '/users/create', 'UsersController@create' );
Route::post( '/users/officeView', 'UsersController@officeView' );
Route::get( '/users/delete', 'UsersController@destroy' );

Route::post('/report/biologist', 'ReportsController@bioReport');


Route::get( '/getSalesmen', 'GetItemsController@getSalesmenList' );
Route::post( '/addSalesmen', 'GetItemsController@addSalesmen' );
Route::post( '/deleteSalesmen/{id}', 'GetItemsController@deleteSalesmen' );

Route::get('/push', 'HomeController@mailform' );
Route::post('/push', 'HomeController@gomailform' );

Route::get('/edit', 'Homecontroller@editform');

Route::get      ('/editGet', 'Homecontroller@editGet');
Route::delete   ('/editGet', 'Homecontroller@editDelete');

Route::post     ('/editFile', 'Homecontroller@editFile');

Route::post('/field/updateReport', 'UpdateController@updateReport');
Route::post('/field/updateMaterial', 'UpdateController@updateMaterial');
Route::post('/field/newMaterial', 'UpdateController@newMaterial');
Route::post('/field/removeMaterial', 'UpdateController@removeMaterial');
Route::post('/field/removeEntireMaterials', 'UpdateController@removeAllMaterial');
Route::post('/field/checkexist', 'FieldActivityController@checkexist');
Route::post('/field/create', 'FieldActivityController@create');
Route::post('/field/getfieldservice', 'FieldActivityController@getFieldService');

Route::post('/field/autocomplete', 'FieldActivityController@autocomplete');

Route::post('/inventory/create', ['as' => 'create_inv', 'uses' => 'InventoryController@create']);
Route::post('/inventory/create/save', ['as' => 'create_inv_save', 'uses' => 'InventoryController@storeInventory']);

Route::group(['middleware' => [ \App\Http\Middleware\CanEditInventory::class ]], function () {
	Route::get('/inventory/get/{officeId}', ['as' => 'get_inv_by_office', 'uses' => 'InventoryController@getInventories']);
	Route::get('/inventory/edit', ['as' => 'edit_inv', 'uses' => 'InventoryController@editInventory']);
	Route::post('/inventory/edit', ['as' => 'update_inv', 'uses' => 'InventoryController@updateInventory']);
});

Route::post('/material/new', 'InventoryController@newMaterial');
Route::post('/material/edit', 'InventoryController@editMaterial');
Route::post('/material/autocomplete', 'InventoryController@autocomplete');
Route::get('/material/autocomplete-report', 'InventoryController@autocompleteReport');
Route::post('/material/autoselect', 'InventoryController@autoselect');

Route::post('/edit', 'Homecontroller@editformpost');

Route::get('/cpr/{id}', ['as' => 'car', 'uses' => 'ReportsController@getCpr']);
Route::get('/print/cpr/{id}', ['as' => 'car', 'uses' => 'ReportsController@printCpr']);
Route::post('/print/cpr/all/', ['as' => 'pall', 'uses' => 'ReportsController@printAll']);
Route::get('/car/', ['as' => 'car', 'uses' => 'ReportsController@getCpr']);
Route::get('/print/car/{id}', ['as' => 'car', 'uses' => 'ReportsController@printCar']);
Route::post('/print/car/', ['as' => 'car', 'uses' => 'ReportsController@printCar']);
Route::get('/carpg/{id}/{skip}/{account}/{sdatei}/{sdatef}/{bdate}/{edate}/{salesman}/{office}/',  'ReportsController@printCarPg');


Route::post('/account/report/expiration_list', ['as' => 'exp', 'uses' => 'ReportsController@getExp']);

//Gets

//Gets
Route::post('/taxDistrict', ['as' => 'getTaxDist', 'uses' => 'GetItemsController@taxStateDistrict']);
Route::post('/taxDistrict/edit', ['as' => 'getTaxDist', 'uses' => 'GetItemsController@taxStateDistrictEdit']);

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

//LD Import Functions
if(env('MIGRATE')){
	Route::get('/LDLink', function () {
		return view('utility.LDLink');
	});
	Route::get('/AcctLink', function () {
		return view('utility.AcctLink');
	});
	Route::get('/FieldLink', function () {
		return view('utility.FieldLink');
	});

    Route::get('migrate/run', 'MigrationController@run');

	Route::get('migrate/run', 'MigrationController@run');
	Route::get('migrate/tax-districts', 'MigrationController@taxDistricts');
	Route::get('migrate/accounts', 'MigrationController@accounts');
	Route::get('migrate/techs', 'MigrationController@techs');
	Route::get('migrate/fields', 'MigrationController@fields');
	Route::get('migrate/material', 'MigrationController@materialMigrate');
	Route::get('migrate/inventory', 'MigrationController@inventoryMigrate');
	Route::get('migrate/users', 'MigrationController@users');
}