<?php

namespace App\Http\Livewire;

use App\Models\Ticket;
use App\Traits\HasTickets;
use App\Traits\HasToggleableModals;
use Livewire\Component;

class DeleteTicketModal extends Component
{
    use HasTickets;
    use HasToggleableModals;

    public $ticket;

    protected $listeners = [
        'toggleTicketModal',
        'deleteTicket' => 'loadTicket',
        'destroyTicket',
    ];


    public function loadTicket($id)
    {
        $this->ticket = $this->getRecord($id);

        $this->toggleTicketModal('Delete', 1);
    }

    public function destroyTicket($id)
    {
        $ticket = $this->getRecord($id);
        $ticket->delete();

        $this->ticket = null;

        $this->clearDataFromCache($id);

        $this->toggleTicketModal('Delete', 0);
        $this->emitTo('tickets', 'tableUpdated');

    }

    public function render()
    {
        return view('livewire.public.tickets.delete-ticket-modal', [
            'ticket' => $this->ticket,
        ]);
    }
}
