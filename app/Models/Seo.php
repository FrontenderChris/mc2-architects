<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;

/**
 * App\Models\Seo
 *
 * @property integer $id
 * @property integer $seoable_id
 * @property string $seoable_type
 * @property string $title
 * @property string $keywords
 * @property string $description
 * @property string $og_title
 * @property string $og_description
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\Seo $seoable
 */
class Seo extends Model
{
    protected $table = 'seo';

    protected $fillable = [
        'title',
        'keywords',
        'description',
        'og_title',
        'og_description',
    ];

    public static function boot() {
        parent::boot();

        self::saving(function($model) {
            $model->title = (empty($model->title) ? null : strip_tags($model->title));
            $model->keywords = (empty($model->keywords) ? null : $model->keywords);
            $model->description = (empty($model->description) ? null : $model->description);
            $model->og_title = (empty($model->og_title) ? null : strip_tags($model->og_title));
            $model->og_description = (empty($model->og_description) ? null : $model->og_description);
        });

        self::deleting(function($model) {
            if ($model->image)
                $model->image->delete();
        });
    }

    public static function saveSeo($model, $data)
    {
        $data['seo']['title'] = self::setTitle($data, 'title');
        $data['seo']['og_title'] = self::setTitle($data, 'og_title');

        if (!empty($data['seo'])) {
            if ($model->seo)
                $model->seo->update($data['seo']);
            else
                $model->seo = $model->seo()->save(new Seo($data['seo']));

            Image::uploadImage($model->seo, 'seo.og_image', 'image', ['title' => Input::get('seo.og_title')]);
        }

        return $model;
    }

    /**
     * Automatically add SEO title if none exists - copy from title/name of article
     * @param $data
     * @param $attribute
     * @return mixed
     */
    private static function setTitle($data, $attribute)
    {
        if (empty($data['seo'][$attribute]) && (!empty($data['title']) || !empty($data['name'])))
            return (!empty($data['title']) ? $data['title'] : $data['name']);

        return (!empty($data['seo'][$attribute]) ? $data['seo'][$attribute] : null);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function seoable()
    {
        return $this->morphTo();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function image()
    {
        return $this->morphOne('App\Models\Image', 'imageable');
    }
}
