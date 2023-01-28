<?php 

namespace App\Traits;

use App\Models\Ticket;
use Illuminate\Support\Facades\Cache;

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
    public function getRecord($id, $shouldCache = true)
    {
        $cacheKey = "ticket-{$id}";

        return Cache::rememberForever($cacheKey, function () use ($id) {
            return Ticket::id($id)->first();
        });
    }
    
    /**
     * Load Relationships
     *
     * @return void
     */
    public function loadCommentRelationships()
    {
        if (isset($this->ticket) && $this->ticket) {
            $this->ticket->load([
                'reporter',
                'comments' => function($query) {
                    $query->orderBy('created_at', 'asc');
                },
                'comments.commentable'
            ]);
        }
    }
    
    /**
     * Clear Ticket Data from Cache
     *
     * @param  mixed $ticketId
     * @return void
     */
    public function clearDataFromCache($ticketId = false)
    {
        $ticketId = $ticketId ?: $this->ticket->id;
        $cacheKey = "ticket-{$ticketId}";

        if (Cache::has($cacheKey)) {
            Cache::forget($cacheKey);
        }
    }
}