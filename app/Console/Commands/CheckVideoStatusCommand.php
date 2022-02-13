<?php

namespace App\Console\Commands;

use App\Models\Video;
use App\Services\VideoService;
use Illuminate\Console\Command;

class CheckVideoStatusCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'video:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @return int
     */
    public function handle()
    {
        $videos = Video::query()
            ->whereIn('status', [
                Video::STATUS_IN_PROCESS,
                Video::STATUS_IN_QUEUE,
                Video::STATUS_RENDERING,
            ])
            ->get();

        $videos->each(function ($video) {
            VideoService::checkStatus($video);
        });

        return 0;
    }
}
