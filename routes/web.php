<?php




/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();



    // Usar essa rota pra desenvolvimento (Lembrar de fazer a autenticação)
   /* Route::get('/home', function () {
        return view('home');
    }); */

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


