<?php

namespace App\Http\Livewire;

use App\Models\Admin;
use App\Models\Comment;
use App\Models\User;
use App\Traits\HasAuth;
use App\Traits\HasCommentForm;
use App\Traits\HasNavigation;
use App\Traits\HasTickets;
use Livewire\Component;

class ViewTicket extends Component
{
    use HasCommentForm;
    use HasTickets;
    use HasAuth;
    use HasNavigation;
    
    public $ticket;

    protected $listeners = [
        'refresh' => 'render',
    ];

    public function createNewComment()
    {
        $this->validate();
        
        $isAdmin = ($this->isAdmin());
        
        $newComment = new Comment([
            'content' => $this->formData['content'],
            'commentable_id' => auth()->user()->id,
            'commentable_type' => ($isAdmin) ? Admin::class : User::class,
        ]);

        
        $this->ticket->comments()->save($newComment);
        // remove from cache
        $this->clearDataFromCache();
        // re-add to cache
        $this->ticket = $this->getRecord($this->ticket->id);

        $this->resetForm();
        $this->render();

    }

    public function render()
    {
        $this->loadCommentRelationships();

        return view('livewire.public.tickets.view-ticket');
    }

    public function mount($ticket)
    {
        $this->ticket = $ticket;

        $this->formData = $this->default;
    }

}
