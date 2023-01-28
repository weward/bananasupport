<?php

namespace App\Models;

use App\Traits\HasReadableDates;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasReadableDates;

    protected $table = "users";

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'active',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
        'readable_created_at',
        'readable_updated_at',
        'status_label',
    ];

    /**
     * Get all of the User's tickets
     */
    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    /**
     * Get all of the User's comments.
     */
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function scopeId($query, $id)
    {
        $query->where('id', $id);
    }

    public function scopeSearch($query, $value = '')
    {
        $query->where(function($q) use ($value) {
            $q->where('name', 'like', "%{$value}%");
            $q->orWhere('email', 'like', "%{$value}%");
        });
    }

    /**
     * Get all active users
     */
    public function scopeActive($query)
    {
        $query->where('active', 1);
    }

    /**
     * Get all active users
     */
    public function scopeInactive($query)
    {
        $query->where('active', 0);
    }

    /**
     * Get all users based on their status
     */
    public function scopeStatus($query, $status)
    {
        $status = ($status == 'inactive' || $status === 0) ? 0 : 1;
        $query->where('active', $status);
    }

    /**
     * Sort By a specific Column
     *
     * @param  QueryBuilder $query
     * @param  string       $col
     * @param  string       $orderBy
     * @return void
     */
    public function scopeFilterOrder($query, $col = 'created_at', $sortBy = 'DESC')
    {
        $query->orderBy($col, $sortBy);
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
                    'active' => $query->status($value),
                    'orderBy' => $query->filterOrder($value, $params['sortBy']),
                    default => '',
                };
            }
        }
    }

    /**
     * Create status_label attribute
     *
     * @return string
     */
    public function getStatusLabelAttribute()
    {
        return $this->active ? "Active" : "Inactive";
    }

}
