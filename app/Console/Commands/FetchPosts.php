<?php

namespace App\Console\Commands;

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

    protected $telegramId;

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
        VkOauth::all()
            ->each(function ($user) {
                $vkToken = $user->vk_token;
                $telegramId = $user->telegram_id;

                $this->telegramId = $telegramId;

                $vkUrl = config('services.vk.url') . $vkToken;
                $response = json_decode(file_get_contents($vkUrl));

                $this->saveGroups(data_get($response, 'response.groups'));
                $this->saveUsers(data_get($response, 'response.profiles'));
                $this->savePosts(data_get($response, 'response.items'), $user);
            });
    }

    private function saveGroups(array $groups = [])
    {
        foreach ($groups as $group) {
            $groupName = new VkGroupName([
                'telegram_id' => $this->telegramId,
                'vk_id_group' => $group->id,
                'vk_group_name' => $group->name,
            ]);
            $groupName->save();
        }
    }

    private function saveUsers(array $users = [])
    {
        foreach ($users as $user) {
            $userName = new VkUserName([
                'telegram_id' => $this->telegramId,
                'vk_id_user' => $user->id,
                'vk_name_user' => $user->first_name . ' ' . $user->last_name,
            ]);
            $userName->save();
        }
    }

    private function savePosts(array $posts, VkOauth $user)
    {
        foreach ($posts as $post) {
            $md5 = Hasher::makeFromPost($post->date, $post->text ?? '');

            $vkFeed = new VkFeed([
                'telegram_id' => $this->telegramId,
                'post_json' => $post,
                'md5_hash_post' => $md5,
            ]);

            if ($user->last_post_id === $md5) {
                return;
            }

            $user->last_post_id = $md5;
            $user->save();

            $vkFeed->save();
        }
    }
}

