<?php

use App\Http\Controllers\FileController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    return Inertia::render('Welcome', [
        'canLogin' => true,
        'canRegister' => true,
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware('auth')->group(function () {
    Route::get('/register', function () {
        return Inertia::render('register');
    })->name('register');
    Route::get('/login', function () {
        return Inertia::render('login')
            ->name('login');
    });
});

//Adding route to the FileController
// the auth checks for authentication and verified checks for email is verified or not
Route::controller(FileController::class)

    ->middleware(['auth', 'verified'])
    ->group(function () {
        // the below routes shows that folder is an optional parameter /my-files and /my-files/folder1 both works
        Route::get('/my-files/{folder?}', 'myFiles')
            ->where('folder', '(.*)')->name('myFiles');
        Route::get('/trash', 'trash')->name('trash');
        Route::post('/folder/create', 'createFolder')->name('folder.create');
        Route::post('/file', 'store')->name('file.store');

        Route::delete('/file', 'destroy')->name('file.delete');
        Route::post('/file/restore', 'restore')->name('file.restore');
        Route::delete('/file/delete-forever', 'deleteForever')->name('file.deleteForever');
        Route::post('/file/share', 'share')->name('file.share');
        Route::get('/file/download', 'download')->name('file.download');

        Route::get('/file/show', 'show')->name('file.show');

        Route::get('/shared-with-me', 'sharedWithMe')->name('file.sharedWithMe');
        Route::get('/shared-by-me', 'sharedByMe')->name('file.sharedByMe');
        Route::get('/file/download-shared-with-me', 'downloadSharedWithMe')->name('file.downloadSharedWithMe');
        Route::get('/file/download-shared-by-me', 'downloadSharedByMe')->name('file.downloadSharedByMe');

    });

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';