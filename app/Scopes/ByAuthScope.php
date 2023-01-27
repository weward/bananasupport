<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class ByAuthScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {
        // If user, restrict to own tickets
        $user = auth()->guard('web')->user();

        $builder->when($user, function ($q) use ($user) {
            $q->where('user_id', $user->id);
        });
    }
}
