<?php

namespace App\Traits;

use App\Models\Ticket;

trait HasTicketForm
{
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

    public function resetForm()
    {
        $this->resetValidation();

        $this->formData = $this->default;
    }
}
