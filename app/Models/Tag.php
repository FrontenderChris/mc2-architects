<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Tag
 *
 * @property integer $id
 * @property string $name
 * @property string $slug
 * @property string $category
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class Tag extends Model
{
    const CATEGORY_BLOG = 'blog';

    protected $fillable = [
        'name',
        'slug',
        'category',
    ];

    public static function listTagsHtml($html, $tagsArray)
    {
        $data = '';
        foreach ($tagsArray as $tag)
            $data .= sprintf($html, $tag->title);

        return $data;
    }

    /**
     * @param null $category
     * @return mixed
     */
    public static function getList($category = null)
    {
        if (empty($category))
            $tags = self::lists('name', 'id')->all();
        else
            $tags = self::where('category', $category)->lists('name', 'id')->toArray();

        return $tags;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function blogPosts()
    {
        return $this->belongsToMany('App\Models\Blog', 'blog_tags');
    }
}
