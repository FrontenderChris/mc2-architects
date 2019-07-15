@extends('layouts.app')

@section('content')
<div class="redirects-page">
    <h1>Create Redirect</h1>
    {!! Breadcrumbs::render('redirects.create') !!}
    <hr>

    @include('partials._messages')

    {{ Form::open(array('route' => 'admin.redirects.store', 'class' => 'form-horizontal redirect-form')) }}
        @include('redirects._form')

        <div class="form-group add-margin-40">
            {{ Form::submit('Add Redirect', ['class' => 'btn btn-primary form-control']) }}
        </div>
    {{ Form::close() }}
</div>
@endsection