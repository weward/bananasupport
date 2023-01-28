<?php

namespace App\Traits;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

trait HasUsers
{
    public $user;

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
        $cacheKey = "user-{$id}";

        return Cache::rememberForever($cacheKey, function () use ($id) {
            return User::id($id)->first();
        });
    }

    /**
     * Clear Ticket Data from Cache
     *
     * @param  mixed $ticketId
     * @return void
     */
    public function clearDataFromCache($userId = false)
    {
        $userId = $userId ?: $this->user->id;
        $cacheKey = "user-{$userId}";

        if (Cache::has($cacheKey)) {
            Cache::forget($cacheKey);
        }
    }

    public function loadRelationships($limit = 0)
    {
        $this->user->load([
            'tickets' => function($q) {
                $q->orderBy('created_at', 'desc');
            } 
        ]);

        if ($limit) {
            $this->user->tickets = $this->user->tickets->take(10);
        }
    }

}
