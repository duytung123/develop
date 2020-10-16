<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShopsController;
use App\Http\Controllers\ClassesController;
use App\Http\Controllers\ItemsController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ShopPaymentsController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\TaxesController;
use App\Http\Controllers\CustomersController;
use App\Http\Controllers\CoursesController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\StaffReceptsController;
use App\Http\Controllers\ReservReceptTimeController;
use App\Http\Controllers\ShoptermsController;
use App\Http\Controllers\ReservReceptController;
use App\Http\Controllers\ShopHolidaiesController;
use App\Http\Controllers\ShopPublicHolidaiesController;
use App\Http\Controllers\Customer\CustomerController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request)
{
    return $request->user();
});

//Classes-------------------------------------------------------


//17/09/2020



    //LoginCustomer

    Route::group(['prefix'=>'LoginCustomer'], function () {

        Route::post('register', [CustomerController::class , 'Register']);

        Route::post('login', [CustomerController::class , 'Login']);
      
    });

    //Authcustomer
   Route::group(['middleware' => ['jwt.Authcustomer']], function () {
    Route::fallback(function ()
    {
        return response()
            ->json(['message' => 'Page Not Found'], 404);
    });
    ////// code here



    Route::get('Closed',[DataCustomerController::class , 'Closed']);
});


Route::group(['middleware' => 'jwt.auth'], function () {

    Route::get('getcustomer', [CustomerController::class , 'User']);

    Route::get('signout',[CustomerController::class , 'Logout']);

    Route::post('deletecustomer/{id}',[CustomerController::class , 'Delete']);

    Route::post('updatecustomer/{id}',[CustomerController::class , 'Update']);

    Route::post('passowrd',[CustomerController::class , 'Password']);
});


// Accout ----------------------------------------------------------
Route::post('register', 'AccountController@Register')
    ->middleware('language');

Route::post('update/{id}', 'AccountController@Update')
    ->middleware('language');

Route::post('login', 'AccountController@Login');
Route::get('open', 'DataController@open');

