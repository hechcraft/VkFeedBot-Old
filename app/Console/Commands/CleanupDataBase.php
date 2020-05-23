<?php

namespace App\Console\Commands;

use App\Import;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CleanupDataBase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'posts:cleanup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cleanup DataBase';

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
        $imports = Import::with('posts')
            ->whereBetween('created_at', [Carbon::now()->startOfMonth()->subMonth(2),
                Carbon::now()->startOfMonth()->subMonth(1)])
            ->get();
        foreach ($imports as $import) {
            $import->posts()->delete();
            $import->delete();
        }
    }
}
