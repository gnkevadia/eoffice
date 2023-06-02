<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\RightsController;
use App\Http\Controllers\Admin\ModuleController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\PagesController;


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
// Route::get('/admin/login', '\App\Http\Controllers\Auth\LoginController@showFormLogin');
// Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout');
// Route::get('/admin/logout', '\App\Http\Controllers\Auth\LoginController@logout');

//  my 
Route::get('/admin/login',[LoginController::class,'showFormLogin']);
Route::post('/backend-login',[LoginController::class,'login']);
//endmy







Route::match(['get','post'],'/', '\App\Http\Controllers\HomeController@index');
Route::get('/set-city', '\App\Http\Controllers\HomeController@setCity');
Route::match(['get'],'/our-offerings', '\App\Http\Controllers\HomeController@ourPackages');
Route::match(['get','post'],'/package-details/{id}', '\App\Http\Controllers\HomeController@packageDetails');
Route::match(['get','post'],'/booking-process', '\App\Http\Controllers\HomeController@bookingProcess');
Route::match(['get','post'],'/booking-process-complete', '\App\Http\Controllers\HomeController@bookingProcessComplete');
Route::match(['get','post'],'/check-coupon', '\App\Http\Controllers\HomeController@checkCoupon');
Route::match(['get','post'],'/contact-us', '\App\Http\Controllers\HomeController@contact');
Route::match(['get','post'],'/thank-you', '\App\Http\Controllers\HomeController@thankYou');


Route::match(['post','put'], '/delete-booking', 'Admin\BookingController@myBookingCancel');
Route::match(['get','post'], '/my-booking', 'Admin\BookingController@myBooking');
Route::match(['get','post'],'/booking-amend', 'Admin\BookingController@bookingAmend');
Route::match(['get','post'],'/send-booking-email', 'Admin\BookingController@sendBookingEmail');
Route::match(['post'],'/print-booking', 'Admin\BookingController@printBooking');
Route::match(['post'],'/corporate-booking', '\App\Http\Controllers\HomeController@corporateBooking');
Route::match(['post'],'/print-booking-admin', 'Admin\BookingController@printBookingAdmin');
Route::match(['post'],'/print-confirmation-admin', 'Admin\BookingController@printBookingAdminConfirmation');

Route::match(['get','post'],'/upload-photo', 'Admin\BookingController@uploadPhoto');
Route::match(['get','post'],'/upload-photos', 'Admin\BookingController@uploadPhotos');

Route::match(['get','post'],'/enquiry/{id}', '\App\Http\Controllers\HomeController@enquiry');

/** Data Solution route */
Route::match(['get','post'],'/data-inshights', '\App\Http\Controllers\HomeController@dataInsightsList');
Route::match(['get','post'],'/whitepapers', '\App\Http\Controllers\HomeController@whitePapers');
Route::match(['get','post'],'/request', '\App\Http\Controllers\HomeController@commonRequest');
Route::match(['get','post'],'/data-solutions', '\App\Http\Controllers\HomeController@dataSolutionsList');
Route::match(['get','post'],'/news-and-update', '\App\Http\Controllers\HomeController@newsAndUpdateList');
Route::match(['get','post'],'/industries-list', '\App\Http\Controllers\HomeController@industriesList');
Route::match(['get','post'],'/user-edit', '\App\Http\Controllers\HomeController@userEdit');

Route::match(['get','post'],'/sign-up', '\App\Http\Controllers\HomeController@signUp');
Route::match(['get','post'],'/log-in', '\App\Http\Controllers\HomeController@showFormLogin');
Route::match(['get','post'],'/log-backend', '\App\Http\Controllers\HomeController@logIn');
Route::match(['get','post'],'/forgot', '\App\Http\Controllers\HomeController@forgotPass');
Route::match(['get','post'],'/custom-reports', '\App\Http\Controllers\HomeController@customReports');
Route::match(['get','post'],'/custom-trends', '\App\Http\Controllers\HomeController@customTrends');
Route::match(['get','post'],'/cart', '\App\Http\Controllers\HomeController@cart');
Route::match(['get','post'],'/checkout', '\App\Http\Controllers\HomeController@checkout');
Route::match(['get','post'],'/review-and-pay', '\App\Http\Controllers\HomeController@reviewAndPay');
Route::match(['get','post'],'/log-out', '\App\Http\Controllers\HomeController@logOut');
Route::match(['get','post'],'/payment', '\App\Http\Controllers\HomeController@payment');

