<?php

namespace App\Jobs;

use App\Post\PostFactory;
use App\VkFeed;
use App\VkGroupName;
use App\VkUserName;
use BotMan\Drivers\Telegram\TelegramDriver;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendPost implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /** @var VkFeed */
    public $post;

    protected $botman;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($id)
    {
        $this->botman = resolve('botman');
        $this->post = VkFeed::where('id', $id)->first();
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws \Exception
     */
    public function handle()
    {
        if (!$this->post) {
            return;
        }
        $user = $this->post->user;

        $messages = PostFactory::make($this->post->post_json, $user->telegram_id);

        $messages->each(function ($message) use ($user) {
            $this->botman->say($message->getMessage(), $user->telegram_id, TelegramDriver::class);
        });

        $this->post->delete();
    }
}
