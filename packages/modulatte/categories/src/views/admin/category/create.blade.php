@extends('layouts.app')

@section('content')
<div class="categories-container">
    <h1>Create Category</h1>
    {!! Breadcrumbs::render('categories.create') !!}
    <hr>

    @include('partials._messages')
    @include('categories::admin.category.partials._nav')

    {{ Form::open(array('route' => 'admin.categories.store', 'class' => 'form-horizontal', 'files' => true)) }}
        @include('categories::admin.category._form')

        <div class="form-group add-margin-40">
            {{ Form::submit('Add Category', ['class' => 'btn btn-primary form-control']) }}
        </div>
    {{ Form::close() }}

    @include('cropper::_modal', ['uniqueKey' => '1'])
</div>
@endsection

@section('footer')
<script>
    $(document).ready(function(){
        initHasSelect2($('.has-select2'));
    });
</script>
@endsection