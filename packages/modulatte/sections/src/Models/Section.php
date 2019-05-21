<?php

namespace Modulatte\Sections\Models;

use App\Models\Traits\Hideable;
use App\Models\Traits\Sortable;
use Illuminate\Database\Eloquent\Model;
use Modulatte\Sections\SectionsServiceProvider;

class Section extends Model
{
    use Sortable;
    use Hideable;

    const DEFAULT_FORM = '_standard';

    protected $casts = [
        'data' => 'array',
    ];

    protected $fillable = [
        'page_id',
        'title',
        'form',
        'data',
    ];

    public static function boot()
    {
        parent::boot();

        self::creating(function($model) {
            if (empty($model->form))
                $model->form = self::DEFAULT_FORM;
        });

        self::saving(function($model) {
            $model->title = (!empty($model->title) ? $model->title : null);
            $model->data = (!empty($model->data) ? $model->data : null);
        });

        self::deleting(function($model) {
            if ($model->image)
                $model->image->delete();

            $model->images->each(function($model1) {
                $model1->delete();
            });
        });
    }

    /**
     * @return string
     */
    public static function formPath()
    {
        return resource_path('views/vendor/' . SectionsServiceProvider::NAME_SPACE . '/forms');
    }

    /**
     * @param null $title
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function image($title = null)
    {
        if (!empty($title))
            return $this->morphOne('App\Models\Image', 'imageable')->where('title', '=', $title)->first();

        return $this->morphOne('App\Models\Image', 'imageable');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function images()
    {
        return $this->morphMany('App\Models\Image', 'imageable');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function page()
    {
        return $this->belongsTo('Modulatte\Pages\Models\Page');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function seo()
    {
        return $this->morphOne('App\Models\Seo', 'seoable');
    }
}
