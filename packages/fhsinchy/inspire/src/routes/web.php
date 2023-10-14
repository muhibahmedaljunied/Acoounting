<?php

use Fhsinchy\Inspire\Controllers;
use Fhsinchy\Inspire\Controllers\InspirationController;
use Illuminate\Support\Facades\Route;

Route::get('inspire', InspirationController::class);