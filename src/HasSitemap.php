<?php

namespace Ably\Sitemap;

use Illuminate\Database\Eloquent\Model;

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
    public function getModificationDate(): ?string
    {
        $column = $this->getUpdatedAtColumn();

        return $this->{$column};
    }

    /**
     * Should contain image urls
     * @return string[]
     */
    public function getSitemapsImages(): array
    {
        return [];
    }

    /**
     * @param $query
     * @return mixed|void
     */
    public function scopeRecentlyModified($query)
    {
        $column = $this->getUpdatedAtColumn();

        $model = $query->orderBy($column, 'DESC')->first();

        if (!$model instanceof Model) {
            return;
        }

        return $model->{$column};
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopePublishedForSitemap($query)
    {
        return $query;
    }
}
