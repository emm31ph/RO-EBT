<?php

use App\Model\ReportItems;
use Illuminate\Support\Facades\Route;
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

Route::get('/', function () {
    return view('welcome');
});

// Auth::routes();
Auth::routes(['register' => false]);

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => ['preventBackHistory','auth']], function() {
    
// Route::resource('manage/users', 'Manage\UserController', ['names' => 'manage.user']);
    Route::resource('manage/users', 'Manage\UserController', ['names' => 'manage.user']);
    Route::resource('manage/roles', 'Manage\RoleController', ['names' => 'manage.role'])->except(['destroy']);
    Route::resource('manage/permissions', 'Manage\PermissionController', ['names' => 'manage.permission']);
    Route::resource('/ro', 'RO\ReleaseorderController', ['names' => 'ro']);
    Route::resource('/report', 'Reports\ReportController', ['names' => 'report']);

    Route::group(['prefix' => 'release'], function () {
        Route::get('delivery', 'RO\ReleaseorderController@deliveryList')->name('release.delivery');
        Route::post('cancel/{id?}', 'RO\ReleaseorderController@deliveryCancel')->name('release.cancel');
        // Route::any('list', 'RO\ReleaseorderController@list')->name('release.list');
        Route::get('list-unprocess', 'RO\ReleaseorderController@listUnprocess')->name('release.listUnprocess');
        Route::get('list-process', 'RO\ReleaseorderController@listProcess')->name('release.listProcess');
        Route::get('print/{ro?}', 'RO\ReleaseorderController@print')->name('release.print');
        // Route::get('print1/{ro?}', 'RO\ReleaseorderController@print1')->name('release.print1');
        Route::get('search', 'RO\ReleaseorderController@search')->name('release.search');
        Route::any('import', 'RO\ReleaseorderController@import')->name('release.import');
        Route::post('import/save', 'RO\ReleaseorderController@importSave')->name('release.import.save');
        Route::get('items/{ro?}', 'RO\ReleaseorderController@itemslist')->name('release.items');
        Route::post('update', 'RO\ReleaseorderController@updateList')->name('release.update');
        Route::get('export/unprocess', 'RO\ReleaseorderController@unprocessexport')->name('export.unprocess');

    });
});


 Route::group(['prefix' => 'export'], function () {
     Route::post('delivery', 'RO\ReleaseorderController@exportDelivery')->name('export.delivery');
 });
 
Route::get('/header1', function ($query = null) {

    $users = ReportItems::where('header1', 'like', '%' . $query . '%')
        ->select('header1 as name')
        ->groupby('header1')
        ->get();

    return response()->json($users);
})->name('header1');

Route::get('/header2', function ($query = null) {

    $users = ReportItems::where('header2', 'like', '%' . $query . '%')
        ->select('header2 as name')
        ->groupby('header2')
        ->get();

    return response()->json($users);
})->name('header2');

Route::get('/header3', function ($query = null) {

    $users = ReportItems::where('header3', 'like', '%' . $query . '%')
        ->select('header3 as name')
        ->groupby('header3')
        ->get();

    return response()->json($users);
})->name('header3');

Route::get('/itemcode', function ($query = null) {

    $users = ReportItems::where('itemcode', 'like', '%' . $query . '%')
        ->select('itemcode as name')
        ->groupby('itemcode')
        ->get();

    return response()->json($users);
})->name('itemcode');

 