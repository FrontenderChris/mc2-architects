@extends('layouts.app')

@section('content')
<div class="page-create pages-module">
    <h1>Create Project</h1>
    <hr>

    @include('partials._messages')
    @include('projects.forms._projects')
</div>
@endsection