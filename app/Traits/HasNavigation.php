<?php

namespace App\Traits;

use App\Models\Admin;
use App\Models\User;

trait HasNavigation
{
    public function goToRoute($route= "dashboard")
    {
        return redirect()->route($route);
    }
}
