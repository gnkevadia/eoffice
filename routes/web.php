<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\RightsController;
use App\Http\Controllers\Admin\ModuleController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\PagesController;
use App\Http\Controllers\Admin\FeaturesController;
use App\Http\Controllers\Admin\TaskController;
use App\Http\Controllers\Admin\ProjectMasterController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\BusinessUnitController;
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Auth;


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

// Route::post('/backend-login', '\App\Http\Controllers\Auth\LoginController@login');
// Route::match(['get','post'],'/admin/forgot-login', '\App\Http\Controllers\Auth\LoginController@forgotLogin');
// Route::match(['get','post'],'/admin/forgot-password/{id}', '\App\Http\Controllers\Auth\LoginController@forgotPassword');

Route::get('/admin/logout', [LoginController::class, 'logout']);

//  my 
Route::get('/admin/login', [LoginController::class, 'showFormLogin']);
Route::post('/backend-login', [LoginController::class, 'login']);


Route::match(['get', 'post'], '/', '\App\Http\Controllers\HomeController@index');
Route::get('/set-city', '\App\Http\Controllers\HomeController@setCity');
Route::match(['get', 'post'], '/contact-us', '\App\Http\Controllers\HomeController@contact');

Route::match(['post'], '/corporate-booking', '\App\Http\Controllers\HomeController@corporateBooking');

Route::get('/clear-cache', function () {
    Artisan::call('cache:clear');
    return "Cache is cleared";
});

