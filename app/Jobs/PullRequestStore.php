<?php

namespace App\Jobs;

use App\Models\PullRequests;
use Illuminate\Support\Carbon;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class PullRequestStore implements ShouldQueue
{
    use Queueable;

    public function __construct(public array $pr){}

    public function handle(): void
    {
        PullRequests::create([
            'api_id' => $this->pr['id'],
            'api_number' => $this->pr['number'],
            'state' => $this->pr['state'],
            'title' => $this->pr['title'],
            'api_created_at' => Carbon::parse($this->pr['created_at'])->format('Y-m-d H:i:s'),
            'api_updated_at' => Carbon::parse($this->pr['updated_at'])->format('Y-m-d H:i:s'),
            'api_closed_at' => Carbon::parse($this->pr['closed_at'])->format('Y-m-d H:i:s'),
            'api_merged_at' => Carbon::parse($this->pr['merged_at'])->format('Y-m-d H:i:s')
        ]);
    }
}
