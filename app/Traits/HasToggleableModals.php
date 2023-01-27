<?php 

namespace App\Traits;


trait HasToggleableModals
{
    public $showNewModal = false;
    public $showEditModal = false;

    /**
     * Toggle Modal
     *
     * @param  strintg  $module
     * @param  boolean  $show
     * @return void
     */
    public function toggleTicketModal($module = 'New', $show = false)
    {
        if (method_exists($this, 'resetForm')) {
            if ($module == 'new') {
                $this->resetForm();
            }
        }

        $modal = "show{$module}Modal";

        $this->{$modal} = $show;
        
    }

}