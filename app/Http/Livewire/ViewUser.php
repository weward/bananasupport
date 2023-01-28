<?php

namespace App\Http\Livewire;

use App\Traits\HasUsers;
use Livewire\Component;

class ViewUser extends Component
{
    use HasUsers;
    
    public $user;

    protected $listeners = [
        'refresh' => 'render',
    ];
    
    public function render()
    {
        $this->loadRelationships(true);

        return view('livewire.admin.users.view-user');
    }

    public function mount($user)
    {
        $this->user = $user;

    }
}
