<?php

use App\Http\Controllers\SalesController;
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
    return redirect()->route('login');
});

Route::redirect('/dashboard', '/sales');

Route::middleware(['auth'])->group(function () {
    Route::get('/sales', [SalesController::class, 'index'])->name('coffee.sales');
    Route::post('/sales', [SalesController::class, 'store'])->name('coffee.sales.store');

    Route::get('/shipping-partners', function () {
        return view('shipping_partners');
    })->name('shipping.partners');
});



require __DIR__ . '/auth.php';
