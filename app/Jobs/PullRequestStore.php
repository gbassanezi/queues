<?php

namespace App\Jobs;

use App\Models\PullRequests;
use Illuminate\Support\Carbon;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class PullRequestStore implements ShouldQueue
{
    use Queueable;

    public function __construct(public array $pullrequests){}

    public function handle(): void
    {
        PullRequests::updateOrCreate([
            'api_id' => $this->pullrequests['id'],
            'api_number' => $this->pullrequests['number'],
            'state' => $this->pullrequests['state'],
            'title' => $this->pullrequests['title'],
            'api_created_at' => Carbon::parse($this->pullrequests['created_at'])->format('Y-m-d H:i:s'),
            'api_updated_at' => Carbon::parse($this->pullrequests['updated_at'])->format('Y-m-d H:i:s'),
            'api_closed_at' => Carbon::parse($this->pullrequests['closed_at'])->format('Y-m-d H:i:s'),
            'api_merged_at' => Carbon::parse($this->pullrequests['merged_at'])->format('Y-m-d H:i:s')
        ]);
    }
}
