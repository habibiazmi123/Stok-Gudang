<?php

use App\Exports\ProductExport;
use App\Product;
use App\ProductStock;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Facades\Excel;

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
    return redirect("admin");
});

Route::get('/testing', function () {
    return Excel::download(new ProductExport("2021-01-06", "2021-01-07"), 'Stok Gudang (2021-01-06 s.d 2021-01-07).xlsx');
});


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();

    Route::get("/", "DashboardController@index")->name("voyager.dashboard");
});
