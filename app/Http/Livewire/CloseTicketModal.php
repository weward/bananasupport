<?php

namespace App\Http\Livewire;

use App\Traits\HasTickets;
use App\Traits\HasToggleableModals;
use Livewire\Component;

class CloseTicketModal extends Component
{
    use HasTickets;
    use HasToggleableModals;

    public $ticket;

    protected $listeners = [
        'toggleTicketModal',
        'closeTicket' => 'loadTicket',
        'disableTicket',
    ];

    public function loadTicket($id) 
    {
        $this->ticket = $this->getRecord($id);

        $this->toggleTicketModal('Close', 1);
    }

    public function disableTicket($id)
    {
        $ticket = $this->getRecord($id);
        $ticket->status = 0;
        $ticket->save();

        $this->clearDataFromCache($id);
        $this->ticket = $ticket;

        $this->toggleTicketModal('Close', 0);
        
        if (request()->routeIs('admin.livewire.tickets')) {
            $this->emitTo('tickets', 'tableUpdated');
            return;
        } 

        $this->emitTo('view-ticket', 'refresh');
    }

    public function render()
    {
        return view('livewire.public.tickets.close-ticket-modal', [
            'tickets' => $this->ticket,
        ]);
    }
}
