<?php

namespace App\Console\Commands;

use App\Import;
use App\Jobs\FetchFeed;
use App\Jobs\SendPost;
use App\Post\PostFactory;
use App\VkFeed;
use App\VkGroupName;
use App\VkOauth;
use App\VkUserName;
use BotMan\Drivers\Telegram\TelegramDriver;
use Illuminate\Console\Command;
use Illuminate\Foundation\Bus\DispatchesJobs;


class SendPosts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'posts:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command sends posts to Telegram';

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
        $imports = Import::with(['groups', 'users', 'posts'])->get();
        foreach ($imports as $import) {
            foreach ($import->posts->chunk(20) as $chunk) {
                SendPost::dispatch($chunk->pluck('id'));
            }
            if (!$import->posts()->count()) {
                $import->users()->delete();
                $import->groups()->delete();
            }
        }
    }
}
