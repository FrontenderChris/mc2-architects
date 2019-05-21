@if (config('categories.subCategories'))
    <div class="form-group">
        {{ Form::label('Parent Category', null, ['class' => 'col-sm-2 control-label']) }}
        <div class="col-sm-10">
            {{ Form::select('parent_id', category()->getList(true), null, ['class' => 'form-control has-select2 category-select', 'data-placeholder' => 'Choose Parent Category']) }}
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
@if (config('categories.hasImage'))
    @include('cropper::_input', [
            'uniqueKey' => '1',
            'width' => config('categories.imageWidth'),
            'height' => config('categories.imageHeight'),
            'image' => (!empty($model) ? $model->image : null),
            'label' => 'Image',
            'inputName' => 'image[file]',
        ])
@endif