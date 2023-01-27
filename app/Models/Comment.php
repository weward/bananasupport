<?php

namespace App\Models;

use App\Traits\HasReadableDates;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    use HasReadableDates;

    protected $table = "comments";

    protected $appends = [
        'readable_created_at',
        'readable_updated_at',
        'formatted_created_at',
        'is_admin',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $touches = ['ticket'];

    protected $guarded = [];


    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    /**
     * Get the parent commentable model (User or Admin).
     */
    public function commentable()
    {
        return $this->morphTo();
    }

    public function getIsAdminAttribute()
    {
        if ($this->commentable && $this->commentable instanceof Admin) {
            return true;
        }

        return false;
    }

}
