<?php
function category($id = null)
{
    if (!empty($id))
        return \Modulatte\Categories\Models\Category::findOrFail($id);

    return new \Modulatte\Categories\Models\Category;
}

function recursiveCategories(\Modulatte\Categories\Models\Category $model)
{
    $html = '<div class="page-children category-child-sortable" data-sort-url="' . route('admin.categories.sort'). '">';
        foreach ($model->children as $key => $child)
        {
            $html .= '<div class="row child-page" id="categories_' . $child->id . '" data-search="' . strtolower($child->title) . '">' . view('categories::admin.category.partials._row', ['model' => $child]);
                if ($child->hasChildren())
                    $html .= recursiveCategories($child);
            $html .= '</div>';
        }
    $html .= '</div>';

    return $html;
}