{!! pageOpenForm($form, (isset($model) ? $model : null)) !!}
<ul class="nav nav-tabs">
    <li class="{{ !request()->has('gallery') ? 'active' : '' }}"><a href="#" class="do-show-content active" data-show=".tab-main">Main</a></li>
    <li><a href="#" class="do-show-content" data-show=".tab-seo">SEO</a></li>
    @if (config('pages.homepageGallery'))
        <li class="{{ request()->has('gallery') ? 'active' : '' }}"><a href="#" class="{{ (empty($page) ? 'disabled-tab' : 'do-show-content') }}" data-show=".tab-gallery">Gallery</a></li>
    @endif
</ul>

{{------------------------------- EDIT THE FORM BELOW ------------------------------}}

{{-- Hidden fields should be added when seeding --}}

<div class="tab-content tab-main contact-form" style="{{ !request()->has('gallery') ? 'display:block;' : '' }}">
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

    @include('pages::partials._submit')
</div>

@if (!empty($page) && config('pages.homepageGallery'))
    <div class="tab-content tab-gallery" style="{{ request()->has('gallery') ? 'display: block;' : '' }}">
        @include('gallery::partials._index', [
            'parent' => $page,
            'width' => 2880,
            'height' => 1030
        ])
    </div>
@endif
{{------------------------------ EDIT THE FORM ABOVE ------------------------------}}

@include('pages::partials._seo')
{{ pageCloseForm() }}

