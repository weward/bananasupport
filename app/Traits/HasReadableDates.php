<?php 

namespace App\Traits;

trait HasReadableDates
{
    public $timezone = "Asia/Manila";

    /**
     * Get the Ticket's created_at attribute in human-readable format
     */
    public function getReadableCreatedAtAttribute()
    {
        return $this->created_at->copy()->setTimezone($this->timezone)->diffForHumans();
    }

    /**
     * Get the Ticket's updated_at attribute in human-readable format
     */
    public function getReadableUpdatedAtAttribute()
    {
        return $this->updated_at->copy()->setTimezone($this->timezone)->diffForHumans();
    }

    public function getFormattedCreatedAtAttribute()
    {
        return $this->created_at->copy()->setTimezone($this->timezone)->format('m/d/Y G:i A');
    }

}