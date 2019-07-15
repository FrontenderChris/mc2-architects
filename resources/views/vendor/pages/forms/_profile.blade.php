{!! pageOpenForm($form, (isset($model) ? $model : null)) !!}
    <ul class="nav nav-tabs">
        <li class="{{ !request()->has('section') ? 'active' : '' }}"><a href="#" class="do-show-content active" data-show=".tab-main">Main</a></li>
        <li><a href="#" class="do-show-content" data-show=".tab-seo">SEO</a></li>
        <li class="{{ request()->has('section') ? 'active' : '' }}"><a href="#" class="{{ (empty($page) ? 'disabled-tab' : 'do-show-content') }}" data-show=".tab-people">People</a></li>
    </ul>

    {{------------------------------- EDIT THE FORM BELOW ------------------------------}}
    <div class="tab-content tab-main" style="{{ !request()->has('section') ? 'display: block;' : '' }}">
        {{ Form::hidden('redirectBack', 1) }}

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
            {{ Form::label('Lead Copy', null, ['class' => 'col-sm-2 control-label']) }}
            <div class="col-sm-10">
                {{ Form::text('data[lead_copy]', null, ['class' => 'form-control']) }}
            </div>
        </div>
        @include('cropper::_input', [
            'uniqueKey' => '1',
            'width' => 1500,
            'height' => 1000,
            'image' => (!empty($model) ? $model->image : null),
            'label' => 'Hero Image',
            'inputName' => 'image[file]',
        ])
        @include('pages::partials._submit')
    </div>

    @if (!empty($page))
        @include('sections::partials._index', ['page' => $page, 'forms' => ['_team'], 'tabTitle' => 'people'])
    @endif
    {{------------------------------ EDIT THE FORM ABOVE ------------------------------}}

    @include('pages::partials._seo')
{{ pageCloseForm() }}

@include('cropper::_modal', ['uniqueKey' => '1'])

