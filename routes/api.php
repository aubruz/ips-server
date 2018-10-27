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

Route::group(['middleware' => ['auth:api']], function () {

    // Route to the location service
    Route::post('find/location', [
        'uses'       => 'IpsController@getLocation',
        'as'         => 'find.location',
    ]);

// Route to save a fingerprint
    Route::post('floors/{floor}/fingerprints', [
        'uses' => 'IpsController@saveFingerprints',
        'as'   => 'save.fingerprint',
    ]);

// Route to get the buildings list
    Route::resource('buildings', 'BuildingController', [
        'only' => ['index'],
    ]);

//Route to get the floor lists
    Route::resource('buildings.floors', 'FloorController', [
        'only' => ['index'],
    ]);

// Route to create or delete a point on a map
    Route::resource('floors.points', 'PointController', [
        'only' => ['index', 'destroy'],
    ]);
});

