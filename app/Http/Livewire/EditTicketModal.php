<?php

namespace App\Http\Livewire;

use App\Traits\HasTicketForm;
use App\Traits\HasTickets;
use App\Traits\HasToggleableModals;
use Livewire\Component;

class EditTicketModal extends Component
{
    use HasTickets; 
    use HasToggleableModals;
    use HasTicketForm;

    public $ticket; 

    protected $listeners = [
        'toggleTicketModal', 
        'editTicket',
    ];

    public function editTicket($id)
    {
        $this->ticket = $this->getRecord($id);

        $this->updateFormData();
        $this->toggleTicketModal('Edit', 1);
    }

    public function updateFormData()
    {
        $this->formData = [
            'subject' => $this->ticket->subject,
            'content' => $this->ticket->content,
        ];
    }

    public function updateTicket()
    {
        $this->validate();

        $ticket = $this->ticket->update([
            'subject' => $this->formData['subject'],
            'content' => $this->formData['content'],
        ]);

        if ($ticket) {
            // hide modal
            $this->toggleTicketModal('Edit', 0);
            $this->resetForm();
            // Update the table 
            $this->emitTo('tickets', 'tableUpdated');
        }
    }

    public function render()
    {
        return view('livewire.public.tickets.edit-ticket-modal', [
            'ticket' => $this->ticket,
            'formData' => $this->formData
        ]);
    }
}

