<?php

namespace App\Models;

use App\Traits\HasReadableDates;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;
    use HasReadableDates;

    protected $table = "tickets";

    protected $with = [
        "reporter",
    ];

    protected $appends = [
        'id_label',
        'readable_created_at',
        'readable_updated_at',
        'status_label',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    /**
     * Get the ticket's reporter
     */
    public function reporter()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    /**
     * Get the ticket's comments
     */
    public function comments()
    {
        return $this->hasmany(Comment::class);
    }

    /**
     * Get ticket by ID
     */
    public function scopeId($query, $id)
    {
        $query->where('id', $id);
    }

    /**
     * Get tickets of User
     */
    public function scopeUserId($query, $userId)
    {
        $query->where('user_id', $userId);
    }

    /**
     * Get all active tickets
     */
    public function scopeActive($query)
    {
        $query->where('status', 1);
    }

    /**
     * Get all closed tickets 
     */
    public function scopeClosed($query)
    {
        $query->where('status', 0);
    }

    /**
     * Get all tickets by provided status
     */
    public function scopeStatus($query, $status)
    {
        $query->where('status', $status);
    }

    public function scopeOwner($query)
    {
        $query->where('user_id', auth()->guard('web')->user()->id);
    }

    public function getStatusLabelAttribute()
    {
        return $this->status ? "Open" : "Closed";
    }

    public function getIdLabelAttribute()
    {
        $prependedId = sprintf("%012d", $this->id);
        $currYear = $this->created_at->copy()->format('Y');

        return $currYear . "-" . $prependedId;
    }

}
