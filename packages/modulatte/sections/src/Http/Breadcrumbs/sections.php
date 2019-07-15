<?php
Breadcrumbs::register('sections.create', function($breadcrumbs, $form, \Modulatte\Pages\Models\Page $page)
{
    $breadcrumbs->parent('pages.edit', $page);
    $breadcrumbs->push('Create', route('admin.sections.create', ['form' => $form, 'pageId' => $page->id]));
});

Breadcrumbs::register('sections.edit', function($breadcrumbs, \Modulatte\Sections\Models\Section $model)
{
    $breadcrumbs->parent('pages.edit', $model->page);
    $breadcrumbs->push($model->title, route('admin.sections.edit', $model->id));
});