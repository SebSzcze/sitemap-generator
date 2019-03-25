<?php

namespace Ably\Sitemap\Jobs;

use Ably\Sitemap\Providers\SitemapFileProvider;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class GenerateSitemapJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    /**
     * @var string
     */
    private $model;
    /**
     * @var int
     */
    private $chunk;

    /**
     * Create a new job instance.
     *
     * @param string $model
     * @param int    $chunk
     */
    public function __construct(string $model, int $chunk)
    {
        $this->model = $model;
        $this->chunk = $chunk;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $offset = config('sitemap.chunk_size') * ($this->chunk - 1);
        
        $items = $this->model::publishedForSitemap()->skip($offset)->take(config('sitemap.chunk_size'))->get();

        $data = view('sitemap::map')->with([
            'items' => $items
        ]);
        
        app(SitemapFileProvider::class)->createMap($this->model, $this->chunk, (string)$data);
    }
}
