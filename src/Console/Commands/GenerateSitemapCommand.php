<?php

namespace Ably\Sitemap\Console\Commands;

use Ably\Sitemap\Jobs\GenerateSitemapJob;
use Ably\Sitemap\Jobs\GenerateSitemapsIndexJob;
use Illuminate\Console\Command;

class GenerateSitemapCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate sitemaps';

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
        $sitemaps = [];
        $sitemapsCount = 0;

        foreach (config('sitemap.models') as $model) {

            $updated = (new $model)->getUpdatedAtColumn();

            $count = $model::published()->count() / config('sitemap.chunk_size');
            $date = $model::published()->latest($updated)->first()->{$updated};

            $sitemaps[$model] = [
                'count' => (int)ceil($count),
                'date' => $date
            ];
        }
        
        foreach ($sitemaps as $model => $data) {
            $index = 1;
            while ($index <= $data['count']){
                GenerateSitemapJob::dispatch($model, $index);
                ++$sitemapsCount;
                ++$index;
            }
        }
        ++$sitemapsCount;
        GenerateSitemapsIndexJob::dispatch($sitemaps);
        
        $this->comment(sprintf('Pushed %d sitemaps for generation', $sitemapsCount));
    }
}
