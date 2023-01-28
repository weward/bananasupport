<?php

namespace App\Traits;

trait HasUserForm
{
    public $default = [
        'name' => '',
        'email' => '',
        'active' => '',
    ];

    public $formData;

    protected $rules = [
        'formData.name' => 'required',
        'formData.email' => 'required|email',
        'formData.active' => 'required'
    ];

    protected $messages = [
        'formData.name.required' => 'Please enter a name',
        'formData.email.required' => 'Please enter an email',
        'formData.email.email'      => 'Please enter a valid email address',
        'formData.active.required' => 'Please select a status',
    ];

    public function resetForm()
    {
        $this->resetValidation();

        $this->formData = $this->default;
    }
}
