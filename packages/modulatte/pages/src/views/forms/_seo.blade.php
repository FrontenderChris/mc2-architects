{!! pageOpenForm($form, (isset($model) ? $model : null)) !!}
    @include('pages::page._nav')

    {{------------------------------- EDIT THE FORM BELOW ------------------------------}}
    <div class="tab-content tab-main" style="display: block;">
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
        @if (isset($model))
            {{ Form::hidden('slug', $model->slug) }}
        @else
            <div class="form-group">
                {{ Form::label('URL', null, ['class' => 'col-sm-2 control-label required']) }}
                <div class="col-sm-10">
                    {{ Form::text('slug', null, ['class' => 'form-control is-slug', 'maxlength' => 100]) }}
                </div>
            </div>
        @endif

        @include('pages::partials._submit')
    </div>
    {{------------------------------ EDIT THE FORM ABOVE ------------------------------}}

    @include('pages::partials._seo')
{{ pageCloseForm() }}

