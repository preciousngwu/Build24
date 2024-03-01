<?php

namespace App\Http\Controllers;

use App\Interfaces\ApiRouteInterface;

class Courses extends Controller
{
    public function __invoke(ApiRouteInterface $action)
    {
        return $action->do();
    }
}
