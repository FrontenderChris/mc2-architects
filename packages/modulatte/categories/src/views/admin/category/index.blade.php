@extends('layouts.app')

@section('content')
<div class="categories">
    <h1>Categories</h1>
    <hr>

    <div class="row">
        <div class="span12">
            <div class="well">
                <div class="row">
                    <div class="col-xs-6">
                        <button type="button" data-loading-text="Loading..." class="btn btn-primary loading-btn" autocomplete="off" data-url="{{ route('admin.categories.create') }}">
                            Create Category
                        </button>
                    </div>
                    <div class="col-xs-6 align-right">
                        @include('.partials._searchPhp', ['route' => 'admin.categories.index'])
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="category-index container-fluid div-table sortable" data-sort-url="{{ route('admin.categories.sort') }}">
        <div class="row table-heading">
            <div class="col-xs-8">
                <strong>Title</strong>
            </div>
            <div class="col-xs-4 align-right">
                <strong>Actions</strong>
            </div>
        </div>


        @foreach ($categories as $model)
            <div class="row {{ ($model->hasChildren() ? 'has-children' : '') }}" id="categories_{{ $model->id }}" data-search="{{ strtolower($model->title) }}">
                @include('categories::admin.category.partials._row', ['model' => $model])

                @if ($model->hasChildren())
                    {!! recursiveCategories($model) !!}
                @endif
            </div>
        @endforeach

    </div>
</div>
@endsection