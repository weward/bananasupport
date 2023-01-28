<?php

namespace App\Models;

use App\Scopes\ByAuthScope;
use App\Traits\HasReadableDates;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;
    use HasReadableDates;

    protected $table = "tickets";

    public $timezone = "Asia/Manila";
    
    protected $with = [
        "reporter",
    ];
    
    protected $appends = [
        'id_label',
        'readable_created_at',
        'readable_updated_at',
        'formatted_created_at',
        'status_label',
        'has_been_updated',
    ];
    
    protected $dates = [
        'created_at',
        'updated_at',
    ];
    
    protected $guarded = [];
    
    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        // Fetch tickets by User type (User | Admin)
        static::addGlobalScope(new ByAuthScope);
    }

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

    public function scopeTicket($query, $value)
    {
        $id = substr($value, 5); // remote year
        $id = ltrim($id, "0");  // Remote prepended zeroes

        $query->where('id', $id);
    }
    
    
    /**
     * Search
     *
     * @param  QueryBuiilder $query
     * @param  string       $value
     * @return void
     */
    public function scopeSearch($query, $value = '')
    {
        $query->ticket($value);
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
        $status = ($status == 'closed' || $status == 0) ? 0 : 1;
        $query->where('status', $status);
    }
        
    /**
     * Filter Tickets by Auth Type
     * User vs Admin
     *
     * @param  mixed $query
     * @return void
     */
    public function scopeByAuth($query)
    {
        // If user, restrict to own tickets
        // $user = auth()->guard('web')->user();
        $user = auth()->guard('web')->check();


        $query->when($user, function($q) use ($user) {
            $q->owner($user->id);
        });
    }

    /**
     * Query Owner/author of ticket
     *
     * @param  QueryBuilder $query
     * @return void
     */
    public function scopeOwner($query, $userId = '')
    {
        $userId = $userId ?: auth()->guard('web')->user()->id;
        $query->where('user_id', $userId);
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
                    'search' => $query->search($value),
                    'status' => $query->status($value),
                    'orderBy' => $query->filterOrder($value, $params['sortBy']),
                    default => '',
                };
            }
        }

        if (!in_array('sortBy', $params)) {
            $query->orderBy('created_at', 'DESC');
        }
    }
    
    /**
     * Sort By a specific Column
     *
     * @param  QueryBuilder $query
     * @param  string       $col
     * @param  string       $orderBy
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
        $currYear = $this->created_at->copy()->setTimezone($this->timezone)->format('Y');

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
        return ($this->updated_at->copy()->setTimezone($this->timezone)->ne($this->created_at->copy()));
    }

}
