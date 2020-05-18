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
use Illuminate\Support\Facades\Log;

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
     */
    public function handle()
    {
        if (is_null(Import::where('telegram_id', $this->user->telegram_id)->first())) {
            $vkUrl = config('services.vk.startUrl') . $this->user->vk_token;
        } else {
            $vkUrl = config('services.vk.url') . $this->user->vk_token;
        }
        $response = json_decode(file_get_contents($vkUrl));

        $this->import = Import::create([
            'telegram_id' => $this->user->telegram_id,
        ]);
        $this->saveGroups(data_get($response, 'response.groups', []));
        $this->saveUsers(data_get($response, 'response.profiles', []));
        $this->savePosts(data_get($response, 'response.items', []), $this->user);
    }

    private function saveGroups(array $groups = [])
    {
        foreach ($groups as $group) {
            $this->import->groups()->create([
                'telegram_id' => $this->user->telegram_id,
                'vk_id_group' => $group->id,
                'vk_group_name' => $group->name,
            ]);
        }
    }

    private function saveUsers(array $users = [])
    {
        foreach ($users as $user) {
            $this->import->users()->create([
                'telegram_id' => $this->user->telegram_id,
                'vk_id_user' => $user->id,
                'vk_name_user' => $user->first_name . ' ' . $user->last_name,
            ]);
        }
    }

    private function savePosts(array $posts, VkOauth $user)
    {
        $countPosts = 0;
        $allMd5 = collect([]);
        $userMd5s = unserialize($user->all_md5);
        foreach ($posts as $post) {
            $md5 = Hasher::makeFromPost($post->date, $post->text ?? ' ');

            $allMd5->push($md5);

            foreach ($userMd5s as $postMd5) {
                if ($postMd5 === $md5) {
                    $this->import->posts_count = $countPosts;
                    $this->import->save();

                    $user->all_md5 = serialize($allMd5);
                    $user->save();
                    return true;
                }
            }

            $vkFeed = new VkFeed([
                'telegram_id' => $this->user->telegram_id,
                'post_json' => $post,
                'md5_hash_post' => $md5,
                'import_id' => $this->import->id,
            ]);

            $countPosts++;

            if ($countPosts === 0 || is_null($countPosts)) {
                $this->import->posts_count = $countPosts;
                $this->import->delete();
            }

            $vkFeed->save();
        }
        $this->import->posts_count = $countPosts;
        $this->import->save();
    }
}
