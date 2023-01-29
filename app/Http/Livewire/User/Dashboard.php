<?php

namespace App\Http\Livewire\User;

use App\Models\Ticket;
use Livewire\Component;

class Dashboard extends Component
{
    public $totalTickets = 0;
    public $activeTickets = 0;

    public function getTotalTickets($isActive = false)
    {
        $total = Ticket::where('user_id', auth()->user()->id)
            ->when($isActive, function($query) {
                $query->status(1);
            })
            ->count();
            
        if ($isActive) {
            $this->activeTickets = $total;
            return;
        }
        
        $this->totalTickets = $total;
    }


    public function render()
    {
        $this->getTotalTickets();
        $this->getTotalTickets(1);

        return view('livewire.user.dashboard');
    }
}
