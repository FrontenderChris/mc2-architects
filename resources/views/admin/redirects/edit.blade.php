@extends('layouts.app')

@section('content')
    <div class="redirects-page">
        <h1>Edit Redirect</h1>
        {!! Breadcrumbs::render('redirects.edit', $model) !!}
        <hr>

        @include('partials._messages')

        {{ Form::model($model, ['route' => ['admin.redirects.update', $model->id], 'method' => 'PUT', 'class' => 'form-horizontal redirect-form']) }}
            @include('redirects._form')

            <div class="form-group add-margin-40">
                {{ Form::submit('Update Redirect', ['class' => 'btn btn-primary form-control']) }}
            </div>
        {{ Form::close() }}
    </div>
@endsection