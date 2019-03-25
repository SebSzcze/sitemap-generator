<?php

namespace Ably\Sitemap\Jobs;

use Ably\Sitemap\Providers\SitemapFileProvider;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class GenerateSitemapsIndexJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    /**
     * @var array
     */
    private $sitemaps;

    /**
     * Create a new job instance.
     *
     * @param array $sitemaps
     */
    public function __construct(array $sitemaps)
    {
        $this->sitemaps = $sitemaps;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        /** @var SitemapFileProvider $fileProvider */
        $fileProvider = app(SitemapFileProvider::class);

        $map = collect($this->sitemaps)->mapWithKeys(function ($data, $model) use ($fileProvider) {
            $files = [];

            $index = 1;
            while ($index <= $data['count']) {
                $files[] = [
                    'name' => $fileProvider->getChunkFileName($model, $index),
                    'date' => $data['date'],
                ];
                ++$index;
            }

            return [$model => $files];
        });

        $data = view('sitemap::index')->with([
            'items' => $map,
        ]);

        $fileProvider->create(config('sitemap.sitemap_index_uri'), (string)$data);
    }
}
