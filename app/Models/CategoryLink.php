<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\CategoryProject
 *
 * @property integer $page_id
 * @property integer $category_id
 */

class CategoryLink extends Model
{
    public $timestamps = false;
    protected $table = 'categories_projects';
}
