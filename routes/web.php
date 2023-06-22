<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CsvImportController;

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

Route::get('/import-csv', function (){
    return view('import-csv');
});
Route::post('csv/import', [CsvImportController::class, 'import'])->name('csv.import');
