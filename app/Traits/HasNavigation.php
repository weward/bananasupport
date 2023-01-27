<?php

namespace App\Traits;

use App\Models\Admin;
use App\Models\User;

trait HasNavigation
{
    public function goToRoute($route= "dashboard")
    {
        $route = (auth()->guard('admin')->check()) ? "admin.{$route}" : $route;
        
        return redirect()->route($route);
    }
}
