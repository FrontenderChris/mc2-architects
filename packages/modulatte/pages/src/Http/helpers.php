<?php
function getForms($formPath, $exclude = [])
{
    $forms = [];
    if (\File::exists($formPath)) {
        foreach (\File::allFiles($formPath) as $file) {
            $file = str_replace('.blade', '', pathinfo($file, PATHINFO_FILENAME));

            if (empty($exclude) || !in_array($file, $exclude))
                $forms[] = $file;
        }
    }

    return $forms;
}

/**
 * @param $form
 * @return string
 */
function readableFormName($form)
{
    return ucwords(str_replace(['.blade', '_'], '', snake_case($form, ' ')));
}

/**
 * @param $key
 * @return mixed
 */
function page($key)
{
    return \Modulatte\Pages\Models\Page::get($key);
}

/**
 * @return mixed
 */
function pageList()
{
    return ['' => '-- Choose --'] + \Modulatte\Pages\Models\Page::whereNull('parent_id')->lists('title', 'id')->all();
}

/**
 * @param array $exclude
 * @return array|bool
 */
function pageForms($exclude = [])
{
    $forms = getForms(\Modulatte\Pages\Models\Page::formPath(), $exclude);

    if (!empty($forms))
        return $forms;

    return false;
}

/**
 * @param \Modulatte\Pages\Models\Page|null $page
 * @param null $form
 * @return \Illuminate\Support\HtmlString
 */
function pageOpenForm($form, \Modulatte\Pages\Models\Page $page = null)
{
    if (!empty($page))
        return Form::model($page, ['route' => ['admin.pages.update', $page->id], 'method' => 'PUT', 'class' => 'form-horizontal', 'files'=>true]) . Form::hidden('form', $page->form);

    return Form::open(['route' => 'admin.pages.store', 'class' => 'form-horizontal', 'files'=>true]) . Form::hidden('form', $form);
}

/**
 * @return string
 */
function pageCloseForm()
{
    return Form::close();
}

function pagesSortable(\Modulatte\Pages\Models\Page $page)
{
    if ((!$page->parent && config('pages.sortable')) || ($page->parent && config('pages.subPagesSortable')))
        return true;

    return false;
}

/**
 * @param \Modulatte\Pages\Models\Page|null $page
 * @param null $form
 * @return \Illuminate\Support\HtmlString
 */
function projectOpenForm($form, \Modulatte\Pages\Models\Page $page = null)
{
    if (!empty($page))
        return Form::model($page, ['route' => ['admin.projects.update', $page->id], 'method' => 'PUT', 'class' => 'form-horizontal', 'files'=>true]) . Form::hidden('form', $page->form);

    return Form::open(['route' => 'admin.projects.store', 'class' => 'form-horizontal', 'files'=>true]) . Form::hidden('form', $form);
}