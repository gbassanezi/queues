<?php

namespace App\Console\Commands;

use App\Jobs\PrSynch;
use Illuminate\Console\Command;

class PullRequestsSync extends Command
{
    protected $signature = 'app:prs {repository}';

    protected $description = 'repository full name';

    public function handle()
    {
        PrSynch::dispatch($this->argument('repository'));
    }
}
