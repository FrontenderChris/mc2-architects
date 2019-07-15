@if (!empty($parent))
    {{-- You must specify the parent class (when creating) to allocate this item to --}}
    {{ Form::hidden('class', get_class($parent)) }}
    {{ Form::hidden('id', $parent->id) }}
@endif

{{-- Return route for after success --}}
{{ Form::hidden('route', $route) }}


@include('cropper::_input', [
    'uniqueKey' => '1',
    'width' => 0,
    'height' => 0,
    'image' => (isset($model) ? $model : null),
    'label' => 'Image',
    'inputName' => 'image[file]',
    'required' => true,
])
<div class="form-group">
    <div class="col-sm-2">
    </div>
    <div class="col-sm-10">
        <p>Add a large image to scale proportionally.</p>
    </div>
</div>
<div class="form-group">
    {{ Form::label('Title', null, ['class' => 'col-sm-2 control-label']) }}
    <div class="col-sm-10">
        {{ Form::text('title', null, ['class' => 'form-control', 'maxlength' => 30]) }}
    </div>
</div>
<div class="form-group">
    {{ Form::label('URL', null, ['class' => 'col-sm-2 control-label']) }}
    <div class="col-sm-10">
        {{ Form::text('url', null, ['class' => 'form-control', 'maxlength' => 30]) }}
    </div>
</div>
<div class="form-group">
    {{ Form::label('Width', null, ['class' => 'col-sm-2 control-label']) }}
    <div class="col-sm-10">
        {{ Form::text('data[width]', null, ['class' => 'form-control', 'maxlength' => 30]) }}
    </div>
</div>

<div class="form-group">
    {{ Form::label('Margin Right', null, ['class' => 'col-sm-2 control-label']) }}
    <div class="col-sm-10">
        {{ Form::text('data[margin_right]', null, ['class' => 'form-control', 'maxlength' => 30]) }}
    </div>
</div>

<div class="form-group">
    {{ Form::label('Margin Bottom', null, ['class' => 'col-sm-2 control-label']) }}
    <div class="col-sm-10">
        {{ Form::text('data[margin_bottom]', null, ['class' => 'form-control', 'maxlength' => 30]) }}
    </div>
</div>

<div class="form-group">
    {{ Form::label('Margin Left', null, ['class' => 'col-sm-2 control-label']) }}
    <div class="col-sm-10">
        {{ Form::text('data[margin_left]', null, ['class' => 'form-control', 'maxlength' => 30]) }}
    </div>
</div>