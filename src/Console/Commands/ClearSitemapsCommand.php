<?php

namespace Ably\Sitemap\Console\Commands;

use Ably\Sitemap\Providers\SitemapFileProvider;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class ClearSitemapsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear sitemaps';
    /**
     * @var Filesystem
     */
    private $filesystem;
    /**
     * @var SitemapFileProvider
     */
    private $fileProvider;

    /**
     * Create a new command instance.
     *
     * @param Filesystem          $filesystem
     * @param SitemapFileProvider $fileProvider
     */
    public function __construct(Filesystem $filesystem, SitemapFileProvider $fileProvider)
    {
        parent::__construct();

        $this->filesystem = $filesystem;
        $this->fileProvider = $fileProvider;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
       $files = collect($this->fileProvider->getStorage()->files(
           $this->fileProvider->getPath()
       ))->filter(function ($name){
           return !str_contains($name, '.gitignore');
       });

        $this->fileProvider->getStorage()->delete($files->toArray());
        
        $this->comment(sprintf('Removed %d files', $files->count()));
    }
}
