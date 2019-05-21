<?php

function settings($key, $return = 'value')
{
    $setting = \App\Models\Settings::get($key);

    if (empty($return))
        return $setting;
    else
        return $setting->$return;
}

function logo()
{
    $setting = \App\Models\Settings::get('logo');
    if ($setting->image)
        return $setting->image->getSrc(true);
    else
        return ViewHelper::getImgSrc('logo.png');
}

function from_email($email)
{
    return (empty($email) ? settings('email_from') : $email);
}

function to_email($email)
{
    return (empty($email) ? settings('email_to') : $email);
}

function title($title, $allowed_tags = '<strong><em><u>')
{
    return strip_tags($title, $allowed_tags);
}

function camelToSpaces($string)
{
    return str_replace('_', ' ', implode(' ', preg_split('/(?=[A-Z])/', $string)));
}

function hasLoginPackage()
{
    return class_exists('Modulatte\Login\LoginServiceProvider');
}

/**
 * Used within the seeders to generate a fake image
 * @param $width
 * @param $height
 * @param $title
 * @return \App\Models\Image
 */
function fakeImage($width, $height, $title = null)
{
    $faker = Faker\Factory::create();
    $filename = $faker->image(storage_path('app/images'), $width, $height, null, false);
    return new \App\Models\Image([
        'title' => (!empty($title) ? $title : $filename),
        'file' => $filename,
        'created_at' => date('Y-m-d H:i:s'),
    ]);
}

function getImage($model, $fallback, $index = null) {
    if ($index) {
        if ($image = $model->image($index)) {
            return $image->getSrc();
        }
    } else {
        if ($image = $model->image) {
            return $image->getSrc();
        }
    }
    return $fallback;
}

function sectionIncludeForms($includes) {
    $formPath = \Modulatte\Sections\Models\Section::formPath();
    $forms = [];
    
    if (\File::exists($formPath)) {
        foreach (\File::allFiles($formPath) as $file) {
            $file = str_replace('.blade', '', pathinfo($file, PATHINFO_FILENAME));

            if (empty($includes) || in_array($file, $includes))
                $forms[] = $file;
        }
    }

    return $forms;
}

function phoneable($number) {
    return preg_replace('[ |-]', '', $number);
}

function categoryList()
{
    return \App\Models\ProjectCategory::getList();
}

function pageCategoryList($id)
{
    $pageCategoryList = \App\Models\ProjectCategory::getList($id);
    return \App\Models\ProjectCategory::getList($id);
}

function storeProjectCategories($categories, $page)
{
    $projectCategories = \App\Models\ProjectCategory::pluck('id');
    $category_id = array();
    foreach ($categories as $category) {
        
        if (!$projectCategories->contains($category)) {
            $newCategory = new \App\Models\ProjectCategory;
            $newCategory->name = $category;
            $newCategory->save();
            $category_id[] = $newCategory->id;
        }  else {
            $category_id[] = $category;
        }
    }
    $page->categories()->sync($category_id);
}
