<?php

use App\Http\Controllers\Company;
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

Route::post(
    '/insert_comp',
    [Company::class, 'insert']
)->name('insert_comp');

Route::get('dash',[Company::class,'view'])->name('dash');

Route::group(['middleware' => ['auth']], function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    // Route::get('/dash', function () {
    //     return view('dash');
    // })->name('dash');
    
});

require __DIR__ . '/auth.php';
