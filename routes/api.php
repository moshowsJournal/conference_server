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
Route::middleware('cors')->post('/add_talk','PagesController@add_talk');
Route::middleware('cors')->get('/get_talks','PagesController@get_talks');
Route::middleware('cors')->post('/create_attendees','PagesController@create_attendees');
Route::middleware('cors')->get('/get_attendees','PagesController@get_attendees');
Route::middleware('cors')->get('/get_attendees/{talk_id}','PagesController@get_attendees');
Route::middleware('cors')->post('/add_to_talk','PagesController@add_to_talk');
