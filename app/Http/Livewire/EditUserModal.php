<?php

namespace App\Http\Livewire;

use App\Traits\HasToggleableModals;
use App\Traits\HasUserForm;
use App\Traits\HasUsers;
use Livewire\Component;

class EditUserModal extends Component
{
    use HasUsers;
    use HasToggleableModals;
    use HasUserForm;

    public $user;
    public $showEditUserModal = false;

    protected $listeners = [
        'toggleModal',
        'editUser',
    ];

    public function editUser($id)
    {
        $this->user = $this->getRecord($id);

        $this->updateFormData();
        $this->toggleModal('EditUser', 1);
    }

    public function updateFormData()
    {
        $this->formData = [
            'name' => $this->user->name,
            'email' => $this->user->email,
            'active' => $this->user->active,
        ];
    }

    public function updateUser()
    {
        $this->validate();

        $user = $this->user->update([
            'name' => $this->formData['name'],
            'email' => $this->formData['email'],
            'active' => $this->formData['active'] == '1' ? 1 : 0,
        ]);

        if ($user) {
            $this->clearDataFromCache($this->user->id);
            // hide modal
            $this->resetForm();
            $this->toggleModal('EditUser', 0);

            $this->emitTo('users', 'tableUpdated');
            $this->emitTo('view-user', 'refresh');
        }
    }

    public function render()
    {
        return view('livewire.admin.users.edit-user-modal', [
            'users' => $this->user,
            'formData' => $this->formData,
        ]);
    }

}
