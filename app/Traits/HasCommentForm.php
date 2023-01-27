<?php

namespace App\Traits;

trait HasCommentForm
{
    public $default = [
        'content' => '',
    ];

    public $formData;

    protected $rules = [
        'formData.content' => 'required|min:2'
    ];

    protected $messages = [
        'formData.content.required' => 'Please provide a content',
        'formData.content.min'      => 'Content is too short. Please make it longer.',
    ];

    public function resetForm()
    {
        $this->resetValidation();

        $this->formData = $this->default;
    }
}
