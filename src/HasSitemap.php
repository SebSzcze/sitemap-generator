<?php

namespace Ably\Sitemap;

/**
 * @author    Sebastian Szczepański
 * @copyright ably
 */
trait HasSitemap
{
    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @return string
     */
    public function getModificationDate(): string
    {
        return $this->updated_at;
    }

    /**
     * Should contain image urls
     * @return string[]
     */
    public function getSitemapsImages(): array
    {
        return [];
    }
}
