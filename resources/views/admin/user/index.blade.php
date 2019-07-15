@extends('layouts.app')

@section('content')
<div class="users">
    <h1>Users</h1>
	<hr />

	<div class="row">
        <div class="span12">
            <div class="well">
                <div class="row">
                    <div class="col-xs-6">
                        <button type="button" data-loading-text="Loading..." class="btn btn-primary loading-btn" autocomplete="off" data-url="{{ route('admin.users.create') }}">
                            Create User
                        </button>
                    </div>
                    <div class="col-xs-6 align-right">
                        @include('.partials._search', ['target' => '.user-index'])
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if (Session::has('error-msg'))
        <p class="alert alert-danger">{!! Session::get('error-msg') !!}</p>
    @endif

    <table class="table table-striped table-responsive user-index" width="100%">
        <thead class="thead-inverse">
            <tr>
                <th>User ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Date Registered</th>
                <th class="align-right">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr data-search="{{ strtolower($user->name) }}">
                    <td> {{ $user->id}} </td>
                    <td> {{ $user->name }} </td>
                    <td> {{ $user->email }} </td>
                    <td> {{ $user->created_at }} </td>
                    <td  align="right">
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-default" title="Edit" data-url="{{ route('admin.users.edit', $user->id) }}">
                                <span class="glyphicon glyphicon-pencil"></span>
                            </button>
                            <button type="button" class="btn btn-default do-delete-row" data-target="{{ route('admin.users.destroy', $user->id) }}"  title="Delete">
                                <span class="glyphicon glyphicon-trash"></span>
                            </button>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {!! $users->links() !!}
</div>
@endsection