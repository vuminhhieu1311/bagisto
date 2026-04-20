<?php

namespace Webkul\Sitemap\Models;

use Illuminate\Support\Carbon;
use Spatie\Sitemap\Contracts\Sitemapable;
use Spatie\Sitemap\Tags\Url;
use Webbycrown\BlogBagisto\Models\Blog;
use Webbycrown\BlogBagisto\Models\Category as BlogCategory;

class BlogPost extends Blog implements Sitemapable
{
    /**
     * Get only active blog posts.
     */
    public function newQuery($excludeDeleted = true)
    {
        return parent::newQuery($excludeDeleted)->where('status', 1);
    }

    /**
     * To get the sitemap tag for the blog post.
     */
    public function toSitemapTag(): Url|string|array
    {
        if (! $this->slug) {
            return [];
        }

        $category = BlogCategory::find($this->default_category);

        $categorySlug = $category ? $category->slug : 'uncategorized';

        return Url::create(url('blog/' . $categorySlug . '/' . $this->slug))
            ->setLastModificationDate(Carbon::create($this->updated_at));
    }
}
