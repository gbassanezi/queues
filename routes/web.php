<?php

use App\Models\PullRequests;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $response = Http::get('https://api.github.com/repos/laravel/laravel/pulls?state=all');

    foreach ($response->json() as $pr) {
        PullRequests::updateOrCreate([
            'api_id' => $pr['id'],
            'api_number' => $pr['number'],
            'state' => $pr['state'],
            'title' => $pr['title'],
            'api_created_at' => Carbon::parse($pr['created_at'])->format('Y-m-d H:i:s'),
            'api_updated_at' => Carbon::parse($pr['updated_at'])->format('Y-m-d H:i:s'),
            'api_closed_at' => Carbon::parse($pr['closed_at'])->format('Y-m-d H:i:s'),
            'api_merged_at' => Carbon::parse($pr['merged_at'])->format('Y-m-d H:i:s'),
        ]);
    }
});

// Route::get('/test', function(){
//     dd('fodase');
// });
