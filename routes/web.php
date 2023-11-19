<?php

use App\Http\Livewire\Form;
use App\Http\Controllers\PdfDocumentController;
use Illuminate\Support\Facades\Route;


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
// Route::get('form', Form::class);

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('warga/surat/{document}', PdfDocumentController::class)->name('pdf');
