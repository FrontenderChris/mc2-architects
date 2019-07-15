@extends('layouts.app')

@section('content')
<div class="user-create">
    <h1>Create User</h1>
    <hr>
	@if (Session::has('error-msg'))
        <p class="alert alert-danger">{!! Session::get('error-msg') !!}</p>
	@endif

    {{ Form::open(array('route' => 'admin.users.store', 'class' => 'form-horizontal')) }}
        @include('user.forms._create')
    {{ Form::close() }}

</div>
@endsection
