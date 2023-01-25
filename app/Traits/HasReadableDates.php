<?php 

namespace App\Traits;

trait HasReadableDates
{
    /**
     * Get the Ticket's created_at attribute in human-readable format
     */
    public function getReadableCreatedAtAttribute()
    {
        return $this->created_at->copy()->diffForHumans();
    }

    /**
     * Get the Ticket's updated_at attribute in human-readable format
     */
    public function getReadableUpdatedAtAttribute()
    {
        return $this->updated_at->copy()->diffForHumans();
    }

}