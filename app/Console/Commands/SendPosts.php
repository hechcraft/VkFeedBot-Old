<?php

namespace App\Console\Commands;

use App\Jobs\SendPost;
use App\Post\PostFactory;
use App\VkGroupName;
use App\VkOauth;
use App\VkUserName;
use BotMan\Drivers\Telegram\TelegramDriver;
use Illuminate\Console\Command;

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
        $users = VkOauth::with('posts')->get();

        foreach ($users as $user) {
            foreach ($user->posts as $post) {
                SendPost::dispatch($post->id);
            }

            if (!$user->posts()->count()) {
                VkUserName::where('telegram_id', $user->telegram_id)->delete();
                VkGroupName::where('telegram_id', $user->telegram_id)->delete();
            }
        }
    }
}
