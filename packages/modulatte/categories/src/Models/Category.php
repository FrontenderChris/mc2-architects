<?php

namespace Modulatte\Categories\Models;

use App\Models\Traits\Hideable;
use App\Models\Traits\Sortable;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Sluggable;

/**
 * App\Models\Category
 *
 * @property integer $id
 * @property integer $parent_id
 * @property string $title
 * @property string $slug
 * @property string $data
 * @property integer $sort_order
 * @property boolean $is_enabled
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Modulatte\Categories\Models\Category $parent
 * @property-read \Illuminate\Database\Eloquent\Collection|\Modulatte\Categories\Models\Category[] $children
 * @property-read \Illuminate\Database\Eloquent\Collection|\Modulatte\Products\Models\Product[] $products
 * @method static \Illuminate\Database\Query\Builder|\Modulatte\Categories\Models\Category enabled()
 */
class Category extends Model
{
    use Sluggable;
    use Sortable;
    use Hideable;

    protected $table = 'categories';
    protected $casts = [
        'data' => 'array',
    ];
    protected $fillable = [
        'parent_id',
        'title',
        'slug',
        'data',
        'sort_order',
        'is_enabled',
    ];

    public static function boot() {
        parent::boot();

        self::saving(function($model) {
            $model->parent_id = (!empty($model->parent_id) ? $model->parent_id : null);
        });
    }

    #####--------------------------------------------------------------------------------------------------------------#####
    #                                                   GENERAL METHODS START
    #####--------------------------------------------------------------------------------------------------------------#####
    /**
     * @param bool $paginate
     * @return mixed
     */
    public static function getParentsOnly($paginate = false)
    {
        if ($paginate)
            return self::with('children')->whereNull('parent_id')->paginate($paginate);
        else
            return self::with('children')->whereNull('parent_id')->get();
    }

    /**
     * @return bool
     */
    public function hasChildren()
    {
        return (bool)$this->children()->first();
    }

    /**
     * @param bool $addBlank
     * @param string $blankTitle
     * @return array
     */
    public static function getList($addBlank = false, $blankTitle = 'Choose Parent')
    {
        if ($addBlank)
            return [''=>$blankTitle] + Category::lists('title', 'id')->all();
        else
            return Category::lists('title', 'id')->all();
    }

    public static function getParentList($addBlank = false)
    {
        if ($addBlank)
            return [''=>'Choose Top Category'] + Category::whereNull('parent_id')->lists('title', 'id')->all();
        else
            return Category::lists('title', 'id')->all();
    }

    public static function getListBySlug()
    {
        return [0 => 'All Categories'] + Category::enabled()->lists('title', 'slug')->all();
    }

    public static function getParentListBySlug()
    {
        return [0 => 'All Categories'] + Category::whereNull('parent_id')->enabled()->lists('title', 'slug')->all();
    }

    public static function getListByName()
    {
        $categories = Category::getList();
        $catList = array();
        if ($categories) {
            foreach ($categories as $value) {
                $catList[$value] = $value;
            }
        }
        return $catList;
    }

    public static function getBySlug($slug)
    {
        return Category::with('products', 'image', 'seo')->where('slug', '=', $slug)->first();
    }

    public static function getColorPalette()
    {
        $categories = self::whereNotNull('hex')->groupBy('hex')->get();

        $data = [];
        foreach ($categories as $model)
            $data[] = $model->hex;

        return json_encode($data);
    }
    #####--------------------------------------------------------------------------------------------------------------#####
    #                                                       SCOPES START
    #####--------------------------------------------------------------------------------------------------------------#####
    /**
     * This will provide only enabled items (for frontend).
     * To use simply call Product::enabled()->get();
     *
     * @param $query
     * @return mixed
     */
    public function scopeEnabled($query)
    {
        return $query->where('is_enabled', 1);
    }

    #####--------------------------------------------------------------------------------------------------------------#####
    #                                                   RELATIONS START
    #####--------------------------------------------------------------------------------------------------------------#####
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function parent()
    {
        return $this->belongsTo('Modulatte\Categories\Models\Category', 'parent_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function children()
    {
        return $this->hasMany('Modulatte\Categories\Models\Category', 'parent_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function products()
    {
        return $this->belongsToMany('Modulatte\Products\Models\Product', 'categories_products')->orderBy('title', 'asc');
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
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function seo()
    {
        return $this->morphOne('App\Models\Seo', 'seoable');
    }
}
