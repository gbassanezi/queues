<?php

use App\Jobs\PrSynch;
// use App\Models\PullRequests;
// use Illuminate\Support\Carbon;
// use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    PrSynch::dispatch();
});
