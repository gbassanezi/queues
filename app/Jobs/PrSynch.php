<?php

namespace App\Jobs;

use App\Models\PullRequests;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class PrSynch implements ShouldQueue
{
    use Queueable;

    public function __construct(public ?int $page = 1)
    {

    }

    public function handle(): void
    {
        $url = 'https://api.github.com/repos/laravel/laravel/pulls?state=all&page=';
        $requestResponse = Http::get($url . $this->page);

        $request = $requestResponse->json();

        if(empty($request)){
            return;
        }

            foreach ($request as $pr) {
                PullRequestStore::dispatch($pr);
            }
            PrSynch::dispatch($this->page + 1);
    }

}
