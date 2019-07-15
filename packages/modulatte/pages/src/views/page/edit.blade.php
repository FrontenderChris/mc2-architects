@extends('layouts.app')

@section('content')
    <div class="pages-edit pages-module">
        <h1>Edit Page</h1>
        {!! Breadcrumbs::render('pages.edit', $model) !!}
        <hr>

        @include('pages::partials._messages')
        @include('pages::forms.' . $form, ['page' => $model])
    </div>
@endsection