Route::group(['middleware' => 'auth.jwt'], function ()
{
    
    Route::get('getUser', 'AccountController@User');

    Route::get('logout', 'AccountController@Logout');

    Route::delete('delete/{id}', 'AccountController@Delete');

    Route::post('forget', 'AccountController@ForgetPassword');

});
Route::group(['middleware' => ['jwt.verify']], function ()
{
    Route::fallback(function ()
    {
        return response()
            ->json(['message' => 'Page Not Found'], 404);
    });
    // Shop-------------------------------------------------------
    Route::post('/shops', [ShopsController::class , 'createShop'])
        ->middleware('language');
    Route::get('/shops/{ShopId}', [ShopsController::class , 'getShop'])
        ->middleware('language');
    Route::put('/shops/{ShopId}', [ShopsController::class , 'updateShop'])
        ->middleware('language');
    Route::delete('/shops/{ShopId}', [ShopsController::class , 'deleteShop'])
        ->middleware('language');

    // Companies-------------------------------------------------------
    Route::get('/companies/{companyId}', 'CompaniesController@getCampany');
    Route::post('/companies', 'CompaniesController@createCompany')
        ->middleware('language');
    Route::put('/companies/{companyId}', 'CompaniesController@updateCompany')
        ->middleware('language');
    Route::delete('/companies/{companyId}', 'CompaniesController@deleteCompany');

    // Classes-------------------------------------------------------
    Route::put('/shops/{shopId}/classes', 'ClassesController@listSort');
    Route::get('/shops/{shopId}/classes', 'ClassesController@getClassesList');
    Route::post('/shops/{ShopId}/classes', 'ClassesController@createClasses')
        ->middleware('language');
    Route::get('/shops/{ShopId}/classes/{ClassesId}', 'ClassesController@getClasses');
    Route::put('/shops/{ShopId}/classes/{ClassesId}', 'ClassesController@updateClasses')
        ->middleware('language');
    Route::delete('/shops/{ShopId}/classes/{ClassesId}', 'ClassesController@deleteClasses');

    //Skill-------------------------------------------------------------
    Route::group(['prefix'=>'shops'], function () {
        Route::get('/{ShopId}/skills', 'SkillController@getSkillList')->middleware('language');
        Route::put('/{shopId}/skills', 'SkillController@updateSkillListSort');
        Route::get('/{ShopId}/skills/{skillId}', 'SkillController@getSkill')->middleware('language');
        Route::post('/{ShopId}/skills', 'SkillController@createSkill')->middleware('language');
        Route::put('/{ShopId}/skills/{skillId}', 'SkillController@updateSkill')->middleware('language');
        Route::delete('/{ShopId}/skills/{skillId}', 'SkillController@deleteSkill')->middleware('language');
    });
    //Discount-------------------------------------------------------------
    Route::group(['prefix' => 'shops'], function ()
    {

        Route::get('/{ShopId}/discounts', 'DiscountsController@getDiscountList');

        Route::put('/{shopId}/discounts', 'DiscountsController@updateDiscountListSort');

        Route::put('/{ShopId}/discounts/{DiscountId}', 'DiscountsController@updateDiscount')
            ->middleware('language');

        Route::get('/{ShopId}/discounts/{DiscountId}', 'DiscountsController@getDiscount')
            ->middleware('language');

        Route::post('/{ShopId}/discounts', 'DiscountsController@createDiscount')
            ->middleware('language');

        Route::delete('/{ShopId}/discounts/{DiscountId}', 'DiscountsController@deleteDiscount')
            ->middleware('language');
    });

    //Taxes-------------------------------------------------------------
    Route::group(['prefix' => 'shops'], function ()
    {
        Route::get('/{ShopId}/taxes', 'TaxesController@getTaxList');
        Route::post('/{ShopId}/taxes', 'TaxesController@createTax')->middleware('language');
        Route::get('/{shopId}/taxes/{taxId}', 'TaxesController@getTax');
        Route::put('/{shopId}/taxes/{taxId}', 'TaxesController@updateTax')->middleware('language');
        Route::delete('/{shopId}/taxes/{taxId}', 'TaxesController@deleteTax');
    });

    //MCourse----------------------------------------------------------------------------------------------------
    Route::group(['prefix' => 'shops'], function ()
    {
        Route::get('/{shopId}/courses', [CoursesController::class , 'getCoursesList'])
            ->middleware('language');

        Route::post('/{shopId}/courses', [CoursesController::class , 'createCourse'])
            ->middleware('language');

        Route::get('/{shopId}/courses/{courseId}', [CoursesController::class , 'getCourse'])
            ->middleware('language');

        Route::put('/{shopId}/courses/{courseId}', [CoursesController::class , 'updateCourse'])
            ->middleware('language');

        Route::delete('/{shopId}/courses/{courseId}', [CoursesController::class , 'deleteCourse'])
            ->middleware('language');

        Route::put('/{shopId}/courses', [CoursesController::class , 'updateCourseListSort']);
    });
     //MShopsPayment-------------------------------------------------------------
     Route::group(['prefix'=>'shops'], function () {
        Route::get('/{ShopId}/payments', 'ShopPaymentsController@getShopPayments');

        Route::get('/{ShopId}/payments/{PaymentId}', 'ShopPaymentsController@getShopPayment');

        Route::post('/{ShopId}/payments', 'ShopPaymentsController@createShopPayment')->middleware('language');

        Route::put('/{ShopId}/payments/{PaymentId}', 'ShopPaymentsController@updateShopPayment')->middleware('language');

        Route::delete('/{ShopId}/payments/{PaymentId}', 'ShopPaymentsController@deleteShopPayment');
    });
    //23/09/2020
    // Author: IVS
    //Items----------------------------------------------------------------------------------------------------
    Route::group(['prefix' => 'shops'], function ()
    {
        Route::get('/{ShopId}/items', [ItemsController::class , 'getItemList'])
            ->middleware('language');

        Route::post('/{ShopId}/items', [ItemsController::class , 'createItems'])
            ->middleware('language');

        Route::get('/{ShopId}/items/{itemsId}', [ItemsController::class , 'getItems'])
            ->middleware('language');

        Route::put('/{ShopId}/items/{itemsId}', [ItemsController::class , 'updateItems'])
            ->middleware('language');

        Route::delete('/{ShopId}/items/{itemsId}', [ItemsController::class , 'deleteItems'])
            ->middleware('language');

        Route::put('/{shopId}/items', 'ItemsController@updateItemListSort');
    });
    //Items----------------------------------------------------------------------------------------------------
    //customers----------------------------------------------------------------------------------------------------
    Route::group(['prefix' => 'shops'], function ()
    {
        Route::get('/{shopId}/customers', [CustomersController::class , 'getCustomerList'])
            ->middleware('language');

        Route::post('/{ShopId}/customers', [CustomersController::class , 'createCustomer'])
            ->middleware('language');

        Route::get('/{shopId}/customers/{customerId}', [CustomersController::class , 'getCustomer'])
            ->middleware('language');

        Route::put('/{shopId}/customers/{customerId}', [CustomersController::class , 'updateCustomer'])
            ->middleware('language');

        Route::delete('/{shopId}/customers/{customerId}', [CustomersController::class , 'deleteCustomer'])
            ->middleware('language');
    });
    //customers----------------------------------------------------------------------------------------------------
    //upload file ---------------------------------------------------
    Route::post('uploads', [UploadController::class , 'uploadFile']);
    //---------------------------------------------------------------
    //reservReceptTimes----------------------------------------------------------------------------------------------------
    Route::group(['prefix' => 'shops'], function ()
    {

        Route::post('/{shopId}/reserv_recept_times', [ReservReceptTimeController::class , 'createReservReceptTime'])
            ->middleware('language');

        Route::get('/{shopId}/reserv_recept_times/{reserv_recept_timeId}', [ReservReceptTimeController::class , 'getReservReceptTime'])
            ->middleware('language');

        Route::put('/{shopId}/reserv_recept_times/{reserv_recept_timeId}', [ReservReceptTimeController::class , 'updateReservReceptTime'])
            ->middleware('language');

        Route::delete('/{shopId}/reserv_recept_times/{reserv_recept_timeId}', [ReservReceptTimeController::class , 'deleteReservReceptTime'])
            ->middleware('language');
    });

    //Staffs------------------------------------------------------------------------------------------
    Route::group(['prefix'=>'shops'], function () {
        Route::get('/{ShopId}/staffs', 'StaffsController@getStaffList')->middleware('language');

        Route::get('/{ShopId}/staffs/{staffsId}', 'StaffsController@getStaff')->middleware('language');

        Route::post('/{ShopId}/staffs', 'StaffsController@createStaff')->middleware('language');

        Route::put('/{ShopId}/staffs/{staffsId}', 'StaffsController@updateStaff')->middleware('language');

        Route::delete('/{ShopId}/staffs/{staffsId}', 'StaffsController@deleteStaff')->middleware('language');
    });

    //MStaffRecepts----------------------------------------------------------------------------------------------------
    Route::group(['prefix' => 'shops'], function ()
    {
        Route::get('/{shopId}/staff_recepts', [StaffReceptsController::class , 'getStaffRecepts'])
            ->middleware('language');

        Route::post('/{shopId}/staff_recepts', [StaffReceptsController::class , 'createStaffRecepts'])
            ->middleware('language');

        Route::get('/{shopId}/staff_recepts/{staff_recepts_id}', [StaffReceptsController::class , 'getStaffRecept'])
            ->middleware('language');

        Route::put('/{shopId}/staff_recepts/{staff_recepts_id}', [StaffReceptsController::class , 'updateStaffRecepts'])
            ->middleware('language');

        Route::delete('/{shopId}/staff_recepts/{staff_recepts_id}', [StaffReceptsController::class , 'deleteStaffRecept'])
            ->middleware('language');
    });

    // Payment-------------------------------------------------------
    Route::post('/payments', [PaymentController::class , 'createPayment'])
        ->middleware('language');

    Route::get('/payments/{PaymentId}', [PaymentController::class , 'getPayment'])
        ->middleware('language');

    Route::get('/payments', [PaymentController::class , 'getAllPayment'])
        ->middleware('language');

    Route::put('/payments/{PaymentId}', [PaymentController::class , 'updatePayment'])
        ->middleware('language');

    Route::delete('/payments/{PaymentId}', [PaymentController::class , 'deletePayment'])
        ->middleware('language');

    // ShopMailDestinations
    Route::post('/shops/{shopId}/shop_mail_destinations', 'ShopMailDestinationsController@createShopMailDestination')
        ->middleware('language');

    Route::get('/shops/{shopId}/shop_mail_destinations/{shopmaildestinationId}', 'ShopMailDestinationsController@getShopMailDestination');

    Route::put('/shops/{shopId}/shop_mail_destinations/{shopmaildestinationId}', 'ShopMailDestinationsController@updateShopMailDestination')
        ->middleware('language');

    Route::delete('/shops/{shopId}/shop_mail_destinations/{shopmaildestinationId}', 'ShopMailDestinationsController@deleteShopMailDestination');

    //ShopView-----------------------------------------------------------------------------
    Route::group(['prefix' => 'shops'], function ()
    {

        Route::get('/{ShopId}/shop_view/{shop_viewId}', 'ShopViewController@getShopView');

        Route::post('/{ShopId}/shop_view', 'ShopViewController@createShopView')
            ->middleware('language');

        Route::put('/{ShopId}/shop_view/{shop_viewId}', 'ShopViewController@updateShopView')
            ->middleware('language');

        Route::delete('/{ShopId}/shop_view/{shop_viewId}', 'ShopViewController@deleteShopView');
    });

    // ShopMails
    Route::post('/shops/{shopId}/shop_mails', 'ShopMailsController@createShopMail')
        ->middleware('language');

    Route::get('/shops/{shopId}/shop_mails/{shopmailId}', 'ShopMailsController@getShopMail');

    Route::put('/shops/{shopId}/shop_mails/{shopmailId}', 'ShopMailsController@updateShopMail')
        ->middleware('language');

    Route::delete('/shops/{shopId}/shop_mails/{shopmailId}', 'ShopMailsController@deleteShopMail');
    // reserv_recepts-------------------------------------------------------
    Route::post('/shops​/{shopId}​/reserv_recepts', [ReservReceptController::class, 'createReservRecept'])->middleware('language');
    Route::get('/shops​/{shopId}​/reserv_recepts/{reserv_receptId}', [ReservReceptController::class, 'getReservRecept'])->middleware('language');
    Route::put('/shops​/{shopId}​/reserv_recepts/{reserv_receptId}', [ReservReceptController::class, 'updateReservRecept'])->middleware('language');
    Route::delete('/shops​/{shopId}​/reserv_recepts/{reserv_receptId}', [ReservReceptController::class, 'deleteReservRecept'])->middleware('language');

    // Shopterms-------------------------------------------------------
    Route::post('/shops/{shopId}/shopterms', [ShoptermsController::class, 'createShopterm'])->middleware('language');
    Route::get('/shops/{shopId}/shopterms/{shoptermId}', [ShoptermsController::class, 'getShopterm'])->middleware('language');
    Route::put('/shops/{shopId}/shopterms/{shoptermId}', [ShoptermsController::class, 'updateShopterm'])->middleware('language');
    Route::delete('/shops/{shopId}/shopterms/{shoptermId}', [ShoptermsController::class, 'deleteShopterm'])->middleware('language');
  
    //ShopHolidaies-----------------------------------------------------------------------------------
    Route::group(['prefix'=>'shops'], function () {

        Route::post('/{shopId}/shop_holidaies', [ShopHolidaiesController::class,'createShopHoliday'])->middleware('language');
        
        Route::get('/{shopId}/shop_holidaies', [ShopHolidaiesController::class, 'getShopHoliday'])->middleware('language');

        Route::put('/{shopId}/shop_holidaies', [ShopHolidaiesController::class,'updateShopHoliday'])->middleware('language');

        Route::delete('/{shopId}/shop_holidaies', [ShopHolidaiesController::class, 'deleteShopHoliday'])->middleware('language');
    });

    
    //ShopPublicHolidaies-----------------------------------------------------------------------------------
    Route::group(['prefix'=>'shops'], function () {

        Route::post('/{shopId}/shop_public_holidaies', [ShopPublicHolidaiesController::class,'createShopPublicHoliday'])->middleware('language');
        
        Route::get('/{shopId}/shop_public_holidaies', [ShopPublicHolidaiesController::class, 'getShopPublicHoliday'])->middleware('language');

        Route::put('/{shopId}/shop_public_holidaies', [ShopPublicHolidaiesController::class,'updateShopPublicHoliday'])->middleware('language');

        Route::delete('/{shopId}/shop_public_holidaies', [ShopPublicHolidaiesController::class, 'deleteShopPublicHoliday'])->middleware('language');
    });


    Route::get('closed', 'DataController@closed');
});
// /Accout ----------------------------------------------------------
//22/09/2020
// Author: IVS
Route::fallback(function ()
{
    return response()
        ->json(['message' => 'Page Not Found'], 404);
});

