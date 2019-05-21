@extends('layouts.app')

@section('content')
    <div class="sections-edit sections-module">
        <h1>Edit Section</h1>
        @if($form != '_image')
            {!! Breadcrumbs::render('sections.edit', $model) !!}
        @endif
        <hr>

        @include('sections::partials._messages')
        @include('sections::forms.' . $form)
    </div>
@endsection