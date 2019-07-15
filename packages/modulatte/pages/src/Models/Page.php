<?php

namespace Modulatte\Pages\Models;

use App\Models\Abstracts\Undeletable;
use App\Models\Traits\Hideable;
use App\Models\Traits\Sluggable;
use App\Models\Traits\Sortable;
use Modulatte\Pages\PagesServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;

/**
 * App\Models\Page
 *
 * @property integer $id
 * @property integer $parent_id
 * @property string $title
 * @property string $slug
 * @property string $form
 * @property string $data
 * @property integer $sort_order
 * @property boolean $is_enabled
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 */
class Page extends Undeletable
{
    use Sluggable;
    use Sortable;
    use Hideable;

    const DEFAULT_FORM = '_standard';
    const DEFAULT_LAT = -36.848729;
    const DEFAULT_LNG = 174.763376;

    protected $casts = [
        'data' => 'array',
    ];

    protected $fillable = [
        'parent_id',
        'title',
        'slug',
        'form',
        'data',
        'sort_order',
        'is_dynamic',
        'is_enabled',
    ];

    public static function boot() {
        parent::boot();

        /*
         * This will make the polymorphic relation (images etc) be Page instead of Modulatte\Pages\Page
         * This means the models can be easily extended without having to worry about namespacing
         */
        Relation::morphMap([
            'Page' => Page::class,
        ]);

        self::creating(function($model) {
            if (empty($model->form))
                $model->form = self::DEFAULT_FORM;
        });

        self::saving(function($model) {
            $model->form = (!empty($model->form) ? $model->form : null);
            $model->data = (!empty($model->data) ? $model->data : null);
            $model->parent_id = (!empty($model->parent_id) ? $model->parent_id : null);
        });

        self::deleting(function($model) {
            if ($model->image)
                $model->image->delete();

            $model->images->each(function($model1) {
                $model1->delete();
            });
        });
    }

    #####--------------------------------------------------------------------------------------------------------------#####
    #                                                  PUBLIC FUNCTIONS START
    #####--------------------------------------------------------------------------------------------------------------#####
    /**
     * @param $slug
     * @return mixed
     */
    public static function get($slug)
    {
        return self::where('slug', $slug)->first();
    }

    /**
     * @return string
     */
    public static function formPath()
    {
        return resource_path('views/vendor/' . PagesServiceProvider::NAME_SPACE . '/forms');
    }

    public function hasChildren()
    {
        return (bool)$this->children()->first();
    }

    public function hasSections()
    {
        return (bool)$this->sections()->first();
    }

    #####--------------------------------------------------------------------------------------------------------------#####
    #                                                       RELATIONS START
    #####--------------------------------------------------------------------------------------------------------------#####

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
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function seo()
    {
        return $this->morphOne('App\Models\Seo', 'seoable');
    }

    /**
     * @return array|\Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sections()
    {
        if (class_exists('Modulatte\Sections\Models\Section'))
            return $this->hasMany('Modulatte\Sections\Models\Section');

        return [];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children()
    {
        return $this->hasMany('Modulatte\Pages\Models\Page', 'parent_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo('Modulatte\Pages\Models\Page', 'parent_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function downloads()
    {
        return $this->morphMany('Modulatte\Downloads\Models\Download', 'downloadable');
    }

    public function categories()
    {
        return $this->belongsToMany('App\Models\ProjectCategory', 'categories_project');
    }
}
