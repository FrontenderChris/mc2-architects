@extends('layouts.app')

@section('content')
    <div class="categories-container">
        <h1>Edit Category</h1>
        {!! Breadcrumbs::render('categories.edit', $model) !!}
        <hr>

        @include('partials._messages')
        @include('categories::admin.category.partials._nav')

        {{ Form::model($model, ['route' => ['admin.categories.update', $model->id], 'method' => 'PUT', 'class' => 'form-horizontal', 'files' => true]) }}
            @include('categories::admin.category._form')

            <div class="form-group add-margin-40">
                {{ Form::submit('Update Category', ['class' => 'btn btn-primary form-control']) }}
            </div>
        {{ Form::close() }}

        @include('cropper::_modal', ['uniqueKey' => '1'])
    </div>
@endsection

@section('footer')
    <script>
        $(document).ready(function(){
            var $hasSelect = $('.has-select2');
            $hasSelect.select2({
                placeholder: $(this).data('placeholder'),
                minimumResultsForSearch: 3
            });
        });
    </script>
@endsection