@extends('layouts.app')

@section('content')
    <div class="gallery-edit gallery-module">
        <h1>Edit Gallery Item</h1>
        {{-- todo: Breadcrumbs --}}
        <hr>

        @include('partials._messages')

        {{ Form::model($model, ['route' => ['admin.gallery.update', $model->id], 'method' => 'PUT', 'class' => 'form-horizontal']) }}
            @include('gallery::partials._form', [
                'width' => $model->width,
                'height' => $model->height,
                'route' => $route,
            ])

            <div class="form-group add-margin-40">
                {{ Form::submit('Update Gallery Item', ['class' => 'btn btn-primary form-control']) }}
            </div>
        {{ Form::close() }}

        @include('cropper::_modal', ['uniqueKey' => '1'])
    </div>
@endsection