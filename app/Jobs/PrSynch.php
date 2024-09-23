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
        $requestResponse = Http::get('https://api.github.com/repos/laravel/laravel/pulls?state=all&page=' . $this->page);

        $request = $requestResponse->json();

        if(empty($request)){
            return;
        }

            foreach ($request as $pr) {
                PullRequests::create([
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
            PrSynch::dispatch($this->page + 1);
    }

}
