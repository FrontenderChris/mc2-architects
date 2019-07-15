@if (!empty($parent))
    {{-- You must specify the parent class (when creating) to allocate this item to --}}
    {{ Form::hidden('class', get_class($parent)) }}
    {{ Form::hidden('id', $parent->id) }}
@endif

{{-- Return route for after success --}}
{{ Form::hidden('route', $route) }}

@include('cropper::_input', [
    'uniqueKey' => '1',
    'width' => $width,
    'height' => $height,
    'image' => (isset($model) ? $model : null),
    'label' => 'Image',
    'inputName' => 'image[file]',
    'required' => true,
])
<div class="form-group">
    {{ Form::label('Alt Tag', null, ['class' => 'col-sm-2 control-label']) }}
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
    {{ Form::label('Caption', null, ['class' => 'col-sm-2 control-label']) }}
    <div class="col-sm-10">
        {{ Form::textarea('caption', null, ['class' => 'form-control', 'rows' => 3]) }}
    </div>
</div>