Route::group(['prefix' => 'admin', 'namespace' => '\App\Http\Controllers'], function () {

    Route::match(['get'], '/dashboard', [DashboardController::class, 'index']);
    Route::match(['get'], '/dashboard/punchin',  [DashboardController::class, 'punchin']);
    Route::match(['get'], '/dashboard/punchout',  [DashboardController::class, 'punchout']);
    Route::match(['get'], '/inventory', 'Admin\InventoryController@index');
    Route::match(['get', 'post'], '/inventory/import', 'Admin\InventoryController@import');

    /** User Management Routes (Admin) */
    Route::match(['get', 'post'], '/user', [UserController::class, 'index']);
    Route::match(array('GET', 'POST'), '/myprofile/{id}', [UserController::class, 'myprofile']); //my
    Route::match(['get', 'post'], '/user/add', [UserController::class, 'add']); //my
    Route::match(['get', 'post'], '/user/edit/{id}', [UserController::class, 'edit']); //my
    Route::match(['post'], '/user/delete', [UserController::class, 'delete']); //my
    Route::match(['post'], '/user/toggle', 'Admin\UserController@toggleStatus');
    Route::match(['get', 'post'], '/user/view/{id}', 'Admin\UserController@view');
    Route::get('/user/state', 'Admin\UserController@getStates');
    Route::get('/user/cities', 'Admin\UserController@getCities');
    Route::match(['get', 'post'], '/user/get-rights', 'Admin\UserController@getRights');
    Route::match(array('GET', 'POST'), '/myprofile/changepassword/{id}', [UserController::class, 'changepassword']); //my

    Route::match(['get', 'post'], '/user/check-user-availability', 'Admin\UserController@checkAvailability');
    Route::match(['get', 'post'], '/user/delete-file', 'Admin\UserController@deleteFile');

    /** Module Management Routes (Admin) */
    Route::match(['get', 'post'], '/module', [ModuleController::class, 'index']); //my
    Route::match(['get', 'post'], '/module/add', [ModuleController::class, 'add']);
    Route::match(['get', 'post'], '/module/edit/{id}', [ModuleController::class, 'edit']);
    Route::match(['post'], '/module/delete', [ModuleController::class, 'delete']);
    Route::match(['post'], '/module/toggle', 'Admin\ModuleController@toggleStatus');

    /** Right Management Routes (Admin) */
    Route::match(['get', 'post'], '/rights', [RightsController::class, 'index']); //my
    Route::match(['get', 'post'], '/rights/add', [RightsController::class, 'add']); //my
    Route::match(['get', 'post'], '/rights/edit/{id}', [RightsController::class, 'edit']);
    Route::match(['post'], '/rights/delete', [RightsController::class, 'delete']); //my
    Route::match(['post'], '/rights/toggle', 'Admin\RightsController@toggleStatus');

    /** Role Management Routes (Admin) */
    Route::match(['get', 'post'], '/role', [RoleController::class, 'index']); //my
    Route::match(['get', 'post'], '/role/add', [RoleController::class, 'add']); //my
    Route::match(['get', 'post'], '/role/edit/{id}', [RoleController::class, 'edit']); //my
    Route::match(['post'], '/role/delete', [RoleController::class, 'delete']); //my
    Route::match(['post'], '/role/toggle', 'Admin\RoleController@toggleStatus');
    Route::match(['get', 'post'], '/role/view/{id}', [RoleController::class, 'view']); //my

    /** Menu Management Routes (Admin) */
    Route::match(['get', 'post'], '/menu', [MenuController::class, 'index']); //my
    Route::match(['get', 'post'], '/menu/add', [MenuController::class, 'add']); //my
    Route::match(['get', 'post'], '/menu/edit/{id}', [MenuController::class, 'edit']); //my
    Route::post('/menu/delete', [MenuController::class, 'delete']); //my
    Route::match(['post'], '/menu/toggle', 'Admin\MenuController@toggleStatus');
    Route::post('/menu/optionSelect', [MenuController::class, 'optionSelect']); //my

    /** Features Routes (Admin) */
    Route::match(['get', 'post'], '/features', [FeaturesController::class, 'index']); //my
    Route::match(['get', 'post'], '/features/add', [FeaturesController::class, 'add']); //my
    Route::match(['get', 'post'], '/features/edit/{id}', [FeaturesController::class, 'edit']); //my
    Route::match(['get', 'post'], '/features/delete', [FeaturesController::class, 'delete']); //my
    Route::match(['get', 'post'], '/features/toggle', [FeaturesController::class, 'toggleStatus']);

    /** Task Routes (Admin) */
    Route::match(['get', 'post'], '/task', [TaskController::class, 'index']); //my
    Route::match(['get', 'post'], '/task/add', [TaskController::class, 'add']); //my
    Route::match(['get', 'post'], '/task/edit/{id}', [TaskController::class, 'edit']); //my
    Route::match(['get', 'post'], '/task/delete', [TaskController::class, 'delete']); //my
    Route::match(['get', 'post'], '/task/toggle', [TaskController::class, 'toggleStatus']);

    /** Department Routes (Admin) */
    Route::match(['get', 'post'], '/department', [DepartmentController::class, 'index']); //my
    Route::match(['get', 'post'], '/department/add', [DepartmentController::class, 'add']); //my
    Route::match(['get', 'post'], '/department/edit/{id}', [DepartmentController::class, 'edit']); //my
    Route::match(['get', 'post'], '/department/delete', [DepartmentController::class, 'delete']); //my
    Route::match(['get', 'post'], '/department/toggle', [DepartmentController::class, 'toggleStatus']);

    /** Menu-type Management Routes (Admin) */
    Route::match(['get', 'post'], '/menu-types', 'Admin\MenuTypesController@index');
    Route::match(['get', 'post'], '/menu-types/add', 'Admin\MenuTypesController@add');
    Route::match(['get', 'post'], '/menu-types/edit/{id}', 'Admin\MenuTypesController@edit');
    Route::match(['post'], '/menu-types/delete', 'Admin\MenuTypesController@delete');
    Route::match(['post'], '/menu-types/toggle', 'Admin\MenuTypesController@toggleStatus');
    Route::match(['get', 'post'], '/menu-types/order/{id}', 'Admin\MenuTypesController@orderMenuTypes');

    /** Category Management Routes (Admin) */
    Route::match(['get', 'post'], '/category', 'Admin\CategoryController@index');
    Route::match(['get', 'post'], '/category/add', 'Admin\CategoryController@add');
    Route::match(['get', 'post'], '/category/edit/{id}', 'Admin\CategoryController@edit');
    Route::match(['post'], '/category/delete', 'Admin\CategoryController@delete');
    Route::match(['post'], '/category/toggle', 'Admin\CategoryController@toggleStatus');

    /** Package Management Routes (Admin) */
    Route::match(['get', 'post'], '/package', 'Admin\PackageController@index');
    Route::match(['get', 'post'], '/package/add', 'Admin\PackageController@add');
    Route::match(['get', 'post'], '/package/edit/{id}', 'Admin\PackageController@edit');
    Route::match(['get', 'post'], '/package/view/{id}', 'Admin\PackageController@view');
    Route::match(['post'], '/package/delete', 'Admin\PackageController@delete');
    Route::match(['post'], '/package/toggle', 'Admin\PackageController@toggleStatus');
    Route::match(['post'], '/package/update-slug', 'Admin\PackageController@updateSlug');

    /** Country Management Routes (Admin) */
    Route::match(['get', 'post'], '/country', 'Admin\CountryController@index');
    Route::match(['get', 'post'], '/country/add', 'Admin\CountryController@add');
    Route::match(['get', 'post'], '/country/edit/{id}', 'Admin\CountryController@edit');
    Route::match(['post'], '/country/delete', 'Admin\CountryController@delete');
    Route::match(['post'], '/country/toggle', 'Admin\CountryController@toggleStatus');
    Route::match(['get', 'post'], '/country/view/{id}', 'Admin\CountryController@view');

    /**  State Management Routes (Admin) */
    Route::match(['get', 'post'], '/state', 'Admin\StatesController@index');
    Route::match(['get', 'post'], '/state/add', 'Admin\StatesController@add');
    Route::match(['get', 'post'], '/state/edit/{id}', 'Admin\StatesController@edit');
    Route::match(['post'], '/state/delete', 'Admin\StatesController@delete');
    Route::match(['post'], '/state/toggle', 'Admin\StatesController@toggleStatus');
    Route::match(['post'], '/state/getStates', 'Admin\StatesController@getStates');

    /**  Project Management Routes (Admin) */
    Route::match(['get', 'post'], '/project', [ProjectMasterController::class, 'index']);
    Route::match(['get', 'post'], '/project/add', [ProjectMasterController::class, 'add']);
    Route::match(['get', 'post'], '/project/edit/{id}', [ProjectMasterController::class, 'edit']);
    Route::match(['get', 'post'], '/project/delete', [ProjectMasterController::class, 'delete']);
    Route::match(['get', 'post'], '/project/toggle', [ProjectMasterController::class, 'toggleStatus']);

    /**  Business Unit Management Routes (Admin) */
    Route::match(['get', 'post'], '/business-unit', [BusinessUnitController::class, 'index']);
    Route::match(['get', 'post'], '/business-unit/add', [BusinessUnitController::class, 'add']);
    Route::match(['get', 'post'], '/business-unit/edit/{id}', [BusinessUnitController::class, 'edit']);
    Route::match(['get', 'post'], '/business-unit/delete', [BusinessUnitController::class, 'delete']);
    Route::match(['get', 'post'], 'business-unit/toggle', [BusinessUnitController::class, 'toggleStatus']);

    /**  Company Management Routes (Admin) */
    Route::match(['get', 'post'], '/company', [CompanyController::class, 'index']);
    Route::match(['get', 'post'], '/company/add', [CompanyController::class, 'add']);
    Route::match(['get', 'post'], '/company/edit/{id}', [CompanyController::class, 'edit']);
    Route::match(['get', 'post'], '/company/delete', [CompanyController::class, 'delete']);
    Route::match(['get', 'post'], '/company/toggle', [CompanyController::class, 'toggleStatus']);



    /**  City Management Routes (Admin) */
    Route::match(['get', 'post'], '/city', 'Admin\CityController@index');
    Route::match(['get', 'post'], '/city/add', 'Admin\CityController@add');
    Route::match(['get', 'post'], '/city/edit/{id}', 'Admin\CityController@edit');
    Route::match(['post'], '/city/delete', 'Admin\CityController@delete');
    Route::match(['post'], '/city/toggle', 'Admin\CityController@toggleStatus');
    Route::match(['get', 'post'], '/city/view/{id}', 'Admin\CityController@view');
    Route::match(['post'], '/city/copy', 'Admin\CityController@copy');
    Route::match(['get', 'post'], '/city/export', 'Admin\CityController@export');
    Route::match(['get'], '/city/get-city', 'Admin\CityController@getCities');
    Route::match(['get'], '/city/get-cluster', 'Admin\CityController@getClusters');
    Route::match(['get', 'post'], '/city/change-city', 'Admin\CityController@changeCity');


    /**  ContactUs Management Routes (Admin) */
    Route::match(['get', 'post'], '/contact-us', 'Admin\ContactUsController@index');
    Route::match(['get', 'post'], '/contact-us/view/{id}', 'Admin\ContactUsController@view');
    Route::match(['get', 'post'], '/contact-us/export', 'Admin\ContactUsController@export');


    /** Type Management Routes (Admin) */
    Route::match(['get', 'post'], '/types', 'Admin\TypesController@index');
    Route::match(['get', 'post'], '/types/add', 'Admin\TypesController@addTypes');
    Route::match(['get', 'post'], '/types/edit/{id}', 'Admin\TypesController@edit');
    Route::match(['post'], '/types/delete', 'Admin\TypesController@delete');
    Route::match(['post'], '/types/toggle', 'Admin\TypesController@toggleStatus');

    /** Page Type Management Routes (Admin) */
    Route::match(['get', 'post'], '/pagetype', 'Admin\PageTypesController@index');
    Route::match(['get', 'post'], '/pagetype/add', 'Admin\PageTypesController@add');
    Route::match(['get', 'post'], '/pagetype/edit/{id}', 'Admin\PageTypesController@edit');
    Route::match(['post'], '/pagetype/delete', 'Admin\PageTypesController@delete');
    Route::match(['post'], '/pagetype/toggle', 'Admin\PageTypesController@toggleStatus');

    /** Pages Routes (Admin) */
    Route::match(['get', 'post'], '/pages', [PagesController::class, 'index']); //my
    Route::match(['get', 'post'], '/pages/add', [PagesController::class, 'add']); //my
    Route::match(['get', 'post'], '/pages/edit/{id}', [PagesController::class, 'edit']); //my
    Route::match(['post'], '/pages/delete', [PagesController::class, 'delete']); //my
    Route::match(['post'], '/pages/toggle', 'Admin\PagesController@toggleStatus');
    Route::match(['post'], '/pages/update-slug', 'Admin\PagesController@updateSlug');

    /** Country Language Management Routes (Admin) */
    Route::match(['get', 'post'], '/country-language', 'Admin\CountryLanguageController@index');
    Route::match(['get', 'post'], '/country-language/add', 'Admin\CountryLanguageController@add');
    Route::match(['get', 'post'], '/country-language/edit/{id}', 'Admin\CountryLanguageController@edit');
    Route::match(['get', 'post'], '/country-language/view/{id}', 'Admin\CountryLanguageController@view');
    Route::match(['post'], '/country-language/delete', 'Admin\CountryLanguageController@delete');

    /** Region Management Routes (Admin) */
    Route::match(['get', 'post'], '/region', 'Admin\RegionController@index');
    Route::match(['get', 'post'], '/region/add', 'Admin\RegionController@add');
    Route::match(['get', 'post'], '/region/edit/{id}', 'Admin\RegionController@edit');
    Route::match(['post'], '/region/delete', 'Admin\RegionController@delete');
    // Route::match(['post'], '/region/toggle', 'Admin\CurrencyController@toggleStatus');
    Route::match(['get', 'post'], '/region/view/{id}', 'Admin\RegionController@view');

    /** FeedBack Management Routes (Admin) */
    Route::match(['get', 'post'], '/feedback', 'Admin\FeedBackController@index');
    Route::match(['get', 'post'], '/feedback/add', 'Admin\FeedBackController@add');
    Route::match(['get', 'post'], '/feedback/edit/{id}', 'Admin\FeedBackController@edit');
    Route::match(['post'], '/feedback/delete/', 'Admin\FeedBackController@delete');
    Route::match(['get', 'post'], '/feedback/toggle', 'Admin\FeedBackController@toggleStatus');

    /** News Management Routes (Admin) */
    Route::match(['get', 'post'], '/news', 'Admin\NewsController@index');
    Route::match(['get', 'post'], '/news/add', 'Admin\NewsController@add');
    Route::match(['get', 'post'], '/news/edit/{id}', 'Admin\NewsController@edit');
    Route::match(['post'], '/news/delete/', 'Admin\NewsController@delete');
    Route::match(['get', 'post'], '/news/toggle', 'Admin\NewsController@toggleStatus');
    Route::match(['post'], '/news/update-slug', 'Admin\PackageController@updateSlug');
});

Route::any('{url}', function(){
    return redirect('/admin/dashboard');
})->where('url', '.*');
Route::match(['get', 'post'], '/{slug}', '\App\Http\Controllers\HomeController@cms');
Auth::routes();
