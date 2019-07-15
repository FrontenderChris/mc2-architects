{!! projectOpenForm($form, (isset($model) ? $model : null)) !!}
    @include('projects._nav')

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
        <div class="form-group">
            {{ Form::label('URL', null, ['class' => 'col-sm-2 control-label required']) }}
            <div class="col-sm-10">
                {{ Form::text('slug', null, ['class' => 'form-control is-slug', 'maxlength' => 100]) }}
            </div>
        </div>
        <div class="form-group">
            {{ Form::label('Lead Copy', null, ['class' => 'col-sm-2 control-label']) }}
            <div class="col-sm-10">
                {{ Form::textarea('data[lead_copy]', null, ['class' => 'form-control', 'rows' => 2, 'maxlength' => 255]) }}
            </div>
        </div>
        <div class="form-group">
            {{ Form::label('Content', null, ['class' => 'col-sm-2 control-label']) }}
            <div class="col-sm-10">
                {{ Form::textarea('data[content]', null, ['class' => 'form-control has-redactor']) }}
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

        @include('projects.partials._submit')
    </div>
    {{------------------------------ EDIT THE FORM ABOVE ------------------------------}}

    @include('projects.partials._seo')
{{ pageCloseForm() }}

@include('cropper::_modal', ['uniqueKey' => '1'])

