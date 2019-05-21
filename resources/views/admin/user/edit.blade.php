@extends('layouts.app')

@section('content')
<div class="user-edit">
    <h1>Edit User</h1>

    <hr>

     @if (Session::has('error-msg'))
        <p class="alert alert-danger">{!! Session::get('error-msg') !!}</p>
    @endif
    @if (Session::has('success-msg'))
        <p class="alert alert-success">{!! Session::get('success-msg') !!}</p>
    @endif

    {{ Form::open( ['route' => ['admin.users.update', $user->id], 'class' => 'form-horizontal', 'method'=> 'put'] ) }}
		@include('user.forms._edit', $user )
    {{ Form::close() }}

</div>
@endsection
