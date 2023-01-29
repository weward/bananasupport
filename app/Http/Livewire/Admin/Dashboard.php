<?php

namespace App\Http\Livewire\Admin;

use App\Models\Ticket;
use App\Models\User;
use Livewire\Component;

class Dashboard extends Component
{
    public $totalTickets = 0;
    public $activeTickets = 0;
    public $totalUsers = 0;

    public function getTotalTickets($isActive = false)
    {
        $total = Ticket::when($isActive, function ($query) {
                $query->status(1);
            })
            ->count();
 
        if ($isActive) {
            $this->activeTickets = $total;
            return;
        }

        $this->totalTickets = $total;
    }

    public function getTotalUsers()
    {
        $this->totalUsers = User::count();
    }

    public function render()
    {
        $this->getTotalTickets();
        $this->getTotalTickets(1);
        $this->getTotalUsers();

        return view('livewire.admin.dashboard');
    }
}
