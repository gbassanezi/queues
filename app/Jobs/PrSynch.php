<?php

namespace App\Jobs;

use Illuminate\Support\Facades\Http;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class PrSynch implements ShouldQueue
{
    use Queueable;

    public function __construct(public ?int $page = 1) {}

    public function handle(): void
    {
        //prepare the url
        $url = 'https://api.github.com/repos/laravel/laravel/pulls?state=all&page=' . $this->page;

        //send the request with auth via git psa token to increate rate-limiting
        $requestResponse = Http::withToken(config('services.github.personal_access_token'))->get($url);

        //convert the request into json
        $request = $requestResponse->json();

        //if the request return an empty array just stop
        if(empty($request)){
            return;
        }

            //foreach request response dispatch a job which persists each one in database
            foreach ($request as $pullrequests) {
                PullRequestStore::dispatch($pullrequests);
            }
        //increase the page with the parameter PAGE, so we can sync every page listed
        PrSynch::dispatch($this->page + 1);
    }

}
