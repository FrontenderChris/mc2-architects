@extends('layouts.app')

@section('content')
<div class="sections-create sections-module">
    <h1>Create Section</h1>
    @if($form != '_image')
        {!! Breadcrumbs::render('sections.create', $form, $page) !!}
    @endif
    <hr>

    @include('sections::partials._messages')
    @include('sections::forms.' . $form)
</div>
@endsection