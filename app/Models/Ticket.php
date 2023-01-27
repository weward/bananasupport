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
        'has_been_updated',
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
     * @param  QueryBuilder $query
     * @return void
     */
    public function scopeId($query, $id)
    {
        $query->where('id', $id);
    }

    /**
     * Get tickets of User
     * 
     * @param  QueryBuilder $query
     * @return void
     */
    public function scopeUserId($query, $userId)
    {
        $query->where('user_id', $userId);
    }

    /**
     * Get all active tickets
     * 
     * @param  QueryBuilder $query
     * @return void
     */
    public function scopeActive($query)
    {
        $query->where('status', 1);
    }

    /**
     * Get all closed tickets 
     * 
     * @param  QueryBuilder $query
     * @return void
     */
    public function scopeClosed($query)
    {
        $query->where('status', 0);
    }

    /**
     * Get all tickets by provided status
     * 
     * @param  QueryBuilder $query
     * @return void
     */
    public function scopeStatus($query, $status)
    {
        $status = ($status == 'closed') ? 0 : 1;
        $query->where('status', $status);
    }
    
    /**
     * Query Owner/author of ticket
     *
     * @param  QueryBuilder $query
     * @return void
     */
    public function scopeOwner($query)
    {
        $query->where('user_id', auth()->guard('web')->user()->id);
    }
    
    /**
     * Query Filter
     *
     * @param  QueryBuilder $query
     * @param  array        $params
     * @return void
     */
    public function scopeFilter($query, $params)
    {
        foreach ($params as $key => $value) {
            if ($value) {
                match ($key) {
                    'status' => $query->status($value),
                    'sortBy' => $query->filterOrder($value, $params['orderBy']),
                    'is_user' => $query->owner(),
                    default => '',
                };
            }
        }
    }
    
    /**
     * Sort By a specific Column
     *
     * @param  QueryBuilder $query
     * @param  string       $col
     * @param  string       $sortBy
     * @return void
     */
    public function scopeFilterOrder($query, $col = 'created_at', $sortBy='DESC')
    {
        $query->orderBy($col, $sortBy);
    }
    
    /**
     * Create status_label attribute
     *
     * @return string
     */
    public function getStatusLabelAttribute()
    {
        return $this->status ? "Open" : "Closed";
    }
    
    /**
     * Create id_label attribute
     * Ticket ID
     *
     * @return string
     */
    public function getIdLabelAttribute()
    {
        $prependedId = sprintf("%012d", $this->id);
        $currYear = $this->created_at->copy()->format('Y');

        return $currYear . "-" . $prependedId;
    }

        
    /**
     * Create has_been_updated attribute
     * For checking if record has been updated
     * 
     * @return void
     */
    public function getHasBeenUpdatedAttribute()
    {
        return ($this->updated_at->copy()->ne($this->created_at->copy()));
    }

}
