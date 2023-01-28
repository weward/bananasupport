<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\User\TicketController;
use App\Http\Livewire\Tickets;
use App\Http\Livewire\Users;
use App\Http\Livewire\ViewTicket;
use App\Models\Ticket;
use Illuminate\Support\Facades\Cache;
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
    return Cache::rememberForever("ticket-{$ticket}", function () use ($ticket) {
        return Ticket::findOrFail($ticket);
    });
});

Route::get('/', function () {
    return view('auth.login');
});

Route::prefix('admin')->middleware('admin:admin')->group(function() {
    Route::get('/', [AdminController::class, 'loginForm']);
    Route::get('login', [AdminController::class, 'loginForm']);
    Route::post('login', [AdminController::class, 'store'])->name('admin.login');
});

/**
 * Admin Routes
 */
Route::prefix('admin')->middleware([
    'auth:sanctum,admin',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('dashboard', function () {
        return view('dashboard');
    })->name('admin.dashboard');

    Route::get('tickets', Tickets::class)->name('admin.livewire.tickets');
    Route::get('tickets/{ticket}', ViewTicket::class)->name('admin.livewire.tickets.show');
    Route::get('users', Users::class)->name('admin.livewire.users');
});


/**
 * User Routes
 */
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('tickets', Tickets::class)->name('livewire.tickets');
    Route::get('tickets/{ticket}', ViewTicket::class)->name('livewire.tickets.show');

});
