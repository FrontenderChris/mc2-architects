<?php
Breadcrumbs::register('redirects', function($breadcrumbs)
{
    $breadcrumbs->push('Redirects', route('admin.redirects.index'));
});

Breadcrumbs::register('redirects.create', function($breadcrumbs)
{
    $breadcrumbs->parent('redirects');
    $breadcrumbs->push('Create', route('admin.redirects.create'));
});

Breadcrumbs::register('redirects.edit', function($breadcrumbs, App\Models\Redirect $model)
{
    $breadcrumbs->parent('redirects');
    $breadcrumbs->push($model->redirect_from, route('admin.redirects.edit', $model->id));
});