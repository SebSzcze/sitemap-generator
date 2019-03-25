<?php

namespace Ably\Sitemap\Providers;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * @author    Sebastian Szczepański
 * @copyright ably
 */
class SitemapFileProvider
{
    /**
     * @param string $filename
     * @return string
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function provide(string $filename)
    {
        $path = $this->getPath($filename);

        if (!$this->getStorage()->exists($path)) {
            abort(Response::HTTP_NOT_FOUND);
        }

        return $this->getStorage()->get($path);
    }

    /**
     * @return \Illuminate\Contracts\Filesystem\Filesystem
     */
    public function getStorage()
    {
        return Storage::disk(config('sitemap.storage.disk', 'local'));
    }

    /**
     * @param string|null $filename
     * @return null|string
     */
    public function getPath(string $filename = null): ?string
    {
        return Str::finish(config('sitemap.storage.path'), '/').$filename;
    }

    /**
     * @param string $model
     * @param int    $chunk
     * @return string
     */
    public function getChunkFileName(string $model, int $chunk)
    {
        $model = strtolower(class_basename($model));

        return str_replace(['{model}', '{chunk}'], [$model, $chunk], config('sitemap.sitemap_uri')).'.xml';
    }

    /**
     * @param string $model
     * @param int    $chunk
     * @param string $content
     * @return bool
     */
    public function createMap(string $model, int $chunk, string $content)
    {
        return $this->create($this->getChunkFileName($model, $chunk), $content);
    }

    /**
     * @param string $filename
     * @param string $content
     * @return bool
     */
    public function create(string $filename, string $content)
    {
        return $this->getStorage()->put($this->getPath($filename), $this->minify($content));
    }

    /**
     * @param string $content
     * @return null|string|string[]
     */
    public function minify(string $content)
    {
        $Search = array(
            '/(\n|^)(\x20+|\t)/',
            '/(\n|^)\/\/(.*?)(\n|$)/',
            '/\n/',
            '/\<\!--.*?-->/',
            '/(\x20+|\t)/', # Delete multispace (Without \n)
            '/\>\s+\</', # strip whitespaces between tags
            '/(\"|\')\s+\>/', # strip whitespaces between quotation ("') and end tags
            '/=\s+(\"|\')/'); # strip whitespaces between = "'

        $Replace = array(
            "\n",
            "\n",
            " ",
            "",
            " ",
            "><",
            "$1>",
            "=$1");

        return preg_replace($Search,$Replace,$content);
    }
}
