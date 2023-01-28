<?php

namespace App\Http\Livewire;

use App\Models\Ticket;
use App\Traits\HasTicketForm;
use App\Traits\HasToggleableModals;
use Livewire\Component;

class NewTicketModal extends Component
{
    use HasToggleableModals, HasTicketForm;

    protected $listeners = [
        'toggleTicketModal'
    ];

    public function createNewTicket()
    {
        $this->validate();

        $ticket = new Ticket;
        $ticket->subject = $this->formData['subject'];
        $ticket->content = $this->formData['content'];
        $ticket->user_id = auth()->guard('web')->user()->id;
        $ticket->save();

        if ($ticket) {

            // Dispatch Job to process emails....
            
            // Reset the form
            $this->resetForm();
            $this->toggleTicketModal('New', 0);
            
            if (url()->current() != route('livewire.tickets')) {
                return redirect()->route('livewire.tickets');
            }
            // Update the table 
            $this->emitTo('tickets', 'tableUpdated');
        }
    }

    public function render()
    {
        return view('livewire.public.tickets.new-ticket-modal');
    }

    public function mount()
    {
        $this->formData = $this->default;
    }
}
