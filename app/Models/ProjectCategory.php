<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Modulatte\Pages\Models\Pages;

/**
 * App\Models\ProjectCategory
 *
 * @property integer $id
 * @property string $name
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class ProjectCategory extends Model
{
    protected $fillable = [];

    /**
     *
     * @return mixed
     */
    public static function getList($id = null)
    {
        if($id)
        {
            $page = \Modulatte\Pages\Models\Page::find($id);
            return ($page->categories() ? $page->categories()->pluck('id')->toArray() : null);
        }
        return ProjectCategory::get()->pluck('name', 'id');
    }

    public function page()
    {
        return $this->belongsToMany('Modulatte\Pages\Models\Page;', categories_project);
    }

}
