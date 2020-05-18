<?php

namespace App\Console\Commands;

use App\Jobs\FetchFeed;
use App\Services\Hasher;
use App\VkFeed;
use App\VkGroupName;
use App\VkOauth;
use App\VkUserName;
use Illuminate\Console\Command;

class FetchPosts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'posts:fetch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command fetches posts';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */

    public function handle()
    {
        VkOauth::pluck('id')
            ->each(function ($id) {
                FetchFeed::dispatch($id);
            });
    }
}

