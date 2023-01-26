<?php

namespace App\Http\Livewire;

use App\Models\Ticket;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Tickets extends Component
{
    public $title = "Filed Tickets";
    public $description = "";
    public $perPage = 5;
    
    private $tickets;

    public function render()
    {
        $this->tickets = (auth()->guard('web')->user() && auth()->guard('web')->user() instanceof User)
            ? Ticket::owner()->latest()->paginate($this->perPage)
            : Ticket::latest()->paginate($this->perPage);

        return view('livewire.public.tickets.tickets', [
            'tickets' => $this->tickets,
        ]);
    }

}
