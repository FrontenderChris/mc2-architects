@extends('layouts.app')

@section('content')
<div class="gallery-create gallery-module">
    <h1>Create Gallery Item</h1>
    {{-- todo: Breadcrumbs --}}
    <hr>

    @include('partials._messages')

    {{ Form::open(array('route' => 'admin.gallery.store', 'class' => 'form-horizontal')) }}
        @include('gallery::partials._form', [
            'parent' => $parent,
            'width' => $width,
            'height' => $height,
            'route' => $route,
        ])

        <div class="form-group add-margin-40">
            {{ Form::submit('Add Gallery Item', ['class' => 'btn btn-primary form-control']) }}
        </div>
    {{ Form::close() }}

    @include('cropper::_modal', ['uniqueKey' => '1'])
</div>
@endsection