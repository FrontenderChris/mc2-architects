<?php
Breadcrumbs::register('pages', function($breadcrumbs)
{
    $breadcrumbs->push('Pages', route('admin.pages.index'));
});

Breadcrumbs::register('pages.create', function($breadcrumbs, $form)
{
    $breadcrumbs->parent('pages');
    $breadcrumbs->push('Create', route('admin.pages.create', ['form' => $form]));
});

Breadcrumbs::register('pages.edit', function($breadcrumbs, \Modulatte\Pages\Models\Page $model)
{
    $breadcrumbs->parent('pages');
    $breadcrumbs->push($model->title, route('admin.pages.edit', $model->id));
});