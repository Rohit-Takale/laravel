<?php

use App\Http\Controllers\Company;
use App\Http\Controllers\Todo;
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

Route::get('dash', [Company::class, 'view'])->name('dash');

Route::group(['middleware' => ['auth']], function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/todo', function(){
        return view('todo');
    })->name('todo');

    Route::post('todo_insert', [Todo::class,'insert'])->name('todo_insert');
    Route::get('get_todo_data',[Todo::class,'view'])->name('get_todo_data');
    Route::get('update_data',[Todo::class,'display_edt'])->name('update_data');
    Route::post('edt_todo', [Todo::class, 'edit_todo'])->name('edt_todo');
    Route::get('completed_todo_data', [Todo::class,'display_completed'])->name('completed_todo_data');
    Route::post('chng_cmpltd', [Todo::class,'move_cmpltd'])->name('chng_cmpltd');
    Route::delete('dlt_todo', [Todo::class, 'delete_todo'])->name('dlt_todo');

    // Route::get('/dash', function () {
    //     return view('dash');
    // })->name('dash');

});

require __DIR__ . '/auth.php';
