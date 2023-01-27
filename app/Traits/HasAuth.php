<?php

namespace App\Traits;

use App\Models\Admin;
use App\Models\User;

trait HasAuth
{
    public function isAdmin()
    {
        return auth()->user() instanceof Admin;
    }
}
