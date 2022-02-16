<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\MessageController;
use \App\Http\Controllers\MesssageWebhookController;
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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::prefix('mail')->middleware(['auth'])->group(function () {
    Route::get('/form', [MessageController::class, 'form'])->name('mailform');
    Route::post('/process', [MessageController::class, 'process'])->name('mailform.process');
    Route::get('/sent/all', [MessageController::class, 'all'])->name('mailform.sent.all');
});

Route::post('/mg-webhook', [MesssageWebhookController::class, 'call'])->name('mailgun.webhook');

require __DIR__.'/auth.php';
