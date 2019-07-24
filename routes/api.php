<?php

use Illuminate\Http\Request;

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
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/**
 * USER SOURCE RESOURCE ROUTES
 * -----------------------------------------------------------
 * VERB      | URI                    | ACTION  | ROUTE NAME
 * -----------------------------------------------------------
 * GET       | /user-setting/{userId} | show    | name.show
 * PUT/PATCH | /user-setting/{userId} | update  | name.update
 * -----------------------------------------------------------
 */
Route::middleware('auth:api')->group(function () {
    Route::resource('user-setting', 'API\UserSettingController')
        ->only(['show', 'update']);
});

/**
 * RESOURCE ROUTES
 * -------------------------------------------------------
 * VERB      | URI             | ACTION  | ROUTE NAME
 * -------------------------------------------------------
 * GET       | /name           | index   | name.index
 * POST      | /name           | store   | name.store
 * GET       | /name/{id}      | show    | name.show
 * PUT/PATCH | /name/{id}      | update  | name.update
 * DESTROY   | /name/{id}      | destroy | name.destroy
 * -------------------------------------------------------
 */
Route::middleware('auth:api')->group(function () {
    Route::apiResource('medicine', 'Api\MedicineController'); // excludes 'create' and 'edit' actions.
});
