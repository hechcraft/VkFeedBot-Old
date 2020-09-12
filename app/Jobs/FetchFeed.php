<?php

namespace App\Jobs;

use App\Import;
use App\Services\Hasher;
use App\VkFeed;
use App\VkGroupName;
use App\VkOauth;
use App\VkUserName;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class FetchFeed implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $user;

    /** @var Import */
    protected $import;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($id)
    {
        $this->user = VkOauth::find($id);
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws \Exception
     */
    public function handle()
    {
        if (is_null(Import::where('telegram_id', $this->user->telegram_id)->first())) {
            $vkUrl = str_replace('postsAmount', 10, config('services.vk.url')) . $this->user->vk_token;
        } else {
            $vkUrl = str_replace('postsAmount', 100, config('services.vk.url')) . $this->user->vk_token;
        }
        $response = json_decode(file_get_contents($vkUrl));

        $this->import = Import::create([
            'telegram_id' => $this->user->telegram_id,
        ]);
        $count = $this->savePosts(data_get($response, 'response.items', []));

        if (!$count) {
            $this->import->delete();
            return;
        }

        $this->import->posts_count = $count;
        $this->import->save();

        $this->saveGroups(data_get($response, 'response.groups', []));
        $this->saveUsers(data_get($response, 'response.profiles', []));
    }

    private function saveGroups(array $groups = [])
    {
        $existingGroups = VkGroupName::pluck('vk_id_group');
        foreach ($groups as $group) {
            if (!$existingGroups->contains($group->id)) {
                $this->import->groups()->create([
                    'vk_id_group' => $group->id,
                    'vk_group_name' => $group->name,
                ]);

                $existingGroups->push($group->id);
            }
        }
    }

    private function saveUsers(array $users = [])
    {
        $existingUsers = VkUserName::pluck('vk_id_user');
        foreach ($users as $user) {
            if (!$existingUsers->contains($user->id)) {
                $this->import->users()->create([
                    'vk_id_user' => $user->id,
                    'vk_name_user' => $user->first_name . ' ' . $user->last_name,
                ]);

                $existingUsers->push($user->id);
            }
        }
    }

    private function savePosts(array $posts)
    {
        $countPosts = 0;
        $postsMd5 = $this->user->posts()->pluck('md5_hash_post');
        foreach ($posts as $post) {
            $md5 = Hasher::makeFromPost($post);

            $vkFeed = new VkFeed([
                'telegram_id' => $this->user->telegram_id,
                'post_json' => $post,
                'md5_hash_post' => $md5,
                'import_id' => $this->import->id,
            ]);

            if ($postsMd5->contains($md5)) {
                $this->import->posts_count = $countPosts;
                $this->import->save();
                return $countPosts;
            }

            $vkFeed->save();

            $countPosts++;
        }

        return $countPosts;
    }
}
