<?php
Breadcrumbs::register('categories', function($breadcrumbs)
{
    $breadcrumbs->push('Categories', route('admin.categories.index'));
});

Breadcrumbs::register('categories.create', function($breadcrumbs)
{
    $breadcrumbs->parent('categories');
    $breadcrumbs->push('Create', route('admin.categories.create'));
});

Breadcrumbs::register('categories.edit', function($breadcrumbs, \Modulatte\Categories\Models\Category $category)
{
    $breadcrumbs->parent('categories');
    $breadcrumbs->push($category->title, route('admin.categories.edit', $category->id));
});