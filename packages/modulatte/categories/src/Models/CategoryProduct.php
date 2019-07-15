<?php

namespace Modulatte\Categories\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\CategoryProduct
 *
 * @property integer $product_id
 * @property integer $category_id
 */
class CategoryProduct extends Model
{
    protected $table = 'categories_products';
}
