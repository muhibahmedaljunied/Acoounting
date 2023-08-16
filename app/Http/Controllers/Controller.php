<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

// use App\Traits\Staff\TemporaleTrait;
// use App\Traits\Staff\Sanction\SanctionTrait;


class Controller extends BaseController
{

   
    
    // use TemporaleTrait,SanctionTrait;
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
