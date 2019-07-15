{!! pageOpenForm($form, (isset($model) ? $model : null)) !!}
<ul class="nav nav-tabs">
    <li class="{{ !request()->has('section') ? 'active' : '' }}"><a href="#" class="do-show-content active" data-show=".tab-main">Main</a></li>
    <li><a href="#" class="do-show-content" data-show=".tab-seo">SEO</a></li>
    <li class="{{ request()->has('section') ? 'active' : '' }}"><a href="#" class="{{ (empty($page) ? 'disabled-tab' : 'do-show-content') }}" data-show=".tab-image">Images</a></li>
</ul>

{{------------------------------- EDIT THE FORM BELOW ------------------------------}}
<div class="tab-content tab-main" style="display: block;">
    {{ Form::hidden('parent_id', 6) }}
    @if (config('pages.subPages'))
        <div class="form-group">
            {{ Form::label('Parent Page', null, ['class' => 'col-sm-2 control-label']) }}
            <div class="col-sm-10">
                {{ Form::select('parent_id', pageList(), null, ['class' => 'form-control has-select2']) }}
            </div>
        </div>
    @endif
    <div class="form-group">
        {{ Form::label('Title', null, ['class' => 'col-sm-2 control-label required']) }}
        <div class="col-sm-10">
            {{ Form::text('title', null, ['class' => 'form-control do-slugify', 'maxlength' => 100]) }}
        </div>
    </div>

    <div class="form-group">
        {{ Form::label('URL', null, ['class' => 'col-sm-2 control-label required']) }}
        <div class="col-sm-10">
            {{ Form::text('slug', null, ['class' => 'form-control is-slug', 'maxlength' => 100]) }}
        </div>
    </div>
    <div class="form-group">
        {{ Form::label('Home Page Featured', null, ['class' => 'col-sm-2 control-label']) }}
        <div class="col-sm-1">
            {{ Form::checkbox('data[featured]', null, null, ['class' => 'form-control do-toggle-special']) }}
        </div>
    </div>

    <div class="form-group">
        {{ Form::label('Project Name', null, ['class' => 'col-sm-2 control-label required']) }}
        <div class="col-sm-10">
            {{ Form::text('title', null, ['class' => 'form-control do-slugify', 'maxlength' => 100]) }}
        </div>
    </div>
    <div class="form-group">
        {{ Form::label('URL', null, ['class' => 'col-sm-2 control-label required']) }}
        <div class="col-sm-10">
            {{ Form::text('slug', null, ['class' => 'form-control is-slug', 'maxlength' => 100]) }}
        </div>
    </div>
    <div class="form-group">
        {{ Form::label('Location', null, ['class' => 'col-sm-2 control-label']) }}
        <div class="col-sm-10">
            {{ Form::text('data[location]', null, ['class' => 'form-control', 'maxlength' => 100]) }}

        </div>
    </div>

    <div class="form-group">
        {{ Form::label('Categories', null, ['class' => 'col-sm-2 control-label']) }}
        <div class="col-sm-10">
            {{ Form::select('categories[]', $pageCategories = categoryList(), pageCategoryList((!empty($model)) ? $model->id : null), ['class' => 'form-control has-tagged-select2', 'multiple' => 'multiple', 'data-placeholder' => 'Choose Categories']) }}
        </div>
    </div>

    <div class="form-group">
        {{ Form::label('Sub Heading', null, ['class' => 'col-sm-2 control-label required']) }}
        <div class="col-sm-10">
            {{ Form::text('data[sub_heading]', null, ['class' => 'form-control', 'maxlength' => 100]) }}
        </div>
    </div>

    <div class="form-group">
        {{ Form::label('Content', null, ['class' => 'col-sm-2 control-label']) }}
        <div class="col-sm-10">
            {{ Form::textarea('data[content]', null, ['class' => 'form-control has-redactor']) }}
        </div>
    </div>

    
    @include('cropper::_input', [
        'uniqueKey' => '0',
        'width' => 0,
        'height' => 0,
        'image' => (!empty($model) ? $model->image('banner') : null),
        'label' => 'Banner Image',
        'inputName' => 'images[banner]',
    ])

    <div class="page-header">
        <h4>Choose your Featured Hero</h4>
    </div>
    <div class="form-group">
            {{ Form::label('Featured Hero Image', null, ['class' => 'col-sm-2 control-label']) }}
            <div class="col-sm-10">
            {{ Form::select('data[featured_project]',  [
                'hero' => 'Hero 1',
                'hero2' => 'Hero 2',
                'hero3' => 'Hero 3',
                'hero4' => 'Hero 4',
                'hero5' => 'Hero 5',
                'hero6' => 'Hero 6',
                'banner' => 'Banner Image',
                ]), null,
                ['class' => 'form-control2', 'label' => 'Please Select', 'data-placeholder' => 'Select Hero Image']
            }}
        </div>
    </div>

    <div class="page-header">
        <h4>Hero Image 1</h4>
    </div>
    <div class="form-group">
        {{ Form::label('Full Width', null, ['class' => 'col-sm-2 control-label']) }}
        <div class="col-sm-1">
            {{ Form::checkbox('data[hero1_is_full]', null, null, ['class' => 'form-control do-toggle-special']) }}
        </div>
    </div>
    @include('cropper::_input', [
        'uniqueKey' => '1',
        'width' => 0,
        'height' => 0,
        'image' => (!empty($model) ? $model->image('hero') : null),
        'label' => 'Upload image',
        'inputName' => 'images[hero]',
    ])

    <div class="page-header">
            <h4>Hero Image 2</h4>
        </div>
        <div class="form-group">
            {{ Form::label('Full Width', null, ['class' => 'col-sm-2 control-label']) }}
            <div class="col-sm-1">
                {{ Form::checkbox('data[hero2_is_full]', null, null, ['class' => 'form-control do-toggle-special']) }}
            </div>
        </div>

        @include('cropper::_input', [
        'uniqueKey' => '2',
        'width' => 0,
        'height' => 0,
        'image' => (!empty($model) ? $model->image('hero2') : null),
        'label' => 'Upload image',
        'inputName' => 'images[hero2]',
    ])


    <div class="page-header">
        <h4>Hero Image 3</h4>
    </div>
    <div class="form-group">
        {{ Form::label('Full Width', null, ['class' => 'col-sm-2 control-label']) }}
        <div class="col-sm-1">
            {{ Form::checkbox('data[hero3_is_full]', null, null, ['class' => 'form-control do-toggle-special']) }}
        </div>
    </div>

        @include('cropper::_input', [
        'uniqueKey' => '3',
        'width' => 0,
        'height' => 0,
        'image' => (!empty($model) ? $model->image('hero3') : null),
        'label' => 'Upload image',
        'inputName' => 'images[hero3]',
    ])

    <div class="page-header">
        <h4>Hero Image 4</h4>
    </div>
    <div class="form-group">
        {{ Form::label('Full Width', null, ['class' => 'col-sm-2 control-label']) }}
        <div class="col-sm-1">
            {{ Form::checkbox('data[hero4_is_full]', null, null, ['class' => 'form-control do-toggle-special']) }}
        </div>
    </div>

    @include('cropper::_input', [
        'uniqueKey' => '4',
        'width' => 0,
        'height' => 0,
        'image' => (!empty($model) ? $model->image('hero4') : null),
        'label' => 'Upload image',
        'inputName' => 'images[hero4]',
    ])

    <div class="page-header">
        <h4>Hero Image 5</h4>
    </div>
    <div class="form-group">
        {{ Form::label('Full Width', null, ['class' => 'col-sm-2 control-label']) }}
        <div class="col-sm-1">
            {{ Form::checkbox('data[hero5_is_full]', null, null, ['class' => 'form-control do-toggle-special']) }}
        </div>
    </div>

        @include('cropper::_input', [
        'uniqueKey' => '5',
        'width' => 0,
        'height' => 0,
        'image' => (!empty($model) ? $model->image('hero5') : null),
        'label' => 'Upload image',
        'inputName' => 'images[hero5]',
    ])

    <div class="page-header">
        <h4>Hero Image 6</h4>
    </div>
    <div class="form-group">
        {{ Form::label('Full Width', null, ['class' => 'col-sm-2 control-label']) }}
        <div class="col-sm-1">
            {{ Form::checkbox('data[hero6_is_full]', null, null, ['class' => 'form-control do-toggle-special']) }}
        </div>
    </div>
        @include('cropper::_input', [
        'uniqueKey' => '6',
        'width' => 0,
        'height' => 0,
        'image' => (!empty($model) ? $model->image('hero6') : null),
        'label' => 'Upload image',
        'inputName' => 'images[hero6]',
    ])

    @include('pages::partials._submit')

</div>

@if (!empty($page))
    @include('sections::partials._index', ['page' => $page, 'forms' => ['_image'], 'tabTitle' => 'image'])
@endif

{{------------------------------ EDIT THE FORM ABOVE ------------------------------}}

@include('pages::partials._seo')
{{ pageCloseForm() }}

@include('cropper::_modal', ['uniqueKey' => '0'])
@include('cropper::_modal', ['uniqueKey' => '1'])
@include('cropper::_modal', ['uniqueKey' => '2'])
@include('cropper::_modal', ['uniqueKey' => '3'])
@include('cropper::_modal', ['uniqueKey' => '4'])
@include('cropper::_modal', ['uniqueKey' => '5'])
@include('cropper::_modal', ['uniqueKey' => '6'])

