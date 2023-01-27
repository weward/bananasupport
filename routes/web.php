<?php

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

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Route::get('tickets', [TicketController::class, 'index'])->name('livewire.tickets');
    Route::get('tickets', Tickets::class)->name('livewire.tickets');
    Route::get('tickets/{ticket}', ViewTicket::class)->name('livewire.tickets.show');
});
