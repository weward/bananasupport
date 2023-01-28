<?php

namespace App\Http\Livewire;

use App\Traits\HasToggleableModals;
use App\Traits\HasUsers;
use Livewire\Component;

class UserStatusModal extends Component
{
    use HasUsers;
    use HasToggleableModals;

    public $user;
    public $showUserStatusModal = false;

    protected $listeners = [
        'toggleModal',
        'loadUserStatus',
        'updateStatus',
    ];

    public function loadUserStatus($id)
    {
        $this->user = $this->getRecord($id);
        $this->toggleModal('UserStatus', 1);
    }

    public function updateStatus($id)
    {
        $user = $this->getRecord($id);
        $user->active = !$user->active;
        $user->save();

        $this->user = null;
        $this->clearDataFromCache($id);

        $this->toggleModal('UserStatus', 0);
        $this->emitTo('users', 'tableUpdated');
    }

    public function render()
    {
        return view('livewire.admin.users.user-status-modal', [
            'user' => $this->user
        ]);
    }
}
