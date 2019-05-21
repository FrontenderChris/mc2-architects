@extends('layouts.app')

@section('content')
    <div class="pages-edit pages-module">
        <h1>Edit Project</h1>
        <hr>

        @include('projects.partials._messages')
        @include('projects.forms.' . $form, ['page' => $model])
    </div>
@endsection