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

/*
Route::get('/hello', function () {
    //return view('welcome');
    return '<h1>Hello World</h1>';
});

Route::get('/users/{id}/{name}', function($id, $name){
    return 'This is user '.$name.' with an id of '.$id;
});
*/
Route::get('/', 'App\Http\Controllers\PagesController@index');
Route::get('/about', 'App\Http\Controllers\PagesController@about');
Route::get('/services', 'App\Http\Controllers\PagesController@services');

Route::get('/profile', 'App\Http\Controllers\ProfileController@profile');

Route::any('/search', 'App\Http\Controllers\PagesController@action_search');

Auth::routes();

Route::resource('address', 'App\Http\Controllers\AddressController');
Route::resource('drink', 'App\Http\Controllers\DrinkController');
Route::resource('drinkrestaurant', 'App\Http\Controllers\DrinkRestaurantController');
Route::resource('drinktype', 'App\Http\Controllers\DrinkTypeController');
Route::resource('evaluation', 'App\Http\Controllers\EvaluationController');
Route::resource('food', 'App\Http\Controllers\FoodController');
Route::resource('foodrestaurant', 'App\Http\Controllers\FoodRestaurantController');
Route::resource('foodtype', 'App\Http\Controllers\FoodTypeController');
Route::resource('order', 'App\Http\Controllers\OrderController');
Route::resource('permission', 'App\Http\Controllers\PermissionController');
Route::resource('reservation', 'App\Http\Controllers\ReservationController');
Route::resource('restaurant', 'App\Http\Controllers\RestaurantController');
Route::resource('restauranttype', 'App\Http\Controllers\RestaurantTypeController');
Route::resource('rolegroup', 'App\Http\Controllers\RoleGroupController');
Route::resource('rolegrouppermission', 'App\Http\Controllers\RoleGroupPermissionController');
Route::resource('userrolegroup', 'App\Http\Controllers\UserRoleGroupController');
Route::resource('user', 'App\Http\Controllers\UserController');

//Cpanal
Route::get('/cpanal', 'App\Http\Controllers\PagesController@cpanal');

Route::resource('addressadmin', 'App\Http\Controllers\AddressAdminController');
Route::resource('drinkadmin', 'App\Http\Controllers\DrinkAdminController');
Route::resource('drinktypeadmin', 'App\Http\Controllers\DrinkTypeAdminController');
Route::resource('evaluationadmin', 'App\Http\Controllers\EvaluationAdminController');
Route::resource('foodadmin', 'App\Http\Controllers\FoodAdminController');
Route::resource('foodtypeadmin', 'App\Http\Controllers\FoodTypeAdminController');
Route::resource('orderadmin', 'App\Http\Controllers\OrderAdminController');
Route::resource('reservationadmin', 'App\Http\Controllers\ReservationAdminController');
Route::resource('restaurantadmin', 'App\Http\Controllers\RestaurantAdminController');
Route::resource('restauranttypeadmin', 'App\Http\Controllers\RestaurantTypeAdminController');
Route::resource('foodrestaurantadmin', 'App\Http\Controllers\FoodRestaurantAdminController');
Route::resource('drinkrestaurantadmin', 'App\Http\Controllers\DrinkRestaurantAdminController');
Route::resource('userrestaurant', 'App\Http\Controllers\UserRestaurantController');

//Functiones:
Route::get('/assignfoodrestaurant/{foodid}', 'App\Http\Controllers\FoodRestaurantController@assignfoodrestaurant');
Route::get('/assigndrinkrestaurant/{drinkid}', 'App\Http\Controllers\DrinkRestaurantController@assigndrinkrestaurant');
Route::get('/assignfoodrestaurantadmin/{foodid}', 'App\Http\Controllers\FoodRestaurantAdminController@assignfoodrestaurantadmin');
Route::get('/assigndrinkrestaurantadmin/{drinkid}', 'App\Http\Controllers\DrinkRestaurantAdminController@assigndrinkrestaurantadmin');
Route::get('/assignroles/{user_id}', 'App\Http\Controllers\UserController@assignroles');
Route::put('/submitassignroles/{user_id}', 'App\Http\Controllers\UserController@submitassignroles');
Route::get('/assignuserrestaurant/{restaurantid}', 'App\Http\Controllers\UserRestaurantController@assignuserrestaurant');


//ajax
Route::post('order/fetch', 'App\Http\Controllers\OrderController@fetch')->name('order.fetch');
//Route::post('order/fetchfood', 'OrderController@fetchfood')->name('order.fetchfood');
//Route::post('order/fetchdrink', 'OrderController@fetchdrink')->name('order.fetchdrink');

Route::post('orderadmin/fetch', 'App\Http\Controllers\OrderAdminController@fetch')->name('orderadmin.fetch');
