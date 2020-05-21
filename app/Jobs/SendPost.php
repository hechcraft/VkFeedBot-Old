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

    protected $botman;
    public $posts;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($chunk)
    {
        $this->botman = resolve('botman');
        $this->posts = VkFeed::whereIn('id', $chunk)->get();
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws \Exception
     */
    public function handle()
    {
        if (!$this->posts) {
            return;
        }
        foreach ($this->posts->sortKeysDesc() as $post) {
            $messages = PostFactory::make($post->post_json, $post->telegram_id);
            $messages->each(function ($message) use ($post) {
                $this->botman->say($message->getMessage(), $post->telegram_id, TelegramDriver::class);
            });
            $post->post_json = "false";
            $post->save();
        }
    }
}
