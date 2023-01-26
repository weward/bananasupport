<?php

namespace App\Http\Livewire;

use App\Models\Ticket;
use App\Traits\HasToggleableModals;
use Livewire\Component;

class NewTicketModal extends Component
{
    use HasToggleableModals;

    protected $listeners = [
        'toggleNewTicketModal' => 'toggleNewTicketModal',
    ];

    public $default = [
        'subject' => '',
        'content' => '',
    ];

    public $formData;

    protected $rules = [
        'formData.subject' => 'required|min:2',
        'formData.content' => 'required|min:2'
    ];

    protected $messages = [
        'formData.subject.required' => 'Please provide a subject',
        'formData.subject.min'      => 'Subject is too short. Please make it longer.',
        'formData.content.required' => 'Please provide a content',
        'formData.content.min'      => 'Content is too short. Please make it longer.',
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
            $this->resetForm();
            $this->toggleNewTicketModal();
        }
    }

    public function resetForm()
    {
        $this->resetValidation();

        $this->formData = $this->default;
    }

    public function render()
    {
        return view('livewire.public.tickets..new-ticket-modal');
    }

    public function mount()
    {
        $this->formData = $this->default;
    }
}
