<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\BorrowAndReturnController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
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

Route::middleware(['auth'])->group(function () {

    //user registration
    Route::get('/register/user', function () {
        return view('auth.register');
    })->name( 'register.user' );
    Route::post('/register', [HomeController::class, 'createUser'])->name('create.user');

    //book and home page
    Route::get('/create/book', [BookController::class, 'create'])->name('book.create');
    Route::post('/store/book', [BookController::class, 'store'])->name('book.store');
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/book/update/{id}', [BookController::class, 'updateView'])->name('book.update.view');
    Route::post('/book/update/{id}', [BookController::class, 'update'])->name('book.update');
    Route::get('/book/delete/{id}', [BookController::class, 'delete'])->name('book.delete');


    //book borrowalroutes
    Route::get('/create/borroval', [BorrowAndReturnController::class, 'borrowView'])->name('borrow.view');
    Route::get('/store/borroval', [BorrowAndReturnController::class, 'storeBorrow'])->name('add.borowal.record');

    //book return
    Route::get('/view/borrovals', [BorrowAndReturnController::class, 'returnView'])->name('return.view');
    Route::get('/complete/return', [BorrowAndReturnController::class, 'confirmReturn'])->name('return.confirm');

    //book search
    Route::get('/search-books', [BookController::class, 'find_books'])->name('search.books');
});

Auth::routes();
