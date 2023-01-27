<?php 

namespace App\Traits;

use App\Models\Ticket;

trait HasTickets 
{
    public $ticket;

    /**
     * Get Ticket Record
     * 
     * Ticket by User Type (User vs Admin) 
     * is handled in the Ticket Model
     *
     * @param  int $id
     * @return App\Models\Ticket
     */
    public function getRecord($id)
    {
        return Ticket::id($id)->first();
    }

    public function loadCommentRelationships()
    {
        if (isset($this->ticket) && $this->ticket) {
            $this->ticket->load([
                'reporter',
                'comments',
                'comments.commentable'
            ]);
        }
    }
}