Route::get('/clear-cache', function() {Artisan::call('cache:clear');return "Cache is cleared";});


// Route::prefix('admin')->group(function () {
//     Route::match(array('GET','POST'),'/myprofile/{id}',[UserController::class, 'myprofile']);
// });




Route::group(['prefix' => 'admin', 'namespace' => '\App\Http\Controllers'], function () {
    
    Route::match(['get'], '/dashboard', 'Admin\DashboardController@index');
    Route::match(['get'], '/inventory', 'Admin\InventoryController@index');
    Route::match(['get','post'], '/inventory/import', 'Admin\InventoryController@import');

    /** User Management Routes (Admin) */
    Route::match(['get','post'], '/user', [UserController::class, 'index']);
    Route::match(array('GET','POST'),'/myprofile/{id}',[UserController::class, 'myprofile']); //my
    Route::match(['get','post'], '/user/add',[UserController::class, 'add']);//my
    Route::match(['get','post'], '/user/edit/{id}',[UserController::class, 'edit']);//my
    Route::match(['post'], '/user/delete', [UserController::class, 'delete']);//my
    Route::match(['post'], '/user/toggle', 'Admin\UserController@toggleStatus');
    Route::match(['get', 'post'], '/user/view/{id}', 'Admin\UserController@view');
    Route::get('/user/state', 'Admin\UserController@getStates');
    Route::get('/user/cities', 'Admin\UserController@getCities');
    Route::match(['get','post'],'/user/get-rights', 'Admin\UserController@getRights');
    Route::match(array('GET','POST'),'/myprofile/changepassword/{id}',[UserController::class, 'changepassword']);//my

    Route::match(['get','post'], '/user/check-user-availability', 'Admin\UserController@checkAvailability');
    Route::match(['get','post'], '/user/delete-file', 'Admin\UserController@deleteFile');
    
    /** Module Management Routes (Admin) */
    
    Route::match(['get','post'], '/module',[ModuleController::class, 'index']);//my
    Route::match(['get','post'], '/module/add',[ModuleController::class, 'add']);
    Route::match(['get','post'], '/module/edit/{id}', [ModuleController::class, 'edit']);
    Route::match(['post'], '/module/delete', [ModuleController::class, 'delete']);
    Route::match(['post'], '/module/toggle', 'Admin\ModuleController@toggleStatus');

    /** Right Management Routes (Admin) */
   
    Route::match(['get', 'post'], '/rights', [RightsController::class, 'index']); //my
    Route::match(['get', 'post'], '/rights/add',[RightsController::class, 'add']);//my
    Route::match(['get', 'post'], '/rights/edit/{id}',[RightsController::class, 'edit']);
    Route::match(['post'], '/rights/delete', [RightsController::class, 'delete']);//my
    Route::match(['post'], '/rights/toggle', 'Admin\RightsController@toggleStatus');

    /** Role Management Routes (Admin) */
    
    Route::match(['get', 'post'], '/role', [RoleController::class, 'index']);//my
    Route::match(['get', 'post'], '/role/add',[RoleController::class, 'add']);//my
    Route::match(['get', 'post'], '/role/edit/{id}',[RoleController::class, 'edit']);//my
    Route::match(['post'], '/role/delete',[RoleController::class, 'delete']);//my
    Route::match(['post'], '/role/toggle', 'Admin\RoleController@toggleStatus');
    Route::match(['get', 'post'], '/role/view/{id}',[RoleController::class, 'view']);//my

    /** Menu Management Routes (Admin) */

    Route::match(['get', 'post'], '/menu',[MenuController::class, 'index']);//my
    Route::match(['get', 'post'], '/menu/add', [MenuController::class, 'add']);//my
    Route::match(['get', 'post'], '/menu/edit/{id}', [MenuController::class, 'edit']);//my
    Route::post('/menu/delete',[MenuController::class,'delete']); //my
    Route::match(['post'], '/menu/toggle', 'Admin\MenuController@toggleStatus');
    Route::post('/menu/optionSelect',[MenuController::class,'optionSelect']); //my

    /** Menu-type Management Routes (Admin) */
    Route::match(['get','post'],'/menu-types', 'Admin\MenuTypesController@index');
    Route::match(['get','post'],'/menu-types/add', 'Admin\MenuTypesController@add');
    Route::match(['get','post'],'/menu-types/edit/{id}', 'Admin\MenuTypesController@edit');
    Route::match(['post'],'/menu-types/delete', 'Admin\MenuTypesController@delete');
    Route::match(['post'],'/menu-types/toggle', 'Admin\MenuTypesController@toggleStatus');
    Route::match(['get','post'],'/menu-types/order/{id}', 'Admin\MenuTypesController@orderMenuTypes');

    /** Category Management Routes (Admin) */
    Route::match(['get','post'], '/category', 'Admin\CategoryController@index');
    Route::match(['get','post'], '/category/add', 'Admin\CategoryController@add');
    Route::match(['get','post'], '/category/edit/{id}', 'Admin\CategoryController@edit');
    Route::match(['post'], '/category/delete', 'Admin\CategoryController@delete');
    Route::match(['post'], '/category/toggle', 'Admin\CategoryController@toggleStatus');

    /** Faq Management Routes (Admin) */
    Route::match(['get','post'], '/faq', 'Admin\FaqController@index');
    Route::match(['get','post'], '/faq/add', 'Admin\FaqController@add');
    Route::match(['get','post'], '/faq/edit/{id}', 'Admin\FaqController@edit');
    Route::match(['post'], '/faq/delete', 'Admin\FaqController@delete');
    Route::match(['post'], '/faq/toggle', 'Admin\FaqController@toggleStatus');

    /** USP Management Routes (Admin) */
    Route::match(['get','post'], '/usp', 'Admin\UspController@index');
    Route::match(['get','post'], '/usp/add', 'Admin\UspController@add');
    Route::match(['get','post'], '/usp/edit/{id}', 'Admin\UspController@edit');
    Route::match(['post'], '/usp/delete', 'Admin\UspController@delete');
    Route::match(['post'], '/usp/toggle', 'Admin\UspController@toggleStatus');

    /** Banner Management Routes (Admin) ak */
    Route::match(['get','post'], '/banner', 'Admin\BannerController@index');
    Route::match(['get','post'], '/banner/add', 'Admin\BannerController@add');
    Route::match(['get','post'], '/banner/edit/{id}', 'Admin\BannerController@edit');
    Route::match(['post'], '/banner/delete', 'Admin\BannerController@delete');
    Route::match(['post'], '/banner/toggle', 'Admin\BannerController@toggleStatus');

    /** Package Management Routes (Admin) */
    Route::match(['get','post'], '/package', 'Admin\PackageController@index');
    Route::match(['get','post'], '/package/add', 'Admin\PackageController@add');
    Route::match(['get','post'], '/package/edit/{id}', 'Admin\PackageController@edit');
    Route::match(['get','post'], '/package/view/{id}', 'Admin\PackageController@view');
    Route::match(['post'], '/package/delete', 'Admin\PackageController@delete');
    Route::match(['post'], '/package/toggle', 'Admin\PackageController@toggleStatus');
    Route::match(['post'],'/package/update-slug', 'Admin\PackageController@updateSlug');

    /** Country Management Routes (Admin) */
    Route::match(['get','post'], '/country', 'Admin\CountryController@index');
    Route::match(['get','post'], '/country/add', 'Admin\CountryController@add');
    Route::match(['get','post'], '/country/edit/{id}', 'Admin\CountryController@edit');
    Route::match(['post'], '/country/delete', 'Admin\CountryController@delete');
    Route::match(['post'], '/country/toggle', 'Admin\CountryController@toggleStatus');
    Route::match(['get','post'], '/country/view/{id}', 'Admin\CountryController@view');

    /**  State Management Routes (Admin) */
    Route::match(['get','post'], '/state', 'Admin\StatesController@index');
    Route::match(['get','post'], '/state/add', 'Admin\StatesController@add');
    Route::match(['get','post'], '/state/edit/{id}', 'Admin\StatesController@edit');
    Route::match(['post'], '/state/delete', 'Admin\StatesController@delete');
    Route::match(['post'], '/state/toggle', 'Admin\StatesController@toggleStatus');
    Route::match(['post'], '/state/getStates', 'Admin\StatesController@getStates');

    /**  City Management Routes (Admin) */
    Route::match(['get','post'], '/city', 'Admin\CityController@index');
    Route::match(['get','post'], '/city/add', 'Admin\CityController@add');
    Route::match(['get','post'], '/city/edit/{id}', 'Admin\CityController@edit');
    Route::match(['post'], '/city/delete', 'Admin\CityController@delete');
    Route::match(['post'], '/city/toggle', 'Admin\CityController@toggleStatus');
    Route::match(['get','post'], '/city/view/{id}', 'Admin\CityController@view');
    Route::match(['post'], '/city/copy', 'Admin\CityController@copy');
    Route::match(['get','post'], '/city/export', 'Admin\CityController@export');
    Route::match(['get'], '/city/get-city', 'Admin\CityController@getCities');
    Route::match(['get'], '/city/get-cluster', 'Admin\CityController@getClusters');
    Route::match(['get','post'], '/city/change-city', 'Admin\CityController@changeCity');

    /**  Booking Management Routes (Admin) */
    Route::match(['get','post'], '/booking', 'Admin\BookingController@index');
    Route::match(['get','post'], '/booking/view/{id}', 'Admin\BookingController@view');
    Route::match(['get','post'], '/booking/export', 'Admin\BookingController@export');
    Route::match(['get','post'], '/booking/toggle', 'Admin\BookingController@toggleStatus');

    /**  ContactUs Management Routes (Admin) */
    Route::match(['get','post'], '/contact-us', 'Admin\ContactUsController@index');
    Route::match(['get','post'], '/contact-us/view/{id}', 'Admin\ContactUsController@view');
    Route::match(['get','post'], '/contact-us/export', 'Admin\ContactUsController@export');

    /** Settingtype Management Routes (Admin) */
    Route::match(['get','post'], '/settingtype', 'Admin\SettingtypeController@index');
    Route::match(['get','post'], '/settingtype/add', 'Admin\SettingtypeController@add');
    Route::match(['get','post'], '/settingtype/edit/{id}', 'Admin\SettingtypeController@edit');
    Route::match(['post'], '/settingtype/delete', 'Admin\SettingtypeController@delete');
    Route::match(['post'], '/settingtype/toggle', 'Admin\SettingtypeController@toggleStatus');

    /** Setting Management Routes (Admin) */
    Route::match(['get','post'], '/setting', 'Admin\SettingController@index');   
    Route::match(['get','post'], '/setting/add', 'Admin\SettingController@add');
    Route::match(['get','post'], '/setting/edit/{id}', 'Admin\SettingController@edit');
    Route::match(['post'], '/setting/delete', 'Admin\SettingController@delete');
    Route::match(['post'], '/setting/toggle', 'Admin\SettingController@toggleStatus');

    /** EmailTemplateTypes Routes (Admin)*/
    Route::match(['get','post'], '/email-template-types', 'Admin\EmailTemplateTypesController@index');
    Route::match(['get','post'], '/email-template-types/add', 'Admin\EmailTemplateTypesController@add');
    Route::match(['get','post'], '/email-template-types/edit/{id}', 'Admin\EmailTemplateTypesController@edit');
    Route::match(['post'], '/email-template-types/delete', 'Admin\EmailTemplateTypesController@delete');
    Route::match(['post'], '/email-template-types/toggle', 'Admin\EmailTemplateTypesController@toggleStatus');

    /** EmailTemplates Routes (Admin)*/
    Route::match(['get','post'], '/email-templates', 'Admin\EmailTemplatesController@index');
    Route::match(['get','post'], '/email-templates/add', 'Admin\EmailTemplatesController@add');
    Route::match(['get','post'], '/email-templates/edit/{id}', 'Admin\EmailTemplatesController@edit');
    Route::match(['post'], '/email-templates/delete', 'Admin\EmailTemplatesController@delete');
    Route::match(['post'], '/email-templates/toggle', 'Admin\EmailTemplatesController@toggleStatus');

    /** Type Management Routes (Admin) */
    Route::match(['get','post'], '/types', 'Admin\TypesController@index');
    Route::match(['get','post'], '/types/add', 'Admin\TypesController@addTypes');
    Route::match(['get','post'], '/types/edit/{id}', 'Admin\TypesController@edit');
    Route::match(['post'], '/types/delete', 'Admin\TypesController@delete');
    Route::match(['post'], '/types/toggle', 'Admin\TypesController@toggleStatus');

    /** Page Type Management Routes (Admin) */
     Route::match(['get','post'], '/pagetype', 'Admin\PageTypesController@index');
     Route::match(['get','post'], '/pagetype/add', 'Admin\PageTypesController@add');
     Route::match(['get','post'], '/pagetype/edit/{id}', 'Admin\PageTypesController@edit');
     Route::match(['post'], '/pagetype/delete', 'Admin\PageTypesController@delete');
     Route::match(['post'], '/pagetype/toggle', 'Admin\PageTypesController@toggleStatus');

    /** Pages Routes (Admin) */
    Route::match(['get','post'], '/pages', [PagesController::class, 'index']);//my
    Route::match(['get','post'], '/pages/add', [PagesController::class, 'add']);//my
    Route::match(['get','post'], '/pages/edit/{id}',[PagesController::class, 'edit']);//my
    Route::match(['post'], '/pages/delete', [PagesController::class, 'delete']);//my
    Route::match(['post'], '/pages/toggle', 'Admin\PagesController@toggleStatus');
    Route::match(['post'],'/pages/update-slug', 'Admin\PagesController@updateSlug');

    /** Coupon Management Routes (Admin) */
    Route::match(['get','post'], '/coupon', 'Admin\CouponController@index');
    Route::match(['get','post'], '/coupon/add', 'Admin\CouponController@add');
    Route::match(['get','post'], '/coupon/edit/{id}', 'Admin\CouponController@edit');
    Route::match(['post'], '/coupon/delete', 'Admin\CouponController@delete');
    Route::match(['post'], '/coupon/toggle', 'Admin\CouponController@toggleStatus');

    /** Terminal Management Routes (Admin) */
    Route::match(['get','post'], '/terminal', 'Admin\TerminalController@index');
    Route::match(['get','post'], '/terminal/add', 'Admin\TerminalController@add');
    Route::match(['get','post'], '/terminal/edit/{id}', 'Admin\TerminalController@edit');
    Route::match(['get','post'], '/terminal/view/{id}', 'Admin\TerminalController@view');
    Route::match(['post'], '/terminal/delete/', 'Admin\TerminalController@delete');
    Route::match(['get','post'], '/terminal/import', 'Admin\TerminalController@import');
    Route::match(['get','post'], '/terminal/toggle', 'Admin\TerminalController@toggleStatus');
    

    /** Currency Management Routes (Admin) */
    Route::match(['get','post'], '/currency', 'Admin\CurrencyController@index');
    Route::match(['get','post'], '/currency/add', 'Admin\CurrencyController@add');
    Route::match(['get','post'], '/currency/edit/{id}', 'Admin\CurrencyController@edit');
    Route::match(['post'], '/currency/delete', 'Admin\CurrencyController@delete');
    // Route::match(['post'], '/currency/toggle', 'Admin\CurrencyController@toggleStatus');
    Route::match(['get','post'], '/currency/view/{id}', 'Admin\CurrencyController@view');

     /** Country Language Management Routes (Admin) */
    Route::match(['get','post'], '/country-language', 'Admin\CountryLanguageController@index');
    Route::match(['get','post'], '/country-language/add', 'Admin\CountryLanguageController@add');
    Route::match(['get','post'], '/country-language/edit/{id}', 'Admin\CountryLanguageController@edit');
    Route::match(['get','post'], '/country-language/view/{id}', 'Admin\CountryLanguageController@view');
    Route::match(['post'], '/country-language/delete', 'Admin\CountryLanguageController@delete');

     /** Region Management Routes (Admin) */
     Route::match(['get','post'], '/region', 'Admin\RegionController@index');
     Route::match(['get','post'], '/region/add', 'Admin\RegionController@add');
     Route::match(['get','post'], '/region/edit/{id}', 'Admin\RegionController@edit');
     Route::match(['post'], '/region/delete', 'Admin\RegionController@delete');
     // Route::match(['post'], '/region/toggle', 'Admin\CurrencyController@toggleStatus');
     Route::match(['get','post'], '/region/view/{id}', 'Admin\RegionController@view');

     /** FeedBack Management Routes (Admin) */
    Route::match(['get','post'], '/feedback', 'Admin\FeedBackController@index');
    Route::match(['get','post'], '/feedback/add', 'Admin\FeedBackController@add');
    Route::match(['get','post'], '/feedback/edit/{id}', 'Admin\FeedBackController@edit');
    Route::match(['post'], '/feedback/delete/', 'Admin\FeedBackController@delete');
    Route::match(['get','post'], '/feedback/toggle', 'Admin\FeedBackController@toggleStatus');

    /** Industries Management Routes (Admin) */
    Route::match(['get','post'], '/industries', 'Admin\IndustriesController@index');
    Route::match(['get','post'], '/industries/add', 'Admin\IndustriesController@add');
    Route::match(['get','post'], '/industries/edit/{id}', 'Admin\IndustriesController@edit');
    Route::match(['post'], '/industries/delete/', 'Admin\IndustriesController@delete');
    Route::match(['get','post'], '/industries/toggle', 'Admin\IndustriesController@toggleStatus');
    Route::match(['post'],'/industries/update-slug', 'Admin\PackageController@updateSlug');

    /** News Management Routes (Admin) */
    Route::match(['get','post'], '/news', 'Admin\NewsController@index');
    Route::match(['get','post'], '/news/add', 'Admin\NewsController@add');
    Route::match(['get','post'], '/news/edit/{id}', 'Admin\NewsController@edit');
    Route::match(['post'], '/news/delete/', 'Admin\NewsController@delete'); 
    Route::match(['get','post'], '/news/toggle', 'Admin\NewsController@toggleStatus');
    Route::match(['post'],'/news/update-slug', 'Admin\PackageController@updateSlug');

    /** BrandStatesStatistics Management Routes (Admin) */
    Route::match(['get','post'], '/brand-states-statistics', 'Admin\BrandStatesStatisticsController@index');
    Route::match(['get','post'], '/brand-states-statistics/add', 'Admin\BrandStatesStatisticsController@add');
    Route::match(['get','post'], '/brand-states-statistics/edit/{id}', 'Admin\BrandStatesStatisticsController@edit');
    Route::match(['post'], '/brand-states-statistics/delete', 'Admin\BrandStatesStatisticsController@delete');
    Route::match(['get','post'], '/brand-states-statistics/import', 'Admin\BrandStatesStatisticsController@import');
    Route::match(['post'], '/brand-states-statistics/toggle', 'Admin\BrandStatesStatisticsController@toggleStatus');

    /**  Brand Management Routes (Admin) */
    Route::match(['get','post'], '/brand', 'Admin\BrandController@index');
    Route::match(['get','post'], '/brand/add', 'Admin\BrandController@add');
    Route::match(['get','post'], '/brand/edit/{id}', 'Admin\BrandController@edit');
    Route::match(['post'], '/brand/delete', 'Admin\BrandController@delete');
    Route::match(['post'], '/brand/toggle', 'Admin\BrandController@toggleStatus');
    Route::match(['post'], '/brand/getStates', 'Admin\BrandController@getStates');
    
});
Route::match(['get','post'],'/{slug}', '\App\Http\Controllers\HomeController@cms');
Auth::routes();