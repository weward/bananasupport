<?php 

namespace App\Traits;


trait HasToggleableModals
{
    public $showModal = false;

    public function toggleNewTicketModal($show = false)
    {
        if (method_exists($this, 'resetForm')) {
            $this->resetForm();
        }

        $this->showModal = $show;
    }


}