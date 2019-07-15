@extends('layouts.app')

@section('content')
<div class="page-create pages-module">
    <h1>Create Page</h1>
    {!! Breadcrumbs::render('pages.create', $form) !!}
    <hr>

    @include('pages::partials._messages')
    @include('pages::forms.' . $form)
</div>
@endsection