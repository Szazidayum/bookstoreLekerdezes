<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\CopyController;
use App\Http\Controllers\LendingController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\UserController;
use App\Models\Reservation;
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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

//ADMIN
Route::middleware( ['admin'])->group(function () {
    //books
    Route::get('/api/books/{id}', [BookController::class, 'show']);
    Route::post('/api/books', [BookController::class, 'store']);
    Route::put('/api/books/{id}', [BookController::class, 'update']);
    Route::delete('/api/books/{id}', [BookController::class, 'destroy']);
    //copies
    Route::apiResource('/api/copies', CopyController::class);
    //queries
    Route::get('/api/book_copies/{title}', [BookController::class, 'bookCopies']);
    //view - copy
    Route::get('/copy/new', [CopyController::class, 'newView']);
    Route::get('/copy/edit/{id}', [CopyController::class, 'editView']);
    Route::get('/copy/list', [CopyController::class, 'listView']); 
});

//SIMPLE USER
Route::middleware(['auth.basic'])->group(function () {
    
    //user   
    Route::apiResource('/api/users', UserController::class);
    Route::patch('/api/users/password/{id}', [UserController::class, 'updatePassword']);
    //queries
    //user lendings
    Route::get('/api/user_lendings', [LendingController::class, 'userLendingsList']);
    Route::get('/api/user_lendings_count', [LendingController::class, 'userLendingsCount']);

    //Lekérdezések
    Route::get('/api/user_reservation', [ReservationController::class, 'userReservation']);
});
//csak a tesztelés miatt van "kint"
Route::patch('/api/users/password/{id}', [UserController::class, 'updatePassword']);
Route::apiResource('/api/copies', CopyController::class);
Route::get('/api/lendings', [LendingController::class, 'index']); 
Route::get('/api/lendings/{user_id}/{copy_id}/{start}', [LendingController::class, 'show']);
Route::put('/api/lendings/{user_id}/{copy_id}/{start}', [LendingController::class, 'update']);
Route::patch('/api/lendings/{user_id}/{copy_id}/{start}', [LendingController::class, 'update']);
Route::post('/api/lendings', [LendingController::class, 'store']);
Route::delete('/api/lendings/{user_id}/{copy_id}/{start}', [LendingController::class, 'destroy']);

//LEKÉRDEZÉSEK
Route::get('api/year_copies/{year}/{author}/{title}', [CopyController::class, 'yearCopies']);
Route::get('api/hardcovered_copies/{hardcovered}', [CopyController::class, 'hardCoveredCopies']);
Route::get('api/kiadott_peldany/{publication}', [CopyController::class, 'kiadottPeldany']);
Route::get('api/raktarban/{status}', [CopyController::class, 'raktarbanPeldany']);
Route::get('api/kolcsonzAdat/{copy_id}', [CopyController::class, 'kolcsonzesiAdatok']);

//Books
Route::get('api/szerzok_abc', [BookController::class, 'szerzokABC']);
Route::get('api/more_than_2', [BookController::class, 'moreThan2']);
Route::get('api/author_b', [BookController::class, 'szerzokB']);

require __DIR__.'/auth.php';
