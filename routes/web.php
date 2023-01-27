<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\User\TicketController;
use App\Http\Livewire\Tickets;
use App\Http\Livewire\ViewTicket;
use App\Models\Ticket;
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

Route::bind('ticket', function($ticket) {
    return Ticket::findOrFail($ticket);
});

Route::get('/', function () {
    return view('auth.login');
});

// Route::get('/admin/login', function () {
//     return view('admin.auth.login');
// })->name('admin.login');

Route::middleware('admin:admin')->group(function() {
    Route::get('/admin/login', [AdminController::class, 'loginForm']);
    Route::post('/admin/login', [AdminController::class, 'store'])->name('admin.login');
});

/**
 * Admin Routes
 */
Route::prefix('admin')->middleware([
    'auth:sanctum,admin',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('admin.dashboard');

    Route::get('tickets', Tickets::class)->name('admin.livewire.tickets');
    Route::get('tickets/{ticket}', ViewTicket::class)->name('admin.livewire.tickets.show');
});


/**
 * User Routes
 */
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('tickets', Tickets::class)->name('livewire.tickets');
    Route::get('tickets/{ticket}', ViewTicket::class)->name('livewire.tickets.show');
    
    // /**
    //  * Admin Routes
    //  */
    // Route::prefix('admin')->group(function() {
    //     Route::get('/', function() {
    //         dd('admin dashboard');
    //     });
    //     Route::get('tickets', Tickets::class)->name('admin.livewire.tickets');
    //     Route::get('tickets/{ticket}', ViewTicket::class)->name('admin.livewire.tickets.show');
    // });

});
