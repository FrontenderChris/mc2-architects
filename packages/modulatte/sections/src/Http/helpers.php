<?php
/**
 * @param array $exclude
 * @return array|bool
 */
function sectionForms($exclude = [])
{
    $forms = getForms(\Modulatte\Sections\Models\Section::formPath(), $exclude);

    if (!empty($forms))
        return $forms;

    return false;
}

/**
 * @param $form
 * @param \Modulatte\Pages\Models\Page $page
 * @param \Modulatte\Sections\Models\Section|null $section
 * @return \Illuminate\Support\HtmlString|string
 */
function sectionOpenForm($form, \Modulatte\Sections\Models\Section $section = null, \Modulatte\Pages\Models\Page $page = null)
{
    if (!empty($section)) {
        return  Form::model($section, ['route' => ['admin.sections.update', $section->id], 'method' => 'PUT', 'class' => 'form-horizontal', 'files'=>true]) .
                Form::hidden('form', $form) .
                Form::hidden('page_id', $section->page->id);
    }


    return  Form::open(['route' => 'admin.sections.store', 'class' => 'form-horizontal', 'files'=>true]) .
            Form::hidden('form', $form) .
            Form::hidden('page_id', $page->id);
}

/**
 * @return string
 */
function sectionCloseForm()
{
    return Form::close();
}